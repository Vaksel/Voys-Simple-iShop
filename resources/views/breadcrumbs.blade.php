@unless ($breadcrumbs->isEmpty())
	<div class="breadcrumbs d-flex align-items-center justify-content-around">

	@foreach ($breadcrumbs as $breadcrumb)

			@if (!is_null($breadcrumb->url) && !$loop->last)
				<a class="breadcrumbs--1" href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a>
				<span> > </span>
			@else
				<span>{{ $breadcrumb->title }}</span>
			@endif

		@endforeach
	</div>
@endunless