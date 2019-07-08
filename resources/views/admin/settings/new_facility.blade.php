@extends('admin.layouts.admin')
 
@section('content')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/css/bootstrap-select.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/bootstrap-select.js"></script>

<div class="well">

    {!! Form::open(['url' => 'admin/addfacility', 'class' => 'form-horizontal']) !!}
   
    <fieldset>
 
        <h1><legend>ADD Facility</legend></h1>
        
            @if ($errors->any())
            <div class="form-group">
                <div class="alert alert-danger">
              {{ implode('', $errors->all(':message')) }}
            </div>
          </div>
            @endif
         

        <div class="form-group">
          {!! Form::label('district', 'Disctrict :', ['class' => 'col-lg-2 control-label']) !!}


            <div class="col-lg-3">
                   @php 
                $facility[''] = 'Select District Name';
                @endphp
                {!!  Form::select('district', $district,  $value =Input::old('district'), ['class' => 'form-control selectpicker', 'data-live-search' => "true" ,  'required' ]) !!}
            </div>
             

            {!! Form::label('sub_district', 'Sub Disctrict :', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-3">
               {!!  Form::select('sub_district', $sub_district,  $value =Input::old('sub_district'), ['class' => 'form-control selectpicker', 'data-live-search' => "true" ,  'required' ]) !!}
            </div>
        </div>
 

        <div class="form-group">
            {!! Form::label('facility_name', 'Facility Name :', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-3">
                {!! Form::text('facility_name', $value = Input::old('facility_name'), ['class' => 'form-control', 'placeholder' => 'Facility Name']) !!}
            </div>
            
             {!! Form::label('facility_no', 'Facility No :', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-3">
                {!! Form::text('facility_no', $value = Input::old('facility_no'), ['class' => 'form-control', 'placeholder' => 'Facility No']) !!}
            </div>
           
        </div>
 
        <div class="form-group">
            {!! Form::label('inspector', 'District Facility Manager', ['class' => 'col-lg-2 control-label'] )  !!}
           <div class="col-lg-3">
               {!!  Form::select('inspector', $inspector,  $value =Input::old('inspector'), ['class' => 'form-control selectpicker', 'data-live-search' => "true" ,  'required' ]) !!}
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
