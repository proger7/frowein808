<?php
    $font = './verdana.ttf';
    $fontsize = 16;
    $width = 120;
    $height = 40;
    $countLine = 5;
    //==========

    header('Content-type: image/png');
    $img = imagecreatetruecolor($width, $height);
    $red = imagecolorallocate($img, 223, 0, 34);
    imagefill($img, 0, 0, $red);
    $capchaText = '';

    $a = mt_rand(1, 19);
    $b = mt_rand(1, 19);
    $capchaText = $a . '+' . $b . '=';
    $capchaResult = $a + $b;

    for ($i = 0; $i < strlen($capchaText); $i++){
        $litteral = $capchaText[$i];
        $x = ($width - 20) / strlen($capchaText) * $i + 10;
        $y = $height - (($height - $fontsize) / 2);
        $color = imagecolorallocate($img, 255, 255, 255 );
        $naklon = rand(-10, 10);
        imagettftext($img, $fontsize, $naklon, $x, $y, $color, $font, $litteral);
    }
    // ==========

    // ==========
    for ($i = 0; $i < $countLine; $i++){
        $part = $width/100;
        $x1 = mt_rand(0, round($part*30));
        $y1 = mt_rand(0, $height);
        $x2 = mt_rand(round($part*70), round($part*100));
        $y2 = mt_rand(0, $height);

        $color = imagecolorallocate($img, 255, 255, 255 );
        imageline ($img, $x1, $y1, $x2, $y2, $color );
    }
    // ==========

    session_start();
    $_SESSION['capcha'] = $capchaResult;
    imagepng($img);
    imagedestroy($img);
