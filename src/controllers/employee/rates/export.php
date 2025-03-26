<?php

if (user() === false) {
    redirect('/account/login');
}

if ($employee = R::findOne('employees', 'id = ?', [$data['id']])) {
    $rates = array_reverse(R::findAll('rates', 'employee_code = ?', [$employee['code']]));
} else {
    redirect('/employee');
}

header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
header("Content-Disposition: attachment; filename=BRB Оценка сотрудника ({$employee['name']}).xls");
header("Pragma: no-cache");
header("Expires: 0");

echo "\xEF\xBB\xBF";

?>

<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Оценка</th>
            <th>Критерии оценки</th>
            <th>IP адрес</th>
            <th>Дата/Время</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($rates as $rate): ?>
            <tr>
                <td><?php echo $rate['id']; ?></td>
                <td>
                    <?php echo $rate['rate']; ?> балла
                </td>
                <td>
                    <?php
                        $criterias = R::findAll('criterias', 'rate_id = ?', [$rate['id']]);

                        foreach ($criterias as $criteria) {
                            echo criteria_index_translate($criteria['index']) . ', ';
                        }
                    ?> 
                </td>
                <td><?php echo $rate['ip_address']; ?></td>
                <td><?php echo $rate['created_at']; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>