<?php

if (user() === false) {
    redirect('/account/login');
}

$branches = R::findAll('branches');

$date = date('Y-m-d H:i:s');

header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
header("Content-Disposition: attachment; filename=BRB Филиалы ($date).xls");
header("Pragma: no-cache");
header("Expires: 0");

echo "\xEF\xBB\xBF";

?>

<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Код</th>
            <th>Название</th>
            <th>Адрес</th>
            <th>Номер телефона</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($branches as $branch): ?>
            <tr>
                <td style="vertical-align: middle;"><?php echo $branch['id']; ?></td>
                <td style="vertical-align: middle;"><?php echo $branch['code']; ?></td>
                <td style="vertical-align: middle;"><?php echo $branch['name']; ?></td>
                <td style="vertical-align: middle;"><?php echo $branch['address']; ?></td>
                <td style="vertical-align: middle;">
                    <?php
                        if (!empty($branch['phone'])) {
                            $phone = preg_replace("/[^0-9]/", "", $branch['phone']);
                            echo "+998 (" . substr($phone, 0, 2) . ") " . substr($phone, 2, 3) . "-" . substr($phone, 5, 2) . "-" . substr($phone, 7, 2);
                        } else {
                            echo "—";
                        }
                    ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>