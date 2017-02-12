<?php
//call directly upon this to gen a captcha and session
ini_set('session.cookie_httponly', 1);
@session_start();

$font = '../fonts/mom.ttf';
$charset = '23456789abcdefghijklmnopqrstuvwxyz'; // corupt 0 and 1
$code_length = 4;
$height = 20;
$width = 60;

$code = '';
for($i=0; $i < $code_length; $i++) {
	$code = $code . substr($charset, mt_rand(0, strlen($charset) - 1), 1);
}

$font_size = $height * 0.7;
$image = @imagecreate($width, $height);
$background_color = @imagecolorallocate($image, 255, 255, 255);
$noise_color = @imagecolorallocate($image, 10, 5, 130);

for($i=0; $i < ($width * $height) / 4; $i++) {
  @imageellipse($image, mt_rand(0,$width), mt_rand(0,$height), 1, 1, $noise_color);
}

$text_color = @imagecolorallocate($image, 20, 40, 100);
@imagettftext($image, $font_size, 0,5,17, $text_color, $font , $code) or die('Cannot render TTF text.');

header('Content-Type: image/png');
@imagepng($image) or die('imagepng error!');
@imagedestroy($image);
$_SESSION['anti_spam'] = $code;
