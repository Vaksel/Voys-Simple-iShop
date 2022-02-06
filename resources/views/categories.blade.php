<?php
	use App\Models\ProductCategory;
?>

<div class="bg--green__submenu">
	<div class="container">
		<div class="row">
			<div class="submenu d-flex align-items justify-content-around">
				<a href="{{route('categoryCatalog', ['category_url' => ProductCategory::find(1)->url])}}">{{__('navbar.hatch')}}</a>
				<a href="{{route('categoryCatalog', ['category_url' => ProductCategory::find(2)->url])}}">{{__('navbar.well')}}</a>
				<a href="{{route('categoryCatalog', ['category_url' => ProductCategory::find(3)->url])}}">{{__('navbar.tile')}}</a>
				<a href="{{route('categoryCatalog', ['category_url' => ProductCategory::find(4)->url])}}">{{__('navbar.drainage')}}</a>
			</div>
		</div>
	</div>
</div>