<?php

header("Content-type: image/png");

function generateCaptchaCode($length = 6) {
    $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789';
    $code = '';
    for ($i = 0; $i < $length; $i++) {
        $code .= $chars[rand(0, strlen($chars)-1)];
    }
    return $code;
}

$code = generateCaptchaCode();
$_SESSION["captcha"] = $code;

$image = imagecreatetruecolor(130, 40);

$bg = imagecolorallocate($image, 255, 255, 255);
$text_color = imagecolorallocate($image, 0, 0, 0);
$line_color = imagecolorallocate($image, 100, 100, 100);

imagefilledrectangle($image, 0, 0, 130, 40, $bg);

for ($i = 0; $i < 5; $i++) {
    imageline($image, rand(0, 130), rand(0, 40), rand(0, 130), rand(0, 40), $line_color);
}

for ($i = 0; $i < 1000; $i++) {
    $noise_color = imagecolorallocate($image, rand(150,255), rand(150,255), rand(150,255));
    imagesetpixel($image, rand(0,130), rand(0,40), $noise_color);
}

$font_size = 5;
$x = 10;
$y = 10;

imagestring($image, $font_size, $x, $y, $code, $text_color);

imagepng($image);
imagedestroy($image);
