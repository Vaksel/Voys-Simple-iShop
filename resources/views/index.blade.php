
@php use App\Models\Meta;
    $meta = Meta::getCollectionByPlace('index');
@endphp

@extends('voyus-layout')

@section('meta')
    <title>{{Meta::getMetaFromCollectionByDestination($meta, 'title')}}</title>
    <meta name="description" content="{{Meta::getMetaFromCollectionByDestination($meta, 'description')}}">
    <meta name="keywords" content="{{Meta::getMetaFromCollectionByDestination($meta, 'keywords')}}">
    <meta property="og:image" content="{{Meta::getMetaFromCollectionByDestination($meta, 'og:image')}}">
    <meta property="og:title" content="{{Meta::getMetaFromCollectionByDestination($meta, 'og:title')}}">
    <meta name="google-site-verification" content="zGZq-F5kAbtA45JSbyS41poA9YRRMabsYIjgyUjlUoo" />
    <meta property="og:description" content="{{Meta::getMetaFromCollectionByDestination($meta, 'og:description')}}">
@endsection

@section('content')
    <script>
        var ipAddress = '{{$ipAddress}}';
        var loc = '{{$loc}}';

        var options = {
            enableHighAccuracy: true,
            timeout: 5000,
            maximumAge: 0
        };

        function success(pos) {
            var crd = pos.coords;

            // console.log(crd);

            setCookie('cookie_coord_' + ipAddress, JSON.stringify({lat: crd.latitude, lng: crd.longitude}), {'max-age' : 600});

            location.reload();
        };

        function error(err) {
            if(err.message === 'User denied geolocation prompt')
            {
                console.log('userDenied');
                setCookie('location_denied',1, {'max-age' : 600});

                location.reload();
            }

            setCookie('location_denied',1, {'max-age' : 600});

            location.reload();

        };

        console.log(loc);


        if((getCookie('location_denied') === undefined || getCookie('location_denied') === null) &&
                (loc === undefined || loc === null || loc === ''))
        {
            console.log(loc);
            navigator.geolocation.getCurrentPosition(success, error, options);
        }

        function setCookie(name, value, options = {}) {

            options = {
                path: '/',
                // при необходимости добавьте другие значения по умолчанию
                ...options
            };

            if (options.expires instanceof Date) {
                options.expires = options.expires.toUTCString();
            }

            let updatedCookie = encodeURIComponent(name) + "=" + encodeURIComponent(value);

            for (let optionKey in options) {
                updatedCookie += "; " + optionKey;
                let optionValue = options[optionKey];
                if (optionValue !== true) {
                    updatedCookie += "=" + optionValue;
                }
            }

            document.cookie = updatedCookie;
        }

        function getCookie(name) {
            let matches = document.cookie.match(new RegExp(
                    "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
            ));
            return matches ? decodeURIComponent(matches[1]) : undefined;
        }

    </script>
    <h1 class="index_h1">{{Meta::getMetaFromCollectionByDestination($meta, 'h1')}}</h1>

    <div class="container mt-2">
        <div class="row align-items-center">
            <div class="col-md-4">
                <div class="d-flex flex-column justify-content-between">
                    <span class="header--text__bg">{{__('index.aboutCompanyInfoTitle')}}</span>
{{--                    <span class="header--text">--}}
{{--                        {{__('index.aboutCompanyInfo')}}--}}
{{--                    </span>--}}
                </div>
            </div>
            <div class="col-md-4">
                <img class="w-100" src="img/logo.png" alt="">

            </div>
            <div class="col-md-4">
                <div class="d-flex flex-column justify-content-between">
                <span class="header--text__bg" style="line-height: 25px">
                    +380977212172
                    <br>
                    +380672012022
                    <br>
                    +380673002022
                </span>
{{--                    <span class="header--text">--}}
{{--                     {{__('index.aboutCompanyInfo2')}}--}}
{{--                    </span>--}}
                </div>
            </div>
        </div>
    </div>

        @include('categories')




