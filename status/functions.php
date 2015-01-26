<?php
/**
 * Created by ECHO360 co.,ltd.
 * User: Wararit Satitnimankan
 * Date: 6/11/2557
 * Time: 14:01 น.
 */
include_once('libs/class/game_status.class.php');
?>

    <script>
        window.fbAsyncInit = function() {
            FB.init({
                appId      : '1499945126956049',
                xfbml      : true,
                version    : 'v2.2'
            });
        };

        (function(d, s, id){
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {return;}
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>

<?php

$gameStatus = new gameStatusClass();
$getStatusAction = $gameStatus->getStatusAction();
$getStatusFeeling = $gameStatus->getStatusFeeling();
$getStatusPerson = $gameStatus->getStatusPerson();
$getStatusPlace = $gameStatus->getStatusPlace();

$lengthStatusAction = array_rand($getStatusAction, 1);
$lengthStatusFeeling = array_rand($getStatusFeeling, 1);
$lengthStatusPerson = array_rand($getStatusPerson, 1);
$lengthStatusPlace = array_rand($getStatusPlace, 1);

$string = "<p style='text-align: center; position: relative;'>"
    .'<u>'.$_POST['userName'].'</u> '
    .$getStatusFeeling[$lengthStatusFeeling][1]
    ."<br/>"
    .$getStatusAction[$lengthStatusAction][1]
    ."กับ "
    .'<u>'.$getStatusPerson[$lengthStatusPerson][1].'</u>'
    ."<br/>"
    .'ที่'
    .$getStatusPlace[$lengthStatusPlace][1]
    ."<br/>"
    ."<div id='powerBy' style='position: absolute; bottom: 0; right: 0; float: right;'>"
    ."<span style='font-size: 14px; '>Power by :</span>"
    ."<img src='libs/img/logo-2.png' height='35' style=''/>"
    ."</div>"
    ."</p>"; // String




$font = 'libs/fonts/PSLxOmyim.ttf';
$canvas = imagecreatetruecolor(504, 504);
$whiteBg = imagecolorallocate($canvas, 255, 255, 255);
$color = ImageColorAllocate($canvas, 0, 0, 0); // Text Color
imagefill($canvas, 0, 0, $whiteBg);
$imgLogo = imagecreatefrompng('libs/img/bg/logo.png');

//imagecopy($canvas, $imgBg, 0, 0, 0, 0, 504, 504);
imagecopy($canvas, $imgLogo, 330, 415, 0, 0, 150, 61);

$string2 = $_POST['userName'].' '.$getStatusFeeling[$lengthStatusFeeling][1];
$string3 = $getStatusAction[$lengthStatusAction][1].' กับ '.$getStatusPerson[$lengthStatusPerson][1];
$string4 = 'ที่ '.$getStatusPlace[$lengthStatusPlace][1];
// get image dimensions
list($img_width, $img_height,,) = getimagesize('libs/img/bg/blank_bg.png');


// find font-size for $txt_width = 80% of $img_width...
$font_size2 = 1;
$font_size3 = 1;
$font_size4 = 1;
$txt_max_width = intval(0.8 * $img_width);

do {

    $font_size2++;
    $p2 = imagettfbbox($font_size2,0,$font,$string2);
    $txt_width2=$p2[2]-$p2[0];
    // $txt_height=$p[1]-$p[7]; // just in case you need it

} while ($txt_width2 <= $txt_max_width);
do {

    $font_size3++;
    $p3 = imagettfbbox($font_size3,0,$font,$string3);
    $txt_width3=$p3[2]-$p3[0];
    // $txt_height=$p[1]-$p[7]; // just in case you need it

} while ($txt_width3 <= $txt_max_width);
do {

    $font_size4++;
    $p4 = imagettfbbox($font_size4,0,$font,$string4);
    $txt_width4=$p4[2]-$p4[0];
    // $txt_height=$p[1]-$p[7]; // just in case you need it

} while ($txt_width4 <= $txt_max_width);

// now center text...
$x2 = ($img_width - $txt_width2) / 2;
$x3 = ($img_width - $txt_width3) / 2;
$x4 = ($img_width - $txt_width4) / 2;
$y2 = $img_height * 0.3; // baseline of text at 90% of $img_height
$y3 = $img_height * 0.5; // baseline of text at 90% of $img_height
$y4 = $img_height * 0.7; // baseline of text at 90% of $img_height
imagettftext($canvas, $font_size2, 0, $x2, $y2, $color, $font, $string2);
imagettftext($canvas, $font_size3, 0, $x3, $y3, $color, $font, $string3);
imagettftext($canvas, $font_size2, 0, $x4, $y4, $color, $font, $string4);

imagepng($canvas,"demo-gd.png");
echo "<center><img src='demo-gd.png'></center>";
/*
 $string2 = "freebie".$getStatusFeeling[$lengthStatusFeeling][1];
$pxX = (Imagesx($canvas) - (strlen($string2)*5) )/ 2; // X
$pxY = Imagesy($canvas) - 450; // Y
ImagettfText($canvas, 20, 0, $x, $y, $color, $font, $string2);

$string3 = $getStatusAction[$lengthStatusAction][1].' กับ '.$getStatusPerson[$lengthStatusPerson][1];
$pxX = (Imagesx($canvas) - (strlen($string2)*5) )/ 2; // X
$pxY = Imagesy($canvas) - 350; // Y
ImagettfText($canvas, 20, 0, $pxX, $pxY, $color, $font, $string3);

$string4 = 'ที่ '.$getStatusPlace[$lengthStatusPlace][1];
$pxX = (Imagesx($canvas) - (strlen($string2)*5) )/ 2; // X
$pxY = Imagesy($canvas) - 250; // Y
ImagettfText($canvas, 20, 0, $pxX, $pxY, $color, $font, $string4);

$im = ImageCreateFromJpeg("libs/img/bg/source-bg.jpg"); // Path Images
$color = ImageColorAllocate($im, 0, 0, 0); // Text Color
$pxX = (Imagesx($im) - 4 * strlen($string))/2; // X
$pxY = Imagesy($im)/2; // Y
ImagettfText($im, 20, 0, $pxX, $pxY, $color, $font, $string);

$imgLogo = imagecreatefrompng("libs/img/logo.png"); // Path Images
$background = imagecolorallocate($imgLogo, 0, 0, 0);// integer representation of the color black (rgb: 0,0,0)
imagecolortransparent($imgLogo, $background);// removing the black from the placeholder
imagealphablending($imgLogo, false);// turning off alpha blending (to ensure alpha channel information is preserved, rather than removed (blending with the rest of the image in the form of black))
imagesavealpha($imgLogo, true);// turning on alpha channel information saving (to ensure the full range of transparency is preserved)
$pxX = (Imagesx($im) - 4)/1.32; // X
$pxY = Imagesy($im) - 10; // Y
ImagettfText($im, 20, 0, $pxX, $pxY, $color, $font, $imgLogo);

imagePng($im,"demo-gd.png");
ImageDestroy($im);

echo $string;
echo "<center><img src='demo-gd.png'></center>";
*/
?>
<div
    class="fb-like"
    data-share="true"
    data-width="450"
    data-show-faces="true">
</div>

