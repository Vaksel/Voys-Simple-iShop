@php

	use mobiledetect\mobiledetectlib\MobileDetect;

	$detect = new Mobile_Detect();

	$isMobile = $detect->isMobile();

@endphp

@extends('voyus-layout')

@php use App\Models\Meta;
	if(!empty($category))
	{
	    $meta = Meta::getCollectionByPlace('catalog-category.' . $category->id);
	}
	else
	{
	     $meta = Meta::getCollectionByPlace('catalog');
	}
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

	@if(!empty($products))
		@include('categories')
	@else
		@include('categories-img')
	@endif

	@if(!empty($products))

		<div class="container-fluid bg--catalog">
		<div class="container bg--catalog__white">

			@php
				$rowClosedCounter = 0;
			@endphp

			@php /** @var Illuminate\Pagination\Paginator $products */ @endphp
			@foreach($products as $key => $paginatorItem)


{{--				@if($isMobile)--}}

				@if(true)



					@if($rowClosedCounter === 0)
						<div class="row">
					@endif

							@php
								$rowClosedCounter++;
							@endphp

{{--							@php--}}
{{--								ddd($rowClosedCounter);--}}
{{--							@endphp--}}

							<div class="col-6">
								<a class="good--link" href="{{route('product', ['url' => $paginatorItem->url])}}">
									<div class="catalog--mob">
										<div class="catalog--1">
										</div>
										<div class="catalog--2">
											<h4>{{$paginatorItem->getName()}}</h4>
											<img loading="lazy" src="{{$paginatorItem->photo}}" alt="">
											<div class=" mt-md-3">
												<span>
													@php
														print_r($paginatorItem->getTinyDescription());
													@endphp
												</span>
											</div>

										</div>
	{{--									<div class="d-flex justify-content-center">--}}
	{{--										<a href="{{route('product', ['id' => $paginatorItem->id])}}" class="btn--green">--}}
	{{--											Посмотреть--}}
	{{--										</a>--}}
	{{--									</div>--}}
									</div>
								</a>
							</div>

{{--							@if($key === 2)--}}
{{--								@php--}}
{{--									ddd($rowClosedCounter);--}}

{{--								@endphp--}}
{{--							@endif--}}

					@if(($key + 1) % 2 === 0 && $rowClosedCounter === 2)
						@php
							$rowClosedCounter = 0;
						@endphp

						</div>
					@endif

				@else

					<div class="row catalog--item align-items-center mob--none">
						<div class="col-md-4">
							<div class="catalog--item__img">
								<a href="{{route('product', ['url' => $paginatorItem->url])}}">
									<span>{{$paginatorItem->getName()}}</span>
									<img src="{{$paginatorItem->photo}}">
								</a>
							</div>
						</div>
						<div class="col-md-8">
							<div class="catalog--item__text d-flex align-items-center">
                    <span>
						@php print_r($paginatorItem->getTinyDescription());@endphp
                    </span>
							</div>
						</div>
					</div>

				@endif

			@endforeach

			@if($products->total() > $products->count())
				<br>
				<div class="row justify-content-center">
					<div class="col-md-12">
						<div class="card">
							<div class="card-body paginator-navbar">
								{{ $products->links() }}
							</div>
						</div>
					</div>
				</div>
			@endif


		</div>
	</div>

	@endif




@endsection
