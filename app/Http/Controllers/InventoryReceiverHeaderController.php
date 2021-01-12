<?php

namespace App\Http\Controllers;

use App\Helpers\ListingHelper;
use App\Helpers\ModelHelper;
use App\InventoryReceiverHeader;
use App\InventoryReceiverDetail;
use App\EcommerceModel\Product;
use App\Permission;
use Illuminate\Http\Request;
use Response;
use Auth;

class InventoryReceiverHeaderController extends Controller
{
    private $searchFields = ['id'];

    public function __construct()
    {
        Permission::module_init($this, 'inventory');
    }

    public function index()
    {
        $listing = new ListingHelper();

        $lists = $listing->simple_search(InventoryReceiverHeader::class, $this->searchFields);

        // Simple search init data
        $filter = $listing->get_filter($this->searchFields);

        $searchType = 'simple_search';

        return view('admin.inventory.index',compact('lists','filter', 'searchType'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(InventoryReceiverHeader $inventoryReceiverHeader)
    {
        //
    }

    public function edit(InventoryReceiverHeader $inventoryReceiverHeader)
    {
        //
    }

    public function update(Request $request, InventoryReceiverHeader $inventoryReceiverHeader)
    {
        //
    }

    public function post($id)
    {
        $update = InventoryReceiverHeader::whereId($id)->update([
                'posted_at' => date('Y-m-d H:i:s'),
                'posted_by' => Auth::id(),
                'status' => 'POSTED'
            ]);
        return back()->with('success','Successfully posted inventory');
    }
    public function cancel($id)
    {
        $update = InventoryReceiverHeader::whereId($id)->update([
                'cancelled_at' => date('Y-m-d H:i:s'),
                'cancelled_by' => Auth::id(),
                'status' => 'CANCELLED'
            ]);
        return back()->with('success','Successfully cancelled inventory');
    }
    public function view($id)
    {
        $data = InventoryReceiverDetail::where('header_id',$id)->get();
        return view('admin.inventory.view',compact('data'));
    }

    public function destroy(InventoryReceiverHeader $inventoryReceiverHeader)
    {
        //
    }

    public function upload_template(Request $request)
    {

        $csv = array();

        if(($handle = fopen($request->csv, 'r')) !== FALSE) {
            // necessary if a large csv file
            set_time_limit(0);

            $row = 0;
            $header = InventoryReceiverHeader::create([
                'user_id' => Auth::id(),
                'status' => 'SAVED'
            ]);

            while(($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                $row++;
                // number of fields in the csv
                $col_count = count($data);
                if($row > 1){
                    if($data[5] <> 0){
                        $insert = InventoryReceiverDetail::create([
                            'product_id' => $data[0],
                            'inventory' => $data[5],
                            'header_id' => $header->id
                        ]);
                    }
                }


            }
            fclose($handle);
        }

        return back()->with('success','Successfully saved new inventory record');

    }

    public function download_template()
    {
        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=inventory.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $products = Product::all();
        $columns = array('DB ID', 'Code', 'Name', 'Current Qty', 'Reorder Qty', 'Add Inventory');

        $callback = function() use ($products, $columns)
        {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach($products as $p) {
                fputcsv($file, array($p->id, $p->code, $p->name, $p->inventory,$p->reorder_point, '0'));
            }
            fclose($file);
        };
        return Response::stream($callback, 200, $headers);
    }
}
