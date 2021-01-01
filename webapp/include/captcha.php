<?php
// start the session to store the variable
SESSION_START();
 
// generate the random code
$chars = 'abcdefghkmnprstuvwxyzABCDEFGHJKLMNPQRSTUV2345689';
$length = 6;
$code = '';
FOR($i = 0; $i < $length; $i++){
   $pos = MT_RAND(0, STRLEN($chars)-1);
   $code .= SUBSTR($chars, $pos, 1);
}
 
// store the code to compare later
$_SESSION['captcha'] = $code;
 
// set up the image
// size
$width = 120;
$height = 30;
// colors
$r = MT_RAND(160, 255);
$g = MT_RAND(160, 255);
$b = MT_RAND(160, 255);
// create handle for new image
$image = imagecreate($width, $height);
// create color handles
$background = imagecolorallocate($image, $r, $g, $b);
$text = imagecolorallocate($image, $r-128, $g-128, $b-128);
// fill the background
imagefill($image, 0, 0, $background);
 
// add characters in random orientation
FOR($i = 1; $i <= $length; $i++){
   $counter = MT_RAND(0, 1);
   IF ($counter == 0){
      $angle = MT_RAND(0, 30);
   }
   IF ($counter == 1){
      $angle = MT_RAND(330, 360);
   }
   // "arial.ttf" can be replaced by any TTF font file stored in the same directory as the script
   putenv('GDFONTPATH=' . realpath('.'));
   imagettftext($image, MT_RAND(14, 18), $angle, ($i * 18)-8, MT_RAND(20, 25), $text, "arial.ttf", SUBSTR($code, ($i - 1), 1));
}
 
// draw a line through the text
imageline($image, 0, MT_RAND(5, $height-5), $width, MT_RAND(5, $height-5), $text);
 
// blur the image
$gaussian = ARRAY(ARRAY(1.0, 2.0, 1.0), ARRAY(2.0, 4.0, 2.0), ARRAY(1.0, 2.0, 1.0));
imageconvolution($image, $gaussian, 16, 0);
 
// add a border for looks
imagerectangle($image, 0, 0, $width - 1, $height - 1, $text);
 
// prevent caching
HEADER('Expires: Tue, 08 Oct 1991 00:00:00 GMT');
HEADER('Cache-Control: no-cache, must-revalidate');
 
// output the image
HEADER("Content-Type: image/gif");
imagegif($image);
imagedestroy($image); 
?>