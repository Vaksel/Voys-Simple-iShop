<?php

use App\Http\Controllers\MonitoreController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\PatternController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\StatController;
use Illuminate\Support\Facades\Route;

Route::get('setlocale/{lang}', function ($lang) {

    $referer = Redirect::back()->getTargetUrl(); //URL предыдущей страницы
    $parse_url = parse_url($referer, PHP_URL_PATH); //URI предыдущей страницы

    //разбиваем на массив по разделителю
    $segments = explode('/', $parse_url);

    //Если URL (где нажали на переключение языка) содержал корректную метку языка
    if (in_array($segments[1], App\Http\Middleware\LocaleMiddleware::$languages)) {

        unset($segments[1]); //удаляем метку
    }

    //Добавляем метку языка в URL (если выбран не язык по-умолчанию)
    if ($lang != App\Http\Middleware\LocaleMiddleware::$mainLanguage){
        array_splice($segments, 1, 0, $lang);
    }

    //формируем полный URL
    $url = Request::root().implode("/", $segments);

    //если были еще GET-параметры - добавляем их
    if(parse_url($referer, PHP_URL_QUERY)){
        $url = $url.'?'. parse_url($referer, PHP_URL_QUERY);
    }
    return redirect($url); //Перенаправляем назад на ту же страницу

})->name('setlocale');

Route::get('/xDV5t9qotVH7tmfaC2MI2IeJ48YKBUKpkQ4uM6ENHS7JnMTHe4OtrKpVDXIEjyPsTwebIgIttnrRp0X599XMYDv6hZE5OzIXYZI', [StatController::class,'index'])->name('statIndex');

Route::group(['prefix' => App\Http\Middleware\LocaleMiddleware::getLocale()], function(){

Route::get('/', [MainController::class,'index'])->middleWare('statVisit')->name('index');

Route::get('/translateItems', [MainController::class,'getTranslatedItems'])->name('translateItems');

Route::get('/contact', [MainController::class,'contact'])->name('contact');

Route::get('/faq', [MainController::class,'faq'])->middleWare('statVisit')->name('faq');

Route::get('/about', [MainController::class,'about'])->middleWare('statVisit')->name('about');

Route::get('/catalog/{category_url}', [CatalogController::class,'categoryCatalog'])->middleWare('statVisit')->name('categoryCatalog');

Route::get('/catalog', [CatalogController::class,'index'])->middleWare('statVisit')->name('catalog');

Route::get('/product/{url}', [CatalogController::class,'product'])->middleWare('statVisit')->name('product');

Route::get('/good', [MainController::class,'good'])->middleWare('statVisit');

Route::get('/good2', [MainController::class,'good2'])->middleWare('statVisit');

Route::get('/redirect-page', [MainController::class,'visitTracking'])->name('visitTracking');

Route::post('/appeal', [MainController::class,'appeal'])->middleWare('statAppeal')->name('appeal');


Route::post('/order-product/{url}', [CatalogController::class,'orderProduct'])->middleWare('statVisit')->name('orderProduct');

});


