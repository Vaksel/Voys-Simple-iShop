<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Order;
use App\Models\ProductCategory;


use App\Mail\OrderShipped;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use App\Http\Middleware\LocaleMiddleware;

class CatalogController extends Controller
{
    public function index()
    {
        $products = null;

        $loc = Cache::store('file')->get($_SERVER['REMOTE_ADDR'] . '_location');

        $ipAddress = $_SERVER['REMOTE_ADDR'];

        return view('catalog', compact('products', 'loc', 'ipAddress'));
    }

    public function categoryCatalog(Request $request)
    {
        $category = ProductCategory::select('id')->where(['url' => $request->category_url])->first();

        $products = Product::where(['category_id' => $category->id])->paginate(300);

        $loc = Cache::store('file')->get($_SERVER['REMOTE_ADDR'] . '_location');

        $ipAddress = $_SERVER['REMOTE_ADDR'];

        return view('catalog', compact('products', 'category', 'loc', 'ipAddress'));
    }

    public function product(Request $request)
    {
        $product = Product::where(['url' => $request->url])->first();

        $loc = Cache::store('file')->get($_SERVER['REMOTE_ADDR'] . '_location');

        $ipAddress = $_SERVER['REMOTE_ADDR'];

        return view('good2', compact('product', 'loc', 'ipAddress'));
    }

    /***
     * @param Request $request
     *
     */
    public function orderProduct(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'lastname' => 'required|max:255',
            'email' => 'required|email:rfc,dns',
            'propertyName' => 'required|max:255',
            'propertyValue' => 'required|max:255',

        ]);

        $product = Product::where(['url' => $request->url])->first();

        $factoryMail = config('app.factoryMail');

        $order = new Order();
        $order->name = $request->name;
        $order->lastname = $request->lastname;
        $order->email = $request->email;
        $order->propertyName = $request->propertyName;
        $order->propertyValue = $request->propertyValue;
        $order->productId = $product->id;
        $order->productName = $product->getName();

        $locale = LocaleMiddleware::getLocale();


        try {

            Mail::to($factoryMail)->send(new OrderShipped($order));

            switch ($locale)
            {
                case 'ru': {
                    $request->session()->flash('mailResultSuccess', 'Заказ успешно отправлен!');
                }
                default : {
                    $request->session()->flash('mailResultSuccess', 'Замовлення успішно відправлене!');
                }
            }

        }
        catch (\Exception $e)
        {
            switch ($locale)
            {
                case 'ru': {
                    $request->session()->flash('mailResultSuccess', 'При отправке произошла ошибка, обратитесь в тех.поддержку или попробуйте снова!');
                }
                default : {
                    $request->session()->flash('mailResultSuccess', "При відправці сталася помилка, зверніться в тех.підтримку або спробуйте знову!");
                }
            }
        }


        return redirect()->back();
    }
}
