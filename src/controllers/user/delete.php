<?php

if (user() === false) {
    redirect('/account/login');
}

if ($user = R::findOne('users', 'id = ?', [$data['id']])) {
    $user['deleted'] = 1;
    R::store($user);
}

redirect('/user');