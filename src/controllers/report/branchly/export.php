<?php

if (user() === false) {
    redirect('/account/login');
}

$year = isset($data['year']) ? $data['year'] : date('Y');
$month = isset($data['month']) ? $data['month'] : date('m');

// Обновляем SQL-запрос, добавляя подсчёт количества оценок
$sql = "
    SELECT 
        b.name AS branch_name,
        IFNULL(AVG(r.rate), 0) AS average_rate,
        COUNT(r.rate) AS rating_count
    FROM 
        rates r
    JOIN 
        employees e ON r.employee_code = e.code
    JOIN 
        branches b ON e.branch_code = b.code
    WHERE 
        MONTH(r.created_at) = ? AND YEAR(r.created_at) = ?
    GROUP BY 
        b.name
    ORDER BY 
        b.name ASC
";

$averageRatesPerBranch = R::getAll($sql, [$month, $year]);

$branchNames = [];
$averageRates = [];
$ratingsCounts = [];

// Заполняем массивы данными, включая количество оценок
foreach ($averageRatesPerBranch as $branch) {
    $branchNames[] = $branch['branch_name'];
    $averageRates[] = $branch['average_rate'];
    $ratingsCounts[] = $branch['rating_count'];
}

// Обновляем условие для определения отсутствия данных
$no_data = (array_sum($ratingsCounts) == 0);

header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
header("Content-Disposition: attachment; filename=BRB Отчет по филиалам ({$year} год {$month} месяц).xls");
header("Pragma: no-cache");
header("Expires: 0");

// Выводим BOM для поддержки UTF-8 в Excel
echo "\xEF\xBB\xBF";

?>

<table border="1">
    <thead>
        <tr>
            <th>Название филиала</th>
            <th>Средняя оценка за месяц</th>
            <th>Количество оценок</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!$no_data): ?>
            <?php foreach ($branchNames as $index => $branchName): ?>
                <tr>
                    <th><?php echo htmlspecialchars($branchName); ?></th>
                    <td><?php echo number_format($averageRates[$index], 2, '.', ''); ?></td>
                    <td><?php echo number_format($ratingsCounts[$index]); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="3">Данные отсутствуют</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
