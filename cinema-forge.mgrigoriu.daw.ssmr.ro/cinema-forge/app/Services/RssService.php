<?php
namespace Services;
// parseaza continut dintr-o sursa externa si il reda ca date proprii, nu ca iframe

class RssService {

    const DEFAULT_FEED = 'https://feeds.bbci.co.uk/news/entertainment_and_arts/rss.xml';
    const DEFAULT_FEED_NAME = 'BBC Entertainment & Arts';

    // cat timp tinem raspunsul in cache, in secunde
    const CACHE_TTL = 1800;

    /**
     * descarca feed-ul, il parseaza si intoarce un array normalizat de stiri
     * intoarce array gol daca sursa nu raspunde, ca pagina sa ramana functionala
     */
    public static function fetch($url = self::DEFAULT_FEED, $limit = 6) {
        $xml = self::read($url);
        if ($xml === false || $xml === '') {
            return [];
        }

        // dezactivam entitatile externe: protectie impotriva xxe
        $previous = libxml_use_internal_errors(true);
        $feed = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA | LIBXML_NONET);
        libxml_clear_errors();
        libxml_use_internal_errors($previous);

        if ($feed === false || !isset($feed->channel->item)) {
            return [];
        }

        $items = [];
        foreach ($feed->channel->item as $item) {
            if (count($items) >= $limit) {
                break;
            }

            $description = strip_tags((string) $item->description);
            $description = html_entity_decode($description, ENT_QUOTES, 'UTF-8');
            $description = trim(preg_replace('/\s+/', ' ', $description));

            $items[] = [
                'title'       => trim((string) $item->title),
                'link'        => trim((string) $item->link),
                'description' => mb_strimwidth($description, 0, 220, '...'),
                'date'        => self::formatDate((string) $item->pubDate)
            ];
        }

        return $items;
    }

    // citim feed-ul cu cache pe disc, ca sa nu lovim sursa la fiecare afisare
    private static function read($url) {
        $cacheFile = PROJECT_ROOT . '/app/storage/cache/rss-' . md5($url) . '.xml';

        if (is_readable($cacheFile) && (time() - filemtime($cacheFile)) < self::CACHE_TTL) {
            return file_get_contents($cacheFile);
        }

        $body = self::download($url);

        if ($body !== false && $body !== '') {
            $dir = dirname($cacheFile);
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }
            file_put_contents($cacheFile, $body);
            return $body;
        }

        // sursa a picat: folosim ultimul cache valid daca exista
        if (is_readable($cacheFile)) {
            return file_get_contents($cacheFile);
        }

        return false;
    }

    private static function download($url) {
        if (function_exists('curl_init')) {
            $ch = curl_init($url);
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_TIMEOUT        => 10,
                CURLOPT_USERAGENT      => 'CinemaForge/1.0 (+https://cinema-forge.mgrigoriu.daw.ssmr.ro)'
            ]);
            $body = curl_exec($ch);
            $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            return ($code >= 200 && $code < 300) ? $body : false;
        }

        $context = stream_context_create([
            'http' => ['timeout' => 10, 'user_agent' => 'CinemaForge/1.0']
        ]);
        return @file_get_contents($url, false, $context);
    }

    private static function formatDate($pubDate) {
        $timestamp = strtotime($pubDate);
        return $timestamp ? date('d.m.Y H:i', $timestamp) : '';
    }
}
