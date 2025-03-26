<?php

if (user() === false) {
    redirect('/account/login');
}

$id = $data['id'];

$start_date = isset($data['start_date']) ? $data['start_date'] : null;
$end_date = isset($data['end_date']) ? $data['end_date'] : null;

if ($employee = R::findOne('employees', 'id = ?', [$id])) {
    $ratesCondition = 'employee_code = ?';
    $params = [$employee['code']];

    if ($start_date && $end_date) {
        $ratesCondition .= ' AND created_at BETWEEN ? AND ?';
        array_push($params, $start_date, $end_date);
    }

    $rates = array_reverse(R::findAll('rates', $ratesCondition, $params));

    $criteriasSql = "
        SELECT 
            `index` AS `index`,
            COUNT(*) AS count
        FROM 
            criterias c
        JOIN 
            rates r ON c.rate_id = r.id
        WHERE 
            r.employee_code = ?
    ";

    if ($start_date && $end_date) {
        $criteriasSql .= " AND r.created_at BETWEEN ? AND ?";
        $criterias = R::getAll($criteriasSql . " GROUP BY `index` ORDER BY count DESC", [$employee->code, $start_date, $end_date]);
    } else {
        $criterias = R::getAll($criteriasSql . " GROUP BY `index` ORDER BY count DESC", [$employee->code]);
    }

    $totalCriteriasCount = array_sum(array_column($criterias, 'count'));

    $sql = "
        SELECT 
            r.rate,
            COUNT(*) AS count
        FROM 
            rates r
        WHERE 
            r.employee_code = ?
    ";

    if ($start_date && $end_date) {
        $sql .= " AND r.created_at BETWEEN ? AND ?";
        $ratesCount = R::getAll($sql . " GROUP BY r.rate ORDER BY r.rate ASC", [$employee->code, $start_date, $end_date]);
    } else {
        $ratesCount = R::getAll($sql . " GROUP BY r.rate ORDER BY r.rate ASC", [$employee->code]);
    }

    $allRates = [
        5 => ['rate' => 5, 'count' => 0],
        4 => ['rate' => 4, 'count' => 0],
        3 => ['rate' => 3, 'count' => 0],
        2 => ['rate' => 2, 'count' => 0],
        1 => ['rate' => 1, 'count' => 0],
    ];

    foreach ($ratesCount as $rateData) {
        $allRates[$rateData['rate']]['count'] = $rateData['count'];
    }

    $totalRatesCount = array_sum(array_column($allRates, 'count'));
} else {
    redirect('/employee');
}

function getBadgeColor($rate) {
    switch ($rate) {
        case 1:
            return 'bg-red';
        case 2:
            return 'bg-orange';
        case 3:
            return 'bg-yellow';
        case 4:
            return 'bg-lime';
        case 5:
            return 'bg-green';
    }
}

function getCriteriaColor($index) {
    return ($index < 5) ? 'bg-green-lt' : 'bg-red-lt';
}
