<?php

if (user() === false) {
    redirect('/account/login');
}

if ($branch = R::findOne('branches', 'id = ?', [$data['id']])) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if ($_POST['code'] != '' && $_POST['name'] != '' && $_POST['address'] != '' && $_POST['phone'] != '') {
            $code = $_POST['code'];
            $name = $_POST['name'];
            $address = $_POST['address'];
            $phone = $_POST['phone'];
    
            if (!R::findOne('branches', 'code = ? AND id != ?', [$code, $branch['id']])) {
                $branch['code'] = $code;
                $branch['name'] = $name;
                $branch['address'] = $address;
                $branch['phone'] = $phone;
                $id = R::store($branch);
    
                redirect('/branch');
            } else {
                $_SESSION['message'] = [
                    'type' => 'danger',
                    'text' => 'Этот код уже занят.'
                ];
            }
    
        }
    }
} else {
    redirect('/branch');
}