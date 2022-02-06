<?php
	use App\Models\ProductCategory;
?>
<div class="bg--green__submenu-catalog">
	<div class="container">
		<h2 class="mb-5" style="text-align: center; color: white; ">Наша продукция</h2>
		<div class="row">
			<div class="col-6 category-nav-item">
				<a href="{{route('categoryCatalog', ['category_url' => ProductCategory::find(1)->url])}}">
					<h3 class="category-nav-item__title">{{__('navbar.hatch')}}</h3>
					<br>
					<img src="/img/1-1,5т.чор.jpg" alt="" class="category-nav-item__img">
				</a>

			</div>
			<div class="col-6 category-nav-item">
				<a href="{{route('categoryCatalog', ['category_url' => ProductCategory::find(2)->url])}}">
					<h3 class="category-nav-item__title">{{__('navbar.well')}}</h3>
					<br>
					<img src="/img/6-колодязь.jpg" alt="" class="category-nav-item__img">
				</a>
			</div>
			<div class="col-6 category-nav-item">
				<a href="{{route('categoryCatalog', ['category_url' => ProductCategory::find(3)->url])}}">
					<h3 class="category-nav-item__title">{{__('navbar.tile')}}</h3>
					<br>
					<img src="/img/1-тактилкаКонус.jpg" alt="" class="category-nav-item__img">
				</a>
			</div>
			<div class="col-6 category-nav-item">
				<a href="{{route('categoryCatalog', ['category_url' => ProductCategory::find(4)->url])}}">
					<h3 class="category-nav-item__title">{{__('navbar.drainage')}}</h3>
					<br>
					<img src="/img/2-водовідвідВЗборі.jpg" alt="" class="category-nav-item__img">

				</a>

			</div>
		</div>

	</div>
</div>
