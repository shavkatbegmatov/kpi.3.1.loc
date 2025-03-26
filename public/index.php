<?php

session_start();

error_reporting(E_ALL);

const BASE_URL = __DIR__;
const SRC = __DIR__ . '/../src/';
const OLD_QR_CODE_URL = true;

require SRC . 'connect/db.php';
require SRC . 'functions.php';
require SRC . 'router.php';