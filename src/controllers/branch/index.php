<?php

if (user() === false) {
    redirect('/account/login');
}

$branches = array_reverse(R::findAll('branches', 'deleted = ?', [0]));