@extends('admin.layouts.admin')
 
@section('content')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/css/bootstrap-select.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/bootstrap-select.js"></script>

<div class="well">

    {!! Form::open(['url' => 'admin/updatefacility', 'class' => 'form-horizontal']) !!}
    <input type="hidden" name="id" value="{{$getForm[0]->id}}" />
    <input type="hidden" name="dist_id" value="{{$getForm[0]->dist_id}}" />
    <input type="hidden" name="sub_dist_id" value="{{$getForm[0]->sub_dist_id}}" />
    <input type="hidden" name="inspector_id" value="{{$getForm[0]->inspector_id}}" />
    <fieldset>
 
        <h1><legend>Edit Facility</legend></h1>
        
            @if ($errors->any())
            <div class="form-group">
                <div class="alert alert-danger">
              {{ implode('', $errors->all(':message')) }}
            </div>
          </div>
            @endif
         

        <div class="form-group">
          {!! Form::label('district', 'Disctrict :', ['class' => 'col-lg-2 control-label']) !!}
            @php
                if($getForm[0]->DistrictName){
                    $district_name = $getForm[0]->DistrictName;
                }else{
                    $district_name = $getForm[0]->district;
                }///0..0
            @endphp

            <div class="col-lg-3">
                {!! Form::text('district', $value = $district_name ? $district_name : Input::old('disctrict') , ['class' => 'col-lg-3 form-control', 'placeholder' => 'District']) !!}
            </div>

            {!! Form::label('sub_district', 'Sub Disctrict :', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-3">
                {!! Form::text('sub_district', $value = $getForm[0]->subdistrict, ['class' => 'form-control', 'placeholder' => 'Sub Disctrict']) !!}
            </div>
        </div>
 

        <div class="form-group">
            {!! Form::label('facility_name', 'Facility Name :', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-3">
                {!! Form::text('facility_name', $value = $getForm[0]->name ? $getForm[0]->name : '0', ['class' => 'form-control', 'placeholder' => 'Facility Name']) !!}
            </div>
            
             {!! Form::label('facility_no', 'Facility No :', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-3">
                {!! Form::text('facility_no', $value = $getForm[0]->facility_no ? $getForm[0]->facility_no : '0', ['class' => 'form-control', 'placeholder' => 'Facility No']) !!}
            </div>
           
        </div>
 
        <div class="form-group">
            {!! Form::label('inspector', 'District Facility Manager', ['class' => 'col-lg-2 control-label'] )  !!}
            @php

                if($getForm[0]->inspector_name){
                    $inspect_name = $getForm[0]->inspector_name ? $getForm[0]->inspector_name : '';
                    
                }else{
                    $inspect_name = !empty($inspector)  ? $inspector['name'] : '';
                }///0..0

            @endphp
            <div class="col-lg-3">
                {!!  Form::text('inspector', $value = $inspect_name ? $inspect_name : Input::old('inspector'), ['class' => 'form-control', 'placeholder' => 'DFM']) !!}

            
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
