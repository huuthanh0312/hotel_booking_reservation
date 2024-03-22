<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Backend\TeamController;
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

// Routes users 
Route::get('/', [UserController::class, 'Index']);

Route::get('/dashboard', function () {
    return view('frontend.dashboard.user_dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [UserController::class, 'UserProfile'])->name('user.profile');
    Route::post('/profile/store', [UserController::class, 'ProfileStore'])->name('profile.store');
    //user logout
    Route::get('user/logout', [UserController::class, 'UserLogout'])->name('user.logout');

    Route::get('user/change/password', [UserController::class, 'UserChangePassword'])->name('user.change.password');
    //change and update pass
    Route::post('password/change/store', [UserController::class, 'UserPasswordUpdate'])->name('password.change.store');
});


require __DIR__.'/auth.php';

// Admin routes login
Route::get('/admin/login', [AdminController::class, 'AdminLogin'])->name('admin.login');


//Admin group Middleware Routes
Route::middleware(['auth', 'roles:admin'])->group(function (){

    Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.dashboard');
    Route::get('/admin/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');
    Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
    Route::post('/admin/profile/store', [AdminController::class, 'AdminProfileStore'])->name('admin.profile.store');
    Route::get('/admin/change/password', [AdminController::class, 'AdminChangePassword'])->name('admin.change.password');
    Route::post('/admin/password/update', [AdminController::class, 'AdminPasswordUpdate'])->name('admin.password.update');

}); // End Admin Group Middleware


//Admin group Middleware Routes with function
Route::middleware(['auth', 'roles:admin'])->group(function (){

    // Routes Team Controller
    Route::controller(TeamController::class)->group(function (){
        Route::get('/all/team', 'AllTeam' )->name('all.team');

        Route::get('/add/team', 'AddTeam' )->name('add.team');

        Route::post('/team/store', 'TeamStore' )->name('team.store');

        Route::get('/team/edit/{id}', 'EditTeam' )->name('team.edit');

        Route::post('/team/update', 'UpdateTeam' )->name('team.update');

        Route::get('/team/delete/{id}', 'DeleteTeam' )->name('team.delete');

    });

    // Routes Book Area Controller
    Route::controller(TeamController::class)->group(function (){
        Route::get('/book/area', 'BookArea' )->name('book.area');
        Route::post('/update/bookarea', 'UpdateBookArea' )->name('update.book.area');


    });




}); // End Admin Group Middleware
