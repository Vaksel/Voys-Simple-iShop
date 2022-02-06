<?php


?>

<!doctype html>
<html lang="en">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<meta name="owner" content="voys.ua@ukr.net"/>
	<meta name="author" lang="ru" content="ВОЮС"/>
	<meta name="robots" content="index"/>

	@yield('meta')

	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
	<link rel="stylesheet" href="/css/style.css">

	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-215570738-1">
	</script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		gtag('config', 'UA-215570738-1');
	</script>
</head>
<body>

<div class="main--wrapper">

	<div class="main--content">
		<div class="container-fluid bg--green">
			&nbsp;
		</div>

		<div class="shar--two">
			<nav class="navbar navbar-expand-lg navbar-light ">
				<div class="container">
					<div class="navbar-brand d-flex align-items-center">
						<img src="/img/logo.png" class="desk--none logo" alt="">
						<img class="mob--none" src="/img/phone.svg" alt="">
						<div class="d-flex flex-column justify-content-between header--phone mob--none">
                <span>
                    +380977212172
                </span>
							<span>
                   +380672012022
                </span>
							<span>
                    +380673002022
                </span>
						</div>
					</div>
					<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>
					<div class="collapse navbar-collapse justify-content-between" id="navbarText">
						<ul class="navbar-nav w-100 justify-content-around mb-2 mb-lg-0">
							<li class="nav-item">
								<a class="nav-link {{Route::current()->getName() === 'index' ? 'active' : null}}" aria-current="page" href="{{route('index')}}">{{__('navbar.main-page')}}</a>
							</li>
							<li class="nav-item">
								<a class="nav-link {{Route::current()->getName() === 'catalog' ? 'active' : null}}" href="{{route('catalog')}}">{{__('navbar.catalog')}}</a>
							</li>
							<li class="nav-item">
								<a class="nav-link {{Route::current()->getName() === 'contact' ? 'active' : null}}" href="{{route('contact')}}">{{__('navbar.contacts')}}</a>
							</li>
							<li class="nav-item">
								<a class="nav-link {{Route::current()->getName() === 'faq' ? 'active' : null}}" href="{{route('faq')}}">{{__('navbar.faq')}}</a>
							</li>
							<li class="nav-item">
								<a class="nav-link {{Route::current()->getName() === 'about' ? 'active' : null}}" href="{{route('about')}}">{{__('navbar.about-us')}}</a>
							</li>

						</ul>
						<div class="lang d-flex flex-column justify-content-around">
							<a class="locale-changer" href="{{route('setlocale', ['lang' => 'ru'])}}"><span>Русский</span></a>
							<a class="locale-changer" href="{{route('setlocale', ['lang' => 'ua'])}}"><span>Українська</span></a>
						</div>
					</div>
				</div>
			</nav>

			@yield('content')
	</div>


</div>

	<footer>
		&nbsp;
	</footer>

</div>




	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>

	<script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>
</body>
</html>
