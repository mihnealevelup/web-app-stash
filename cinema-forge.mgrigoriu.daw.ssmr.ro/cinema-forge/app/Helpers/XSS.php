<?php

namespace Helpers;

function e($string) {
    // ENT_QUOTES transforms both single and double quotation marks
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}