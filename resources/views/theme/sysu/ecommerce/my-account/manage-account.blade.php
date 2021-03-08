@extends('theme.'.env('FRONTEND_TEMPLATE').'.main')

@section('pagecss')
    <link rel="stylesheet" href="{{ asset('theme/lydias/plugins/responsive-tabs/css/responsive-tabs.css') }}" />
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
                    <div id="res-tabs-account">

                        <nav>
                            <div class="nav nav-tabs account-tabs" id="nav-tab" role="tablist">
                                <a href="#tab-1" class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" role="tab" aria-controls="nav-home" aria-selected="true">Personal Info</a>
                                <a href="#tab-2" class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" role="tab" aria-controls="nav-profile" aria-selected="false">Contact Info</a>
                                <a href="#tab-3" class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" role="tab" aria-controls="nav-contact" aria-selected="false">Address</a>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active login-forms" id="tab-1" role="tabpanel" aria-labelledby="nav-home-tab">
                                <br>
                                <h4>Personal Information</h4>
                                <hr>
                                <div class="gap-10"></div>
                                <div class="form-style-alt">
                                    @if (Session::has('success-personal'))
                                        <div class="alert alert-success" role="alert"><span class="fa fa-info-circle"></span>{{ Session::get('success-personal') }}</div>
                                    @endif
                                    <form method="post" class="row" action="{{ route('my-account.update-personal-info') }}">
                                        @csrf                                          
                                            <div class="col-lg-6">
                                                <label>First Name *</label>
                                                <div class="form-group">
                                                    <input type="text" class="form-control @error('firstname') is-invalid @enderror" id="firstname" name="firstname" value="{{ old('firstname', $member->firstname) }}">
                                                    @hasError(['inputName' => 'firstname'])
                                                    @endhasError
                                                </div>
                                           
                                            </div>
                                            <div class="col-lg-6">
                                                <label>Last Name *</label>
                                                <div class="form-group">
                                                    <input type="text" class="form-control @error('lastname') is-invalid @enderror" id="lastname" name="lastname" value="{{ old('lastname', $member->lastname) }}">
                                                    @hasError(['inputName' => 'lastname'])
                                                    @endhasError
                                                </div>
                                          
                                            </div>                                           
                                        <div class="col-lg-6">
                                            <button type="submit" class="btn btn-md btn-success">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="tab-pane fade login-forms" id="tab-2" role="tabpanel" aria-labelledby="nav-profile-tab"><br>
                                <h4>Contact Information</h4>
                                <hr>
                                <div class="gap-10"></div>
                                <div class="form-style-alt">
                                    @if (Session::has('success-contact'))
                                        <div class="alert alert-success" role="alert"><span class="fa fa-info-circle"></span>{{ Session::get('success-contact') }}</div>
                                    @endif
                                    <form method="post" class="row" action="{{ route('my-account.update-contact-info') }}">
                                        @csrf
                                       
                                        <div class="col-lg-6">
                                            <label>Mobile Number *</label>
                                            <div class="form-group">
                                                <input type="text" class="form-control @error('mobile') is-invalid @enderror" id="mobile" name="mobile" value="{{ old('mobile', $member->mobile) }}">
                                                @hasError(['inputName' => 'mobile'])
                                                @endhasError
                                            </div>
                                          
                                        </div>
                                        <div class="col-lg-6">
                                            <label>Telephone Number </label>
                                            <div class="form-group">
                                                <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $member->phone) }}">
                                                @hasError(['inputName' => 'phone'])
                                                @endhasError
                                            </div>
                                            <div class="gap-20"></div>
                                        </div>                                            
                                        <div class="col-lg-12">
                                            <button type="submit" class="btn btn-md btn-success">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="tab-pane fade login-forms" id="tab-3" role="tabpanel" aria-labelledby="nav-contact-tab">
                                <form method="post" action="{{ route('my-account.update-address-info') }}">
                                    @csrf
                                    @if (Session::has('success-address'))
                                        <div class="alert alert-success" role="alert"><span class="fa fa-info-circle">Personal information has been updated</span>{{ Session::get('success-contact') }}</div>
                                    @endif
                                    <br>
                                    <h4>Delivery Address</h4>
                                   
                                    <div class="gap-20"></div>
                                    <div class="address-card">
                                        <div class="form-style-alt">                                               
                                            
                                            <div class="gap-10"></div>
                                            <div class="form-group form-wrap">
                                                <label>Address Line 1 *</label>
                                                <input type="text" class="form-control @error('address_street') is-invalid @enderror" id="delivery_street" name="address_street" placeholder="Unit No./Building/House No./Street" value="{{ old('address_street', $member->address_street) }}"/>
                                                @hasError(['inputName' => 'address_street'])
                                                @endhasError
                                            </div>
                                           
                                       
                                            <div class="form-group form-wrap">
                                                <label>Address Line 2 *</label>
                                                <input type="text" class="form-control @error('address_municipality') is-invalid @enderror" id="delivery_zip" name="address_municipality" placeholder="Subd/Brgy/Municipality/City/Province" value="{{ old('address_municipality', $member->address_municipality) }}"/>      

                                                @hasError(['inputName' => 'address_municipality'])
                                                @endhasError
                                            </div>    
                                            
                                            <div class="form-group form-wrap">
                                                <label>City/Province *</label>
                                                <input type="text" class="form-control @error('address_city') is-invalid @enderror" id="delivery_zip" name="address_city" value="{{ old('address_city', $member->address_city) }}"/>      

                                                @hasError(['inputName' => 'address_city'])
                                                @endhasError
                                            </div>    
                                                                         
                                             <div class="form-group form-wrap">
                                                <label>Zip </label>
                                                <input type="text" class="form-control @error('address_zip') is-invalid @enderror" id="delivery_zip" name="address_zip" value="{{ old('address_zip', $member->address_zip) }}"/>                                                  
                                                @hasError(['inputName' => 'address_zip'])
                                                @endhasError
                                            </div>
                                            
                                            <div class="gap-10"></div>
                                           
                                        </div>
                                    </div>
                                    <div class="gap-10"></div>
                                    <button type="submit" class="btn btn-md btn-success">Save</button>
                                </form>
                            </div>
                        </div>
                        <div class="gap-20"></div>
                    </div>
                    
                    
                </div>
            </div>
        </div>
    </section>
   


@endsection

@section('jsscript')
    <script src="{{ asset('theme/lydias/plugins/responsive-tabs/js/jquery.responsiveTabs.js') }}"></script>
    <script>
        $("#res-tabs-account").responsiveTabs({
            startCollapsed: "accordion",
            active: {{$selectedTab}},
            scrollToAccordion: true
        });

      

        function toTitleCase(str) {
            return str.replace(/\w\S*/g, function(txt){
                return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
            });
        }

        
    </script>
@endsection
