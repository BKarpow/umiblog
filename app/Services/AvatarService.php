<?php

namespace App\Services;

// use App\Services\TranslitService;

class AvatarService
{

  const FONT_PATH = '/font/comforta.ttf';
  const FONT_SIZE = 32;

  static public function headerPng():void
  {
    header('Content-type: image/png');
  }

  static public function getSvgAvatar(string $nameUser):string
  {
      $av = new GenerateAvatar();
      return $av->getSvgAvatar($nameUser);
  }

  static public function generatePngAvatar(string $nameUser):void
  {
    $nameUser = TranslitService::convert($nameUser);
    $name = (function_exists('mb_strtoupper')) ? mb_strtoupper($nameUser, 'UTF-8') : strtoupper($nameUser);
    // $name = mb_strtoupper($name);
    $name = $name[0] ;
    $size = [100, 100];
    $im = imagecreatetruecolor($size[0], $size[1]);
    $color = imageColorAllocate($im, 255, 255, 255); //Цвет шрифта
    $w=(int)$size[0]; // ширина
    $h=(int)$size[1]; // высота
    $box = imagettfbbox(self::FONT_SIZE, 0, self::FONT_PATH, $name);
    $x = ($w/2)-($box[2]-$box[0])/2; //по оси x
    $y = ($h/2) + (self::FONT_SIZE / 2); //по оси y
    $colorsFill = [];
    // Определяем красный цвет #e91e63
    $colorsFill[] = imagecolorallocate($im, 0xE9, 0x1E, 0x63);
    //                                          #f44336
    $colorsFill[] = imagecolorallocate($im, 0xF4, 0x43, 0x36);
    //                                          #9c27b0
    $colorsFill[] = imagecolorallocate($im, 0x9C, 0x27, 0xB0);
    //                                          #880e4f
    $colorsFill[] = imagecolorallocate($im, 0x88, 0x0E, 0x4F);
    $randomColor = $colorsFill[ random_int(0, count($colorsFill)) ];
    // Делаем фон белым (по-умолчанию черный)
    imagefill($im, 1, 1, $randomColor);
    //Разметка самого текста
    imagettftext($im, self::FONT_SIZE, 0, $x, $y, $color, self::FONT_PATH, $name);
    // Выводим изображение
    imagepng($im);
  }
}
