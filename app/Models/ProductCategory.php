<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Middleware\LocaleMiddleware;

class ProductCategory extends Model
{
    use HasFactory;

    public function getName()
    {
        $locale = LocaleMiddleware::getLocale();

        switch ($locale)
        {
            case 'ru' : {
                $translation = $this->name_ru;
                break;
            }
            default : {
                $translation = $this->name_ua;
                break;
            }
        }

        return $translation;
    }
}
