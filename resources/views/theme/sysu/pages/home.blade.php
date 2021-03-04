@extends('theme.'.env('FRONTEND_TEMPLATE').'.main')

@section('pagecss')
@endsection

@php
    $contents = $page->contents;

    $featuredArticles = \App\Article::where('is_featured', 1)->where('is_published', 1)->get();

    if ($featuredArticles->count()) {

        $featuredArticlesHTML = '';
        foreach ($featuredArticles as $index => $article) {
            $imageUrl = (empty($article->thumbnail_url)) ? asset('theme/'.env('FRONTEND_TEMPLATE').'/images/misc/no-image.jpg') : $article->thumbnail_url;

            $featuredArticlesHTML .= '<div class="col-lg-4 col-md-12 mb-4">
					<div class="card border-0 article-items">
					  <img class="card-img-top" src="'. $imageUrl .'" alt="Card image cap">
					  <div class="card-body px-0 article-body">
						<h5 class="card-title article-title"><a href="'. $article->get_url() .'">'. $article->name .'</a></h5>
						<p class="card-text article-text my-4">'. $article->teaser .'</p>
						<div class="article-info">
							<div class="float-left">
							  <time class="meta"><i class="fa fa-calendar-alt"></i> '. $article->date_posted() .' </span>
							</div>
							<a class="float-right text-btn" href="'. $article->get_url() .'">Read More</a>
						</div>
					  </div>
					</div>
				</div>';

            if (\App\Article::has_featured_limit() && $index >= env('FEATURED_NEWS_LIMIT')) {
                break;
            }
        }

        $featuredArticlesHTML = '<section class="wrapper border-top">
                            <div class="container">
                                <div class="row">
                                    <div class="col-12 text-center">
                                        <!-- <h2 class="h1 font-weight-bold main-title mb-5">Latest News</h2> -->
                                    </div>
                                    '. $featuredArticlesHTML .'
                                </div>
                            </div>
                        </section>';

        $contents = str_replace('{Featured Articles}', $featuredArticlesHTML, $contents);

    } else {
        $contents = str_replace('{Featured Articles}', '', $contents);
    }
@endphp

@section('content')
    {!! $contents !!}
@endsection

@section('pagejs')
@endsection

@section('customjs')
@endsection
