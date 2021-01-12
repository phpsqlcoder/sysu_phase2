<?php

namespace App\Http\Controllers\Cms4Controllers;

use App\Http\Controllers\Controller;
use App\Permission;
use Illuminate\Http\Request;

class FileManagerController extends Controller
{
    public function __construct()
    {
        Permission::module_init($this, 'file_manager');
    }

    public function index(Request $request)
    {
        return view('cms4.files.index');
    }
}
