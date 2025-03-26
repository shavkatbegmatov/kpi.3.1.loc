<?php

if (user() === false) {
    redirect('/account/login');
}

$branches = R::findAll('branches');

if ($user = R::findOne('users', 'id = ?', [$data['id']])) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if ($_POST['username'] != '' && $_POST['email'] != '' && $_POST['name'] != '' && $_POST['phone'] != '') {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $name = $_POST['name'];
            $phone = $_POST['phone'];

            if (!R::findOne('users', 'username = ? AND id != ?', [$username, $data['id']])) {
                if (!R::findOne('users', 'email = ? AND id != ?', [$email, $data['id']])) {
                    $user['username'] = $username;
                    $user['email'] = $email;
                    $user['name'] = $name;
                    $user['phone'] = $phone;
                    
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
} else {
    redirect('/user');
}