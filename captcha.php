<?php
session_start();
header("Content-type: image/png");

$width = 80;
$height = 30;
$img = imagecreate($width, $height);
$bg = imagecolorallocate($img, 255, 255, 255);
$textColor = imagecolorallocate($img, 0, 0, 0);

// 生成随机验证码
$chars = '23456789ABCDEFGHJKLMNPQRSTUVWXYZ';
$captcha = substr(str_shuffle($chars), 0, 4);
$_SESSION['captcha'] = $captcha;

// 绘制干扰线
for($i=0; $i<5; $i++) {
    $color = imagecolorallocate($img, rand(0,255), rand(0,255), rand(0,255));
    imageline($img, rand(0,$width), rand(0,$height), rand(0,$width), rand(0,$height), $color);
}

// 绘制文字
imagestring($img, 5, 15, 8, $captcha, $textColor);
imagepng($img);
imagedestroy($img);
?>