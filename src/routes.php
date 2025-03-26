<?php

get('/', function() {
    render('index');
});

get('/rate/:code', function($code) {
    render('rate', ['code' => $code], 'rate');
});

get('/employee', function() {
    render('employee/index');
});

get('/employee/add', function() {
    render('employee/add');
});

get('/employee/rates/:id', function($id) {
    render('employee/rates/index', ['id' => $id]);
});

get('/employee/rates/:id/:start_date/:end_date', function($id, $start_date, $end_date) {
    render('employee/rates/index', ['id' => $id, 'start_date' => $start_date, 'end_date' => $end_date]);
});

get('/employee/rates/export/:id', function($id) {
    render('employee/rates/export', ['id' => $id], 'no-layout');
});

get('/employee/change/:id', function($id) {
    render('employee/change', ['id' => $id]);
});

get('/employee/delete/:id', function($id) {
    render('employee/delete', ['id' => $id]);
});

get('/employee/export', function() {
    render('employee/export', 'no-layout');
});

get('/branch', function() {
    render('branch/index');
});

get('/branch/add', function() {
    render('branch/add');
});

get('/branch/change/:id', function($id) {
    render('branch/change', ['id' => $id]);
});

get('/branch/delete/:id', function($id) {
    render('branch/delete', ['id' => $id]);
});

get('/branch/export', function() {
    render('branch/export', 'no-layout');
});

get('/report/annual', function() {
    render('report/annual/index');
});

get('/report/annual/:year', function($year) {
    render('report/annual/index', ['year' => $year]);
});

get('/report/annual/export/:year', function($year) {
    render('report/annual/export', ['year' => $year], 'no-layout');
});

get('/report/branchly', function() {
    render('report/branchly/index');
});

get('/report/branchly/:year/:month', function($month, $year) {
    render('report/branchly/index', ['month' => $month, 'year' => $year]);
});

get('/report/branchly/export/:year/:month', function($month, $year) {
    render('report/branchly/export', ['month' => $month, 'year' => $year], 'no-layout');
});

get('/report/branch/:code', function() {
    render('report/branch/index');
});

get('/report/branch/:code/:year/:month', function($code, $month, $year) {
    render('report/branch/index', ['code' => $code, 'month' => $month, 'year' => $year]);
});

get('/report/branch/export/:code/:year/:month', function($code, $month, $year) {
    render('report/branch/export', ['code' => $code, 'month' => $month, 'year' => $year], 'no-layout');
});

get('/report/employee/:id', function($id) {
    render('report/employee/index', ['id' => $id]);
});

get('/report/employee/:id/:start_date/:end_date', function($id, $start_date, $end_date) {
    render('report/employee/index', ['id' => $id, 'start_date' => $start_date, 'end_date' => $end_date]);
});

get('/user', function() {
    render('user/index');
});

get('/user/add', function() {
    render('user/add');
});

get('/user/change/:id', function($id) {
    render('user/change', ['id' => $id]);
});

get('/user/delete/:id', function($id) {
    render('user/delete', ['id' => $id]);
});

get('/account/login', function() {
    render('account/login', 'auth');
});

get('/account/v/:username', function($username) {
    render('account/index', ['username' => $username]);
});

get('/account/settings/password', function() {
    render('account/settings/password');
});

get('/account/logout', function() {
    render('account/logout');
});

get('/account/captcha', function() {
    render('account/captcha', 'none');
});

get('*', function() {
   render('404', 'blank'); 
});

dispatch();