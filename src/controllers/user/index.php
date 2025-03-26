<?php

if (user() === false) {
    redirect('/account/login');
}

$users = array_reverse(R::findAll('users', 'deleted = ?', [0]));