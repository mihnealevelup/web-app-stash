<?php
namespace Controllers;
// contact: formular simplu cu protectie csrf si anti-bot

use Helpers\CSRF;
use Helpers\Security;
use Services\MailService;

class ContactController extends BaseController {

    public function show() {
        $this->render('contact/form', [
            'title'      => 'Contact',
            'csrf_token' => CSRF::generateCSRFToken(),
            'captcha'    => Security::generateCaptcha()
        ]);
    }

    public function submit() {
        // form spoofing / csrf: cererea trebuie sa vina cu tokenul din sesiune
        if (!CSRF::validateCSRFToken($_POST['csrf_token'] ?? '')) {
            http_response_code(403);
            die('Invalid CSRF token');
        }

        $name    = Security::clean($_POST['name'] ?? '');
        $email   = Security::clean($_POST['email'] ?? '');
        $subject = Security::clean($_POST['subject'] ?? '');
        $message = Security::clean($_POST['message'] ?? '');
        $answer  = trim($_POST['captcha'] ?? '');
        $honey   = trim($_POST['website'] ?? '');

        $errors = [];

        // honeypot: campul este ascuns, doar un bot il completeaza
        if ($honey !== '') {
            $errors[] = 'Automated submission detected.';
        }
        if (!Security::validateCaptcha($answer)) {
            $errors[] = 'The anti-spam answer is not correct.';
        }
        if ($name === '' || mb_strlen($name) < 3) {
            $errors[] = 'Please fill in your name (at least 3 characters).';
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Please provide a valid email address.';
        }
        if ($message === '' || mb_strlen($message) < 10) {
            $errors[] = 'The message must be at least 10 characters long.';
        }

        if (!empty($errors)) {
            $this->render('contact/form', [
                'title'      => 'Contact',
                'errors'     => $errors,
                'old'        => ['name' => $name, 'email' => $email, 'subject' => $subject, 'message' => $message],
                'csrf_token' => CSRF::generateCSRFToken(),
                'captcha'    => Security::generateCaptcha()
            ]);
            return;
        }

        $sent = MailService::sendContactMessage($name, $email, $subject, $message);

        $this->render('contact/form', [
            'title'      => 'Contact',
            'success'    => $sent
                ? 'Thank you, your message has been sent. We will reply shortly.'
                : 'Your message was recorded, but the mail server did not confirm delivery.',
            'csrf_token' => CSRF::generateCSRFToken(),
            'captcha'    => Security::generateCaptcha()
        ]);
    }
}
