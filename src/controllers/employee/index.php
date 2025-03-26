<?php

if (user() === false) {
    redirect('/account/login');
}

$branches = R::findAll('branches');
$employees = array_reverse(R::findAll('employees', 'deleted = ?', [0]));