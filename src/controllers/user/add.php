<?php

if (user() === false) {
    redirect('/account/login');
}

$branches = R::findAll('branches');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['username'] != '' && $_POST['email'] != '' && $_POST['name'] != '' && $_POST['phone'] != '' && $_POST['password'] != '') {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $password = md5($_POST['password']);

        if (!R::findOne('users', 'username = ?', [$username])) {
            if (!R::findOne('users', 'email = ?', [$email])) {
                $user = R::dispense('users');
                $user['username'] = $username;
                $user['email'] = $email;
                $user['name'] = $name;
                $user['phone'] = $phone;
                $user['password'] = $password;
                $id = R::store($user);
    
                redirect('/user');
            } else {
                $_SESSION['message'] = [
                    'type' => 'danger',
                    'text' => 'Этот адрес электронной почты уже занят.'
                ];
            }
        } else {
            $_SESSION['message'] = [
                'type' => 'danger',
                'text' => 'Эта имя пользователя уже занята.'
            ];
        }
    }
}