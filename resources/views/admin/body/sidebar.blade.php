{{-- @extends('admin.admin_dashboard')

@section('sidebar')
     --}}



<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div>
            <img src="{{asset('backend/assets/images/logo-icon.png')}}" class="logo-icon" alt="logo icon">
        </div>
        <div>
            <h4 class="logo-text">Thanh Hotel</h4>
        </div>
        <div class="toggle-icon ms-auto"><i class='bx bx-arrow-back'></i>
        </div>
     </div>
    <!--navigation-->
    <ul class="metismenu" id="menu">
        <li>
            <a href="{{route('admin.dashboard')}}" >
                <div class="parent-icon"><i class='bx bx-home-alt'></i>
                </div>
                <div class="menu-title">Dashboard</div>
            </a>
            
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bx bx-category"></i>
                </div>
                <div class="menu-title">Manager Teams</div>
            </a>
            <ul>
                <li> <a href="{{route('all.team')}}"><i class='bx bx-radio-circle'></i>All Team</a>
                </li>
                <li> <a href="{{ route('add.team') }}"><i class='bx bx-radio-circle'></i>Add Team</a>
                </li>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bx bx-category"></i>
                </div>
                <div class="menu-title">Manager Book Area</div>
            </a>
            <ul>
                <li> <a href="{{route('book.area')}}"><i class='bx bx-radio-circle'></i>Update Book Area</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bx bx-category"></i>
                </div>
                <div class="menu-title">Manager Room Type</div>
            </a>
            <ul>
                <li> <a href="{{route('room.type.list')}}"><i class='bx bx-radio-circle'></i>List Room Type </a>
                </li>
            </ul>
        </li>
        <li class="menu-label">Booking Manager</li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-cart'></i>
                </div>
                <div class="menu-title">Booking</div>
            </a>
            <ul>
                <li> <a href="{{route('booking.list')}}"><i class='bx bx-radio-circle'></i>Booking List</a>
                </li>
                
            </ul>
        </li>
        <li>
            <a class="has-arrow" href="javascript:;">
                <div class="parent-icon"><i class='bx bx-bookmark-heart'></i>
                </div>
                <div class="menu-title">Manager Room List</div>
            </a>
            <ul>
                <li> <a href="{{route('view.room.list')}}"><i class='bx bx-radio-circle'></i>Room List</a>
                </li>
                <li> <a href="{{route('add.room.list')}}"><i class='bx bx-radio-circle'></i>Add Room List</a>
                </li>
            </ul>
        </li>
        <li>
            <a class="has-arrow" href="javascript:;">
                <div class="parent-icon"><i class='bx bx-bookmark-heart'></i>
                </div>
                <div class="menu-title">Setting</div>
            </a>
            <ul>
                <li> <a href="{{route('smtp.setting')}}"><i class='bx bx-radio-circle'></i>SMTP Setting</a>
                </li>
            </ul>
        </li>
        <li>
            <a class="has-arrow" href="javascript:;">
                <div class="parent-icon"><i class='bx bx-bookmark-heart'></i>
                </div>
                <div class="menu-title">Testimonial</div>
            </a>
            <ul>
                <li> <a href="{{route('testimonial.all')}}"><i class='bx bx-radio-circle'></i>All Testimonial </a>
                </li>
                <li> <a href="{{route('testimonial.add')}}"><i class='bx bx-radio-circle'></i>Add Testimonial</a>
                </li>
            </ul>
        </li>
        <li>
            <a class="has-arrow" href="javascript:;">
                <div class="parent-icon"><i class='bx bx-bookmark-heart'></i>
                </div>
                <div class="menu-title">Blog</div>
            </a>
            <ul>
                <li> <a href="{{route('blog.category.all')}}"><i class='bx bx-radio-circle'></i>All Blog Category </a>
                </li>
                
            </ul>
        </li>
        <li class="menu-label">Others</li>
        <li>
            <a href="https://themeforest.net/user/codervent" target="_blank">
                <div class="parent-icon"><i class="bx bx-support"></i>
                </div>
                <div class="menu-title">Setting</div>
            </a>
        </li>
        <li>
            <a href="https://themeforest.net/user/codervent" target="_blank">
                <div class="parent-icon"><i class="bx bx-support"></i>
                </div>
                <div class="menu-title">Support</div>
            </a>
        </li>
    </ul>
    <!--end navigation-->
</div>

{{-- @endsection --}}