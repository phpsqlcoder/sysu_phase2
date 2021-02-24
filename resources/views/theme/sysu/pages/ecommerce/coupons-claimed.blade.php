@extends('theme.'.env('FRONTEND_TEMPLATE').'.main')

@section('pagecss')
   
@endsection

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row">
            <span onclick="closeNav()" class="dark-curtain"></span> 
            <span onclick="openNav()" class="mb-4 btn btn-primary btn-bg open-nav rounded-0 d-block d-lg-none"><i class="fa fa-1x fa-th-list"></i></span>

            <div class="col-lg-3">                          
                <div class="desk-cat d-none d-lg-block">
                    <div class="quick-nav">
                        <h3 class="catalog-title">My Account</h3>
                        @include('theme.sysu.layout.sidebar-menu')
                    </div>
                </div>
            </div>

            <div class="col-lg-9">
                <h3 class="catalog-title">{{ $page->name }}</h3>
                <div class="table-history" style="overflow-x:auto;">
                    <table class="table table-hover small text-left overflow-auto">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col" class="align-middle text-nowrap" width="20%">Name</th>
                                <th scope="col" class="align-middle" width="25%">Description</th>
                                <th scope="col" class="align-middle" width="15%">T&C</th>
                                <th scope="col" class="align-middle" width="10%">Validity</th>
                                <th scope="col" class="align-middle" width="15%">Date Claimed</th>
                                <th scope="col" class="align-middle" width="15%">Order #</th>
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
    
@endsection