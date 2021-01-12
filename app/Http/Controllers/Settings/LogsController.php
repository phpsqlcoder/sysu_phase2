<?php

namespace App\Http\Controllers\Settings;
use App\Http\Controllers\Controller;
use App\Permission;
use Illuminate\Http\Request;
use App\Helpers\ListingHelper;

use Illuminate\Support\Facades\Input;
use App\Logs;

class LogsController extends Controller
{
    private $searchFields = ['db_table', 'firstname', 'lastname', 'activity_date','id'];

    public function __construct()
    {
        Permission::module_init($this, 'audit_logs');
    }

    public function index(Request $request)
    {
        $listing = new ListingHelper('desc',10,'activity_date');

        $logs = $listing->simple_search(Logs::class, $this->searchFields);

        $filter = $listing->get_filter($this->searchFields);

        $searchType = 'simple_search';

        return view('admin.settings.audit.index', compact('logs', 'filter', 'searchType'));
    }
}
