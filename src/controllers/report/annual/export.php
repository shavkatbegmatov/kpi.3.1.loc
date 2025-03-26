<?php

if (user() === false) {
    redirect('/account/login');
}

$year = isset($data['year']) ? $data['year'] : date('Y');

// Массив месяцев с их числовыми значениями и названиями на русском языке
$months = [
    'january'   => ['number' => 1,  'name' => 'Январь'],
    'february'  => ['number' => 2,  'name' => 'Февраль'],
    'march'     => ['number' => 3,  'name' => 'Март'],
    'april'     => ['number' => 4,  'name' => 'Апрель'],
    'may'       => ['number' => 5,  'name' => 'Май'],
    'june'      => ['number' => 6,  'name' => 'Июнь'],
    'july'      => ['number' => 7,  'name' => 'Июль'],
    'august'    => ['number' => 8,  'name' => 'Август'],
    'september' => ['number' => 9,  'name' => 'Сентябрь'],
    'october'   => ['number' => 10, 'name' => 'Октябрь'],
    'november'  => ['number' => 11, 'name' => 'Ноябрь'],
    'december'  => ['number' => 12, 'name' => 'Декабрь'],
];

// Инициализируем массивы для хранения средних оценок и количества оценок
$averageRate = [];
$ratingsCount = [];

// Выполняем один запрос для получения всех данных
$results = R::getAll('
    SELECT MONTH(created_at) AS month, AVG(rate) AS avg_rate, COUNT(*) AS rate_count
    FROM rates
    WHERE YEAR(created_at) = ?
    GROUP BY MONTH(created_at)
', [$year]);

// Инициализируем массивы значениями по умолчанию
foreach ($months as $monthKey => $monthData) {
    $averageRate[$monthKey] = '0.00';
    $ratingsCount[$monthKey . '_count'] = 0;
}

// Заполняем массивы данными из результата запроса
foreach ($results as $row) {
    $monthNumber = (int)$row['month'];
    $avgRate = (float)$row['avg_rate'];
    $rateCount = (int)$row['rate_count'];
    foreach ($months as $monthKey => $monthData) {
        if ($monthData['number'] === $monthNumber) {
            $averageRate[$monthKey] = number_format($avgRate, 2, '.', '');
            $ratingsCount[$monthKey . '_count'] = number_format($rateCount);
            break;
        }
    }
}

$no_data = (array_sum($ratingsCount) == 0);

header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
header("Content-Disposition: attachment; filename=BRB Отчет по месяцам ({$year} год).xls");
header("Pragma: no-cache");
header("Expires: 0");

// Выводим BOM для корректного отображения кириллицы
echo "\xEF\xBB\xBF";
?>

<table border="1">
    <thead>
        <tr>
            <th>Месяц</th>
            <th>Средняя оценка по всем филиалам</th>
            <th>Количество оценок</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($months as $monthKey => $monthData): ?>
            <tr>
                <th><?php echo $monthData['name'] . " " . $year; ?></th>
                <td><?php echo $averageRate[$monthKey]; ?></td>
                <td><?php echo $ratingsCount[$monthKey . '_count']; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
