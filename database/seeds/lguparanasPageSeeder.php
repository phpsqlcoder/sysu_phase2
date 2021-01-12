<?php

use Illuminate\Database\Seeder;

class lguparanasPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $homeHTML = '<section class="welcome-wrapper wrapper">
              <div id="particles-js"></div>
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="welcome-intro">
                                <h2 class="ttle-main">About Paranas</h2>
                                <p>Welcome to the About Us section of our agency website. This is where we’d usually tell you we care more about results then awards. Here agencies also usually brag about their unique station at the intersection of specialized expertise and a generalist approach and give themselves a ‘thumbs up’ for having a perfect blend of big agency resources and small agency nimbleness.</p>
                                <div class="gap-70"></div>
                                <div class="welcome-video">
                                    <iframe width="100%" src="https://www.youtube.com/embed/ArcyvGg58bk" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            
            <div class="gallery-wrapper wrapper">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <h2 class="ttle-main">Gallery</h2>
                            <p>If you work in the advertising industry, staying up-to-date is a crucial job requirement!</p>
                            <div class="gap-70"></div>
                        </div>
                        
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="card gallery-item gallery-home">
                              <a href="'.\URL::to('/').'/theme/lguparanas/images/misc/news5.jpg" data-toggle="lightbox" data-gallery="example-gallery" data-max-width="700"><img src="'.\URL::to('/').'/theme/lguparanas/images/misc/gallery.jpg" class="card-img-top"></a>
                              <div class="card-body">
                                <h5 class="card-title"><strong>Content Marketing</strong></h5>
                              </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="card gallery-item gallery-home">
                              <a href="'.\URL::to('/').'/theme/lguparanas/images/misc/gallery-prev.jpg" data-toggle="lightbox" data-gallery="example-gallery" data-max-width="700"><img src="'.\URL::to('/').'/theme/lguparanas/images/misc/gallery.jpg" class="card-img-top"></a>
                              <div class="card-body">
                                <h5 class="card-title"><strong>Content Marketing</strong></h5>
                              </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="card gallery-item gallery-home">
                              <a href="'.\URL::to('/').'/theme/lguparanas/images/misc/gallery-prev.jpg" data-toggle="lightbox" data-gallery="example-gallery" data-max-width="700"><img src="'.\URL::to('/').'/theme/lguparanas/images/misc/gallery.jpg" class="card-img-top"></a>
                              <div class="card-body">
                                <h5 class="card-title"><strong>Content Marketing</strong></h5>
                              </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="card gallery-item gallery-home">
                              <a href="'.\URL::to('/').'/theme/lguparanas/images/misc/gallery-prev.jpg" data-toggle="lightbox" data-gallery="example-gallery" data-max-width="700"><img src="'.\URL::to('/').'/theme/lguparanas/images/misc/gallery.jpg" class="card-img-top"></a>
                              <div class="card-body">
                                <h5 class="card-title"><strong>Content Marketing</strong></h5>
                              </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="card gallery-item gallery-home">
                              <a href="'.\URL::to('/').'/theme/lguparanas/images/misc/gallery-prev.jpg" data-toggle="lightbox" data-gallery="example-gallery" data-max-width="700"><img src="'.\URL::to('/').'/theme/lguparanas/images/misc/gallery.jpg" class="card-img-top"></a>
                              <div class="card-body">
                                <h5 class="card-title"><strong>Content Marketing</strong></h5>
                              </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="card gallery-item gallery-home">
                              <a href="'.\URL::to('/').'/theme/lguparanas/images/misc/gallery-prev.jpg" data-toggle="lightbox" data-gallery="example-gallery" data-max-width="700"><img src="'.\URL::to('/').'/theme/lguparanas/images/misc/gallery.jpg" class="card-img-top"></a>
                              <div class="card-body">
                                <h5 class="card-title"><strong>Content Marketing</strong></h5>
                              </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="card gallery-item gallery-home">
                              <a href="'.\URL::to('/').'/theme/lguparanas/images/misc/gallery-prev.jpg" data-toggle="lightbox" data-gallery="example-gallery" data-max-width="700"><img src="'.\URL::to('/').'/theme/lguparanas/images/misc/gallery.jpg" class="card-img-top"></a>
                              <div class="card-body">
                                <h5 class="card-title"><strong>Content Marketing</strong></h5>
                              </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="card gallery-item gallery-home">
                              <a href="'.\URL::to('/').'/theme/lguparanas/images/misc/gallery-prev.jpg" data-toggle="lightbox" data-gallery="example-gallery"><img src="'.\URL::to('/').'/theme/lguparanas/images/misc/gallery.jpg" class="card-img-top"></a>
                              <div class="card-body">
                                <h5 class="card-title"><strong>Content Marketing</strong></h5>
                              </div>
                            </div>
                        </div>				
                        
                        <div class="col-md-12">
                            <ul class="gallery-options">
                                <div class="gap-40"></div>
                                <li><a href="#" class="btn btn-primary btn-lg btn-main">photos</a></li>
                                <li><a href="#" class="btn btn-primary btn-lg btn-main">videos</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            <section class="tourism-wrapper wrapper">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h2 class="ttle-main">Tourism</h2>
                            <p>If you work in the advertising industry, staying up-to-date is a crucial job requirement!</p>
                            <div class="gap-70"></div>
                        </div>
                        
                        <div class="col-lg-4 col-md-6">
                            <div class="tourism-item">
                                <div class="tourism-icon"><i class="fa fa-map-marker-alt fa-4x"></i></div>
                                <div class="tourism-details">
                                    <div class="tourism-title"><h4><strong>Content Marketing</strong></h4></div>
                                    <div class="tourism-info"><p>When it comes to digital marketing, one cannot underestimate the importance of the content. This is why we have a team of professional...</p></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="tourism-item">
                                <div class="tourism-icon"><i class="fa fa-map-marker-alt fa-4x"></i></div>
                                <div class="tourism-details">
                                    <div class="tourism-title"><h4><strong>Content Marketing</strong></h4></div>
                                    <div class="tourism-info"><p>When it comes to digital marketing, one cannot underestimate the importance of the content. This is why we have a team of professional...</p></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="tourism-item">
                                <div class="tourism-icon"><i class="fa fa-map-marker-alt fa-4x"></i></div>
                                <div class="tourism-details">
                                    <div class="tourism-title"><h4><strong>Content Marketing</strong></h4></div>
                                    <div class="tourism-info"><p>When it comes to digital marketing, one cannot underestimate the importance of the content. This is why we have a team of professional...</p></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="tourism-item">
                                <div class="tourism-icon"><i class="fa fa-map-marker-alt fa-4x"></i></div>
                                <div class="tourism-details">
                                    <div class="tourism-title"><h4><strong>Content Marketing</strong></h4></div>
                                    <div class="tourism-info"><p>When it comes to digital marketing, one cannot underestimate the importance of the content. This is why we have a team of professional...</p></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="tourism-item">
                                <div class="tourism-icon"><i class="fa fa-map-marker-alt fa-4x"></i></div>
                                <div class="tourism-details">
                                    <div class="tourism-title"><h4><strong>Content Marketing</strong></h4></div>
                                    <div class="tourism-info"><p>When it comes to digital marketing, one cannot underestimate the importance of the content. This is why we have a team of professional...</p></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="tourism-item">
                                <div class="tourism-icon"><i class="fa fa-map-marker-alt fa-4x"></i></div>
                                <div class="tourism-details">
                                    <div class="tourism-title"><h4><strong>Content Marketing</strong></h4></div>
                                    <div class="tourism-info"><p>When it comes to digital marketing, one cannot underestimate the importance of the content. This is why we have a team of professional...</p></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            
            <section class="local-officials-wrapper wrapper">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h2 class="ttle-main">The Local Officials</h2>
                            <p>If you work in the advertising industry, staying up-to-date is a crucial job requirement!</p>
                            <div class="gap-70"></div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="card text-center local-official-item">
                              <img src="'.\URL::to('/').'/theme/lguparanas/images/misc/people.jpg" class="card-img-top">
                              <div class="card-body local-official-details">
                                <h4 class="card-title"><strong>Ruben Burns</strong></h4>
                                <div class="local-officials-position">project manager</div>
                                <p class="card-text">Originally from London, at one point of his sophomore college year, Ruben decided to turn the tables for his career and travel to the US,</p>
                              </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="card text-center local-official-item">
                              <img src="'.\URL::to('/').'/theme/lguparanas/images/misc/people.jpg" class="card-img-top">
                              <div class="card-body local-official-details">
                                <h4 class="card-title"><strong>Ruben Burns</strong></h4>
                                <div class="local-officials-position">project manager</div>
                                <p class="card-text">Originally from London, at one point of his sophomore college year, Ruben decided to turn the tables for his career and travel to the US,</p>
                              </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="card text-center local-official-item">
                              <img src="'.\URL::to('/').'/theme/lguparanas/images/misc/people.jpg" class="card-img-top">
                              <div class="card-body local-official-details">
                                <h4 class="card-title"><strong>Ruben Burns</strong></h4>
                                <div class="local-officials-position">project manager</div>
                                <p class="card-text">Originally from London, at one point of his sophomore college year, Ruben decided to turn the tables for his career and travel to the US,</p>
                              </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="card text-center local-official-item">
                              <img src="'.\URL::to('/').'/theme/lguparanas/images/misc/people.jpg" class="card-img-top">
                              <div class="card-body local-official-details">
                                <h4 class="card-title"><strong>Ruben Burns</strong></h4>
                                <div class="local-officials-position">project manager</div>
                                <p class="card-text">Originally from London, at one point of his sophomore college year, Ruben decided to turn the tables for his career and travel to the US,</p>
                              </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="card text-center local-official-item">
                              <img src="'.\URL::to('/').'/theme/lguparanas/images/misc/people.jpg" class="card-img-top">
                              <div class="card-body local-official-details">
                                <h4 class="card-title"><strong>Ruben Burns</strong></h4>
                                <div class="local-officials-position">project manager</div>
                                <p class="card-text">Originally from London, at one point of his sophomore college year, Ruben decided to turn the tables for his career and travel to the US,</p>
                              </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="card text-center local-official-item">
                              <img src="'.\URL::to('/').'/theme/lguparanas/images/misc/people.jpg" class="card-img-top">
                              <div class="card-body local-official-details">
                                <h4 class="card-title"><strong>Ruben Burns</strong></h4>
                                <div class="local-officials-position">project manager</div>
                                <p class="card-text">Originally from London, at one point of his sophomore college year, Ruben decided to turn the tables for his career and travel to the US,</p>
                              </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>';

        $aboutHTML = '<h2 class="ttle-secondary">Official Seal</h2>
                    <p>We are a US leading global communications marketing firm, enhanced by more than a hundred of talented employees. They are connecting, informing and creating inspiring work. We re-evaluate brands to broaden awareness, improve their global positioning and reconnect them with end-customers.Led by few seasoned advertising industry pros, our agency delivers innovative solutions across all the mediums available nowadays. We offer services related to advertising media, marketing, partnerships, interactive, creative, content, insights, and campaign management, with a time and efficiency proven record.</p>
                    <p>Over all those years, we’ve designed and implemented some of the most iconic and now industry-standard digital business solutions and interactive advertising campaigns in the world. We’re humbled to say this experience has made you stronger and earned us a unique perspective for the work we do today.</p>';


        $contact_us = '<iframe class="mt-2 mb-4" width="100%" height="500" frameborder="0" style="border:0" allowfullscreen src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4382.958302278679!2d125.11588054899259!3d11.85122404012657!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3309aeaf71b709e7%3A0x9fef93737c976069!2sMunicipality%20of%20Paranas!5e0!3m2!1sen!2sph!4v1582808067393!5m2!1sen!2sph">
                    </iframe>';

        $footerHTML = '<div class="container">
			<div class="row">
				<div class="col-md-4">
					<div class="footer-item">
						<div class="footer-item-icon"><i class="fa fa-map-marker-alt fa-4x"></i></div>
						<div class="footer-item-title"><h6 class="ttle-secondary">Address</h6></div>
						<div class="footer-item-detials">
							<p>Rosales St. Poblacion 4 Paranas, Samar</p>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="footer-item">
						<div class="footer-item-icon"><i class="fa fa-mobile-alt fa-4x"></i></div>
						<div class="footer-item-title"><h6 class="ttle-secondary">Phones</h6></div>
						<div class="footer-item-detials">
							<p>Globe: +63917 5812 963</p>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="footer-item">
						<div class="footer-item-icon"><i class="fa fa-paper-plane fa-4x"></i></div>
						<div class="footer-item-title"><h6 class="ttle-secondary">Contacts</h6></div>
						<div class="footer-item-detials">
							<p><a href="mailto:lguparanas@gmail.com">LGUparanas@gmail.com</a>
							<br><a href="mailto:lguparanas@yahoo.com">LGUparanas@yahoo.com</a></p>
						</div>
					</div>
				</div>
			</div>
		</div>';

        $galleryHTML = '<section class="gallery-wrapper wrapper sub-gallery">
                <div class="container">
                    <div class="row">				
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="card gallery-item">
                              <img src="'.\URL::to('/').'/theme/lguparanas/images/misc/gallery.jpg" class="card-img-top"></a>
                              <div class="card-body">
                                <h5 class="card-title"><strong>Content Marketing</strong></h5>
                              </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="card gallery-item">
                              <img src="'.\URL::to('/').'/theme/lguparanas/images/misc/gallery.jpg" class="card-img-top"></a>
                              <div class="card-body">
                                <h5 class="card-title"><strong>Content Marketing</strong></h5>
                              </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="card gallery-item">
                              <img src="'.\URL::to('/').'/theme/lguparanas/images/misc/gallery.jpg" class="card-img-top"></a>
                              <div class="card-body">
                                <h5 class="card-title"><strong>Content Marketing</strong></h5>
                              </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="card gallery-item">
                              <img src="'.\URL::to('/').'/theme/lguparanas/images/misc/gallery.jpg" class="card-img-top"></a>
                              <div class="card-body">
                                <h5 class="card-title"><strong>Content Marketing</strong></h5>
                              </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="card gallery-item">
                              <img src="'.\URL::to('/').'/theme/lguparanas/images/misc/gallery.jpg" class="card-img-top"></a>
                              <div class="card-body">
                                <h5 class="card-title"><strong>Content Marketing</strong></h5>
                              </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="card gallery-item">
                              <img src="'.\URL::to('/').'/theme/lguparanas/images/misc/gallery.jpg" class="card-img-top"></a>
                              <div class="card-body">
                                <h5 class="card-title"><strong>Content Marketing</strong></h5>
                              </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="card gallery-item">
                              <img src="'.\URL::to('/').'/theme/lguparanas/images/misc/gallery.jpg" class="card-img-top"></a>
                              <div class="card-body">
                                <h5 class="card-title"><strong>Content Marketing</strong></h5>
                              </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="card gallery-item">
                              <img src="'.\URL::to('/').'/theme/lguparanas/images/misc/gallery.jpg" class="card-img-top"></a>
                              <div class="card-body">
                                <h5 class="card-title"><strong>Content Marketing</strong></h5>
                              </div>
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <ul class="gallery-options">
                                <div class="gap-40"></div>
                                <li><a href="'.\URL::to('/').'/videos" class="btn btn-primary btn-lg btn-main">videos</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>';

        $newsListingContent = '';
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
                'slug' => 'about-paranas',
                'name' => 'About Paranas',
                'label' => 'About Paranas',
                'contents' => $aboutHTML,
                'status' => 'PUBLISHED',
                'page_type' => 'standard',
                'image_url' => \URL::to('/').'/theme/lguparanas/images/banners/sub-banner-bg.jpg',
                'meta_title' => '',
                'meta_keyword' => '',
                'meta_description' => '',
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
                'image_url' => \URL::to('/').'/theme/lguparanas/images/banners/sub-banner-bg.jpg',
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
                'image_url' => \URL::to('/').'/theme/lguparanas/images/banners/sub-banner-bg.jpg',
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
                'created_at' => '2019-10-06 20:31:26',
                'updated_at' => '2019-10-06 20:31:26'
            ],
            [
                'parent_page_id' => 0,
                'album_id' => 0,
                'slug' => 'gallery',
                'name' => 'Gallery',
                'label' => 'Gallery',
                'contents' => $galleryHTML,
                'status' => 'PUBLISHED',
                'page_type' => 'standard',
                'image_url' => \URL::to('/').'/theme/lguparanas/images/banners/sub-banner-bg.jpg',
                'meta_title' => '',
                'meta_keyword' => '',
                'meta_description' => '',
                'user_id' => 1,
                'template' => '',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'parent_page_id' => 6,
                'album_id' => 0,
                'slug' => 'videos',
                'name' => 'Videos',
                'label' => 'Videos',
                'contents' => $galleryHTML,
                'status' => 'PUBLISHED',
                'page_type' => 'standard',
                'image_url' => \URL::to('/').'/theme/lguparanas/images/banners/sub-banner-bg.jpg',
                'meta_title' => '',
                'meta_keyword' => '',
                'meta_description' => '',
                'user_id' => 1,
                'template' => '',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [

                'parent_page_id' => 6,
                'album_id' => 0,
                'slug' => 'photos',
                'name' => 'Photos',
                'label' => 'Photos',
                'contents' => $galleryHTML,
                'status' => 'PUBLISHED',
                'page_type' => 'standard',
                'image_url' => \URL::to('/').'/theme/lguparanas/images/banners/sub-banner-bg.jpg',
                'meta_title' => '',
                'meta_keyword' => '',
                'meta_description' => '',
                'user_id' => 1,
                'template' => '',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [

                'parent_page_id' => 0,
                'album_id' => 0,
                'slug' => 'tourism',
                'name' => 'Tourism',
                'label' => 'Tourism',
                'contents' => $galleryHTML,
                'status' => 'PUBLISHED',
                'page_type' => 'standard',
                'image_url' => \URL::to('/').'/theme/lguparanas/images/banners/sub-banner-bg.jpg',
                'meta_title' => '',
                'meta_keyword' => '',
                'meta_description' => '',
                'user_id' => 1,
                'template' => '',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [

                'parent_page_id' => 0,
                'album_id' => 0,
                'slug' => 'programs',
                'name' => 'Programs',
                'label' => 'programs',
                'contents' => $galleryHTML,
                'status' => 'PUBLISHED',
                'page_type' => 'standard',
                'image_url' => \URL::to('/').'/theme/lguparanas/images/banners/sub-banner-bg.jpg',
                'meta_title' => '',
                'meta_keyword' => '',
                'meta_description' => '',
                'user_id' => 1,
                'template' => '',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [

                'parent_page_id' => 10,
                'album_id' => 0,
                'slug' => 'current-and-on-going-programs',
                'name' => 'Current and On-going programs',
                'label' => 'Current and On-going programs',
                'contents' => $galleryHTML,
                'status' => 'PUBLISHED',
                'page_type' => 'standard',
                'image_url' => \URL::to('/').'/theme/lguparanas/images/banners/sub-banner-bg.jpg',
                'meta_title' => '',
                'meta_keyword' => '',
                'meta_description' => '',
                'user_id' => 1,
                'template' => '',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [

                'parent_page_id' => 11,
                'album_id' => 0,
                'slug' => 'scholarship',
                'name' => 'Scholarship',
                'label' => 'Scholarship',
                'contents' => $galleryHTML,
                'status' => 'PUBLISHED',
                'page_type' => 'standard',
                'image_url' => \URL::to('/').'/theme/lguparanas/images/banners/sub-banner-bg.jpg',
                'meta_title' => '',
                'meta_keyword' => '',
                'meta_description' => '',
                'user_id' => 1,
                'template' => '',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [

                'parent_page_id' => 11,
                'album_id' => 0,
                'slug' => 'clean-and-green',
                'name' => 'Clear and Green',
                'label' => 'Clear and Green',
                'contents' => $galleryHTML,
                'status' => 'PUBLISHED',
                'page_type' => 'standard',
                'image_url' => \URL::to('/').'/theme/lguparanas/images/banners/sub-banner-bg.jpg',
                'meta_title' => '',
                'meta_keyword' => '',
                'meta_description' => '',
                'user_id' => 1,
                'template' => '',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [

                'parent_page_id' => 10,
                'album_id' => 0,
                'slug' => 'services',
                'name' => 'Services',
                'label' => 'Services',
                'contents' => $galleryHTML,
                'status' => 'PUBLISHED',
                'page_type' => 'standard',
                'image_url' => \URL::to('/').'/theme/lguparanas/images/banners/sub-banner-bg.jpg',
                'meta_title' => '',
                'meta_keyword' => '',
                'meta_description' => '',
                'user_id' => 1,
                'template' => '',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [

                'parent_page_id' => 14,
                'album_id' => 0,
                'slug' => 'civil-registry',
                'name' => 'Civil Registry',
                'label' => 'Civil Registry',
                'contents' => $galleryHTML,
                'status' => 'PUBLISHED',
                'page_type' => 'standard',
                'image_url' => \URL::to('/').'/theme/lguparanas/images/banners/sub-banner-bg.jpg',
                'meta_title' => '',
                'meta_keyword' => '',
                'meta_description' => '',
                'user_id' => 1,
                'template' => '',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [

                'parent_page_id' => 14,
                'album_id' => 0,
                'slug' => 'business-investment',
                'name' => 'Business Investment',
                'label' => 'Business Investment',
                'contents' => $galleryHTML,
                'status' => 'PUBLISHED',
                'page_type' => 'standard',
                'image_url' => \URL::to('/').'/theme/lguparanas/images/banners/sub-banner-bg.jpg',
                'meta_title' => '',
                'meta_keyword' => '',
                'meta_description' => '',
                'user_id' => 1,
                'template' => '',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [

                'parent_page_id' => 14,
                'album_id' => 0,
                'slug' => 'social-service',
                'name' => 'Social Service',
                'label' => 'Social Service',
                'contents' => $galleryHTML,
                'status' => 'PUBLISHED',
                'page_type' => 'standard',
                'image_url' => \URL::to('/').'/theme/lguparanas/images/banners/sub-banner-bg.jpg',
                'meta_title' => '',
                'meta_keyword' => '',
                'meta_description' => '',
                'user_id' => 1,
                'template' => '',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [

                'parent_page_id' => 2,
                'album_id' => 0,
                'slug' => 'official-seal',
                'name' => 'Official Seal',
                'label' => 'Official Seal',
                'contents' => $galleryHTML,
                'status' => 'PUBLISHED',
                'page_type' => 'standard',
                'image_url' => \URL::to('/').'/theme/lguparanas/images/banners/sub-banner-bg.jpg',
                'meta_title' => '',
                'meta_keyword' => '',
                'meta_description' => '',
                'user_id' => 1,
                'template' => '',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [

                'parent_page_id' => 2,
                'album_id' => 0,
                'slug' => 'the-vision-and-mission',
                'name' => 'The Vision and Mission',
                'label' => 'The Vision and Mission',
                'contents' => $galleryHTML,
                'status' => 'PUBLISHED',
                'page_type' => 'standard',
                'image_url' => \URL::to('/').'/theme/lguparanas/images/banners/sub-banner-bg.jpg',
                'meta_title' => '',
                'meta_keyword' => '',
                'meta_description' => '',
                'user_id' => 1,
                'template' => '',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [

                'parent_page_id' => 2,
                'album_id' => 0,
                'slug' => 'history-of-paranas',
                'name' => 'History of Paranas',
                'label' => 'History of Paranas',
                'contents' => $galleryHTML,
                'status' => 'PUBLISHED',
                'page_type' => 'standard',
                'image_url' => \URL::to('/').'/theme/lguparanas/images/banners/sub-banner-bg.jpg',
                'meta_title' => '',
                'meta_keyword' => '',
                'meta_description' => '',
                'user_id' => 1,
                'template' => '',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [

                'parent_page_id' => 2,
                'album_id' => 0,
                'slug' => 'the-local-officials',
                'name' => 'The Local Officials',
                'label' => 'The Local Officials',
                'contents' => $galleryHTML,
                'status' => 'PUBLISHED',
                'page_type' => 'standard',
                'image_url' => \URL::to('/').'/theme/lguparanas/images/banners/sub-banner-bg.jpg',
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
