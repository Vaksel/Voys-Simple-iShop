@php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.
use Diglactic\Breadcrumbs\Breadcrumbs;


@endphp

@extends('voyus-layout')

@php use App\Models\Meta;
    $meta = Meta::getCollectionByProductId($product->id);
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

  @include('categories')
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


  <div class="container-fluid bg--good">
  <div class="container bg--good__white">
    <div class="row">

      @if(session('mailResultSuccess'))
        <h2 class="text-center">{{session('mailResultSuccess')}}</h2>
      @endif

      @if(session('mailResultError'))
        <h2 class="text-danger text-center">{{session('mailResultError')}}</h2>
      @endif

      <div class="col-md-6">


        <div class="container--gallery">

          @php
            $miniaturePhotos = $product->photos()->where(['role' => 'miniature'])->get();
            $photoCount = count($miniaturePhotos);
          @endphp

          @foreach($miniaturePhotos as $key => $photo)

          <!-- Полноразмерные изображения с числовым текстом -->
          <div class="mySlides">
            <div class="numbertext">{{$key + 1}} / {{$photoCount}}</div>
            <img class="slider--main__photo" src="{{$photo->path}}" alt="{{$photo->alt}}" style="width:100%">
          </div>

            @endforeach

          <!-- Вперед и назад кнопки -->
          <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
          <a class="next" onclick="plusSlides(1)">&#10095;</a>

          <!-- Текст изображения -->
                    <div class="caption-container">
                       <p id="caption"></p>
                      </div>

          <!-- Миниатюры -->
          <div class="row--gallery">
            @foreach($miniaturePhotos as $key => $minPhoto)
            <div class="column">
              <img class="demo cursor" src="{{$minPhoto->path}}" style="width:100%" onclick="currentSlide({{$key + 1}})" alt="{{$minPhoto->alt}}">
            </div>
              @endforeach
          </div>
        </div>

      </div>
      <div class="col-md-6">

        <div class="good--title">
          <span>{{$product->getName()}}</span>
        </div>

{{--        <div class="breadcrumbs d-flex align-items-center justify-content-around">--}}
{{--          <a class="breadcrumbs--1" href="/">Главная</a>--}}
{{--          <span> > </span>--}}
{{--          <a class="breadcrumbs--2" href="/catalog.html">Каталог</a>--}}
{{--          <span> > </span>--}}
{{--          <span>Люк садовый черный 1т</span>--}}

{{--        </div>--}}

        {{Breadcrumbs::render('product', $product->category, $product)}}

        <div class="good2--desc d-flex flex-column">
              <span>
                @php
                print_r($product->getTinyDescription());
                @endphp
              </span>
        </div>

{{--        <div class="d-flex justify-content-center">--}}
{{--          <button class="btn--green" data-bs-toggle="modal" data-bs-target="#tehModal">--}}
{{--            {{__('good.openPassport')}}--}}

{{--          </button>--}}
{{--        </div>--}}

        @if($product->getProperty())
        <form>
          <div class="form__radio-group property-item mt-4">
            <input type="checkbox" id="propertyValue" class="form__radio-input propertyValue" name="size">
            <label for="propertyValue" class="form__radio-label">
              <span class="form__radio-button"></span>
              <span id="propertyName" class="propertyName">
                {{$product->getProperty()}}
              </span>
            </label>
          </div>

<!--          <div class="form__radio-group">-->
<!--            <input type="checkbox" class="form__radio-input" id="ushki" name="size">-->
<!--            <label for="ushki" class="form__radio-label">-->
<!--              <span class="form__radio-button"></span>-->
<!--              Люк с ушками-->
<!--            </label>-->
<!--          </div>-->

        </form>
        @endif

        <div class="d-flex justify-content-center">
          <button class="btn--green" data-bs-toggle="modal" data-bs-target="#exampleModal">
            {{__('good.sendOffer')}}
          </button>
        </div>


      </div>

      <div class="col-12 good2-desc">
        <span>
          @php
            print_r($product->getDescription());
          @endphp
        </span>

        <div class="mt-2 text-center">
          <img src="/img/logo.png" alt="">
        </div>
      </div>
    </div>
  </div>
</div>







<div class="modal fade" id="tehModal" tabindex="-1" aria-labelledby="tehModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <img src="{{$product->getTechPass()}}" alt="">
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">{{__('good.registrationApplication')}}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        @if ($errors->any())
          <div class="alert alert-danger">
            <ul>
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif
        <form action="{{route('orderProduct', ['url' => $product->url])}}" method="POST">
          @csrf
          <div class="form-floating mb-3">
            <input type="text" name="name" class="form-control" id="floatingName" placeholder="name@example.com">
            <label for="floatingName">{{__('good.formName')}}</label>
          </div>
          <div class="form-floating mb-3">
            <input type="text" name="lastname" class="form-control" id="floatingSurname" placeholder="name@example.com">
            <label for="floatingSurname">{{__('good.formSurname')}}</label>
          </div>
          <div class="form-floating mb-3">
            <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com">
            <label for="floatingInput">{{__('good.formEmail')}}</label>
          </div>

          <input type="hidden" name="propertyName" id="propertyNameHidden">
          <input type="hidden" name="propertyValue" id="propertyValueHidden">


          <div class="d-flex justify-content-center">
            <button class="btn--green" >
              {{__('good.formSend')}}
            </button>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>

<script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>

<script src="/js/index.js"></script>


<script>
  var slideIndex = 1;
  showSlides(slideIndex);

  // Вперед/назад элементы управления
  function plusSlides(n) {
    showSlides(slideIndex += n);
  }

  // Элементы управления миниатюрами изображений
  function currentSlide(n) {
    showSlides(slideIndex = n);
  }

  function showSlides(n) {
    var i;
    var slides = document.getElementsByClassName("mySlides");
    var dots = document.getElementsByClassName("demo");
    var captionText = document.getElementById("caption");
    if (n > slides.length) {slideIndex = 1}
    if (n < 1) {slideIndex = slides.length}
    for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";
    }
    for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" active", "");
    }
    slides[slideIndex-1].style.display = "block";
    dots[slideIndex-1].className += " active";
    captionText.innerHTML = dots[slideIndex-1].alt;
  }
</script>
@endsection

