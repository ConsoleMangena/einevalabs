<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/services', [PageController::class, 'services'])->name('services');
Route::get('/projects', [PageController::class, 'projects'])->name('projects');
Route::get('/team', [PageController::class, 'team'])->name('team');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])
    ->middleware('throttle:contact')
    ->name('contact.submit');
Route::get('/privacy', [PageController::class, 'privacy'])->name('privacy');
Route::get('/ethics', [PageController::class, 'ethics'])->name('ethics');

Route::get('/projects/sitesurveyor', [PageController::class, 'sitesurveyor'])->name('projects.sitesurveyor');
Route::get('/projects/bizintel', [PageController::class, 'bizintel'])->name('projects.bizintel');

Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])
    ->middleware('throttle:newsletter')
    ->name('newsletter.subscribe');

Route::get('/blog', [PostController::class, 'index'])->name('posts.index');
Route::get('/blog/{post:slug}', [PostController::class, 'show'])->name('posts.show');

/*
| Cart and checkout. Everything that mutates state is POST so it is covered by
| CSRF protection; a GET here would be reachable from a prefetcher or an
| <img> tag and, for checkout, would spend a gateway reference number.
*/
Route::post('/store/{slug}/add-to-cart', [ProductController::class, 'addToCart'])
    ->middleware('throttle:add-to-cart')
    ->name('products.addToCart');
Route::get('/cart', [ProductController::class, 'cart'])->name('products.cart');
Route::post('/cart/remove/{slug}', [ProductController::class, 'removeFromCart'])->name('products.removeFromCart');
Route::post('/checkout', [ProductController::class, 'checkout'])
    ->middleware('throttle:checkout')
    ->name('checkout');

/*
| These two are called by the gateway, not by a browser session, so they must
| not depend on the cart. The return URL re-verifies the order against
| check-payment before showing anything.
*/
Route::get('/checkout/success', [ProductController::class, 'checkoutSuccess'])
    ->name('checkout.success');
Route::get('/checkout/return', [ProductController::class, 'checkoutSuccess'])
    ->name('checkout.return');
Route::post('/checkout/webhook', [ProductController::class, 'checkoutWebhook'])
    ->middleware('throttle:60,1')
    ->name('checkout.webhook');

Route::get('/store', [ProductController::class, 'index'])->name('products.index');
Route::get('/store/category/{category}', [ProductController::class, 'category'])
    ->where('category', '[^/]+')
    ->name('products.category');
Route::get('/store/{slug}', [ProductController::class, 'show'])->name('products.show');
