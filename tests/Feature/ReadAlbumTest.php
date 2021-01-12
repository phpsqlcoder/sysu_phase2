<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ReadAlbumTest extends TestCase
{
    use DatabaseMigrations;

    protected $album;

    public function setUp() : void
    {
        parent::setUp();
        $this->album = factory('App\Album')->create();
    }

    /** @test */
    function a_user_can_see_album_that_are_associated_with_a_banner()
    {        
        $banner = factory('App\Banner')
            ->create(['album_id' => $this->album->id]);             
        $this->get($this->album->path())
            ->assertSee($banner->name);        
    }
    
}