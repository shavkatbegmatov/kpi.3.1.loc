<?php

if (user() === false) {
    redirect('/account/login');
}

if ($employee = R::findOne('employees', 'id = ?', [$data['id']])) {
    $employee['deleted'] = 1;
    R::store($employee);
}

redirect('/employee');