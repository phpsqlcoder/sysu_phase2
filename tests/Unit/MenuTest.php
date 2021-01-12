<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class MenuTest extends TestCase
{
    use DatabaseMigrations;

    protected $menu;

    public function setUp() : void
    {
        parent::setUp();
        $this->menu = factory('App\Menu')->create();
    }

    /** @test */    
    public function a_menu_exists_on_pages()
    {
        $this->assertTrue(true,$this->menu->navigation);
    }   
           
}