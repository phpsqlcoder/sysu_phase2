@extends('theme.'.env('FRONTEND_TEMPLATE').'.main')

@section('pagecss')
   <link rel="stylesheet" href="{{ asset('theme/sysu/plugins/ion.rangeslider/css/ion.rangeSlider.css') }}">
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
            <div class="col-lg-3">                          
                <div class="desk-cat d-none d-lg-block">
                    <div class="quick-nav">
                        <h3 class="catalog-title">{{ $page->name }}</h3>
                        @include('theme.sysu.layout.sidebar-menu')
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <span onclick="openNav()" class="filter-btn d-block d-lg-none pb-3"><i class="fa fa-list"></i> Options</span>
                <h3 class="catalog-title">{{$page->name}}</h3>
                <div class="table-history" style="overflow-x:auto;">
                    <table class="table table-hover small overflow-auto">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col" class="align-middle">Actions</th>
                                <th scope="col" class="align-middle">Product Name</th>
                                <th scope="col" class="align-middle">Available Stock</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $product)
                                <tr>
                                    <td align="right">
                                        <a href="#" title="Remove Product" onclick="remove_product('{{$product->product_id}}');" class="btn btn-danger btn-sm mb-1"><i class="fa fa-times pb-1"></i></a>&nbsp;

                                        @if($product->product_details->maxpurchase > 0)
                                            @if(\App\EcommerceModel\Cart::on_cart($product->product_id) == 0)
                                            <a href="{{ route('favorite.product-add-to-cart',$product->product_id) }}" title="Add to Cart" class="btn btn-success btn-sm mb-1"><i class="fa fa-shopping-cart pb-1"></i></a>&nbsp;
                                            @endif
                                        @endif

                                        <a href="{{route('product.front.show',$product->product_details->slug)}}" target="_blank" title="View Product Details" class="btn btn-success btn-sm mb-1"><i class="fa fa-eye pb-1"></i></a>
                                    </td>
                                    <td>{{ $product->product_details->name }}</td>
                                    <td>{{ $product->product_details->maxpurchase }}</td>
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
