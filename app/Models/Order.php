<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public $name,$email,$phone,$clientMessage;

    public static function doTranslate($data)
    {
        $letters = [
            "й"=>"y",
            "ї"=>"yi",
            "і"=>"i",
            "є"=>"ye",
            'ґ'=>'g`',
            "ц"=>"ts",
            "у"=>"u",
            "к"=>"k",
            "е"=>"e",
            "н"=>"n",
            "г"=>"g",
            "ш"=>"sh",
            "щ"=>"sch",
            "з"=>"th",
            "х"=>"h",
            "ъ"=>"",
            "ф"=>"f",
            "ы"=>"u",
            "в"=>"v",
            "а"=>"a",
            "п"=>"p",
            "р"=>"r",
            "о"=>"o",
            "л"=>"l",
            "д"=>"d",
            "ж"=>"zh",
            "э"=>"е",
            "ё"=>"ye",
            "я"=>"ya",
            "ч"=>"ch",
            "с"=>"s",
            "м"=>"m",
            "и"=>"i",
            "т"=>"t",
            "ь"=>"",
            "б"=>"b",
            "ю"=>"yu",
            "?"=>"",
            "!"=>"",
            " "=>"-",
            '"'=>'',
            "'"=>'',
            '.'=>'',
            ','=>'',
            '/'=>'-',
        ];

        $combinedString = [];
        if (is_array($data)) {
            foreach($data as $str) {
                $str = mb_strtolower($str);
                $combinedString[] = strtr($str, $letters);
            }
            $combinedString = implode('-', $combinedString);
        } else {
            $data = mb_strtolower($data);
            $combinedString = strtr($data, $letters);
        }

        return $combinedString;
    }
}
