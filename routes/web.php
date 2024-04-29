<?php

use App\Http\Controllers\Backend\BlogController;
use App\Http\Controllers\Backend\GalleryController;
use App\Http\Controllers\Backend\ReportController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Frontend\BookingController;
use App\Http\Controllers\ProfileController;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Backend\TeamController;
use App\Http\Controllers\Backend\RoomTypeController;
use App\Http\Controllers\Backend\RoomController;
use App\Http\Controllers\Frontend\FrontendRoomController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Backend\CommentController;
use App\Http\Controllers\Backend\RoomListController;
use App\Http\Controllers\Backend\TestimonialController;
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

    // Routes Room List Routes
    Route::controller(RoomListController::class)->group(function (){

        Route::get('/room-list/view', 'ViewRoomList' )->name('view.room.list');

        Route::get('/room-list/add', 'AddRoomList' )->name('add.room.list');

        Route::post('/room-list/store', 'StoreRoomList' )->name('store.room.list');

        
    });

    // Setting Routes
    Route::controller(SettingController::class)->group(function (){
        //// SMTP Setting
        Route::get('/smtp-setting', 'SmtpSetting' )->name('smtp.setting');

        Route::post('/smtp-setting/update', 'UpdateSmtpSetting' )->name('smtp.update');

        
    });

    // Testimonial Routes
    Route::controller(TestimonialController::class)->group(function (){
        //// 
        Route::get('/testimonial/all', 'AllTestimonial' )->name('testimonial.all');

        Route::get('/testimonial/add', 'AddTestimonial' )->name('testimonial.add');

        Route::post('/testimonial/store', 'StoreTestimonial' )->name('testimonial.store');

        Route::get('/testimonial/edit/{id}', 'EditTestimonial' )->name('testimonial.edit');

        Route::post('/testimonial/update', 'UpdateTestimonial' )->name('testimonial.update');

        Route::get('/testimonial/delete/{id}', 'DelteTestimonial' )->name('testimonial.delete');

    });

    // Blog Category Routes
    Route::controller(BlogController::class)->group(function (){
        //// 
        Route::get('/blog-category/all', 'AllBlogCategory' )->name('blog.category.all');

        Route::post('/blog-category/store', 'StoreBlogCategory' )->name('blog.category.store');

        Route::get('/blog-category/edit/{id}', 'EditBlogCategory' )->name('blog.category.edit');

        Route::post('/blog-category/update', 'UpdateBlogCategory' )->name('blog.category.update');

        Route::get('/blog-category/delete/{id}', 'DeleteBlogCategory' )->name('blog.category.delete');

    });

    // Blog  Routes
    Route::controller(BlogController::class)->group(function (){
        //// 
        Route::get('/blog-post/all', 'AllBlogPost' )->name('blog.post.all');

        Route::get('/blog-post/add', 'AddBlogPost' )->name('blog.post.add');

        Route::post('/blog-post/store', 'StoreBlogPost' )->name('blog.post.store');

        Route::get('/blog-post/edit/{id}', 'EditBlogPost' )->name('blog.post.edit');

        Route::post('/blog-post/update', 'UpdateBlogPost' )->name('blog.post.update');

        Route::get('/blog-post/delete/{id}', 'DeleteBlogPost' )->name('blog.post.delete');

    });

    // Manager Comments
    Route::controller(CommentController::class)->group(function (){
        ///
        Route::get('/comment/all', 'AllComment' )->name('comment.all');

        Route::post('/comment/update/status', 'UpdateCommentStatus')->name('update.comment.status');

    });

        // Booking Report
        Route::controller(ReportController::class)->group(function (){
            ///
            Route::get('/booking/report', 'BookingReport' )->name('booking.report');

            Route::post('/search-by-date', 'SearchByDate' )->name('search-by-date');
    
            
        });

        // Site Setting Routes
        Route::controller(SettingController::class)->group(function (){
            //// Site Setting
            Route::get('/site-setting', 'SiteSetting' )->name('site.setting');

            Route::post('/site-setting/update', 'UpdateSiteSetting' )->name('site.update');

    
        });

        // Gallery Setting Routes
        Route::controller(GalleryController::class)->group(function (){
            //// gallery Setting
            Route::get('/gallery/all', 'AllGallery' )->name('gallery.all');

            Route::get('/gallery/add', 'AddGallery' )->name('gallery.add');

            Route::post('/gallery/store', 'StoreGallery' )->name('gallery.store');
            
            Route::get('/gallery/edit/{id}', 'EditGallery' )->name('gallery.edit');

            Route::post('/gallery/update', 'UpdateGallery' )->name('gallery.update');
            
            Route::get('/gallery/delete/{id}', 'DeleteGallery' )->name('gallery.delete');

            ///// delete Multiple Gallery
            
            Route::post('/gallery/delete/multiple', 'DeleteGallaryMultiple' )->name('delete.gallary.multiple');

        });

        // Contact Setting Send Admin Routes
        Route::controller(GalleryController::class)->group(function (){
           
            Route::get('/contact/message', 'AdminContactMessage' )->name('contact.message');

        });
}); // End Admin Group Middleware




////// Front End Show Controller 
Route::controller(FrontendRoomController::class)->group(function (){
    Route::get('/rooms', 'AllRoom' )->name('all.room.frontend');

    Route::get('/rooms/details/{id}', 'DetailsRoomPage' )->name('details.froom');

    // booking search
    Route::post('/booking/search/', 'BookingSearch' )->name('booking.search');

    // Details serach room
    Route::get('/search-rooms-details/{id}', 'SearchRoomDetails' )->name('search.room.details');

    // Check room available room
    Route::get('/check-room-availability', 'CheckRoomAvailablity' )->name('check.room.availability');

});

///// Frontend Blog Routes
Route::controller(BlogController::class)->group(function (){
        Route::get('/blog/details/{slug}', 'BlogDetails' );

        Route::get('/blog-category/list/{id}', 'BlogCatList' );

        Route::get('/blog/list', 'BlogList' )->name('blog.list');


});

/// Frontend Comment Routes
Route::controller(CommentController::class)->group(function (){
        Route::post('/comment/store', 'StoreComment' )->name('comment.store');

});

/// Frontend Gallery Routes And Cont
Route::controller(GalleryController::class)->group(function (){
    Route::get('/gallery', 'ShowGallery' )->name('show.gallery');

    // >>> Router Contact form message  <<<< //
    Route::get('/contact', 'ContactUs' )->name('contact.us');

    // send messgae user to admin
    Route::post('/contact/sotre', 'ContactSTore' )->name('contact.store');

});

/// end frontend show


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
        
        //  User Booking  Route
        Route::get('/user-booking', 'UserBooking' )->name('user.booking');
        //user invoice Route
        Route::get('/user-invoice/{id}', 'UserInvoice' )->name('user.invoice');

    }); // end group booking

}); // End  Group Middleware User 


///// Notifiaction  Booking Check Out
Route::controller(BookingController::class)->group(function (){
    //  Booking 
    Route::post('/mark-notification-as-read/{notificationId}', 'MarkAsRead' );

}); // end group booking  