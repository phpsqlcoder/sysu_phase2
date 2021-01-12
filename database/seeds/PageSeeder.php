<?php

use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        $galleryHTML = '
            <section id="default-wrapper">
                <div class="container">
                  <div class="custom-gallery">
                    <div id="lightgallery" class="list-unstyled justified-gallery" style="height: 520px;">
                      <a data-pinterest-text="Pin it" data-tweet-text="share it on twitter" class="jg-entry" href="images/gallery/1.jpg" data-sub-html="sdsdsd">
                        <img class="img-responsive" src="'.\URL::to('/').'/theme/artemissalt/images/gallery/1.jpg">
                        <div class="custom-gallery-poster">
                          <img src="'.\URL::to('/').'/theme/artemissalt/images/gallery/zoom.png">
                        </div>
                  
                      </a>
                      <a data-pinterest-text="Pin it" data-tweet-text="share it on twitter" class="jg-entry" href="images/gallery/2.jpg" data-sub-html="sdsdsd">
                        <img class="img-responsive" src="'.\URL::to('/').'/theme/artemissalt/images/gallery/2.jpg">
                        <div class="custom-gallery-poster">
                          <img src="'.\URL::to('/').'/theme/artemissalt/images/gallery/zoom.png">
                        </div>
                  
                      </a>
                      <a data-pinterest-text="Pin it" data-tweet-text="share it on twitter" class="jg-entry" href="images/gallery/3.jpg">
                        <img class="img-responsive" src="'.\URL::to('/').'/theme/artemissalt/images/gallery/3.jpg">
                        <div class="custom-gallery-poster">
                          <img src="'.\URL::to('/').'/theme/artemissalt/images/gallery/zoom.png">
                        </div>
                  
                      </a>
                      <a data-pinterest-text="Pin it" data-tweet-text="share it on twitter" class="jg-entry" href="images/gallery/4.jpg">
                        <img class="img-responsive" src="'.\URL::to('/').'/theme/artemissalt/images/gallery/4.jpg">
                        <div class="custom-gallery-poster">
                          <img src="'.\URL::to('/').'/theme/artemissalt/images/gallery/zoom.png">
                        </div>
                  
                      </a>
                      <a data-pinterest-text="Pin it" data-tweet-text="share it on twitter" class="jg-entry" href="images/gallery/5.jpg">
                        <img class="img-responsive" src="'.\URL::to('/').'/theme/artemissalt/images/gallery/5.jpg">
                        <div class="custom-gallery-poster">
                          <img src="'.\URL::to('/').'/theme/artemissalt/images/gallery/zoom.png">
                        </div>
                  
                      </a>
                      <a data-pinterest-text="Pin it" data-tweet-text="share it on twitter" class="jg-entry" href="images/gallery/6.jpg">
                        <img class="img-responsive" src="'.\URL::to('/').'/theme/artemissalt/images/gallery/6.jpg">
                        <div class="custom-gallery-poster">
                          <img src="'.\URL::to('/').'/theme/artemissalt/images/gallery/zoom.png">
                        </div>
                  
                      </a>
                      <a data-pinterest-text="Pin it" data-tweet-text="share it on twitter" class="jg-entry" href="images/gallery/7.jpg">
                        <img class="img-responsive" src="'.\URL::to('/').'/theme/artemissalt/images/gallery/7.jpg">
                        <div class="custom-gallery-poster">
                          <img src="'.\URL::to('/').'/theme/artemissalt/images/gallery/zoom.png">
                        </div>
                  
                      </a>
                      <!-- <a data-pinterest-text="Pin it" data-tweet-text="share it on twitter" class="jg-entry" href="../static/img/8.jpg"
                        style="width: 187px; height: 126.144px; top: 133.144px; left: 382px; opacity: 1;">
                  
                        <img class="img-responsive" src="../static/img/thumb-8.jpg"
                          style="width: 187px; height: 127px; margin-left: -93.5px; margin-top: -63.5px;">
                        <div class="custom-gallery-poster">
                          <img src="images/gallery/zoom.png">
                        </div>
                  
                      </a>
                      <a data-pinterest-text="Pin it" data-tweet-text="share it on twitter" class="jg-entry" href="../static/img/9.jpg"
                        data-sub-html="sdsdsd" style="width: 187px; height: 126.144px; top: 133.144px; left: 570px; opacity: 1;">
                  
                        <img class="img-responsive" src="../static/img/thumb-9.jpg"
                          style="width: 187px; height: 127px; margin-left: -93.5px; margin-top: -63.5px;">
                        <div class="custom-gallery-poster">
                          <img src="images/gallery/zoom.png">
                        </div>
                  
                      </a>
                      <a data-pinterest-text="Pin it" data-tweet-text="share it on twitter" class="jg-entry" href="../static/img/10.jpg"
                        style="width: 186px; height: 126.144px; top: 133.144px; left: 758px; opacity: 1;">
                  
                        <img class="img-responsive" src="../static/img/thumb-10.jpg"
                          style="width: 186px; height: 127px; margin-left: -93px; margin-top: -63.5px;">
                        <div class="custom-gallery-poster">
                          <img src="images/gallery/zoom.png">
                        </div>
                  
                      </a>
                      <a data-pinterest-text="Pin it" data-tweet-text="share it on twitter" class="jg-entry" href="../static/img/11.jpg"
                        data-sub-html="sdsdsd" style="width: 187px; height: 126.144px; top: 260.287px; left: 6px; opacity: 1;">
                  
                        <img class="img-responsive" src="../static/img/thumb-11.jpg"
                          style="width: 187px; height: 127px; margin-left: -93.5px; margin-top: -63.5px;">
                        <div class="custom-gallery-poster">
                          <img src="images/gallery/zoom.png">
                        </div>
                  
                      </a>
                      <a data-pinterest-text="Pin it" data-tweet-text="share it on twitter" class="jg-entry" href="../static/img/12.jpg"
                        style="width: 187px; height: 126.144px; top: 260.287px; left: 194px; opacity: 1;">
                  
                        <img class="img-responsive" src="../static/img/thumb-12.jpg"
                          style="width: 187px; height: 127px; margin-left: -93.5px; margin-top: -63.5px;">
                        <div class="custom-gallery-poster">
                          <img src="images/gallery/zoom.png">
                        </div>
                  
                      </a>
                      <a data-pinterest-text="Pin it" data-tweet-text="share it on twitter" class="jg-entry" href="../static/img/13.jpg"
                        style="width: 187px; height: 126.144px; top: 260.287px; left: 382px; opacity: 1;">
                  
                        <img class="img-responsive" src="../static/img/thumb-13.jpg"
                          style="width: 187px; height: 127px; margin-left: -93.5px; margin-top: -63.5px;">
                        <div class="custom-gallery-poster">
                          <img src="images/gallery/zoom.png">
                        </div>
                  
                      </a>
                      <a data-pinterest-text="Pin it" data-tweet-text="share it on twitter" class="jg-entry" href="../static/img/14.jpg"
                        style="width: 187px; height: 126.144px; top: 260.287px; left: 570px; opacity: 1;">
                  
                        <img class="img-responsive" src="../static/img/thumb-14.jpg"
                          style="width: 187px; height: 127px; margin-left: -93.5px; margin-top: -63.5px;">
                        <div class="custom-gallery-poster">
                          <img src="images/gallery/zoom.png">
                        </div>
                  
                      </a>
                      <a data-pinterest-text="Pin it" data-tweet-text="share it on twitter" class="jg-entry" href="../static/img/15.jpg"
                        data-sub-html="sdsdsd" style="width: 186px; height: 126.144px; top: 260.287px; left: 758px; opacity: 1;">
                  
                        <img class="img-responsive" src="../static/img/thumb-15.jpg"
                          style="width: 186px; height: 127px; margin-left: -93px; margin-top: -63.5px;">
                        <div class="custom-gallery-poster">
                          <img src="images/gallery/zoom.png">
                        </div>
                  
                      </a>
                      <a data-pinterest-text="Pin it" data-tweet-text="share it on twitter" class="jg-entry" href="../static/img/16.jpg"
                        style="width: 187px; height: 126.144px; top: 387.431px; left: 6px; opacity: 1;">
                  
                        <img class="img-responsive" src="../static/img/thumb-16.jpg"
                          style="width: 187px; height: 127px; margin-left: -93.5px; margin-top: -63.5px;">
                        <div class="custom-gallery-poster">
                          <img src="images/gallery/zoom.png">
                        </div>
                  
                      </a>
                      <a data-pinterest-text="Pin it" data-tweet-text="share it on twitter" class="jg-entry" href="../static/img/17.jpg"
                        style="width: 187px; height: 126.144px; top: 387.431px; left: 194px; opacity: 1;">
                  
                        <img class="img-responsive" src="../static/img/thumb-17.jpg"
                          style="width: 187px; height: 127px; margin-left: -93.5px; margin-top: -63.5px;">
                        <div class="custom-gallery-poster">
                          <img src="images/gallery/zoom.png">
                        </div>
                  
                      </a>
                      <a data-pinterest-text="Pin it" data-tweet-text="share it on twitter" class="jg-entry" href="../static/img/18.jpg"
                        style="width: 187px; height: 126.144px; top: 387.431px; left: 382px; opacity: 1;">
                  
                        <img class="img-responsive" src="../static/img/thumb-18.jpg"
                          style="width: 187px; height: 127px; margin-left: -93.5px; margin-top: -63.5px;">
                        <div class="custom-gallery-poster">
                          <img src="images/gallery/zoom.png">
                        </div>
                  
                      </a>
                      <a data-pinterest-text="Pin it" data-tweet-text="share it on twitter" class="jg-entry" href="../static/img/19.jpg"
                        data-sub-html="sdsdsd" style="width: 187px; height: 126.144px; top: 387.431px; left: 570px; opacity: 1;">
                  
                        <img class="img-responsive" src="../static/img/thumb-19.jpg"
                          style="width: 187px; height: 127px; margin-left: -93.5px; margin-top: -63.5px;">
                        <div class="custom-gallery-poster">
                          <img src="images/gallery/zoom.png">
                        </div>
                  
                      </a>
                      <a data-pinterest-text="Pin it" data-tweet-text="share it on twitter" class="jg-entry" href="../static/img/20.jpg"
                        style="width: 186px; height: 126.144px; top: 387.431px; left: 758px; opacity: 1;">
                  
                        <img class="img-responsive" src="../static/img/thumb-20.jpg"
                          style="width: 186px; height: 127px; margin-left: -93px; margin-top: -63.5px;">
                        <div class="custom-gallery-poster">
                          <img src="images/gallery/zoom.png">
                        </div>
                  
                      </a> -->
                    </div>
                  </div>
                </div>
              </section>
        ';

        $homeHTML = '
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
                                    <span class="service-icon"><img src="'.\URL::to('/').'/theme/artemissalt/images/misc/icon1.png"></span>
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
                                    <span class="service-icon"><img src="'.\URL::to('/').'/theme/artemissalt/images/misc/icon1.png"></span>
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
                                    <span class="service-icon"><img src="'.\URL::to('/').'/theme/artemissalt/images/misc/icon1.png"></span>
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
                                    <span class="service-icon"><img src="'.\URL::to('/').'/theme/artemissalt/images/misc/icon1.png"></span>
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
                                    <span class="service-icon"><img src="'.\URL::to('/').'/theme/artemissalt/images/misc/icon1.png"></span>
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
                                    <span class="service-icon"><img src="'.\URL::to('/').'/theme/artemissalt/images/misc/icon1.png"></span>
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
                                <div class="bg-wrapper" style="background-image:url('.\URL::to('/').'/theme/artemissalt/images/misc/bakery.jpg)"></div>
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
                                        <img src="'.\URL::to('/').'/theme/artemissalt/images/misc/img01.jpg">
                                        <div class="special-icon"><img src="'.\URL::to('/').'/theme/artemissalt/images/misc/icon1.png"></div>
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
                                        <img src="'.\URL::to('/').'/theme/artemissalt/images/misc/img01.jpg">
                                        <div class="special-icon"><img src="'.\URL::to('/').'/theme/artemissalt/images/misc/icon1.png"></div>
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
                                        <img src="'.\URL::to('/').'/theme/artemissalt/images/misc/img01.jpg">
                                        <div class="special-icon"><img src="'.\URL::to('/').'/theme/artemissalt/images/misc/icon1.png"></div>
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
                                            <img src="'.\URL::to('/').'/theme/artemissalt/images/misc/news1.jpg" class="img-fluid" alt="blog">
                                        </figure>
                                    </div>
                                    <div class="item-content">
                                        <span class="published-date">Posted on February 27, 2020</span>
                                        <h3 class="news-title">
                                            <a href="article.htm">Were divided land his creature which have evening subdue</a>
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
                                            <img src="'.\URL::to('/').'/theme/artemissalt/images/misc/news2.jpg" class="img-fluid" alt="blog">
                                        </figure>
                                    </div>
                                    <div class="item-content">
                                        <span class="published-date">Posted on February 27, 2020</span>
                                        <h3 class="news-title">
                                            <a href="article.htm">Were divided land his creature which have evening subdue</a>
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
                                            <img src="'.\URL::to('/').'/theme/artemissalt/images/misc/news3.jpg" class="img-fluid" alt="blog">
                                        </figure>
                                    </div>
                                    <div class="item-content">
                                        <span class="published-date">Posted on February 27, 2020</span>
                                        <h3 class="news-title">
                                            <a href="article.htm">Were divided land his creature which have evening subdue</a>
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
                        <h2 class="heading-decorated">Clients words</h2>
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
        ';

        $aboutHTML = '
            <section id="default-wrapper">
                <div class="container">
                  <div class="row default-row">
                    <div class="col-lg-3">
                      <h3>Quick Links</h3>
                      <div class="gap-20"></div>
                      <div class="side-menu">
                        <ul>
                          <li>
                            <a href="#">Lorem ipsum dolor</a>
                            <ul>
                              <li><a href="#">History</a></li>
                              <li><a href="#">Company Profile</a></li>
                              <li><a href="#">Mission & Vision</a></li>
                              <li><a href="#">Our Team</a></li>
                            </ul>
                          </li>
                          <li><a href="#">Nulla sequi, sint</a></li>
                          <li><a href="#">Corporis, quos, sit</a></li>
                        </ul>
                      </div>
                    </div>
                    <div class="col-lg-9">
                      <div class="article-content">
                        <h3>Company Profile</h3>
                        <p>&nbsp;</p>
                        <p>
                          Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                          eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut
                          enim ad minim veniam, quis nostrud exercitation ullamco laboris
                          nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor
                          in reprehenderit in voluptate velit esse cillum dolore eu fugiat
                          nulla pariatur. Excepteur sint occaecat cupidatat non proident,
                          sunt in culpa qui officia deserunt mollit anim id est laborum.
                        </p>
                        <p>&nbsp;</p>
                        <img src="images/misc/about-img.jpg" alt="" />
                        <p>&nbsp;</p>
                        <p>
                          Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                          eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut
                          enim ad minim veniam, quis nostrud exercitation ullamco laboris
                          nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor
                          in reprehenderit in voluptate velit esse cillum dolore eu fugiat
                          nulla pariatur. Excepteur sint occaecat cupidatat non proident,
                          sunt in culpa qui officia deserunt mollit anim id est laborum.
                        </p>
                        <p>&nbsp;</p>
                        <p>
                          Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                          eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut
                          enim ad minim veniam, quis nostrud exercitation ullamco laboris
                          nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor
                          in reprehenderit in voluptate velit esse cillum dolore eu fugiat
                          nulla pariatur. Excepteur sint occaecat cupidatat non proident,
                          sunt in culpa qui officia deserunt mollit anim id est laborum.
                        </p>
                        <p>&nbsp;</p>
                        <p>
                          Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                          eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut
                          enim ad minim veniam, quis nostrud exercitation ullamco laboris
                          nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor
                          in reprehenderit in voluptate velit esse cillum dolore eu fugiat
                          nulla pariatur. Excepteur sint occaecat cupidatat non proident,
                          sunt in culpa qui officia deserunt mollit anim id est laborum.
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
              </section>
        ';



        $contact_us = '<h3>Contact Details</h3>
              <iframe class="mt-2 mb-4"
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14917.830083111654!2d-73.65783255789836!3d45.465301998048886!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4cc917153ba67f8f%3A0xa508f1e92565d250!2s5544+Avenue+Rosedale%2C+C%C3%B4te+Saint-Luc%2C+QC+H4V+2J1%2C+Canada!5e0!3m2!1sen!2sph!4v1564111296278!5m2!1sen!2sph"
                width="100%" height="300" frameborder="0" style="border:0" allowfullscreen></iframe>
              <div class="row">
                <div class="col-md-6">
                  <p>
                    <strong>Office Location</strong><br />5544 Avenue
                    Rosedale, Cöte Saint-Luc<br />QC H4V 2J1
                  </p>
                  <div class="gap-20"></div>
                </div>
                <div class="col-md-6">
                  <p>
                    <strong>Office Location</strong><br />5544 Avenue
                    Rosedale, Cöte Saint-Luc<br />QC H4V 2J1
                  </p>
                  <div class="gap-20"></div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <p>
                    <strong>Telephone</strong><br />+63 (2) 706-6144<br />+63
                    (2) 706-5796<br />+63 (2) 511-0528
                  </p>
                  <div class="gap-20"></div>
                </div>
                <div class="col-md-6">
                  <p>
                    <strong>Follow Us</strong><br />For more updates, follow
                    us on our social media accounts.
                  </p>
                  <div class="gap-80"></div>
                </div>
              </div>';

        $footerHTML = '<div class="pre-footer">
          <div class="container">
            <div class="row">
              <div class="col-lg-4 col-md-6">
                <div class="footer-info">
                  <h6 class="footer-title">Customer Care</h6>
                  <ul class="quick-link">
                    <li><a href="">Email: support@sysu.com</a></li>
                    <li><a href="">Mobile: +639191234567</a></li>
                    <li><a href="">Tel: +63(02)1234567</a></li>
                    <li><a href="">Fax: +63(02)9876543</a></li>
                  </ul>
                  <div class="gap-20"></div>
                </div>
              </div>

              <div class="col-lg-1 col-md-12">
              </div>
            
              <div class="col-lg-7 col-md-12">
                <div class="footer-info">
                  <a href="/" class="footer-logo">
                    <img src="'.\URL::to('/').'/images/misc/logo-header-white.png" alt="Artemis Salt" />
                  </a>
                  <p>SYSU International Inc.<br>
                  145 Panay Ave. Quezon City 1008, Philippines</p>
                  <div class="gap-20"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="post-footer">
        <div class="container p-0">
          <p>
            Copyright © 2020 <a href="">SYSU International Inc.</a> <span class="white-spc">All rights reserved.</span>
          </p>
        </div>
      </div>';

      
        $pages = [
            [
                'parent_page_id' => 0,
                'album_id' => 1,
                'slug' => 'home',
                'name' => 'Home',
                'label' => 'Home',
                'contents' => $homeHTML,
                'status' => 'PUBLISHED',
                'page_type' => 'default',
                'image_url' => '',
                'meta_title' => 'Home',
                'meta_keyword' => 'home',
                'meta_description' => 'Home page',
                'user_id' => 1,
                'template' => 'home',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'parent_page_id' => 0,
                'album_id' => 0,
                'slug' => 'about-us',
                'name' => 'About Us',
                'label' => 'About Us',
                'contents' => $aboutHTML,
                'status' => 'PUBLISHED',
                'page_type' => 'standard',
                'image_url' => \URL::to('/').'/theme/artemissalt/images/banners/sub/image1.jpg',
                'meta_title' => 'About Us',
                'meta_keyword' => 'About Us',
                'meta_description' => 'About Us page',
                'user_id' => 1,
                'template' => '',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],

            [
                'parent_page_id' => 0,
                'album_id' => 0,
                'slug' => 'contact-us',
                'name' => 'Contact Us',
                'label' => 'Contact Us',
                'contents' => $contact_us,
                'status' => 'PUBLISHED',
                'page_type' => 'standard',
                'image_url' => \URL::to('/').'/theme/artemissalt/images/banners/sub/image1.jpg',
                'meta_title' => 'Contact Us',
                'meta_keyword' => 'Contact Us',
                'meta_description' => 'Contact Us page',
                'user_id' => 1,
                'template' => 'contact-us',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'parent_page_id' => 0,
                'album_id' => 0,
                'slug' => 'news',
                'name' => 'News',
                'label' => 'News',
                'contents' => '',
                'status' => 'PUBLISHED',
                'page_type' => 'customize',
                'image_url' => '',
                'meta_title' => 'News',
                'meta_keyword' => 'news',
                'meta_description' => 'News page',
                'user_id' => 1,
                'template' => 'news',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'parent_page_id' => 0,
                'album_id' => 0,
                'slug' => 'footer',
                'name' => 'Footer',
                'label' => 'footer',
                'contents' => $footerHTML,
                'status' => 'PUBLISHED',
                'page_type' => 'default',
                'image_url' => '',
                'meta_title' => '',
                'meta_keyword' => '',
                'meta_description' => '',
                'user_id' => 1,
                'template' => '',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]
        ];

        DB::table('pages')->insert($pages);
    }
}
