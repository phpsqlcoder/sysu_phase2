<?php
namespace App\Shortcodes;
use App\Article;

class ArticlesShortcodes {

	public function latest($shortcode, $content, $compiler, $name, $viewData)
	{
		$limit = $shortcode->limit;
		$latest_news = Article::whereStatus('Published')->orderBy('date', 'desc')->take($limit)->get();

		$data = '
                    <div class="article-widget-title">
                        Latest News
                    </div>
                    ';

        foreach($latest_news as $latest){
        	$data.='
				<div class="article-widget-news">
                    <p class="news-date">'.date("F d, Y",strtotime($latest->date)).'</p>
                    <p class="news-title">
                        <a href="'.$latest->slug.'">'.$latest->name.'</a>
                    </p>
                </div>
        	';
        }


		return sprintf('<div class="article-widget">'.$data.'</div>', $shortcode->class, $content);
	}

    public function latest_homepage($shortcode, $content, $compiler, $name, $viewData)
    {
        $limit = 3;
        $latest_news = Article::where('is_featured', 1)->whereStatus('Published')->orderBy('date', 'desc')->take($limit)->get();

        if ($latest_news->count() == 0) {
            return '';
        }

        $data = '
                 
                        <div class="container">
                            <h2>Our Latest News</h2>
                            <div class="gap-40"></div>
                            <div class="row">
                    ';
                    logger($latest_news);
        foreach($latest_news as $latest) {
            $imageHTML = '';
            if (!empty($latest->image_url)) {
                $imageHTML = '<figure>
                                <img src="' . $latest->image_url . '" class="img-fluid" alt="blog">
                            </figure>';
            }

            $data.='
                <div class="col-lg-4 col-md-12 col-sm-12">
                    <div class="news-layout">
                        <div class="item-img">
                            '.$imageHTML.'
                            <ul class="published-date-comment">
                                <li>
                                    <a href="#"><i class="fa fa-calendar-o" aria-hidden="true"></i>'.$latest->get_created_at_date_only().'</a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa fa-user" aria-hidden="true"></i>Posted by '.$latest->user->firstname.'</a>
                                </li>
                            </ul>
                        </div>
                        <div class="item-content">
                            <h3 class="news-title">
                                <a href='.route("news.front.show",$latest->slug).'>'.$latest->name.'</a>
                            </h3>
                            <p>'.$latest->teaser.'…</p>
                            <a href='.route("news.front.show",$latest->slug).' class="read-more-btn">Read More <i class="fa fa-angle-right" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
            ';
        }

        $data.='
                </div>
            </div>

        ';


        return sprintf('<section id="home-news">'.$data.'</section>', $shortcode->class, $content);
    }



}

?>
