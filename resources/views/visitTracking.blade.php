@extends('voyus-layout')

@section('content')

<script>
	var cachedReq = '{{$cachedReq}}';
	var ipAddress = '{{$ipAddress}}';

    var options = {
        enableHighAccuracy: true,
        timeout: 5000,
        maximumAge: 0
    };

    function success(pos) {
        var crd = pos.coords;

        // alert('Широта: ' + crd.latitude + ' ' + 'Долгота: ' + crd.longitude);

        setCookie('cookie_coord_' + ipAddress, JSON.stringify({lat: crd.latitude, lng: crd.longitude}), {'max-age' : 600});

        if(cachedReq === '/redirect-page')
        {
            location.href = '/';
        }
        else
        {
            location.href = cachedReq;
        }
    };

    function error(err) {
        if(err.message === 'User denied geolocation prompt')
		{
            setCookie('location_denied',1, {'max-age' : 600});
        }
    };

    function checkVisitByCookie()
    {
        getCookie()
    }

    if(getCookie())

    navigator.geolocation.getCurrentPosition(success, error, options);

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

<div class="container" style="height: 100%;">
    <div style="width:350px; margin: auto;">
        Данные о вашем местоположении будут использованы для
        лучшего и более точного предложения услуг и товаров вашего региона,
        они не хранятся на сервере, только в вашем браузере!
    </div>
</div>

@endsection
