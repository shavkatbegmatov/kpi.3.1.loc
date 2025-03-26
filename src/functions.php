<?php

function debug($data) {
    echo '<pre>' . $data . '</pre>';
}

function redirect($url) {
    header('Location: ' . $url);
    exit();
}

function generateRandomCode($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomCode = '';

    for ($i = 0; $i < $length; $i++) {
        $randomIndex = rand(0, $charactersLength - 1);
        $randomCode .= $characters[$randomIndex];
    }

    return $randomCode;
}

function criteria_index_translate($index) {
    $criteria_texts = [
        1 => 'Вежливость и профиссионализм',
        2 => 'Скорость обслуживания',
        3 => 'Стоимость услуг',
        4 => 'Комфортный офис',
        5 => 'Повысить вежливость сотрудников',
        6 => 'Повысить знания сотрудников',
        7 => 'Повысить скорость обслуживания',
        8 => 'Сократить очереди',
        9 => 'Сократить список требуемых документов',
        10 => 'Снизить тарифы',
        11 => 'Добавить больше продуктов и услуг',
        12 => 'Улучшить офисы',
    ];

    return $criteria_texts[$index];
}

function user() {
    if (isset($_SESSION['user'])) {
        $timestamp = $_SESSION['user']['last_activity'];
        $currentTimestamp = time();
        $secondsDifference = abs($currentTimestamp - $timestamp);

        if ($secondsDifference < (1800)) {
            $_SESSION['user']['last_activity'] = time();
            return R::findOne('users', 'id = ?', [$_SESSION['user']['id']]);
        } else {
            unset($_SESSION['user']);
            return false;
        }
    } else {
        return false;
    }
}