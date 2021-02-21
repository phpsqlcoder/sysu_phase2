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
                                <th scope="col" class="align-middle text-nowrap" width="25%">Coupon</th>
                                <th scope="col" class="align-middle" width="40%">Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($coupons as $coupon)
                                <tr>
                                    <td class="align-middle">
                                        <p><strong>{{ $coupon->details->name }}</strong></p>
                                    </td>
                                    <td class="align-middle"><p>{{ $coupon->details->description }}</p></td>
                                </tr>
                            @empty
                                <td colspan="1">
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
