@php
    $dataBookArea = App\Models\BookArea::find(1);
@endphp



<div class="book-area-two pt-100 pb-70">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="book-content-two">
                    <div class="section-title">
                        <span class="sp-color">{{$dataBookArea->short_title}}</span>
                        <h2>{{$dataBookArea->main_title}}</h2>
                        <p>{{$dataBookArea->short_desc}}</p>
                    </div>
                    <a href="{{$dataBookArea->linl_url}}" class="default-btn btn-bg-three">Quick Booking</a>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="book-img-2">
                    <img src="{{ (!empty($dataBookArea->images)) ? url('upload/book_area/'.$dataBookArea->images) 
                    : url('upload/no_image.jpg')}}" alt="Images">
                </div>
            </div>
        </div>
    </div>
</div>