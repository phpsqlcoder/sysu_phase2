@extends('theme.'.env('FRONTEND_TEMPLATE').'.main')
@section('pagecss')

@endsection
@section('content')
<section class="mb-5">
    <div class="container pt-2">
        <div class="gap-20"></div>
        <div class="row">
            <span onclick="closeNav()" class="dark-curtain"></span> 
            <span onclick="openNav()" class="mb-4 btn btn-primary btn-bg open-nav rounded-0 d-block d-lg-none"><i class="fa fa-1x fa-th-list"></i></span>

            <div class="col-md-3">
                <div class="tablet-view">
                    <a href="javascript:void(0)" class="closebtn d-block d-lg-none mt-5" onclick="closeNav()">&times;</a>
                    <h3>Categories</h3>
                        {!! $categories !!}

                    <h5>Archive</h5>
                    <div class="accordion" id="accordionExample">
                      {!! $dates !!}
                    </div>
                </div>
            </div>
            
            <div class="col-lg-9">
                <div class="search mb-5">
                    <form id="frm_search">
                        <div class="searchbar">
                            <input type="text" name="searchtxt" id="searchtxt" class="form-control form-input form-search" placeholder="Search news" aria-label="Search news" aria-describedby="button-addon1" />
                            <button class="form-submit-search" type="submit" name="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
                <div class="row">
                    @foreach($articles as $article)
                        <div class="col-lg-4 col-md-6">
                            <div class="card news-post-list">
                                @if($article->thumbnail_url)
                                    <a href="{{ route('news.front.show',$article->slug) }}" class="news-post-image"><img src="{{ $article->thumbnail_url }}" alt="..."></a>
                                @else
                                    <a href="{{ route('news.front.show',$article->slug) }}" class="news-post-image"><img src="{{ asset('storage/news_image/news_thumbnail/No_Image_Available.jpg')}}" alt="no image"></a>
                                @endif
                                <div class="card-body">
                                    <p class="news-post-time">Posted {{ Setting::date_for_news_list($article->created_at) }}</p>
                                    <h5 class="card-title"><a href="{{ route('news.front.show',$article->slug) }}">{{ $article->name }}</a></h5>
                                    <p class="card-text">{{ $article->teaser }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                {{ $articles->links('theme.'.env('FRONTEND_TEMPLATE').'.layout.pagination') }}
            </div>
        </div>
    </div>
</section>
@endsection

@section('pagejs')
@endsection

@section('customjs')
    <script>
        var navikMenuListDropdown = $(".side-menu ul li:has(ul)");

        navikMenuListDropdown.each(function() {
            $(this).append('<span class="dropdown-append"></span>');
        });

        $(".side-menu .active").each(function() {
            $(this).parents("ul").css("display", "block");
            $(this).parents("ul").prev("a").css("color", "#00bfca");
            $(this).parents("ul").next(".dropdown-append").addClass("dropdown-open");
        });

        $(".dropdown-append").on("click", function() {
            $(this).prev("ul").slideToggle(300);
            $(this).toggleClass("dropdown-open");
        });
    </script>
    <script>
        $(function() {
            $('#frm_search').on('submit', function(e) {
                e.preventDefault();
                window.location.href = "{{route('news.front.index')}}?type=searchbox&criteria="+$('#searchtxt').val();
            });
        });
    </script>
@endsection
