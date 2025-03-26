<?php

if (user() !== false) {
    redirect('/');
}

$title = 'Авторизация';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $captcha = $_POST['captcha_input'];

    if ($captcha != $_SESSION['captcha']) {
        $_SESSION['message'] = [
            'type' => 'danger',
            'text' => 'Символы с картинки введены неверно.'
        ];

        redirect('/account/login');
    }

    $user = R::findOne('users', 'username = ?', [$username]);

    if ($user) {
        if ($user['password'] == md5($password)) {
            $_SESSION['user']['id'] = $user['id'];
            $_SESSION['user']['last_activity'] = time();
    
            redirect('/account/v/' . $username);
        }
    }

    $_SESSION['message'] = [
        'type' => 'danger',
        'text' => 'Имя пользователя и/или пароль введены неверно.'
    ];
}