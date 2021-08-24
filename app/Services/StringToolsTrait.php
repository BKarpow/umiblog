<?php


namespace App\Services;


trait StringToolsTrait
{
    function translit(string $string):string
    {
        $chars_arr = array(
            "а" => "a",
            "б" => "b",
            "в" => "v",
            "г" => "g",
            "ґ" => "g",
            "д" => "d",
            "е" => "e",
            "ё" => "e",
            "э" => "e",
            "є" => "ie",
            "ж" => "zh",
            "з" => "z",
            "и" => "i",
            "ы" => "y",
            "і" => "i",
            "ї" => "i",
            "й" => "i",
            "к" => "k",
            "л" => "l",
            "м" => "m",
            "н" => "n",
            "о" => "o",
            "п" => "p",
            "р" => "r",
            "с" => "s",
            "т" => "t",
            "у" => "u",
            "ф" => "f",
            "х" => "kh",
            "ц" => "ts",
            "ч" => "ch",
            "ш" => "sh",
            "щ" => "shch",
            "ю" => "iu",
            "я" => "ya",

            "ь" => "",
            "Ь" => "",
            "ъ" => "",
            "Ъ" => "",
            "!" => "",
            "?" => "",
            ":" => "",
            ";" => "",
            "’" => "",
            "'" => "",
            "—" => "",
            "--" => "",
//        "-" => "", //Allow in file & title
//        "." => "", //Allow in file & title
            "@" => "",
            "#" => "",
            "^" => "",
            "*" => "",
            "(" => "",
            ")" => "",
            //"_" => "", //Allow in a widgets panel
            "=" => "",
            "+" => "",

            "₴" => "uah",
            "€" => "eur",
            "$" => "usd",
            "%" => "protsent",

            'à' => 'a',
            'ô' => 'o',
            'ď' => 'd',
            'ḟ' => 'f',
            'ë' => 'e',
            'š' => 's',
            'ơ' => 'o',
            'ß' => 'ss',
            'ă' => 'a',
            'ř' => 'r',
            'ț' => 't',
            'ň' => 'n',
            'ā' => 'a',
            'ķ' => 'k',
            'ŝ' => 's',
            'ỳ' => 'y',
            'ņ' => 'n',
            'ĺ' => 'l',
            'ħ' => 'h',
            'ṗ' => 'p',
            'ó' => 'o',
            'ú' => 'u',
            'ě' => 'e',
            'é' => 'e',
            'ç' => 'c',
            'ẁ' => 'w',
            'ċ' => 'c',
            'õ' => 'o',
            'ṡ' => 's',
            'ø' => 'o',
            'ģ' => 'g',
            'ŧ' => 't',
            'ș' => 's',
            'ė' => 'e',
            'ĉ' => 'c',
            'ś' => 's',
            'î' => 'i',
            'ű' => 'u',
            'ć' => 'c',
            'ę' => 'e',
            'ŵ' => 'w',
            'ṫ' => 't',
            'ū' => 'u',
            'č' => 'c',
            'ö' => 'oe',
            'è' => 'e',
            'ŷ' => 'y',
            'ą' => 'a',
            'ł' => 'l',
            'ų' => 'u',
            'ů' => 'u',
            'ş' => 's',
            'ğ' => 'g',
            'ļ' => 'l',
            'ƒ' => 'f',
            'ž' => 'z',
            'ẃ' => 'w',
            'ḃ' => 'b',
            'å' => 'a',
            'ì' => 'i',
            'ï' => 'i',
            'ḋ' => 'd',
            'ť' => 't',
            'ŗ' => 'r',
            'ä' => 'ae',
            'í' => 'i',
            'ŕ' => 'r',
            'ê' => 'e',
            'ü' => 'ue',
            'ò' => 'o',
            'ē' => 'e',
            'ñ' => 'n',
            'ń' => 'n',
            'ĥ' => 'h',
            'ĝ' => 'g',
            'đ' => 'd',
            'ĵ' => 'j',
            'ÿ' => 'y',
            'ũ' => 'u',
            'ŭ' => 'u',
            'ư' => 'u',
            'ţ' => 't',
            'ý' => 'y',
            'ő' => 'o',
            'â' => 'a',
            'ľ' => 'l',
            'ẅ' => 'w',
            'ż' => 'z',
            'ī' => 'i',
            'ã' => 'a',
            'ġ' => 'g',
            'ṁ' => 'm',
            'ō' => 'o',
            'ĩ' => 'i',
            'ù' => 'u',
            'į' => 'i',
            'ź' => 'z',
            'á' => 'a',
            'û' => 'u',
            'þ' => 'th',
            'ð' => 'dh',
            'æ' => 'ae',
            'µ' => 'u',
            'ĕ' => 'e',
            'œ' => 'oe',
            ' ' => '_',
        );
        if(function_exists('mb_strtolower')){
            $trans_string = mb_strtolower( urldecode($string) , 'UTF-8');
        }else{
            $trans_string = strtolower($trans_string);

        }
        $trans_string = str_replace(array_keys($chars_arr),array_values($chars_arr), $trans_string);
        $trans_string = preg_replace('/\_+/i', '_', $trans_string);
        $trans_string = preg_replace('/[^a-zA-Z0-9-_\.]/i', '', $trans_string);
        return $trans_string;
    }

    /**
     * Створює нове унікальне імя для файлу, яке підходить для сховища.
     * @param string $fileName
     * @param string $extension
     * @return string
     */
    public function getNameFileToStore(string $fileName, string $extension):string
    {
        return $fileName . '_' . now()->format('YmdHis') . '.' . $extension;
    }

    /**
     * Метод для корекції нляху до файлів сховища, для коректного доступу через браузер.
     * @param string $path
     * @return string
     */
    public function correctStoragePath(string $path):string
    {
        return preg_replace('#^public\/#i', '/storage/', $path);
    }
}
