<?php

if (user() === false) {
    redirect('/account/login');
}

$employees = R::findAll('employees');

$date = date('Y-m-d H:i:s');

header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
header("Content-Disposition: attachment; filename=BRB Сотрудники ($date).xls");
header("Pragma: no-cache");
header("Expires: 0");

echo "\xEF\xBB\xBF";

?>

<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Код</th>
            <th>Ф.И.О</th>
            <th>Должность</th>
            <th>Номер телефона</th>
            <th>Филиал</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($employees as $employee): ?>
            <tr>
                <td style="vertical-align: middle;"><?php echo $employee['id']; ?></td>
                <td style="vertical-align: middle;"><?php echo $employee['code']; ?></td>
                <td style="vertical-align: middle;"><?php echo $employee['name']; ?></td>
                <td style="vertical-align: middle;"><?php echo $employee['position']; ?></td>
                <td style="vertical-align: middle;">
                    <?php
                        if (!empty($employee['phone'])) {
                            $phone = preg_replace("/[^0-9]/", "", $employee['phone']);
                            echo "+998 (" . substr($phone, 0, 2) . ") " . substr($phone, 2, 3) . "-" . substr($phone, 5, 2) . "-" . substr($phone, 7, 2);
                        } else {
                            echo "—";
                        }
                    ?>
                </td>
                <td>
                    <?php
                        $branch = R::findOne('branches', 'code = ?', [$employee['branch_code']]);
                    ?>
                    <?php echo $branch['name']; ?> (<?php echo $employee['branch_code']; ?>)
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>