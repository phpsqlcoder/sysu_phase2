@extends('theme.'.env('FRONTEND_TEMPLATE').'.main')

@section('pagecss')
    <link rel="stylesheet" href="{{ asset('theme/sysu/plugins/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/sysu/plugins/datatables/Responsive-2.2.3/css/responsive.dataTables.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
@endsection

@section('content')
<div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
</div>
<span onclick="closeNav()" class="dark-curtain"></span>

<section class="py-5">
    <div class="container">
        <div class="row">
            <div id="col1" class="col-lg-3">  
                <nav class="rd-navbar rd-navbar-listing">
                    <div class="listing-filter-wrap">
                        <div class="rd-navbar-listing-close-toggle rd-navbar-static--hidden toggle-original"><span class="lnr lnr-cross"></span> Close</div>
                        <h3 class="subpage-heading">Options</h3>
                        @include('theme.sysu.layout.sidebar-menu')
                    </div>
                </nav>
            </div>
            <div id="col2" class="col-lg-9">
                <nav class="rd-navbar">
                    <div class="rd-navbar-listing-toggle rd-navbar-static--hidden toggle-original" data-rd-navbar-toggle=".listing-filter-wrap"><span class="lnr lnr-list"></span> Options</div>
                </nav>
                <h3 class="catalog-title">{{$page->name}}</h3>
                <div class="table-history" style="overflow-x:auto;">
                    <table class="table table-hover small overflow-auto">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col" class="align-middle">Product Name</th>
                                <th scope="col" class="align-middle">Available Stock</th>
                                <th scope="col" class="align-middle">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $product)
                                <tr class="@if($product->product_details->maxpurchase > 0) table-warning @endif">
                                    <td>{{ $product->product_details->name }}</td>
                                    <td>
                                        @if($product->product_details->maxpurchase > 0)
                                            <span class="text-success">Available</span>
                                        @else
                                            <span class="text-danger">Out of Stock</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="#" title="Remove Product" onclick="remove_product('{{$product->product_id}}');" class="btn btn-danger btn-sm mb-1" style="width:33.75px;"><i class="fa fa-times pb-1"></i></a>&nbsp;

                                        <a href="{{route('product.front.show',$product->product_details->slug)}}" target="_blank" title="View Product Details" class="btn btn-success btn-sm mb-1"><i class="fa fa-eye pb-1"></i></a>

                                        @if($product->product_details->maxpurchase > 0)
                                            @if(\App\EcommerceModel\Cart::on_cart($product->product_id) == 0)
                                                <a href="{{ route('wishlist.add-to-cart',$product->product_id) }}" title="Add to Cart" class="btn btn-success btn-sm mb-1"><i class="fa fa-shopping-cart pb-1"></i></a>&nbsp;
                                            @else
                                                <a href="javascript:;" title="Already on Cart" class="btn btn-warning btn-sm mb-1"><i class="fa fa-shopping-cart pb-1"></i></a>&nbsp;
                                            @endif
                                        @else
                                            <a href="javascript:;" title="Add to Cart" class="btn btn-secondary btn-sm mb-1"><i class="fa fa-shopping-cart pb-1"></i></a>&nbsp;
                                        @endif

                                    </td>
                                </tr>
                            @empty
                                <td>
                                    <div class="alert alert-warning" role="alert">
                                        No Record found
                                    </div>
                                </td>
                            @endforelse

                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal fade" id="remove_product" tabindex="-1" role="dialog" aria-labelledby="cancel_orderid" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="{{route('wishlist.remove-product')}}" method="post">
                @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="cancel_orderid">Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to remove this product?</p>
                <input type="hidden" id="productid" name="productid">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <input class="btn btn-success" type="submit" value="Continue">
            </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('pagejs')
    <script src="{{ asset('theme/sysu/plugins/datatables/datatables.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    <script>
        $(document).ready(function () {
            @if(Session::has('success'))
                swal({
                    toast: true,
                    position: 'center',
                    title: "{{ session('success', '') }}",
                    type: "success",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    onOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })
            @endif

            @if(Session::has('failed'))
                swal({
                    toast: true,
                    position: 'center',
                    title: "{{ session('failed', '') }}",
                    type: "error",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    onOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })
            @endif
        });
        
        function remove_product(productid){
            $('#productid').val(productid);
            $('#remove_product').modal('show');
        }
    </script>
@endsection
