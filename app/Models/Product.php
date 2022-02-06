<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Middleware\LocaleMiddleware;

class Product extends Model
{
    use HasFactory;

    protected function getLocale()
    {
        $locale = LocaleMiddleware::getLocale();

        if($locale === null)
        {
            $locale = 'ua';
        }

        return $locale;
    }

    public function getName()
    {
        $locale = $this->getLocale();

        $translation = $this->translations()->select('name')->where('locale', $locale)->first();

        return !empty($translation->name) ? $translation->name : 'default';
    }

    public function getTinyDescription()
    {
        $locale = $this->getLocale();

        $translation = $this->translations()->select('head_description')->where('locale', $locale)->first();

        return !empty($translation->head_description) ? $translation->head_description : 'default';
    }

    public function getDescription()
    {
        $locale = $this->getLocale();

        $translation = $this->translations()->select('main_description')->where('locale', $locale)->first();

        return !empty($translation->main_description) ? $translation->main_description : 'default';
    }

    public function getTechPass()
    {
        $locale = $this->getLocale();

        $translation = $this->translations()->select('tech_passport')->where('locale', $locale)->first();

        return !empty($translation->tech_passport) ? $translation->tech_passport : '/img/default-tech.png';
    }

    public function getProperty()
    {
        $locale = $this->getLocale();

        $translation = $this->translations()->select('property_name')->where('locale', $locale)->first();

        return !empty($translation->property_name) ? $translation->property_name : null;
    }

    public function translations()
    {
        return $this->hasMany(Translations::class);
    }

    public function photos()
    {
        return $this->hasMany(ProductGallery::class);
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class);
    }
}
