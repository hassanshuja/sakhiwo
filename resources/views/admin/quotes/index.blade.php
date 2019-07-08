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
  <div class="row col-sm-12">
  {!! Form::open(array('url' => 'admin/importExcelForUpload', "enctype" => "multipart/form-data", "method" => "post", 'file' => true)) !!}
  {!! Form::token() !!}
  {{-- <form action="{{route('admin.importExcel')}}" enctype="multipart/form-data"> --}}
        <div class="form-group">
            <label for="uploads"><h1>Upload Quotes Excel File</h1></label>
            {!! Form::file('quotes', array('class' => 'form-control')) !!}
            {!! $errors->first('quotes', '<p class="alert alert-danger">:message</p>') !!}
            
        </div>
        <div class="form-group" style="margin-top: 56px;">
        <button type="submit" class="btn btn-default">Submit</button>
        </div>
      {{-- </form> --}}
  {!! Form::close() !!}
  </div>
</div>
    
@endsection