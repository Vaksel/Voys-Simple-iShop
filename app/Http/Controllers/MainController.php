<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use App\Http\Middleware\LocaleMiddleware;
use App\Models\Order;
use App\Models\Product;
use App\Models\StatVisit;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;


use App\Mail\Appeal;
use Illuminate\Support\Facades\Mail;

class MainController extends Controller
{
    public function getTranslatedItems()
    {
        $products = Product::all();
        $productsTranslated = [];

        foreach ($products as $product)
        {
            foreach($product->photos as $photo)
            {
                $productName = Str::between($photo->path, '/img/', '.jpg');
                $productName = Order::doTranslate($productName);
                $productsTranslated[$photo->id] = $productName;
            }
        }

        ddd($productsTranslated);
    }
    public function index()
    {
        $products = Product::get();

        $productsArr = [];
        foreach ($products as $product)
        {
            $productsArr[$product->id] = $product;
        }

        $location = Cache::store('file')->get($_SERVER['REMOTE_ADDR'] . '_location');

        return view('index', ['ipAddress' => $_SERVER['REMOTE_ADDR'], 'productsArr' => $productsArr, 'loc' => $location]);
    }

    public function contact()
    {
        $reqResult = StatVisit::checkIsMobile();

        if(!empty($reqResult['mobile']))
        {
            $isMobile = true;
        }
        else
        {
            $isMobile = false;
        }

        $ipAddress = $_SERVER['REMOTE_ADDR'];

        $loc = Cache::store('file')->get($_SERVER['REMOTE_ADDR'] . '_location');

        return view('contact', compact('isMobile', 'ipAddress', 'loc'));
    }

    public function faq()
    {
        $location = Cache::store('file')->get($_SERVER['REMOTE_ADDR'] . '_location');

        return view('faq', ['ipAddress' => $_SERVER['REMOTE_ADDR'], 'loc' => $location]);
    }

    public function about()
    {
        $location = Cache::store('file')->get($_SERVER['REMOTE_ADDR'] . '_location');

        return view('about', ['ipAddress' => $_SERVER['REMOTE_ADDR'], 'loc' => $location]);
    }

    public function good()
    {
        $location = Cache::store('file')->get($_SERVER['REMOTE_ADDR'] . '_location');

        return view('good', ['ipAddress' => $_SERVER['REMOTE_ADDR'], 'loc' => $location]);
    }

    public function good2()
    {
        $location = Cache::store('file')->get($_SERVER['REMOTE_ADDR'] . '_location');

        return view('good2', ['ipAddress' => $_SERVER['REMOTE_ADDR'], 'loc' => $location]);
    }

    public function visitTracking()
    {
        $cachedReq = Cache::store('file')->get($_SERVER['REMOTE_ADDR'] . '_location');

        return view('visitTracking', ['cachedReq' => $cachedReq, 'ipAddress' => $_SERVER['REMOTE_ADDR']]);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function appeal(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email:rfc,dns',
            'phone' => 'required|max:255',
            'message' => 'required|max:1024',

        ]);

        $siteMail = config('app.siteMail', 'voys@blueberrywebwstudio.com');

        $order = new Order();
        $order->name = $request->name;
        $order->email = $request->email;
        $order->phone = $request->phone;
        $order->clientMessage = $request->message;

        $locale = LocaleMiddleware::getLocale();

        try {

            Mail::to($siteMail)->send(new Appeal($order));

            switch ($locale)
            {
                case 'ru': {
                    $request->session()->flash('mailResultSuccess', 'Заявка успешно отправлена!');
                }
                default : {
                    $request->session()->flash('mailResultSuccess', 'Заявка успішно відправлена!');
                }
            }
        }
        catch (\Exception $e)
        {
            $e = (string)$e;
            switch ($locale)
            {
                case 'ru': {
                    $request->session()->flash('mailResultError', 'При отправке произошла ошибка, обратитесь в тех.поддержку или попробуйте снова!');
                }
                default : {
                    $request->session()->flash('mailResultError', "При відправці сталася помилка, зверніться в тех.підтримку або спробуйте знову!");
                }
            }
        }


        return redirect()->back();
    }
}
