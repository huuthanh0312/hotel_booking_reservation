@php
    $site = App\Models\SiteSetting::find(1);
@endphp


<header class="top-header top-header-bg">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-3 col-md-2 pr-0">
                <div class="language-list">
                    <select class="language-list-item">
                        <option>English</option>
                        <option>Vietnamese</option>                       
                    </select>	
                    
                </div>
            </div>

            <div class="col-lg-9 col-md-10">
                <div class="header-right">
                    <ul>                       
                        <li>
                            <i class='bx bx-home-alt'></i>
                            <a href="#">{{$site->address}}</a>
                        </li>
                        <li>
                            <i class='bx bx-phone-call'></i>
                            <a href="tel:{{$site->phone}}">{{$site->phone}}</a>
                        </li>
                        @if (Auth::check())
                        <li>
                            <i class='bx bxs-user-pin'></i>
                            <a href="{{ route('dashboard')}}">Dashboard</a>
                        </li>
                        <li>
                            <i class='bx bxs-log-in-circle'></i>
                            <a href="{{route('user.logout')}}">Logout</a>
                        </li>
                        @else
                        <li>
                            <i class='bx bxs-user-pin'></i>
                            <a href="{{ route('login')}}">Login</a>
                        </li>
                        <li>
                            <i class='bx bxs-user-rectangle'></i>
                            <a href="{{route('register')}}">Register</a>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>