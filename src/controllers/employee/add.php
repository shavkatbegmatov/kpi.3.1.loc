<?php

if (user() === false) {
    redirect('/account/login');
}

$branches = R::findAll('branches');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['name'] != '' && $_POST['position'] != '' && $_POST['branch'] != '' && $_POST['phone'] != '') {
        $uploadDir = BASE_URL . '/uploads/employees/';
        $file = $_FILES['photo'];
        $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        $allowedExtensions = ['png', 'jpeg', 'jpg'];

        if (in_array($fileExtension, $allowedExtensions)) {
            if ($file['error'] === UPLOAD_ERR_OK) {
                $newFileName = generateRandomCode(11) . '.' . $fileExtension;
                $uploadFile = $uploadDir . $newFileName;

                if (move_uploaded_file($file['tmp_name'], $uploadFile)) {
                    echo "Файл успешно загружен!";
                    
                    $name = $_POST['name'];
                    $position = $_POST['position'];
                    $branch = $_POST['branch'];
                    $phone = $_POST['phone'];

                    $employee = R::dispense('employees');
                    $employee['code'] = generateRandomCode(11);
                    $employee['name'] = $name;
                    $employee['position'] = $position;
                    $employee['branch_code'] = $branch;
                    $employee['phone'] = $phone;
                    $employee['photo'] = $newFileName;
                    $id = R::store($employee);

                    redirect('/employee');
                } else {
                    $_SESSION['message'] = [
                        'type' => 'danger',
                        'text' => 'Ошибка при загрузке файла!'
                    ];
                }
            } else {
                $_SESSION['message'] = [
                    'type' => 'danger',
                    'text' => 'Ошибка загрузки файла: ' . $file['error']
                ];
            }
        } else {
            $_SESSION['message'] = [
                'type' => 'danger',
                'text' => 'Недопустимый формат файла. Разрешены только .png, .jpeg, .jpg'
            ];
        }
    }
}