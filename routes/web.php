<?php

use App\Http\Controllers\TestimonialController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [TestimonialController::class, 'home'])->name('landing-page');

// Admin Routes
Route::prefix('admin')->group(function () {

    // Testimonials
    Route::get('/testimonials', [TestimonialController::class, 'index'])->name('admin.testimonials.index');
    Route::get('/testimonials/create', [TestimonialController::class, 'create'])->name('admin.testimonials.create');
    Route::post('/testimonials', [TestimonialController::class, 'store'])->name('admin.testimonials.store');
    Route::get('/testimonials/{testimonial}/edit', [TestimonialController::class, 'edit'])->name('admin.testimonials.edit');
    Route::patch('/testimonials/{testimonial}', [TestimonialController::class, 'update'])->name('admin.testimonials.update');
    Route::put('/testimonials/updateAll', [TestimonialController::class, 'updateAll'])->name('admin.testimonials.updateAll');
    Route::delete('/testimonials/{testimonial}', [TestimonialController::class, 'destroy'])->name('admin.testimonials.delete');

    Route::patch('/testimonialsVisibility/{testimonial}', [TestimonialController::class, 'updateVisibility'])->name('admin.testimonials.updateVisibility');
});
