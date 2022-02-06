<?php

namespace App\Models;

use Error;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Middleware\LocaleMiddleware;

class Meta extends Model
{
    use HasFactory;

    protected static function getLocale()
    {
        $locale = LocaleMiddleware::getLocale();

        if($locale === null)
        {
            $locale = 'ua';
        }

        return $locale;
    }

    public static function getCollectionByPlace($place)
    {
        $locale = self::getLocale();
        $metaCollection = self::select('destination', 'value')->where(['place' => $place, 'locale' => $locale])->get();

        if(empty($metaCollection))
        {
            throw new Error('Такого мета-тега не найдено в базе данных!', 404);
        }

        return $metaCollection;
    }

    public static function getCollectionByProductId($productId)
    {
        $locale = self::getLocale();
        $metaCollection = self::select('destination', 'value')->where(['product_id' => $productId, 'locale' => $locale])->get();

        if(empty($metaCollection))
        {
            throw new Error('Такого мета-тега не найдено в базе данных!', 404);
        }

        return $metaCollection;
    }

    public static function getMetaFromCollectionByDestination($collection, $destination)
    {
        foreach ($collection as $item)
        {
            if($item->destination === $destination)
            {
                return $item->value;
            }
        }

        return '';
    }

    public function translations()
    {
        return $this->hasMany(Translations::class);
    }
}
