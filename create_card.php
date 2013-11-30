<?php
require('common.php');
require('phpqrcode/qrlib.php');

$template_image = 'images/card_template.png';
$im = ImageCreateFromPng($template_image);

$user_id = intval($_REQUEST['user_id']);
$person = $sql->getAssoc("SELECT name, phone, email FROM User WHERE id=$user_id AND status=1 AND user_type='volunteer'");
if(!$person) die("Invalid User ID");
$position = 'MAD Volunteer';
extract($person);

$user_url = 'http://makeadiff.in/volunteer/' . $user_id;

$frame = QRcode::text($user_url, false, QR_ECLEVEL_L, 4,  0); 
$qrcode = get_qrcode($frame);


$crayola = imagecolorallocate($im, 248, 0, 73);
$black = imagecolorallocate($im, 0, 0, 0);

ImageTtfText($im, 35, 0, 20, 280, $crayola, "fonts/BebasNeue-webfont.ttf", $name); // Name
ImageTtfText($im, 15, 0, 20, 310, $black, "fonts/BebasNeue-webfont.ttf", $position); //Position

ImageTtfText($im, 15, 0, 55, 360, $black, "fonts/Trebuchet.ttf", $phone); // Phone
ImageTtfText($im, 15, 0, 55, 390, $black, "fonts/Trebuchet.ttf", $email); // EMail

ImageTtfText($im, 20, 0, 20, 140, $crayola, "fonts/Trebuchet.ttf", $user_id); // EMail

$width = ImageSx($im);
$height= ImageSy($im);
$newimage = imagecreatetruecolor($width, $height);
imageCopyResampled($newimage,$im,0,0,0,0,$width,$height,$width,$height);
imagecopyresampled($newimage, $qrcode, 20, 20, 0, 0, 100, 100, 100, 100);

header("Content-type: image/png");
header('Content-Disposition: attachment; filename=Card.png');
header('Pragma: no-cache');

imagepng($newimage);
imagedestroy($newimage);


function get_qrcode($frame) {
	$outerFrame = 0;
    $pixelPerPoint = 4;
    
	$h = count($frame);
    $w = strlen($frame[0]);
    
    $imgW = $w + 2 * $outerFrame;
    $imgH = $h + 2 * $outerFrame;
    
    $base_image = imagecreate($imgW, $imgH);
    
    $col[0] = imagecolorallocate($base_image,255,255,255); // BG, white 
    $col[1] = imagecolorallocate($base_image,0,0,0);     // FG, Black

    imagefill($base_image, 0, 0, $col[0]);

    for($y=0; $y<$h; $y++) {
        for($x=0; $x<$w; $x++) {
            if ($frame[$y][$x] == '1') {
                imagesetpixel($base_image,$x+$outerFrame,$y+$outerFrame,$col[1]); 
            }
        }
    }
    
    // saving to file
    $target_image = imagecreate($imgW * $pixelPerPoint, $imgH * $pixelPerPoint);
    imagecopyresized(
        $target_image, 
        $base_image, 
        0, 0, 0, 0, 
        $imgW * $pixelPerPoint, $imgH * $pixelPerPoint, $imgW, $imgH
    ); 
	
	return $target_image;
}