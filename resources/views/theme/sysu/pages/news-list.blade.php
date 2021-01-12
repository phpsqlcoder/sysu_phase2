@extends('theme.'.env('FRONTEND_TEMPLATE').'.main')
@section('pagecss')

@endsection
@section('content')
    <section id="default-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <h3>News</h3>
                    <div class="gap-20"></div>
                    <div class="side-menu">
                        <ul>
                            @foreach ($articleYears as $year)
                                <li><a href="#">{{ $year->year }}</a>
                                    <ul>
                                        @foreach ($articleMonthsByYear[$year->year] as $month)
                                            <li @if ($search == $month->year.'-'.$month->month) class="active" @endif>
                                                <a href="{{ route('news.front.index') }}?type=month&criteria={{ $month->year.'-'.$month->month }}">{{ $month->month_name }}</a>
                                            </li>                                            
                                        @endforeach
                                    </ul>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="gap-40"></div>
                    <h3>Categories</h3>
                    <div class="gap-20"></div>
                    <div class="side-menu">                        
                        <ul>
                            @foreach ($articleCategories as $category)
                                <li @if ($type == "category" && $search == $category->id) class="active" @endif>
                                    <a href="{{route('news.front.index')}}?type=category&criteria={{ $category->id }}">{{ $category->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="gap-80"></div>
                </div>
                <div class="col-lg-9">
                    <div class="search">
                        <form action="news" method="get">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Search news" aria-label="Search news"
                                aria-describedby="button-addon1" />
                                <span class="search-icon"><i class="fa fa-search"></i></span>
                            </div>
                            <button class="primary-btn btn-md" type="submit" id="button-addon1">
                                Search
                            </button>
                        </form>
                    </div>
                    @foreach($articles as $article)
                        <div class="news-post">
                            @if (empty($article->image_url))
                                <div class="news-post-img" style="background-image:url({{ asset('theme/'.env('FRONTEND_TEMPLATE').'/images/misc/news1.jpg') }})"></div>
                            @else
                                <div class="news-post-img" style="background-image:url({{ $article->image_url }})"></div>
                            @endif
                            
                            <div class="news-post-info">
                                <div class="news-post-content">
                                    <h3>
                                        <a href="{{ $article->get_url() }}">{{ $article->name }}</a>
                                    </h3>
                                    <p class="news-post-info-excerpt">
                                       {{ $article->teaser }}
                                    </p>
                                </div>
                                <div class="news-post-share">
                                    <div class="share_link"></div>
                                    <p class="news-post-info-meta">Posted on  {{ Setting::date_for_news_list($article->created_at) }}</p>
                                </div>
                            </div>
                            
                        </div>
                    @endforeach

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
        window.location.href = "/news?type=searchbox&criteria="+$('#searchtxt').val();
    });
});

</script>
@endsection
