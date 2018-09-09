<?php

session_start();

$num=rand(1000,9999);
$_SESSION["num"]=$num;
$image = imagecreatetruecolor(50, 24);
$image_b = imagecolorallocate($image, 255, 255, 255);
$image_f = imagecolorallocate($image, 0, 0, 0);
imagefill($image, 0, 0, $image_b);
imagestring($image, 5, 5, 5,  $num, $image_f);
header("Cache-Control: no-cache, must-revalidate");
header('Content-type: image/png');
imagepng($image);
imagedestroy($image);

?>