<?php
namespace Helpers;
// utilitare de securizare folosite de formularele publice

class Security {

    // curatam intrarile: taiem spatiile si eliminam caracterele de control
    public static function clean($value) {
        $value = is_string($value) ? $value : '';
        $value = str_replace(["\0", "\r"], '', $value);
        return trim($value);
    }

    // escape pentru afisare in html
    public static function escape($value) {
        return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
    }

    /**
     * captcha aritmetica simpla, fara dependinte externe
     * raspunsul asteptat ramane in sesiune, intrebarea pleaca in formular
     */
    public static function generateCaptcha() {
        $a = random_int(1, 9);
        $b = random_int(1, 9);
        $_SESSION['captcha_answer'] = $a + $b;
        return sprintf('How much is %d + %d?', $a, $b);
    }

    public static function validateCaptcha($answer) {
        if (!isset($_SESSION['captcha_answer'])) {
            return false;
        }
        $expected = (int) $_SESSION['captcha_answer'];
        unset($_SESSION['captcha_answer']);
        return $answer !== '' && (int) $answer === $expected;
    }

    // http request spoofing: acceptam doar cereri din propriul formular
    public static function checkOrigin() {
        $referer = $_SERVER['HTTP_REFERER'] ?? '';
        if ($referer === '') {
            return true;
        }
        $host = parse_url($referer, PHP_URL_HOST);
        return $host === ($_SERVER['HTTP_HOST'] ?? '');
    }

    // slug seo-friendly, cu diacriticele romanesti transliterate
    public static function slugify($text) {
        $map = [
            'ă' => 'a', 'â' => 'a', 'î' => 'i', 'ș' => 's', 'ş' => 's',
            'ț' => 't', 'ţ' => 't', 'Ă' => 'a', 'Â' => 'a', 'Î' => 'i',
            'Ș' => 's', 'Ş' => 's', 'Ț' => 't', 'Ţ' => 't'
        ];
        $text = strtr($text, $map);
        $text = mb_strtolower($text, 'UTF-8');
        $text = preg_replace('/[^a-z0-9]+/', '-', $text);
        return trim($text, '-');
    }
}
