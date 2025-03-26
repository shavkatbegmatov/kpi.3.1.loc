<?php

if (OLD_QR_CODE_URL === true) {
    $code = $_GET['code'];
} else {
    $code = $data['code'];
}
$ip_address = filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP);

if (R::findOne('rates', 'employee_code = ? AND ip_address = ?', [$code, $ip_address])) {
    $_SESSION['rated'] = true;
} elseif ($employee = R::findOne('employees', 'code = ?', [$code])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $rate = $_POST['rate'];
        $advantages = isset($_POST['advantages']) ? $_POST['advantages'] : [];
        $disadvantages = isset($_POST['disadvantages']) ? $_POST['disadvantages'] : [];
        $disadvantage_other = trim($_POST['disadvantage-other']);

        $rateBean = R::dispense('rates');
        $rateBean['employee_code'] = $employee['code'];
        $rateBean['rate'] = $rate;
        if ($disadvantage_other) {
            $rateBean['text'] = $disadvantage_other;
        }
        $rateBean['ip_address'] = $ip_address;
        $id = R::store($rateBean);

        if ($rate == 5) {
            if (!empty($advantages)) {
                foreach ($advantages as $advantage) {
                    $supplementaryBean = R::dispense('supplementaries');
                    $supplementaryBean['rate_id'] = $id;
                    $supplementaryBean['supplementary'] = $advantage;
                    R::store($supplementaryBean);
                }
            }
        } else {
            if (!empty($disadvantages)) {
                foreach ($disadvantages as $disadvantage) {
                    $supplementaryBean = R::dispense('supplementaries');
                    $supplementaryBean['rate_id'] = $id;
                    $supplementaryBean['supplementary'] = $disadvantage;
                    R::store($supplementaryBean);
                }
            }
        }

        $_SESSION['rated'] = true;
    }
}
