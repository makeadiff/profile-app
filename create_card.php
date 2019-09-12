<?php
require('common.php');
require('phpqrcode/qrlib.php');

error_reporting(0);

$template_image = 'images/madcred.png';
$im = ImageCreateFromPng($template_image);

$user_id = intval($_REQUEST['user_id']);
$person = $sql->getAssoc("SELECT id,name, phone, email,facebook_id,photo FROM User WHERE id=$user_id AND status=1 AND user_type='volunteer'");
if(!$person) die("Invalid User ID");
$position = 'MAD Volunteer';
extract($person);

$black = imagecolorallocate($im, 0, 0, 0);
$madRed = imagecolorallocate($im, 237, 24, 73);
$phoneNumber = (string)$phone;
$phoneNumberAppended = checkCode($phoneNumber);

/*Parameters
	1. Image Vector Variable
	2. Font Size
	3. Inclination (degrees)
	4. X Pos
	5. Y Pos
	6. Color Code
	7. Fonts
	8. String to be placed.
*/
function appendZeros($string,$len){
    $nZ = 6-$len;
    //echo $nZ;
    $zeros="";
    for($i=0;$i<$nZ;$i++){
        $zeros.="0";
    }

    $final = $zeros.$string;
    return $final;
}

function checkCode($phone){
    $len = strlen($phone);
    $phoneWithCode = "+91-";
    if($len>10){
        for($i=($len-10);$i<$len;$i++){
            $phoneWithCode.=$phone[$i];
        }
    }
    else{
        $phoneWithCode.=$phone;
    }
    return $phoneWithCode;
}


$length = strlen($user_id);
$link = 'http://makeadiff.in/volunteer/'.$user_id;
$frame = QRcode::text($link, false, QR_ECLEVEL_L, 4,  0);
$qrcode = get_qrcode($frame);
$idNumber = (string)$user_id;
$idSixLength = appendZeros($idNumber,$length);
//echo $idSixLength;

ImageTtfText($im, 35, 0, 15, 323, $madRed, "fonts/BebasNeue-webfont.ttf", $name); // Name
ImageTtfText($im, 13, 0, 15, 343, $black, "fonts/BebasNeue-webfont.ttf", "MAD Volunteer");
ImageTtfText($im, 15, 0, 48, 382, $black, "fonts/univers.ttf",$phoneNumberAppended );
ImageTtfText($im, 15, 0, 48, 410, $black, "fonts/univers.ttf", $email);
ImageTtfText($im, 13, 0, 637, 324, $madRed, "fonts/BebasNeue-webfont.ttf", "MAD ID : ");
ImageTtfText($im, 13, 0, 682, 324, $madRed, "fonts/BebasNeue-webfont.ttf", $idSixLength);
ImageTtfText($im, 15, 0, 48, 432, $black, "fonts/univers.ttf", $link);
imagecopyresampled($im, $qrcode, 637, 336, 0, 0, 90, 90, 100, 100);
/*
	Parameters
	1. Final Image
	2. Sampled Image
	3. Start X
	4. Start Y
	5. Source X Point
	6. Source Y Point
	7. Image Width
	8. Image Height
	9. Source Width
	10. Source Height
    imagecopyresampled ( resource $dst_image , resource $src_image , int $dst_x , int $dst_y , int $src_x , int $src_y , int $dst_w , int $dst_h , int $src_w , int $src_h )
*/

if($person['photo'] and file_exists($user_upload_folder . $person['photo'])) {
    $profile_photo = ImageCreateFromJpeg($user_upload_folder . $person['photo']);

    // Resize to smaller size...
    $width = imagesx($profile_photo);
    $height= imagesy($profile_photo);
    $new_width = 163;
    $new_height = 0; // Calculate automatically
    $max_height = 205;
    
    //If the width or height is give as 0, find the correct ratio using the other value
    if(!$new_height and $new_width) $new_height = $height * $new_width / $width; //Get the new height in the correct ratio
    if($new_height and !$new_width) $new_width  = $width  * $new_height/ $height;//Get the new width in the correct ratio

    if($new_height > $max_height) $new_height = $max_height;

    imagecopyresampled($im, $profile_photo, 24, 55, 0, 0, $new_width, $new_height, $width, $height);

// Insert the Facebook profile photo into the MAD Cred
} elseif($person['facebook_id']) {
	$image_url = 'https://graph.facebook.com/v2.2/'.$person['facebook_id'].'/picture?type=large';
	$photo = load($image_url);

    if($photo) {
    	$temp_photo_file = "profile_photos/$user_id.jpg";
    	file_put_contents($temp_photo_file, $photo);
    	$profile_photo = ImageCreateFromJpeg($temp_photo_file);
    	imagecopyresampled($im, $profile_photo, 24, 55, 0, 0, 163, 205, 163, 205);
    	imagedestroy($profile_photo);
    	unlink($temp_photo_file);
    }
}

/// header('Content-Disposition: attachment; filename='.str_replace(' ', '_', $name).'_Card.png');
header("Content-type: image/png");
header('Pragma: no-cache');
imagepng($im);
imagedestroy($im);

function get_qrcode($frame) {
    $outerFrame = 0;
    $pixelPerPoint = 4;

    $h = count($frame);
    $w = strlen($frame[0]);

    $imgW = $w + 2 * $outerFrame;
    $imgH = $h + 2 * $outerFrame;

    $base_image = imagecreate($imgW, $imgH);

    $col[0] = imagecolorallocate($base_image,255,255,255); // BG, white
    $col[1] = imagecolorallocate($base_image,0,0,0);     // FG,

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
