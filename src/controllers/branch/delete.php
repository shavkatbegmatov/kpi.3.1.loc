<?php

if (user() === false) {
    redirect('/account/login');
}

if ($branch = R::findOne('branches', 'id = ?', [$data['id']])) {
    $branch['deleted'] = 1;
    R::store($branch);
}

redirect('/branch');