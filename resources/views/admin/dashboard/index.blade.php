@extends('admin.layouts.app')

@section('pagetitle')
    Dashboard
@endsection

@section('content')
    <div class="container pd-x-0">
        <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    </ol>
                </nav>
                <h4 class="mg-b-0 tx-spacing--1">Welcome, {{ Auth::user()->firstname }}!</h4>
            </div>
            <div class="d-none d-md-block">
                <a href="{{ env('APP_URL') }}" class="btn btn-sm pd-x-15 btn-white btn-uppercase">
                    <i data-feather="arrow-up-right" class="wd-10 mg-r-5"></i> View Website
                </a>
            </div>
        </div>

        <div class="row row-sm">
            <div class="col-lg-3 col-md-6">
                <div class="card dashboard-widget">
                   
                        <div class="card-body">
                            <h4 class="tx-bold mg-b-5 lh-1"><i data-feather="layers" class="mg-r-6"></i> {{ \App\Page::totalPages() }}</h4>
                            <span class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold">Total Pages</span>
                        </div>
                   
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card dashboard-widget">
                    
                        <div class="card-body">
                            <h4 class="tx-bold mg-b-5 lh-1"><i data-feather="image" class="mg-r-6"></i> {{ \App\Banner::totalBanners() }}</h4>
                            <span class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold">Total Banner
                        Albums</span>
                        </div>
                
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card dashboard-widget">
                    
                        <div class="card-body">
                            <h4 class="tx-bold mg-b-5 lh-1"><i data-feather="edit" class="mg-r-6"></i> {{ \App\Article::totalArticles() }}</h4>
                            <span class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold">Total
                        Articles</span>
                        </div>
             
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card dashboard-widget">
                    <div class="card-body">
                        <h4 class="tx-bold mg-b-5 lh-1"><i data-feather="eye" class="mg-r-6"></i> 155,863</h4>
                        <span class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold">Website
                    Views</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4">
                <div class="card dashboard-summary mg-t-20">
                    <div class="card-header">
                        Website Summary
                    </div>
                    <div class="card-body">
                        <h6><strong>Pages</strong></h6>
                        <p><span class="badge badge-dark">{{ \App\Page::totalPublicPages() }}</span> Public Pages</p>
                        <p><span class="badge badge-dark">{{ \App\Page::totalPrivatePages() }}</span> Private Pages</p>
                        <hr>
                        <h6><strong>Main Banner</strong></h6>
                        <p><span class="badge badge-dark">{{ \App\Album::totalAlbums() }}</span> Albums</p>
                        <hr>
                        <h6><strong>Users</strong></h6>
                        <p><span class="badge badge-dark">{{ \App\User::totalUser() }}</span> Users</p>
                        <hr>
                        <h6><strong>Articles</strong></h6>
                        <p><span class="badge badge-dark">{{ \App\Article::totalPublishedArticles() }}</span> Published Articles</p>
                        <p><span class="badge badge-dark">{{ \App\Article::totalDraftArticles() }}</span> Drafts</p>
                    </div>
                </div>
                <div class="dashboard-quick mg-t-20" style="display:none;">
                    <a href="{{ route('pages.create') }}" class="btn btn-sm pd-x-15 btn-primary btn-uppercase btn-block tx-left text-white">
                        <i data-feather="layers" class="wd-10 mg-r-5"></i> Create a Page
                    </a>
                    <a href="{{ route('news.create') }}" class="btn btn-sm pd-x-15 btn-primary btn-uppercase btn-block tx-left text-white">
                        <i data-feather="edit" class="wd-10 mg-r-5"></i> Create a News
                    </a>
                    <a href="{{ route('albums.create') }}" class="btn btn-sm pd-x-15 btn-primary btn-uppercase btn-block tx-left text-white">
                        <i data-feather="image" class="wd-10 mg-r-5"></i> Create an Album
                    </a>
                </div>
            </div>
            <div class="col-lg-9 col-md-8">
                <div class="card dashboard-recent mg-t-20">
                    <div class="card-header">
                        To Do List
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4 col-md-6">
                                <div class="card">       
                                    <a href="{{route('sales-transaction.index')}}?deliverystatus=UNPAID">
                                        <div class="card-body text-center">
                                            <h4 class="tx-bold mg-b-5 lh-1 text-center">
                                                {{ \App\EcommerceModel\SalesHeader::where('payment_status','UNPAID')->count() }}
                                            </h4>
                                            <span class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold">Unpaid</span>
                                        </div>         
                                    </a>                                                      
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="card">                    
                                    <a href="{{route('sales-transaction.index')}}?deliverystatus=Scheduled for Processing">
                                        <div class="card-body text-center">
                                            <h4 class="tx-bold mg-b-5 lh-1 text-center">
                                                {{ \App\EcommerceModel\SalesHeader::where('delivery_status','Scheduled for Processing')->count() }}
                                            </h4>
                                            <span class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold">Scheduled for Processing</span>
                                        </div> 
                                    </a>
                                                                                   
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="card">   
                                    <a href="{{route('sales-transaction.index')}}?deliverystatus=Ready for Delivery">                                
                                        <div class="card-body text-center">
                                            <h4 class="tx-bold mg-b-5 lh-1 text-center">
                                                {{ \App\EcommerceModel\SalesHeader::where('delivery_status','Ready for Delivery')->count() }}
                                            </h4>
                                            <span class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold">Ready for Delivery</span>
                                        </div> 
                                    </a>                                  
                                </div>
                            </div>
                            
                            
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-md-6">
                                <div class="card"> 
                                    <a href="{{route('sales-transaction.index')}}?deliverystatus=Returned">                                  
                                        <div class="card-body text-center">
                                            <h4 class="tx-bold mg-b-5 lh-1 text-center">
                                                {{ \App\EcommerceModel\SalesHeader::where('delivery_status','Returned')->count() }}
                                            </h4>
                                            <span class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold">Returned</span>
                                        </div>  
                                    </a>                                 
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="card">   
                                    <a href="{{route('sales-transaction.index')}}?deliverystatus=Cancelled">                                
                                        <div class="card-body text-center">
                                            <h4 class="tx-bold mg-b-5 lh-1 text-center">
                                                {{ \App\EcommerceModel\SalesHeader::where('delivery_status','Cancelled')->count() }}
                                            </h4>
                                            <span class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold">Cancelled</span>
                                        </div>   
                                    </a>                                
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="card">          
                                    <a href="{{route('report.inventory.reorder_point')}}" target="_blank">                         
                                        <div class="card-body text-center">
                                            <h4 class="tx-bold mg-b-5 lh-1 text-center">                                            
                                                {{Setting::belowReorderTotal()}}
                                            </h4>
                                            <span class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold">Below reorder Point</span>
                                        </div>     
                                    </a>                              
                                </div>
                            </div>
                            
                        </div>
                        <div class="list-group">
                          {{--   @forelse($logs as $log)
                                <p class="list-group-item list-group-item-action">
                                    <!--<a href="/admin/log-search?logID={{$log->id}}" target="_blank">-->
                                        <span class="badge badge-dark">{{ ucwords($log->firstname) }} {{ ucwords($log->lastname) }}</span>
                                    <!--</a> -->
                                    {{ $log->dashboard_activity }} at {{ Setting::date_for_listing($log->activity_date) }}
                                </p>
                            @empty
                            @endforelse --}}

                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-end">
                            <span class="tx-12"><a href="/admin/audit/index" style="display: none;">Show all activities <i class="fa fa-arrow-right"></i></a></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('pagejs')
    <script src="{{ asset('lib/nestable2/jquery.nestable.min.js') }}"></script>
@endsection
