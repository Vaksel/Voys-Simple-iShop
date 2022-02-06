@extends('voyus-layout')

@php use App\Models\Meta;
    $meta = Meta::getCollectionByPlace('faq');
@endphp

@section('meta')
    <title>{{Meta::getMetaFromCollectionByDestination($meta, 'title')}}</title>
    <meta name="description" content="{{Meta::getMetaFromCollectionByDestination($meta, 'description')}}">
    <meta name="keywords" content="{{Meta::getMetaFromCollectionByDestination($meta, 'keywords')}}">
    <meta property="og:image" content="{{Meta::getMetaFromCollectionByDestination($meta, 'og:image')}}">
    <meta property="og:title" content="{{Meta::getMetaFromCollectionByDestination($meta, 'og:title')}}">
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

            // alert('Широта: ' + crd.latitude + ' ' + 'Долгота: ' + crd.longitude);

            setCookie('cookie_coord_' + ipAddress, JSON.stringify({lat: crd.latitude, lng: crd.longitude}), {'max-age' : 600});

            location.reload();
        };

        function error(err) {
            if(err.message === 'User denied geolocation prompt')
            {
                setCookie('location_denied',1, {'max-age' : 600});

                location.reload();

            }

            setCookie('location_denied',1, {'max-age' : 600});

            location.reload();
        };

        if((getCookie('location_denied') === undefined || getCookie('location_denied') === null) &&
                (loc === undefined || loc === null || loc === ''))
        {
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
    <h1>{{Meta::getMetaFromCollectionByDestination($meta, 'h1')}}</h1>

    @include('categories')

        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                   Які перевагі полімерпіщаного колодязя?
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <img class="w-100" src="/img/fearures.jpg" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    З чого складається комлект полімерпіщаного колодязя?
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <img class="w-100" src="/img/shem.jpg" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    Які ми маємо сертифікати?
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                <div class="accordion-body text-center">
                                    <img class="" style="max-height: 600px" src="/img/cert1.jpg" alt="">
                                    <img class="" style="max-height: 600px" src="/img/cert2.jpg" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>

@endsection
