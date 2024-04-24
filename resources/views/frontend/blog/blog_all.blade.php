@extends('frontend.main_master')
@section('main')
<!-- Inner Banner -->
<div class="inner-banner inner-bg3">
    <div class="container">
        <div class="inner-title">
            <ul>
                <li>
                    <a href="{{url('/')}}">Home</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>Blog </li>
            </ul>
            <h3>All Blog List</h3>
        </div>
    </div>
</div>
<!-- Inner Banner End -->

<!-- Blog Details Area -->
<div class="blog-details-area pt-100 pb-70">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                @if ($blog->count() > 0)
                    @foreach ($blog as $item)
                    <div class="col-lg-12">
                        <div class="blog-card">
                            <div class="row align-items-center">
                                <div class="col-lg-5 col-md-4 p-0">
                                    <div class="blog-img">
                                        <a href="{{url('blog/details/'.$item->post_slug)}}">
                                            <img src="{{asset($item->post_image)}}" alt="Images">
                                        </a>
                                    </div>
                                </div>

                                <div class="col-lg-7 col-md-8 p-0">
                                    <div class="blog-content">
                                        <span>{{$item->created_at->format('M d Y')}}</span>
                                        <h3>
                                            <a href="{{url('blog/details/'.$item->post_slug)}}">{{$item->post_title}}</a>
                                        </h3>
                                        <p>{{$item->short_descp}}</p>
                                        <a href="{{url('blog/details/'.$item->post_slug)}}" class="read-btn">
                                            Read More
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach  
                    <div class="col-lg-12 col-md-12">
                        <div class="pagination-area">    
                            {{$blog->links('vendor.pagination.custom')}}
                        </div>
                    </div>
                @else
                    <div class="alert alert-danger" role="alert">
                        There are currently no posts !!!!!! >> href <a href="{{ url('/')}}">Home</a>
                    </div>
                @endif
            </div>    
            <div class="col-lg-4">
                <div class="side-bar-wrap">
                    <div class="search-widget">
                        <form class="search-form">
                            <input type="search" class="form-control" placeholder="Search...">
                            <button type="submit">
                                <i class="bx bx-search"></i>
                            </button>
                        </form>
                    </div>

                    <div class="services-bar-widget">
                        <h3 class="title">Blog Category</h3>
                        <div class="side-bar-categories">
                            <ul>
                                @foreach ($blog_category as $category)
                                    
                                    <li>
                                        <a href="{{url('blog-category/list/'.$category->id)}}">{{$category->category_name}}</a>
                                    </li>
                                @endforeach  
                            </ul>
                        </div>
                    </div>

                    <div class="side-bar-widget">
                        <h3 class="title">Recent Posts</h3>
                        <div class="widget-popular-post">
                            @foreach ($list_post_diff as $blog)
                            
                            <article class="item">
                                <a href="{{url('blog/details/'.$blog->post_slug)}}" class="thumb">
                                    <span class="full-image cover bg1" role="img"></span>
                                </a>
                                <div class="info">
                                    <h4 class="title-text">
                                        <a href="{{url('blog/details/'.$blog->post_slug)}}">
                                            {{$blog->post_title}}
                                        </a>
                                    </h4>
                                    <ul>
                                        <li>
                                            <i class='bx bx-user'></i>
                                            29K
                                        </li>
                                        <li>
                                            <i class='bx bx-message-square-detail'></i>
                                            15K
                                        </li>
                                    </ul>
                                </div>
                            </article>  
                            @endforeach

                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>
<!-- Blog Details Area End -->

@endsection