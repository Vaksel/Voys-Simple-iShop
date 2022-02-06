<?php // routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.
use Diglactic\Breadcrumbs\Breadcrumbs;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Главная
Breadcrumbs::for('index', function (BreadcrumbTrail $trail) {
    $trail->push('Главная', route('index'));
});

// Главная > Каталог
Breadcrumbs::for('catalog', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push('Каталог', route('catalog'));
});

// Главная > Каталог > Название категории
Breadcrumbs::for('categoryCatalog', function (BreadcrumbTrail $trail, $category) {
    $trail->parent('catalog');
    $trail->push($category->getName(), route('categoryCatalog', ['category_url' => $category->url]));
});

// Главная > Каталог > Название категории > [Продукт]
Breadcrumbs::for('product', function (BreadcrumbTrail $trail, $category ,$product) {
    $trail->parent('categoryCatalog', $category);
    $trail->push($product->getName(), route('product', $product));
});