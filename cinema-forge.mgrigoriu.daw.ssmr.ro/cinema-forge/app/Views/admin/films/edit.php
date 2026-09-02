<?php
// formular de editare film
/** @var array $film */
/** @var string $csrf_token */
$formAction = '/admin/films/update/' . (int) $film['id'];
$submitLabel = 'Save changes';
require __DIR__ . '/_form.php';
