<?php

use App\Http\Controllers\Frontend\BookingController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Backend\TeamController;
use App\Http\Controllers\Backend\RoomTypeController;
use App\Http\Controllers\Backend\RoomController;
use App\Http\Controllers\Frontend\FrontendRoomController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Backend\RoomListController;

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

Route::post('/admin/store/', [AuthenticatedSessionController::class, 'AdminStore'])->name('admin.store');


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

    // Routes Room Type Controller
    Route::controller(RoomTypeController::class)->group(function (){
        Route::get('/room-type/list', 'RoomTypeList' )->name('room.type.list');

        Route::get('/room-type/add', 'RoomTypeAdd' )->name('room.type.add');

        Route::post('/room-type/store', 'RoomTypeStore' )->name('room.type.store');

        Route::get('/room-type/edit/{id}', 'RoomTypeEdit' )->name('room.type.edit');

        Route::post('/room-type/update', 'RoomTypeUpdate' )->name('room.type.update');


    });

    // Routes Room Controller
    Route::controller(RoomController::class)->group(function (){

        Route::get('/room/edit/{id}', 'RoomEdit' )->name('edit.room');

        Route::post('/room/update/{id}', 'RoomUpdate' )->name('update.room');

        Route::get('/multi-images/delete/{id}', 'MultiImageDelete' )->name('multi.image.delete');


        // Add Room Number
        Route::post('/room-number/{id}', 'StoreRoomNumber' )->name('store.room.no');

        Route::get('/room-number/edit/{id}', 'EditRoomNumber' )->name('edit.room.no');

        Route::post('/room-number/update/{id}', 'UpdateRoomNumber' )->name('update.room.no');

        Route::get('/room-number/delete/{id}', 'DeleteRoomNumber' )->name('delete.room.no');

        ////////////////// Room Type And Room Relationship method delete ////////////////////
        Route::get('/room/delete/{id}', 'RoomDelete' )->name('delete.room');
        //////////////////End  Room Type And Room Relationship method delete ////////////////////
    });

    //Admin Routes Booking Request payment ... Frontend/Booking Controller
    Route::controller(BookingController::class)->group(function (){
        //list booking
        Route::get('/booking/list', 'BookingList' )->name('booking.list');

        // Info Edit Booking 
        Route::get('/booking/edit/{id}', 'EditBooking' )->name('edit_booking');

        // Update Status Booking
        Route::post('/booking/update/status/{id}', 'UpdateBookingStatus' )->name('booking.update.status');
       
        // Update Booking
        Route::post('/booking/update/{id}', 'UpdateBooking' )->name('update.booking');
           
        
        // assign room booking 
        Route::get('/booking/assign-room/{id}', 'AssignRoom' )->name('assign_room');

        // assign room booking 
        Route::get('/booking/assign-room/store/{booking_id}/{room_number_id}', 'AssignRoomStore' )->name('assign_room_store');
        
        // assign room booking  delete
        Route::get('/booking/assign-room/delete/{id}', 'AssignRoomDelete' )->name('assign_room_delete');

        // Download PDF invoice
        Route::get('/download-invoice/{id}', 'DownloadInvoice' )->name('download.invoice');

    });

    // Routes Room List Controller
    Route::controller(RoomListController::class)->group(function (){

        Route::get('/room-list/view', 'ViewRoomList' )->name('view.room.list');

        Route::get('/room-list/add', 'AddRoomList' )->name('add.room.list');

        Route::post('/room-list/store', 'StoreRoomList' )->name('store.room.list');

        
    });

}); // End Admin Group Middleware




////// Front End Show Controller 
Route::controller(FrontendRoomController::class)->group(function (){
    Route::get('/rooms/', 'AllRoom' )->name('all.room.frontend');

    Route::get('/rooms/details/{id}', 'DetailsRoomPage' )->name('details.froom');

    // booking search
    Route::post('/booking/search/', 'BookingSearch' )->name('booking.search');

    // Details serach room
    Route::get('/search-rooms-details/{id}', 'SearchRoomDetails' )->name('search.room.details');

    // Check room available room
    Route::get('/check-room-availability', 'CheckRoomAvailablity' )->name('check.room.availability');

});


//Auth group Middleware Routes with function User Booking
Route::middleware(['auth'])->group(function (){

    Route::controller(BookingController::class)->group(function (){
        //  Booking 
        Route::post('/booking-store', 'BookingStore' )->name('user.booking.store');
        // Check out 
        Route::get('/checkout', 'Checkout' )->name('checkout');

        // Check out 
        Route::post('/checkout-store', 'CheckoutStore' )->name('checkout.store');
        
        //payment stripe 
        
        Route::match(['get', 'post'],'/stripe_pay', [BookingController::class, 'stripe_pay'])->name('stripe_pay');
    
    }); // end group booking

}); // End  Group Middleware User 
