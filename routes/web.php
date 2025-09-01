<?php

use App\Http\Controllers\CalendarController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CrmController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Mail\MyEmail;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Http\Request;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', function () {
    return Inertia::render('Home');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/posts/create', [PostController::class, 'create'])->name('post.create');
Route::get('/posts/{id}', [PostController::class, 'show'])->name('post.show');
Route::post('/posts/create', [PostController::class, 'store'])->name('post.store');
Route::get('/post/{id}/edit', [PostController::class, 'edit'])->name('post.edit');
Route::put('/post/{id}/edit', [PostController::class, 'update'])->name('post.update');
Route::delete('/post/{id}/delete', [PostController::class, 'delete'])->name('post.delete');

Route::get('/categories', [CategoryController::class, 'index'])->name('category.index');
Route::get('/categories/create', [CategoryController::class, 'create'])->name('category.create');
Route::get('/categories/{id}', [CategoryController::class, 'show'])->name('category.show');
Route::post('/categories/create', [CategoryController::class, 'store'])->name('category.store');
Route::get('/category/{id}/edit', [CategoryController::class, 'edit'])->name('category.edit');
Route::put('/category/{id}/edit', [CategoryController::class, 'update'])->name('category.update');
Route::delete('/category/{id}/delete', [CategoryController::class, 'delete'])->name('category.delete');
});

Route::get('/posts', [PostController::class, 'index'])->name('post.index');

Route::get('calendar', [CalendarController::class, 'index']);
Route::post('calendar', [CalendarController::class, 'store']);

Route::get('customers', [CrmController::class, 'index'])->name('customers.index');
Route::get('customer/create', [CrmController::class, 'create']);
Route::post('customers', [CrmController::class, 'store']);
Route::post('customers/edit/{id}', [CrmController::class, 'update']);
Route::delete('customers/delete/{id}', [CrmController::class, 'destroy']);

Route::post('/send-email', function(Request $request){

    $data = $request->input('message');
    Mail::to($request->input('email'))->send(new MyEmail($data));

    return to_route('customers.index');
});
require __DIR__.'/auth.php';
