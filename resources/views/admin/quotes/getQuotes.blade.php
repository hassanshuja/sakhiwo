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
                  Management
                </h1>
            </div><!--col-->
        </div><!--row-->
        <div class="row">
            {!! Form::open(['url' => 'admin/search', 'class' => 'form-horizontal']) !!}
                 <!-- Email -->
                <div class="form-group">
                {!! Form::label('search', 'Search:', ['class' => 'col-lg-1 control-label searchtxt']) !!}
                <div class="col-lg-3">
                    {!! Form::text('searchs', $value = null, ['class' => 'form-control', 'placeholder' => 'Search Quotes']) !!}
                </div>
                <button type="submit" class="btn btn-default">
                    <span class="glyphicon glyphicon-search"></span>
                </button>
            
            {!! Form::close() !!}
            <div class="pull-right" style="margin-right: 14px;
    background: #f7f7f7;
    border: 1px solid #ccc;
    padding: 9px;">
            <a href="{{ route('admin.newCapturing') }}">
                <i class="fa fa-plus" aria-hidden="true"></i>
                {{ __('views.backend.section.navigation.menu_1_4') }}
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
                            <th>Job Card No.</th>
                            <th>Sub Disctrict</th>
                            <th>Problem Type</th>
                            <th>Facility Name</th>
                            <th>Last Updated By</th>
                            <th>View</th>
                            @if(\Auth::user()->hasRole('administrator'))
                            <th>Delete</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                          @if(count($datas) > 0){
                         @foreach ($datas as $index => $data)
                        <?php  $dt = new DateTime($data->created_date); $date = $dt->format('m/d/Y'); $time = $dt->format('H:i:s');
                        ?>
                            <tr>
                                <td>{{ ++$index}}</td>
                                <td>{{ $data->job_card_number }}</td>
                                <td>{{ $data->sub_district }}</td>
                                <td>{{ $data->problem_type}}</td>
                                <td>{{$data->facility_name}}</td>
                                <td>{{ $data->updated_by }}</td>
                                <td><a class="but btn btn-success" href="{{url('admin/edit', [$data->id])}}">Edit</a></td>
                                @if(\Auth::user()->hasRole('administrator'))
                                <td><a class="but btn btn-danger" href="{{route('admin.uploads.deleteUploads', [$data->id])}}">Delete</a></td>
                                 @endif
                            </tr>
                        @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div><!--col-->
        @if(isset($datas) && count($datas) > 0)
        
        {{ $datas->appends(request()->input())->links() }}
        Results Found {{ $datas->total() }}
        @endif
</div><!--card-->
    
@endsection