<?php

namespace App\Services;

class Svg
{
    static private string $cssClass;

	static public function svgTag(string $body, string $size = '128'):string
	{
	    $cssClass = (!empty(self::$cssClass)) ? self::getCssClass(): '';
		return '<svg '.$cssClass.' xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="'.$size.'" height="'.$size.'" viewBox="0 0 '.$size.' '.$size.'" version="1.1">'.$body.'</svg>';
	}

	static public function rectTag(string $fill, int $size):string
	{
		return '<rect fill="'.$fill.'" width="'.$size.'" height="'.$size.'" r="'.($size/2).'" cy="'.($size/2).'" cx="'.($size/2).'" />';
	}

	static public function textTag(string $text, string $fill = '#000000',int $size = 128):string
	{
	    $text = TranslitService::convert($text);
	    $text = strtoupper($text);
		$size = (int)( ($size / 100) * 44 );
		return '<text x="50%" y="50%" style="color: #000000; line-height: 1;font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', \'Roboto\', \'Oxygen\', \'Ubuntu\', \'Fira Sans\', \'Droid Sans\', \'Helvetica Neue\', sans-serif;" alignment-baseline="middle" text-anchor="middle" font-size="'.$size.'" font-weight="400" dy=".1em" dominant-baseline="middle" fill="'.$fill.'">'.$text.'</text>';
	}

    /**
     * @return string
     */
    public static function getCssClass(): string
    {
        return ' class="'. self::$cssClass.'" ';
    }

    /**
     * @param string $cssClass
     */
    public static function setCssClass(string $cssClass): void
    {
        $cssClass = trim($cssClass);
        $cssClass = (string) preg_replace('#(\,|\s+)#si', ' ', $cssClass);
        self::$cssClass = $cssClass;
    }
}
