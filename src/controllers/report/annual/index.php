<?php

if (user() === false) {
    redirect('/account/login');
}

$year = isset($data['year']) ? $data['year'] : date('Y');

// Array of months with their numeric representations
$months = [
    'january'   => 1,
    'february'  => 2,
    'march'     => 3,
    'april'     => 4,
    'may'       => 5,
    'june'      => 6,
    'july'      => 7,
    'august'    => 8,
    'september' => 9,
    'october'   => 10,
    'november'  => 11,
    'december'  => 12,
];

// Initialize arrays with default values
$averageRate = array_fill_keys(array_keys($months), '0.00');
$ratingsCount = array_fill_keys(array_map(function($m) { return $m . '_count'; }, array_keys($months)), 0);

// Retrieve data in a single query
$results = R::getAll('
    SELECT MONTH(created_at) AS month, AVG(rate) AS avg_rate, COUNT(*) AS rate_count
    FROM rates
    WHERE YEAR(created_at) = ?
    GROUP BY MONTH(created_at)
', [$year]);

// Populate arrays with results
foreach ($results as $row) {
    $monthNumber = (int)$row['month'];
    $monthName = array_search($monthNumber, $months);
    if ($monthName !== false) {
        $averageRate[$monthName] = number_format($row['avg_rate'], 2);
        $ratingsCount[$monthName . '_count'] = number_format($row['rate_count']);
    }
}

$no_data = (array_sum($ratingsCount) == 0);

// Now you have $averageRate and $ratingsCount arrays containing data for each month