<?php

namespace Tests\Unit;

use App\Permission;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PermissionTest extends TestCase
{
    function permission()
    {
        return new Permission();
    }

    function admin_role_has_access_to_all_page()
    {
        $result = $this->permission()->hasAcces();
    }
}
