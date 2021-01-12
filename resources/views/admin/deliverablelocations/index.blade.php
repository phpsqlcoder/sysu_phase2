@extends('admin.layouts.app')

@section('pagetitle')
Serviceable Areas
@endsection

@section('pagecss')
<link href="{{ asset('lib/ion-rangeslider/css/ion.rangeSlider.min.css') }}" rel="stylesheet">
<style>
    .row-selected {
        background-color: #92b7da !important;
    }
</style>
@endsection

@section('content')

    <div class="container pd-x-0">
        <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1 mg-b-5">
                        <li class="breadcrumb-item" aria-current="page"><a href="{{route('dashboard')}}">CMS</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Serviceable Areas</li>
                    </ol>
                </nav>
                <h4 class="mg-b-0 tx-spacing--1">Serviceable Areas</h4>
            </div>
        </div>



            <!-- Start Pages -->
            <div class="col-md-12 text-right">
                @if (auth()->user()->has_access_to_route('locations.create'))
                    <a class="btn btn-primary btn-sm mg-b-20" href="{{ route('locations.create') }}">Add New Location</a>
                @endif
            </div>
            <div class="col-md-12">
                <div class="table-list mg-b-10">
                    <div class="table-responsive-lg">
                        <table class="table mg-b-0 table-light table-hover">
                            <thead>
                            <tr>
                                <th>Location</th>
                                <th>Rate</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($address as $add)
                                <tr>

                                    <td>{{ $add->name }}</td>
                                    <td>{{ number_format($add->rate,2) }}</td>
                                    <td>{{ $add->status }}</td>

                                    <td>
                                        <nav class="nav table-options">
                                            @if (auth()->user()->has_access_to_route('locations.edit'))
                                                <a class="nav-link" href="{{ route('locations.edit',$add->id) }}" title="Edit Location"><i data-feather="edit"></i></a>
                                            @endif

                                            @if (auth()->user()->has_access_to_route('locations.enable') || auth()->user()->has_access_to_route('locations.disable'))
                                                @if($add->status=='PRIVATE')
                                                    <a class="nav-link" href="javascript:void(0)" onclick="enable_location({{$add->id}})" title="Enable Location"><i data-feather="settings"></i></a>
                                                @else
                                                    <a class="nav-link" href="javascript:void(0)" onclick="disable_location({{$add->id}})" title="Disable Location"><i data-feather="settings"></i></a>
                                                @endif
                                            @endif

                                            @if (auth()->user()->has_access_to_route('locations.delete'))
                                                <a class="nav-link" href="javascript:void(0)" onclick="delete_location({{$add->id}})" title="Delete location"><i data-feather="trash"></i></a>
                                            @endif
                                        </nav>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <th colspan="10" style="text-align: center;"> <p class="text-danger">No Address found.</p></th>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="modal effect-scale" id="prompt-delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="{{route('locations.delete')}}" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Delete Location</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this location?</p>
                            @csrf
                            <input type="hidden" id="delete_id" name="delete_id">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-danger">Yes, Delete</button>
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal effect-scale" id="prompt-enable" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="{{route('locations.enable')}}" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Enable Location</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to enable this location?</p>
                            @csrf
                            <input type="hidden" id="enable_id" name="enable_id">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-danger">Yes, Enable</button>
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal effect-scale" id="prompt-disable" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="{{route('locations.disable')}}" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Disable Location</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to disable this location?</p>
                            @csrf
                            <input type="hidden" id="disable_id" name="disable_id">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-danger">Yes, Disable</button>
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>




@endsection

@section('pagejs')
    <script src="{{ asset('lib/bselect/dist/js/bootstrap-select.js') }}"></script>

    <script>
        function delete_location(id){
            $('#delete_id').val(id);
            $('#prompt-delete').modal('show');
        }
        function enable_location(id){
            $('#enable_id').val(id);
            $('#prompt-enable').modal('show');
        }
        function disable_location(id){
            $('#disable_id').val(id);
            $('#prompt-disable').modal('show');
        }
    </script>


@endsection

@section('customjs')

@endsection
