@extends('admin.layouts.report')

@section('pagetitle')

@endsection

@section('pagecss')
    <!-- vendor css -->
    <link href="{{ asset('lib/@fortawesome/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/ionicons/css/ionicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/jqvmap/jqvmap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/bselect/dist/css/bootstrap-select.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/ion-rangeslider/css/ion.rangeSlider.min.css') }}" rel="stylesheet">

    <style>
        .row-selected {
            background-color: #92b7da !important;
        }
    </style>
@endsection

@section('content')

  
                    
               
<div style="margin:0px 40px 200px 40px;font-family:Arial;">
         <h4 class="mg-b-0 tx-spacing--1">Sales Report</h4>
                    <form action="{{route('report.coupon.list')}}" method="get">
                        <input type="hidden" name="act" value="go">
                        @csrf
                        <table style="font-size:12px;">
                            <tr>
                                <td>Coupon Code</td>
                                <td>Order Start date</td>
                                <td>Order End Date</td>
                                <td>Category</td>
                                <td>Brand</td>
                                <td>Product</td>
                                <td>Customer</td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td>
                                    <input style="font-size:12px;width: 140px;" type="text" class="form-control input-sm" name="coupon_code" autocomplete="off"
                                    @if(isset($_GET['coupon_code'])) value="{{$_GET['coupon_code']}}" @endif >
                                </td>
                                <td><input style="font-size:12px;width: 140px;" type="date" class="form-control input-sm" name="start" autocomplete="off"
                                    @if(isset($_GET['start'])) value="{{$_GET['start']}}" @endif >
                                </td>
                                <td><input style="font-size:12px;width: 140px;" type="date" class="form-control input-sm" name="end" autocomplete="off"
                                    @if(isset($_GET['end'])) value="{{$_GET['end']}}" @endif >
                                </td>
                                <td>
                                    <select style="font-size:12px;width: 140px;" name="category" id="category" class="form-control input-sm">
                                        <option value="">Select</option>
                                        @php
                                            $categories = \App\EcommerceModel\ProductCategory::orderBy('name')->get();
                                        @endphp
                                        @forelse($categories as $c)
                                            <option value="{{$c->id}}" 
                                                @if(isset($_GET['category']) and $_GET['category']==$c->id) selected="selected" @endif 
                                            >
                                                {{$c->name}}
                                            </option>
                                        @empty
                                        @endforelse
                                    </select>
                                </td>
                                <td>
                                    <select style="font-size:12px;width: 140px;" name="brand" id="brand" class="form-control input-sm">
                                        <option value="">Select</option>
                                        @php
                                            $brands = \App\EcommerceModel\Product::distinct()->select('brand')->orderBy('brand')->get();
                                        @endphp
                                        @forelse($brands as $b)
                                            <option value="{{$b->brand}}"
                                                @if(isset($_GET['brand']) and $_GET['brand']==$b->brand) selected="selected" @endif 
                                            >
                                                {{$b->brand}}
                                            </option>
                                        @empty
                                        @endforelse
                                    </select>
                                </td>
                                <td>
                                    <select style="font-size:12px;width: 140px;" name="product" id="product" class="form-control input-sm">
                                        <option value="">Select</option>
                                        @php
                                            $products = \App\EcommerceModel\Product::orderBy('name')->get();
                                        @endphp
                                        @forelse($products as $p)
                                            <option value="{{$p->id}}"
                                                @if(isset($_GET['product']) and $_GET['product']==$p->id) selected="selected" @endif 
                                            >
                                                {{$p->name}}
                                            </option>
                                        @empty
                                        @endforelse
                                    </select>
                                </td>
                                <td>
                                    <select style="font-size:12px;width: 140px;" name="customer" id="customer" class="form-control input-sm">
                                        <option value="">Select</option>
                                        @php
                                            $customers = \App\User::where('role_id','6')->orderBy('name')->get();
                                        @endphp
                                        @forelse($customers as $cu)
                                            <option value="{{$cu->id}}"
                                                @if(isset($_GET['customer']) and $_GET['customer']==$cu->id) selected="selected" @endif 
                                            >
                                                {{$cu->name}}
                                            </option>
                                        @empty
                                        @endforelse
                                    </select>
                                </td>
                                <td><button type="submit" class="btn btn-primary" style="margin:0px 0px 0px 20px;">Generate</button></td>
                                <td><a href="{{ route('report.sales.list') }}" class="btn btn-success" style="margin:0px 0px 0px 20px;">Reset</a></td>
                            </tr>
                        </table>
                    </form>
            
            @if($rs <>'')
              
                        <br><br>
                        <table id="example" class="display nowrap" style="width:100%;font: normal 13px/150% Arial, sans-serif, Helvetica;">
                            <thead>
                            <tr>
                                <th align="left">Code</th>
                                <th align="left">Name</th>
                                <th align="left">Order #</th>
                                <th align="left">Customer</th>
                                <th align="left">Total Amount</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($rs as $r)
                                <tr>
                                    <td>{{$r->coupon_code}}</td>
                                    <td>{{$r->name}}</td>
                                    <th>{{$r->order_number}}</th>
                                    <td>{{$r->customer_name}}</td>
                                    <td>{{number_format($r->net_amount,2)}}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">No report result.</td>
                                </tr>
                            @endforelse

                            </tbody>

                        </table>
                   
            @endif

        </div>
    

@endsection

@section('pagejs')
    <script src="{{ asset('lib/bselect/dist/js/bootstrap-select.js') }}"></script>
    <script src="{{ asset('lib/bselect/dist/js/i18n/defaults-en_US.js') }}"></script>
    <script src="{{ asset('lib/prismjs/prism.js') }}"></script>
    <script src="{{ asset('lib/jqueryui/jquery-ui.min.js') }}"></script>

@endsection

@section('customjs')
<script src="{{ asset('js/datatables/Buttons-1.6.1/js/buttons.colVis.min.js') }}"></script>
<script>
  

    $(document).ready(function() {
        $('#example').DataTable( {
            dom: 'Bfrtip',
            pageLength: 20,
            order: [[0,'desc']],
            buttons: [
                {
                    extend: 'print',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'copy',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'excel',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                 // {
                //     extend: 'pdf',
                //     exportOptions: {
                //         columns: ':visible'
                //     }
                // },
                {   
                    extend: 'pdfHtml5',
                    text: 'PDF',
                    exportOptions: {
                        modifier: {
                            page: 'current'
                        }
                    },
                    orientation : 'landscape',
                    pageSize : 'LEGAL'
                },
                'colvis'
            ],
            columnDefs: [ {
                targets: [6,10,11,12,13,14,15,16,17,18,19],
                visible: false
            } ]
        } );
    } );
</script>
@endsection



