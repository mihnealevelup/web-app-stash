<?php
namespace Services;
// trimite mesajele formularului de contact catre adresa studioului

class MailService {

    const RECIPIENT = 'office@cinema-forge.mgrigoriu.daw.ssmr.ro';

    public static function sendContactMessage($name, $email, $subject, $message) {
        $subjectLine = $subject !== ''
            ? '[Cinema Forge] ' . $subject
            : '[Cinema Forge] New message from the contact form';

        $body = "A new message was submitted through the contact form.\n\n"
            . "Name:    " . $name . "\n"
            . "Email:   " . $email . "\n"
            . "Subject: " . $subject . "\n"
            . "Sent at: " . date('d.m.Y H:i:s') . "\n"
            . "IP:      " . ($_SERVER['REMOTE_ADDR'] ?? 'unknown') . "\n\n"
            . "Message:\n" . $message . "\n";

        // header injection: taiem orice caracter de linie noua din datele utilizatorului
        $safeEmail = str_replace(["\r", "\n"], '', $email);
        $safeName  = str_replace(["\r", "\n"], '', $name);

        $headers = [
            'MIME-Version: 1.0',
            'Content-Type: text/plain; charset=UTF-8',
            'From: Cinema Forge <no-reply@cinema-forge.mgrigoriu.daw.ssmr.ro>',
            'Reply-To: ' . $safeName . ' <' . $safeEmail . '>',
            'X-Mailer: PHP/' . phpversion()
        ];

        $sent = @mail(self::RECIPIENT, $subjectLine, $body, implode("\r\n", $headers));

        // pastram o copie pe disc, ca mesajul sa nu se piarda daca smtp-ul refuza
        self::archive($body, $sent);

        return $sent;
    }

    private static function archive($body, $sent) {
        $dir = PROJECT_ROOT . '/app/storage/messages';
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        $status = $sent ? 'sent' : 'failed';
        $file = $dir . '/' . date('Ymd-His') . '-' . $status . '.txt';
        @file_put_contents($file, $body);
    }
}
