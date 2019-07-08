@extends('admin.layouts.admin')

{{-- @section('title', __('views.admin.quotes.index.title')) --}}

@section('content')
@if(session()->has('success'))
<div class="alert alert-success">
    {{ session()->get('success') }}
</div>
@endif
@if(session()->has('error'))
<div class="alert alert-danger">
    {{ session()->get('error') }}
</div>
@endif
<div class="container">
        <div class="row">
            <div class="col-sm-5">
                <h1 >
                  Facility Management
                </h1>
            </div><!--col-->
        </div><!--row-->
        <div class="row">

            <div class="pull-right" style="margin-right: 14px;
    background: #f7f7f7;
    border: 1px solid #ccc;
    padding: 9px;">
            <a href="{{ route('admin.addfacility') }}">
                <i class="fa fa-plus" aria-hidden="true"></i>
                ADD New Facility
            </a>
            </div>
        </div>
        </div><!--row-->
            <div class="col">
                <div class="table-responsive tablequotes">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Facility Name</th>
                            <th>District</th>
                            <th>Sub Disctrict</th>
                            <th>Facility Manager</th>
                            <th>Edit</th>
                            @if(\Auth::user()->hasRole('administrator'))
                            <th>Delete</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                          @if(count($datas) > 0)
                         @foreach ($datas as $index => $data)

                            <tr>
                                <td>{{ ++$index}}</td>
                                <td>{{ $data->name }}</td>
                                <td>{{ $data->district }}</td>
                                <td>{{ $data->subdistrict }}</td>
                                <td>{{$data->facility_manager}}</td>
                                <td><a class="but btn btn-success" href="{{url('admin/editfacility', [$data->id])}}">Edit</a></td>
                                @if(\Auth::user()->hasRole('administrator'))
                                <td><a class="but btn btn-danger" href="{{route('admin.deleteFacility', [$data->id])}}">Delete</a></td>
                                 @endif
                            </tr>
                        @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div><!--col-->
            
        @if(isset($datas) && count($datas) > 0)
        
        {{ $datas->links() }}
        Results Found {{ $datas->total() }}
        @endif
</div><!--card-->
    
@endsection