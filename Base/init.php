<?php

require '../vendor/autoload.php';


function debug($attr) {
    echo '<pre>' . var_dump($attr) . '</pre>';
}

function isUserAuthorized(): bool
{
    return isset($_SESSION['user_id']);
}
