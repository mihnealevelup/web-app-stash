<?php
// formular de editare talent
/** @var array $talent */
/** @var string $csrf_token */
$formAction = '/admin/talents/update/' . (int) $talent['id'];
$submitLabel = 'Save changes';
require __DIR__ . '/_form.php';
