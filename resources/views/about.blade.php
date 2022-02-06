@extends('voyus-layout')

@php use App\Models\Meta;
    $meta = Meta::getCollectionByPlace('about');
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

  <div class="about--img">
  <div class="container-fluid about--bg">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <h3>{{__('about.aboutCompanyTitle')}}</h3>

          <br>

          <span>
            {{__('about.aboutCompanyValue')}} <br> {{__('about.aboutCompanyValue2')}}
          </span>
        </div>
      </div>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <div class="col-12 payment">

        <h3>{{__('about.aboutPayTitle')}}</h3>
        <br>
        <span>
            {{__('about.aboutPayValue')}}
        </span>

      </div>
    </div>
  </div>

  <div class="container">
    <div class="row">
      <div class="col-12 cooperation">

        <h3>{{__('about.aboutCooperationTitle')}}</h3>
        <br>
        <span>
          {{__('about.aboutCooperationValue')}}
        </span>

      </div>
    </div>
  </div>


</div>

@endsection
