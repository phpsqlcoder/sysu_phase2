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
                    <table id="tabless" class="table table-hover small text-center overflow-auto">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col" class="align-middle text-nowrap">Name</th>
                                <th scope="col" class="align-middle">Description</th>
                                <th scope="col" class="align-middle">T&C</th>
                                <th scope="col" class="align-middle">Validity</th>
                                <th scope="col" class="align-middle">Date Claimed</th>
                                <th scope="col" class="align-middle">Order #</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($coupons as $coupon)
                                <tr>
                                    <td class="align-middle">
                                        <p><strong>{{ $coupon->details->name }}</strong></p>
                                        @if($coupon->details->acitivation_type == 'manual')
                                            {{ $coupon->details->coupon_code }}
                                        @endif
                                    </td>
                                    <td class="align-middle"><p>{{ $coupon->details->description }}</p></td>
                                    <td class="align-middle"><a href="#" data-toggle="modal" data-target="#terms{{$coupon->id}}">View Details</a></td>
                                    <td></td>
                                    <td>{{ \Carbon\Carbon::parse($coupon->created_at)->format('Y-m-d h:i A') }}</td>
                                    <td>{{ $coupon->sales_details->order_number }}</td>
                                </tr>

                                <!-- Modal -->
                                <div class="modal fade" id="terms{{$coupon->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">Terms and Conditions</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>{{ $coupon->details->terms_and_conditions }}</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <td colspan="2">
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
@endsection

@section('pagejs')
    <script src="{{ asset('theme/sysu/plugins/datatables/datatables.min.js') }}"></script>
@endsection
