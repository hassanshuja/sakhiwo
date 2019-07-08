@extends('admin.layouts.admin')
 
@section('content')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/css/bootstrap-select.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/bootstrap-select.js"></script>

<div class="well">

    {!! Form::open(['url' => 'admin/updateDFM', 'class' => 'form-horizontal']) !!}
    <input type="hidden" name="id" value="{{$getForm[0]->id}}" />
    <input type="hidden" name="dist_id" value="{{$getForm[0]->district_id}}" />
    <input type="hidden" name="sub_dist_id" value="{{$getForm[0]->sub_district_id}}" />
    <input type="hidden" name="inspector_id" value="{{$getForm[0]->inspector_id}}" />
    <fieldset>
 
        <h1><legend>Edit DFM</legend></h1>
        
            @if ($errors->any())
            <div class="form-group">
                <div class="alert alert-danger">
              {{ implode('', $errors->all(':message')) }}
            </div>
          </div>
            @endif
         

        <div class="form-group">

            {!! Form::label('sub_district', 'Sub Disctrict :', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-3">
               {!!  Form::select('sub_district', $sub_district,  $value = $getForm[0]->sub_district_id ? $getForm[0]->sub_district_id:Input::old('sub_district'), ['class' => 'form-control selectpicker', 'data-live-search' => "true" ,  'required' ]) !!}
            </div>
            
            {!! Form::label('inspector', 'District Facility Manager', ['class' => 'col-lg-2 control-label'] )  !!}
            @php
                    $inspect_name = $getForm[0]->inspector_name ? $getForm[0]->inspector_name : '';
            @endphp
            <div class="col-lg-3">
                {!!  Form::text('inspector', $value = $inspect_name ? $inspect_name : Input::old('inspector'), ['class' => 'form-control', 'placeholder' => 'DFM']) !!}
            
            </div>
            
        </div>
 
        <div class="form-group">
            {!! Form::label('inspector_email', 'District Facility Manager Email', ['class' => 'col-lg-2 control-label'] )  !!}
            @php
                    $inspect_email = $getForm[0]->inspector_email ? $getForm[0]->inspector_email : '';
            @endphp
            <div class="col-lg-3">
                {!!  Form::email('inspector_email', $value = $inspect_email ? $inspect_email : Input::old('inspector_email'), ['class' => 'form-control', 'placeholder' => 'DFM Email']) !!}
            </div>
        </div>
        <!-- Submit Button -->
        <div class="form-group">
            <div class="col-lg-10 col-lg-offset-2">
                {!! Form::submit('Submit', ['class' => 'btn btn-lg btn-info pull-right'] ) !!}
            </div>
        </div>
 
    </fieldset>
 
    {!! Form::close()  !!}
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

@endsection
