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
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');
Route::get('/privacy', [PageController::class, 'privacy'])->name('privacy');

Route::get('/projects/sitesurveyor', [PageController::class, 'sitesurveyor'])->name('projects.sitesurveyor');
Route::get('/projects/bizintel', [PageController::class, 'bizintel'])->name('projects.bizintel');

Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');

Route::get('/blog', [PostController::class, 'index'])->name('posts.index');
Route::get('/blog/{post:slug}', [PostController::class, 'show'])->name('posts.show');

Route::match(['get', 'post'], '/store/{slug}/add-to-cart', [ProductController::class, 'addToCart'])->name('products.addToCart');
Route::get('/cart', [ProductController::class, 'cart'])->name('products.cart');
Route::post('/cart/remove/{slug}', [ProductController::class, 'removeFromCart'])->name('products.removeFromCart');
Route::get('/checkout', [ProductController::class, 'checkout'])->name('checkout');
Route::get('/checkout/success', [ProductController::class, 'checkoutSuccess'])->name('checkout.success');
Route::post('/checkout/webhook', [ProductController::class, 'checkoutWebhook'])->name('checkout.webhook');

Route::get('/store', [ProductController::class, 'index'])->name('products.index');
Route::get('/store/category/{category}', [ProductController::class, 'category'])->name('products.category');
Route::get('/store/{slug}', [ProductController::class, 'show'])->name('products.show');