<section>
    <div class="rt-container">
        <div class="col-rt-12">
            <div class='demo-container'>
                <div class='carousel'>
                    <input checked='checked' class='carousel__activator' id='carousel-slide-activator-1' name='carousel' type='radio'>
                    <input class='carousel__activator' id='carousel-slide-activator-2' name='carousel' type='radio'>
                    <input class='carousel__activator' id='carousel-slide-activator-3' name='carousel' type='radio'>
                    <div class='carousel__controls'>
                        <label class='carousel__control carousel__control--forward' for='carousel-slide-activator-2'>
                            <img src="img/arrow-right.png" alt="">
                        </label>
                    </div>
                    <div class='carousel__controls'>
                        <label class='carousel__control carousel__control--backward' for='carousel-slide-activator-1'>
                            <img src="img/arrow-left.png" alt="">
                        </label>
                        <label class='carousel__control carousel__control--forward' for='carousel-slide-activator-3'>
                            <img src="img/arrow-right.png" alt="">
                        </label>
                    </div>
                    <div class='carousel__controls'>
                        <label class='carousel__control carousel__control--backward' for='carousel-slide-activator-2'>
                            <img src="img/arrow-left.png" alt="">
                        </label>
                    </div>
                    <div class='carousel__screen'>
                        <div class='carousel__track'>
                            <div class='carousel__item carousel__item--mobile-in-1 carousel__item--tablet-in-2 carousel__item--desktop-in-3'>
                                <div class='demo-content'>
                                    <div class="slider--img">
                                        <img src="/img/7-1т.чор.jpg" alt="">
                                    </div>
                                    <span>{{{$productsArr[1]->getName()}}}</span>
                                </div>
                            </div>
                            <div class='carousel__item carousel__item--mobile-in-1 carousel__item--tablet-in-2 carousel__item--desktop-in-3'>
                                <div class='demo-content'>
                                    <div class="slider--img">
                                        <img src="/img/8-1т.зел.jpg" alt="">
                                    </div>
                                    <span>{{{$productsArr[14]->getName()}}}</span>
                                </div>
                            </div>
                            <div class='carousel__item carousel__item--mobile-in-1 carousel__item--tablet-in-2 carousel__item--desktop-in-3'>
                                <div class='demo-content'>
                                    <div class="slider--img">
                                        <img src="/img/7-1,5т.чор.jpg" alt="">
                                    </div>
                                    <span>{{{$productsArr[15]->getName()}}}</span>
                                </div>
                            </div>

                            <div class='carousel__item carousel__item--mobile-in-1 carousel__item--tablet-in-2 carousel__item--desktop-in-3'>
                                <div class='demo-content'>
                                    <div class="slider--img">
                                        <img src="/img/6-4,5т.чор.jpg" alt="">
                                    </div>
                                    <span>{{{$productsArr[17]->getName()}}}</span>
                                </div>
                            </div>
                            <div class='carousel__item carousel__item--mobile-in-1 carousel__item--tablet-in-2 carousel__item--desktop-in-3'>
                                <div class='demo-content'>
                                    <div class="slider--img">
                                        <img src="/img/1-В125.jpg" alt="">
                                    </div>
                                    <span>{{{$productsArr[19]->getName()}}}</span>
                                </div>
                            </div>
                            <div class='carousel__item carousel__item--mobile-in-1 carousel__item--tablet-in-2 carousel__item--desktop-in-3'>
                                <div class='demo-content'>
                                    <div class="slider--img">
                                        <img src="/img/2-С250.jpg" alt="">
                                    </div>
                                    <span>{{{$productsArr[20]->getName()}}}</span>
                                </div>
                            </div>
                            <div class='carousel__item carousel__item--mobile-in-1 carousel__item--tablet-in-2 carousel__item--desktop-in-3'>
                                <div class='demo-content'>
                                    <div class="slider--img">
                                        <img src="/img/1-конус.jpg" alt="">
                                    </div>
                                    <span>{{{$productsArr[21]->getName()}}}</span>
                                </div>
                            </div>
                            <div class='carousel__item carousel__item--mobile-in-1 carousel__item--tablet-in-2 carousel__item--desktop-in-3'>
                                <div class='demo-content'>
                                    <div class="slider--img">
                                        <img src="/img/1-кільце.jpg" alt="">
                                    </div>
                                    <span>{{{$productsArr[22]->getName()}}}</span>
                                </div>
                            </div>
                            <div class='carousel__item carousel__item--mobile-in-1 carousel__item--tablet-in-2 carousel__item--desktop-in-3'>
                                <div class='demo-content'>
                                    <div class="slider--img">
                                        <img src="/img/2-колодязь.jpg" alt="">
                                    </div>
                                    <span>{{{$productsArr[56]->getName()}}}</span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<div class=" " style="margin-top: 10vh">
{{--<div class="shar--two__down " style="margin-top: 10vh">--}}
    <div class="container features ">
        <div class="row ">

            <div class="col-md-4 features--title d-flex align-items-center">
                <span>{{__('index.benefits')}}</span>
            </div>
            <div class="col-md-8">
                <div class="d-flex align-items-center features--item">
                    <img src="img/done_black.png" alt="">
                    <span>
                        {{__('index.benefit1')}}
                    </span>
                </div>
                <div class="d-flex align-items-center features--item">
                    <img src="img/done_black.png" alt="">
                    <span>
                        {{__('index.benefit2')}}
                    </span>
                </div>
                <div class="d-flex align-items-center features--item">
                    <img src="img/done_black.png" alt="">
                    <span>
                        {{__('index.benefit3')}}
                    </span>
                </div>
                <div class="d-flex align-items-center features--item">
                    <img src="img/done_black.png" alt="">
                    <span>
                        {{__('index.benefit4')}}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="container materials">
        <div class="row">
            <div class="col-md-5 ">
                <div class="materials--title">
                    <img src="img/materials.png" alt="">
                    <span >{{__('index.aboutMaterials')}}</span>
                </div>

            </div>
            <div class="col-md-7 d-flex flex-column justify-content-center">
                <div class="d-flex align-items-center features--item">
                    <img src="img/done_green.png" alt="">
                    <span>
                        {{__('index.aboutMaterial1')}}
                    </span>
                </div>
                <div class="d-flex align-items-center features--item">
                    <img src="img/done_green.png" alt="">
                    <span>
                        {{__('index.aboutMaterial2')}}
                    </span>
                </div>
                <div class="d-flex align-items-center features--item">
                    <img src="img/done_green.png" alt="">
                    <span>
                        {{__('index.aboutMaterial3')}}
                    </span>
                </div>
                <div class="d-flex align-items-center features--item">
                    <img src="img/done_green.png" alt="">
                    <span>
                        {{__('index.aboutMaterial4')}}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

