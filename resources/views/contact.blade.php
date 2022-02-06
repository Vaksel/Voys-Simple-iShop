@extends('voyus-layout')

@php use App\Models\Meta;
    $meta = Meta::getCollectionByPlace('contact');
@endphp

@section('meta')
  <title>{{Meta::getMetaFromCollectionByDestination($meta, 'title')}}</title>
  <meta name="description" content="{{Meta::getMetaFromCollectionByDestination($meta, 'description')}}">
  <meta name="keywords" content="{{Meta::getMetaFromCollectionByDestination($meta, 'keywords')}}">
  <meta property="og:image" content="{{Meta::getMetaFromCollectionByDestination($meta, 'og:image')}}">
  <meta property="og:description" content="{{Meta::getMetaFromCollectionByDestination($meta, 'og:description')}}">
@endsection

@section('content')

  <script>
    var isMobile = '{{$isMobile}}';
    let map;
    var ipAddress = '{{$ipAddress}}';

    var options = {
      enableHighAccuracy: true,
      timeout: 5000,
      maximumAge: 0
    };

    function getCookie(name) {
      let matches = document.cookie.match(new RegExp(
              "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
      ));
      return matches ? decodeURIComponent(matches[1]) : undefined;
    }

    if(isMobile && !getCookie('cookie_coord_appeal_' + ipAddress))
    {
      navigator.geolocation.getCurrentPosition(success, error, options);
    }

    function success(pos) {
      var crd = pos.coords;

      // alert('Широта: ' + crd.latitude + ' ' + 'Долгота: ' + crd.longitude);

      setCookie('cookie_coord_appeal_' + ipAddress, JSON.stringify({lat: crd.latitude, lng: crd.longitude}), {'max-age' : 600});
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


    function initMap() {
      map = new google.maps.Map(document.getElementById("map"), {
        center: { lat: 49.773632, lng: 28.717428 },
        zoom: 15,
      });

      var marker = new google.maps.Marker(
              {
                position:{lat: 49.773632,lng: 28.717428},
                map:map
              }
      );
    }
  </script>

  <h1>{{Meta::getMetaFromCollectionByDestination($meta, 'h1')}}</h1>


  <div class="cont--bg">
  <div class="container-fluid contact--bg">
    <div class="container">
      <div class="row">
        <div class="col-md-4">
          <div class="d-flex flex-column contact--item align-items-center">
            <h6>Телефон:</h6>

            <strong>
              +380977212172
              <br>
              +380672012022
              <br>
              +380673002022
            </strong>
          </div>
        </div>
        <div class="col-md-4">
          <div class="d-flex flex-column contact--item align-items-center">
            <h6>{{__('contact.email')}}:</h6>

            <span>
            voys.ua@ukr.net
          </span>
          </div>
        </div>
        <div class="col-md-4">
          <div class="d-flex flex-column contact--item align-items-center">
            <h6>{{__('contact.address')}}:</h6>

            <span>
            {{__('contact.addressValue')}}
{{--              <strong>58</strong>--}}
          </span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="container explore--wrapper">
    <div class="row align-items-center">
      <div class="col-md-5">
        <div class="explore">
          <img src="/img/contact.png" alt="">
          <div class="explore--text d-flex flex-column">
            <img src="/img/explore.png" alt="">
            <span>{{__('contact.whereWe')}}:  </span>
          </div>
        </div>
      </div>
      <div class="col-md-7">
        <div class="map" id="map">
          &nbsp;
        </div>
      </div>
    </div>
  </div>

  <div class="container contact--form">
    <form class="row" action="{{route('appeal')}}" method="POST">
      @csrf
      <div class="col-md-12">
        <h4 class="text-center mb-5">{{__('contact.writeToUs')}}</h4>
      </div>
      <div class="col-md-3 form--text">
        <span> {{__('contact.name')}}:</span>
      </div>
      <div class="col-md-9 form--input">
        <input class="w-100" type="text" name="name">
      </div>
      <div class="col-md-3 form--text">
        <span> {{__('contact.formEmail')}}:</span>
      </div>
      <div class="col-md-9 form--input">
        <input class="w-100" type="email" name="email">
      </div>
      <div class="col-md-3 form--text">
        <span> {{__('contact.phone')}}:</span>
      </div>
      <div class="col-md-9 form--input">
        <input class="w-100" type="text" name="phone">
      </div>
      <div class="col-md-3 form--text">
        <span> {{__('contact.message')}}:</span>
      </div>
      <div class="col-md-9 form--input">
        <textarea name="message" class="w-100" id="" cols="50" >

        </textarea>
      </div>

      <button class="btn--green" type="submit">Отправить</button>

      @if(session('mailResultSuccess'))
        <h2 class="text-center">{{session('mailResultSuccess')}}</h2>
      @endif

      @if(session('mailResultError'))
        <h2 class="text-danger text-center">{{session('mailResultError')}}</h2>
      @endif

    </form>
  </div>

  <div class="container">
    <div class="row">
      <div class="col-12 good2-desc">
        <div class="mt-2 text-center">
          <img src="/img/logo.png" alt="">
        </div>
      </div>
    </div>
  </div>



</div>
  <script async
          src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBeNUcxp24jGROmuwibFFQwzxRsSZIqfpM&callback=initMap">
  </script>


@endsection
