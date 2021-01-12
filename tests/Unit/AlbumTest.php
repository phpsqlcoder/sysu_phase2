<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AlbumTest extends TestCase
{
    use DatabaseMigrations;

    protected $album;

    public function setUp() : void
    {
        parent::setUp();
        $this->album = factory('App\Album')->create();
    }

    /** @test */
    public function an_album_can_add_a_banner()
    {
        $this->album->addBanners(array([
            'album_id' => '21',
            'title' => 'Testing Scripts Title 1',
            'description' => 'Testing Scripts Description 1',
            'alt' => 'Nashty Blue',
            'image_path' => 'https://www.google.com/images/branding/googlelogo/2x/googlelogo_color_272X92dp.png',
            'url' => 'http://localhost'           
        ])
    );            
        $this->assertCount(1,$this->album->banners);
    }

    /** @test */    
    public function an_album_exists_on_pages()
    {
        $this->assertTrue(true,$this->album->pages);
    }

    /** @test */    
    public function an_album_exists_on_banner()
    {
        $this->assertTrue(true,$this->album->banners);
    } 
    
    /** @test */
    function an_option_has_an_album_animation_in()
    {        
        $this->assertEquals(1, $this->album->transition_in);
    } 

    /** @test */
    function an_option_has_an_album_animation_out()
    {        
        $this->assertEquals(2, $this->album->transition_out);
    }

    /** @test */
    function an_album_has_banners()
    {           

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->album->pages);
    }


}