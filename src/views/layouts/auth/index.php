<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BRB<?php if (!empty($title)) echo (' | ' . $title) ?></title>

    <link rel="icon" type="image/png" href="/assets/static/logo-small.png">

    <link rel="stylesheet" href="/assets/dist/css/tabler.min.css">
    <link rel="stylesheet" href="/assets//dist/css/tabler-flags.min.css">
    <link rel="stylesheet" href="/assets//dist/css/tabler-payments.min.css">
    <link rel="stylesheet" href="/assets//dist/css/tabler-vendors.min.css">
    <link rel="stylesheet" href="/assets//dist/css/demo.min.css">
</head>

<body class="d-flex flex-column">
    <script src="/assets//dist/js/demo-theme.min.js"></script>

    <?php echo $content; ?>

    <script src="/assets//dist/js/tabler.min.js"></script>
    <script src="/assets//dist/js/demo.min.js"></script>
</body>

</html>