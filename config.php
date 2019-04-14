<?php

// Запрещает прямой запуск в обход index.php
defined('BEZNEVROZA') or die("Доступ запрещен...");

date_default_timezone_set('Europe/Riga');

$config = array(
    'db' => array(
        "database" => "celebry",
        "host" => "localhost",
        "username" => 'root',
        "password" => ""
    ),
    "default-theme" => "beznevroza",
    "controller-label" => 'c',
    "action-label" => 'act',
    "default-controller" => "audiosessionsController",
    "controllers" => array(
        "audiosessions" => "audiosessionsController",
        "abonements" => "abonementsController",
        "users" => "usersController",
        "orders" => "ordersController",
        "comments" => "commentsController",
        "ajax" => "ajaxController",
        "registration" => "registrationController",
        "authorization" => "authorizationController",
        "roles" => "rolesController",
        "finances" => "financesController",
        "support" => "supportController",
        "questions" => "questionsController"
    ),
    'payment' => array(
        'password1' => "eDntN7F7hIEx7Fcvky95",
        'password2' => "pA1xQKph2OO9ktX62ntw",
        'password1test' => "N7g24uMwbkLn5bzexqd0",
        'password2test' => "yXaSuGMt68gwFBP0T8a4",
        'login' => "testsdfjjkadkajdasdas"
    ),
    'audiosession-storage' => __DIR__.DIRECTORY_SEPARATOR.'media'.DIRECTORY_SEPARATOR.'audiosessions'.DIRECTORY_SEPARATOR,
    'player-path' => __DIR__.DIRECTORY_SEPARATOR.'media'.DIRECTORY_SEPARATOR.'player'.DIRECTORY_SEPARATOR
);