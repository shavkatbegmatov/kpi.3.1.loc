<?php

if (user() === false) {
    redirect('/account/login');
}

$branches = R::findAll('branches');

$branch_code = isset($data['code']) ? $data['code'] : null;
$year = isset($data['year']) ? $data['year'] : date('Y');
$month = isset($data['month']) ? $data['month'] : date('m');

// Обновляем SQL-запрос, добавляя подсчёт количества оценок
$sql = "
    SELECT 
        e.name AS employee_name,
        IFNULL(AVG(r.rate), 0) AS average_rate,
        COUNT(r.rate) AS ratings_count
    FROM 
        employees e
    LEFT JOIN 
        rates r ON e.code = r.employee_code AND MONTH(r.created_at) = ? AND YEAR(r.created_at) = ?
    WHERE 
        e.branch_code = ?
    GROUP BY 
        e.name
    ORDER BY 
        e.name ASC
";

$averageRatesPerEmployee = R::getAll($sql, [$month, $year, $branch_code]);

$employeeNames = [];
$averageRates = [];
$ratingsCounts = [];

foreach ($averageRatesPerEmployee as $employee) {
    $employeeNames[] = $employee['employee_name'];
    $averageRates[] = $employee['average_rate'];
    $ratingsCounts[] = $employee['ratings_count'];
}

// Обновляем условие для определения отсутствия данных
$no_data = (array_sum($ratingsCounts) == 0);

header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
header("Content-Disposition: attachment; filename=BRB Отчет по сотрудникам филиала ({$year} год {$month} месяц).xls");
header("Pragma: no-cache");
header("Expires: 0");

// Выводим BOM для корректного отображения кириллицы
echo "\xEF\xBB\xBF";

?>

<table border="1">
    <thead>
        <tr>
            <th>Имя сотрудника</th>
            <th>Средняя оценка за месяц</th>
            <th>Количество оценок</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!$no_data): ?>
            <?php foreach ($averageRatesPerEmployee as $employee): ?>
                <tr>
                    <th><?php echo htmlspecialchars($employee['employee_name']); ?></th>
                    <td><?php echo number_format($employee['average_rate'], 2, '.', ''); ?></td>
                    <td><?php echo number_format($employee['ratings_count']); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="3">Данные отсутствуют</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
