@extends('theme.'.env('FRONTEND_TEMPLATE').'.main')

@section('pagecss')
@endsection

@section('content')
    <!-- {!! $page->contents !!} -->
    <section id="home-one">
    	<div class="container">
    		<h6 class="text-center">Who We Are</h6>
    		<h2 class="heading-decorated">Welcome to Artemis Salt</h2>
    		<div class="gap-20"></div>
    		<p class="text-center">Lorem ipsum dolor sit amet consectetur adipisicing elit. Nobis laudantium deleniti pariatur culpa sed illo molestiae architecto aperiam repudiandae similique. Sed exercitationem veritatis temporibus excepturi minima eos quaerat suscipit assumenda.</p>

    		<div class="gap-20"></div>

    		<div class="row">
    			<div class="col-lg-4">
    				<div class="service-card">
    					<span class="service-icon"><img src="{{\URL::to('/')}}/theme/artemissalt/images/misc/icon1.png"></span>
    					<div class="media-body">
    						<h3 class="service-title">
    							<a href="#">Water Softener Application</a>
    						</h3>
    						<p>Lorem ipsum dolor sit amet, consectuerter adipiscing elit diam, sed diam nonummy nibh euismod tincidunt.</p>
    					</div>
    				</div>
    			</div>
    			<div class="col-lg-4">
    				<div class="service-card">
    					<span class="service-icon"><img src="{{\URL::to('/')}}/theme/artemissalt/images/misc/icon1.png"></span>
    					<div class="media-body">
    						<h3 class="service-title">
    							<a href="#">Food Application</a>
    						</h3>
    						<p>Lorem ipsum dolor sit amet, consectuerter adipiscing elit diam, sed diam nonummy nibh euismod tincidunt.</p>
    					</div>
    				</div>
    			</div>
    			<div class="col-lg-4">
    				<div class="service-card">
    					<span class="service-icon"><img src="{{\URL::to('/')}}/theme/artemissalt/images/misc/icon1.png"></span>
    					<div class="media-body">
    						<h3 class="service-title">
    							<a href="#">Bakery Application</a>
    						</h3>
    						<p>Lorem ipsum dolor sit amet, consectuerter adipiscing elit diam, sed diam nonummy nibh euismod tincidunt.</p>
    					</div>
    				</div>
    			</div>
    			<div class="col-lg-4">
    				<div class="service-card">
    					<span class="service-icon"><img src="{{\URL::to('/')}}/theme/artemissalt/images/misc/icon1.png"></span>
    					<div class="media-body">
    						<h3 class="service-title">
    							<a href="#">Feed Application</a>
    						</h3>
    						<p>Lorem ipsum dolor sit amet, consectuerter adipiscing elit diam, sed diam nonummy nibh euismod tincidunt.</p>
    					</div>
    				</div>
    			</div>
    			<div class="col-lg-4">
    				<div class="service-card">
    					<span class="service-icon"><img src="{{\URL::to('/')}}/theme/artemissalt/images/misc/icon1.png"></span>
    					<div class="media-body">
    						<h3 class="service-title">
    							<a href="#">Chemical and Fertilizer Application</a>
    						</h3>
    						<p>Lorem ipsum dolor sit amet, consectuerter adipiscing elit diam, sed diam nonummy nibh euismod tincidunt.</p>
    					</div>
    				</div>
    			</div>
    			<div class="col-lg-4">
    				<div class="service-card">
    					<span class="service-icon"><img src="{{\URL::to('/')}}/theme/artemissalt/images/misc/icon1.png"></span>
    					<div class="media-body">
    						<h3 class="service-title">
    							<a href="#">Health & Advocacy</a>
    						</h3>
    						<p>Lorem ipsum dolor sit amet, consectuerter adipiscing elit diam, sed diam nonummy nibh euismod tincidunt.</p>
    					</div>
    				</div>
    			</div>
    		</div>
    	</div>
    </section>

    <section id="home-two">
    	<div class="container-fluid p-0">
    		<div class="row no-gutters">
    			<div class="col-lg-6">
    				<div class="bg-wrapper" style="background-image:url({{\URL::to('/')}}/theme/artemissalt/images/misc/bakery.jpg)"></div>
    			</div>
    			<div class="col-lg-6">
    				<div class="two-wrapper">
    					<div class="two-wrap">
    						<h6 class="text-center">Special Offers</h6>
    						<h2>GET 30% OFF</h2>
    						<p class="text-center"><strong>YOUR ORDER OF $100 OR MORE</strong></p>
    						<div class="gap-40"></div>
    						<ul id="countdown" class="countdown" data-date-time="Sep 30, 2020 00:00:00">
    							<li><span id="days"></span>Days</li>
    							<li><span id="hours"></span>Hours</li>
    							<li><span id="minutes"></span>Minutes</li>
    							<li><span id="seconds"></span>Seconds</li>
    						</ul>
    					</div>
    				</div>
    			</div>
    		</div>
    	</div>
    </section>

    <section id="home-three">
    	<div class="container">
    		<div class="row">
    			<div class="col-lg-4">
    				<div class="special-card">
    					<div class="special-image">
    						<img src="images/misc/img01.jpg">
    						<div class="special-icon"><img src="{{\URL::to('/')}}/theme/artemissalt/images/misc/icon1.png"></div>
    					</div>
    					<div class="special-content">
    						<h4>Local Farmers</h4>
    						<div class="gap-10"></div>
    						<p>Donec nec justo eget felis facilisis ferme ntum. Aliquam porttitor mauris sit amet orci. Aenean dignissim pellentesque
    						felis. Morbi in sem quis dui placerat ornare.</p>
    					</div>
    				</div>
    			</div>
    			<div class="col-lg-4">
    				<div class="special-card">
    					<div class="special-image">
    						<img src="images/misc/img01.jpg">
    						<div class="special-icon"><img src="{{\URL::to('/')}}/theme/artemissalt/images/misc/icon1.png"></div>
    					</div>
    					<div class="special-content">
    						<h4>Local Industries</h4>
    						<div class="gap-10"></div>
    						<p>Donec nec justo eget felis facilisis ferme ntum. Aliquam porttitor mauris sit amet orci. Aenean dignissim
    							pellentesque
    						felis. Morbi in sem quis dui placerat ornare.</p>
    					</div>
    				</div>
    			</div>
    			<div class="col-lg-4">
    				<div class="special-card">
    					<div class="special-image">
    						<img src="images/misc/img01.jpg">
    						<div class="special-icon"><img src="{{\URL::to('/')}}/theme/artemissalt/images/misc/icon1.png"></div>
    					</div>
    					<div class="special-content">
    						<h4>Local Health Concerns</h4>
    						<div class="gap-10"></div>
    						<p>Donec nec justo eget felis facilisis ferme ntum. Aliquam porttitor mauris sit amet orci. Aenean dignissim
    							pellentesque
    						felis. Morbi in sem quis dui placerat ornare.</p>
    					</div>
    				</div>
    			</div>
    		</div>

    		<div class="gap-80"></div>
    		<h6 class="text-center">All News Around Us</h6>
    		<h2 class="heading-decorated">Our Blog</h2>
    		<div class="gap-40"></div>
    		<div class="row">
    			<div class="col-lg-4">
    				<div class="news-layout">
    					<div class="item-img">
    						<figure>
    							<img src="{{\URL::to('/')}}/theme/artemissalt/images/misc/news1.jpg" class="img-fluid" alt="blog">
    						</figure>
    					</div>
    					<div class="item-content">
    						<span class="published-date">Posted on February 27, 2020</span>
    						<h3 class="news-title">
    							<a href="article.htm">We're divided land his creature which have evening subdue</a>
    						</h3>
    						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin tincidunt nunc lorem, nec faucibus mi facilisis eget.
    						Mauris laoreet, nisl id faucibus pellentesque, mi mi tempor enim, sit amet interdum felis nibh a leo.</p>
    						<div class="gap-30"></div>
    						<a class="btn btn-md primary-btn mr-2" href="#">Read More</a>
    					</div>
    				</div>
    			</div>
    			<div class="col-lg-4">
    				<div class="news-layout">
    					<div class="item-img">
    						<figure>
    							<img src="{{\URL::to('/')}}/theme/artemissalt/images/misc/news2.jpg" class="img-fluid" alt="blog">
    						</figure>
    					</div>
    					<div class="item-content">
    						<span class="published-date">Posted on February 27, 2020</span>
    						<h3 class="news-title">
    							<a href="article.htm">We're divided land his creature which have evening subdue</a>
    						</h3>
    						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin tincidunt nunc lorem, nec faucibus mi facilisis
    							eget.
    						Mauris laoreet, nisl id faucibus pellentesque, mi mi tempor enim, sit amet interdum felis nibh a leo.</p>
    						<div class="gap-30"></div>
    						<a class="btn btn-md primary-btn mr-2" href="#">Read More</a>
    					</div>
    				</div>
    			</div>
    			<div class="col-lg-4">
    				<div class="news-layout">
    					<div class="item-img">
    						<figure>
    							<img src="{{\URL::to('/')}}/theme/artemissalt/images/misc/news3.jpg" class="img-fluid" alt="blog">
    						</figure>
    					</div>
    					<div class="item-content">
    						<span class="published-date">Posted on February 27, 2020</span>
    						<h3 class="news-title">
    							<a href="article.htm">We're divided land his creature which have evening subdue</a>
    						</h3>
    						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin tincidunt nunc lorem, nec faucibus mi facilisis
    							eget.
    						Mauris laoreet, nisl id faucibus pellentesque, mi mi tempor enim, sit amet interdum felis nibh a leo.</p>
    						<div class="gap-30"></div>
    						<a class="btn btn-md primary-btn mr-2" href="#">Read More</a>
    					</div>
    				</div>
    			</div>
    		</div>
    	</div>
    </section>

    <section id="home-four">
    	<div class="container">
    		<div class="row">
    			<div class="col-lg-6">
    				<h6>Want to know more?</h6>
    				<h2 class="text-left">Send a Quote!</h2>
    				<div class="gap-20"></div>

    				<form action="">
    					<div class="form-group">
    						<label for="name">Your Name (required)</label>
    						<div class="form-control-wrap">
    							<input type="text" class="form-control" id="name" required autocomplete>
    						</div>
    					</div>
    					<div class="form-group">
    						<label for="email">Your Email (required)</label>
    						<div class="form-control-wrap">
    							<input type="email" class="form-control" id="email" required autocomplete>
    						</div>
    					</div>
    					<div class="form-group">
    						<label for="phone">Your Phone (required)</label>
    						<div class="form-control-wrap">
    							<input type="number" class="form-control" id="phone" required autocomplete>
    						</div>
    					</div>
    					<div class="form-group">
    						<label for="subject">Subject</label>
    						<div class="form-control-wrap">
    							<input type="text" class="form-control" id="subject" autocomplete>
    						</div>
    					</div>
    					<div class="form-group">
    						<label for="message">Your Message (required)</label>
    						<div class="form-control-wrap">
    							<textarea class="form-control" id="message" rows="3"></textarea>
    						</div>
    					</div>
    					<button type="submit" class="btn btn-md primary-btn">Submit</button>
    				</form>
    			</div>
    		</div>
    	</div>
    </section>

    <section id="home-five">
    	<div class="container">
    		<h6 class="text-center">Testimonials</h6>
    		<h2 class="heading-decorated">Client's words</h2>
    		<div id="testimonial-slider" class="slick-slider">
    			<div class="testimonial-card">
    				<div class="testimonial-quote">
    					<blockquote>
    						<q>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam at ultrices ante. Nunc eu ex turpis. Vestibulum
    							imperdiet fermentum velit ac laoreet. Fusce imperdiet ac nisi aliquam rhoncus. Ut ac dui eu massa pretium posuere in in
    						velit. Nulla id odio fermentum.</q>
    					</blockquote>
    				</div>
    				<div class="testimonial-author">
    					<cite>Pearl R. <small>School Teacher</small></cite>
    				</div>
    			</div>
    			<div class="testimonial-card">
    				<div class="testimonial-quote">
    					<blockquote>
    						<q>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam at ultrices ante. Nunc eu ex turpis. Vestibulum
    							imperdiet fermentum velit ac laoreet. Fusce imperdiet ac nisi aliquam rhoncus. Ut ac dui eu massa pretium
    							posuere in in
    						velit. Nulla id odio fermentum.</q>
    					</blockquote>
    				</div>
    				<div class="testimonial-author">
    					<cite>John Augustus A. <small>School Teacher</small></cite>
    				</div>
    			</div>
    		</div>
    	</div>
    </section>

    <section id="home-six">
    	<div class="container">
    		<h6 class="text-center text-white">The Ultimate Retreat</h6>
    		<h2 class="text-white heading-decorated">Benefit of Sea Salt</h2>
    	</div>
    </section>

    <section id="home-seven">
    	<div class="container-fluid p-0">
    		<div class="portfolio-grid">
    			<div class="grid-sizer"></div>

    			<a class="grid-item civic-muni large" href="">
    				<div class="grid-item-inner"
	    				style="background: url(https://images.unsplash.com/photo-1453929203062-5b1b9cb4cb94?dpr=1&auto=format&fit=crop&w=1500&h=2256&q=80&cs=tinysrgb&crop=&bg=); background-size: cover; background-position: center center;">
	    				<h3>Keeps you hydrated</h3>
	    				<div class="overlay"></div>
	    			</div>
	    		</a>

	    		<a class="grid-item k-12" href="">
	    			<div class="grid-item-inner"
		    			style="background: url(https://images.unsplash.com/photo-1484882918957-e9f6567be3c8?dpr=1&auto=format&fit=crop&w=1500&h=1875&q=80&cs=tinysrgb&crop=&bg=); background-size: cover; background-position: center center;">
		    			<h3>Reduces fluid retention</h3>
		    			<div class="overlay"></div>
		    		</div>
		    	</a>

		    	<a class="grid-item higher-edu" href="">
		    		<div class="grid-item-inner"
			    		style="background: url(https://images.unsplash.com/photo-1489878950755-bbe8f9b8672c?dpr=1&auto=format&fit=crop&w=1500&h=844&q=80&cs=tinysrgb&crop=&bg=); background-size: cover; background-position: center center;">
			    		<h3>A great source of minerals</h3>
			    		<div class="overlay"></div>
			    	</div>
			    </a>


			    <a class="grid-item medical" href="">
			    	<div class="grid-item-inner"
				    	style="background: url(https://images.unsplash.com/photo-1419406692015-ddbc1dd91e54?dpr=1&auto=format&fit=crop&w=1500&h=1636&q=80&cs=tinysrgb&crop=&bg=); background-size: cover; background-position: center center;">
				    	<h3>Balances electrolytes</h3>
				    	<div class="overlay"></div>
				    </div>
				</a>

				<a class="grid-item civic-muni medium" href="">
					<div class="grid-item-inner"
						style="background: url(https://images.unsplash.com/photo-1450740199001-78e928502994?dpr=1&auto=format&fit=crop&w=1500&h=994&q=80&cs=tinysrgb&crop=&bg=); background-size: cover; background-position: center center;">
						<h3>Prevents muscle cramps</h3>
						<div class="overlay"></div>
					</div>
				</a>

				<a class="grid-item civic-muni" href="">
					<div class="grid-item-inner"
						style="background: url(https://images.unsplash.com/photo-1457630509638-7a7543f31f75?dpr=1&auto=format&fit=crop&w=1500&h=1000&q=80&cs=tinysrgb&crop=&bg=); background-size: cover; background-position: center center">
						<h3>Great for skin health</h3>
						<div class="overlay"></div>
					</div>
				</a>

				<a class="grid-item k-12" href="">
					<div class="grid-item-inner"
						style="background: url(https://images.unsplash.com/photo-1470075801209-17f9ec0cada6?dpr=1&auto=format&fit=crop&w=1500&h=2250&q=80&cs=tinysrgb&crop=&bg=); background-size: cover; background-position: center center;">
						<h3>Improves digestion</h3>
						<div class="overlay"></div>
					</div>
				</a>

				<a class="grid-item retail-commercial medium" href="">
					<div class="grid-item-inner"
						style="background: url(https://images.unsplash.com/photo-1478025101087-7f1ce4c83156?dpr=1&auto=format&fit=crop&w=1500&h=1000&q=80&cs=tinysrgb&crop=&bg=); background-size: cover; background-position: center center;">
						<h3>Nourishes the adrenal glands</h3>
						<div class="overlay"></div>
					</div>
				</a>

				<a class="grid-item church-theater medium" href="">
					<div class="grid-item-inner"
						style="background: url(https://images.unsplash.com/photo-1477525105990-60a9f6610642?dpr=1&auto=format&fit=crop&w=1500&h=1000&q=80&cs=tinysrgb&crop=&bg=); background-size: cover; background-position: center center;">
						<h3>Regulates blood pressure</h3>
						<div class="overlay"></div>
					</div>
				</a>

			</div>
		</div>
	</section>
@endsection

@section('pagejs')
@endsection

@section('customjs')
@endsection
