<?php

if (user() === false) {
    redirect('/account/login');
}

$year = isset($data['year']) ? $data['year'] : date('Y');
$month = isset($data['month']) ? $data['month'] : date('m');

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

foreach ($averageRatesPerBranch as $branch) {
    $branchNames[] = $branch['branch_name'];
    $averageRates[] = $branch['average_rate'];
    $ratingsCounts[] = $branch['rating_count'];
}

$no_data = (array_sum($ratingsCounts) == 0); // Check if there are any ratings

// Now you have $branchNames, $averageRates, and $ratingsCounts arrays containing data for each branch
