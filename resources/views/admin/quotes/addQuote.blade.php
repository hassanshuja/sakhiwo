@extends('admin.layouts.admin')
 
@section('content')
 
<div class="well">

    {!! Form::open(['url' => 'admin/capturing', 'class' => 'form-horizontal']) !!}
    {{-- <input type="hidden" name="id" value="{{$getForm[0]->id}}" />
    <input type="hidden" name="dist_id" value="{{$getForm[0]->dist_id}}" />
    <input type="hidden" name="sub_dist_id" value="{{$getForm[0]->sub_dist_id}}" />
    <input type="hidden" name="inspector_id" value="{{$getForm[0]->inspector_id}}" /> --}}
    <fieldset>
 
        <h1><legend>Quote Edit</legend></h1>
        
            @if ($errors->any())
            <div class="form-group">
                <div class="alert alert-danger">
              {{ implode('', $errors->all(':message')) }}
            </div>
          </div>
            @endif
         
        <div class="form-group">
            {!! Form::label('job_card_no', 'Job No :', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-3">
                {!! Form::text('job_card_no', Input::old('job_card_no'), ['class' => 'form-control', 'placeholder' => 'Job Card Number']) !!}
            </div>

            {!! Form::label('sub_district', 'Sub Disctrict :', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-4">
                {!! Form::text('sub_district', Input::old('sub_district'), ['class' => 'form-control', 'placeholder' => 'Sub Disctrict']) !!}
            </div>
        </div>
 
        <div class="form-group">
            {!! Form::label('district', 'Disctrict :', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-3">
                {!! Form::text('district', Input::old('district'), ['class' => 'col-lg-3 form-control', 'placeholder' => 'District']) !!}
            </div>

            {!! Form::label('problem_type', 'Problem Type :', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-4">
                {!! Form::text('problem_type', Input::old('problem_type'), ['class' => 'form-control', 'placeholder' => 'Problem Type']) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('facility_name', 'Facility Name :', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-3">
                {!! Form::text('facility_name', Input::old('facility_name'), ['class' => 'form-control', 'placeholder' => 'Facility Name']) !!}
            </div>
            {!! Form::label('inspector', 'District Facility Manager', ['class' => 'col-lg-2 control-label'] )  !!}
            @php $inspector[0] = "Please Select DFM"; @endphp
            <div class="col-lg-4">
                {!!  Form::select('inspector', $inspector, 'S', ['class' => 'form-control' ]) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('quotation_no', 'Quotation No :', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-3">
                {!! Form::text('quotation_no', Input::old('quotation_no'), ['class' => 'form-control', 'placeholder' => 'Quotation Number']) !!}
            </div>
            {!! Form::label('labour_amount', 'Labour Amount :', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-3">
                {!! Form::text('labour_amount', Input::old('labour_amount'), ['class' => 'form-control', 'placeholder' => 'Labour Amount']) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('travelling_amount', 'Travelling Amount :', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-3">
                {!! Form::text('travelling_amount', Input::old('travelling_time_amount'), ['class' => 'form-control', 'placeholder' => 'Travelling Amount']) !!}
            </div>
            {!! Form::label('travelling_cost', 'Travelling Cost :', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-3">
                {!! Form::text('travelling_cost', $value = $getForm[0]->travelling_cost ? $getForm[0]->travelling_cost: Input::old('travelling_cost'), ['class' => 'form-control', 'placeholder' => 'Travelling Cost']) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('desludge_delive', 'Desludge Delive :', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-3">
                {!! Form::text('desludge_delive', $value = $getForm[0]->desludging_water_delive ? $getForm[0]->desludging_water_delive : Input::old('desludge_delive'), ['class' => 'form-control', 'placeholder' => 'Desludge Delive']) !!}
            </div>
            {!! Form::label('accomodation', 'Accomodation :', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-3">
                {!! Form::text('accomodation', $value = $getForm[0]->accomodation ? $getForm[0]->accomodation: Input::old('accomodation'), ['class' => 'form-control', 'placeholder' => 'Accomodation']) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('material_used_amount', 'Material Used :', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-3">
                {!! Form::text('material_used_amount', $value = $getForm[0]->material_used_amount ? $getForm[0]->material_used_amount:Input::old('material_used_amount'), ['class' => 'form-control', 'placeholder' => 'Material Used']) !!}
            </div>
            {!! Form::label('amount_exc_vat', 'Amount Exc(VAT) :', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-3">
                {!! Form::text('amount_exc_vat',Input::old('amount_exc_vat'), ['class' => 'form-control', 'placeholder' => 'Amount Exc(VAT)']) !!}
            </div>
        </div>



        <div class="form-group">
            {!! Form::label('amount_inc_vat', 'Amount INC(VAT) :', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-3">
                {!! Form::text('amount_inc_vat', Input::old('amount_inc_vat'), ['class' => 'form-control', 'placeholder' => 'Amount INC(VAT)']) !!}
            </div>

            {!! Form::label('firs_status', 'Status :', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-3">
              @if($getForm[0]->status == 0)
                  {!! Form::text('firs_status', 'Capturing', ['class' => 'form-control', 'placeholder' => 'Status', 'readonly']) !!}
                  <input type="hidden" name="status" value="1">
              @else
              @php 
                $status = array(
                  'Select Qoute Status',
                  '1' => 'Capturing',
                  '2' => 'Approved',
                  '3' => 'Rejected Internally',
                  '4' => 'Reject After Vetting By Client',
                  '5' => 'Corrected',
                  '6' => 'Vetted',
                  '7' => 'Invoiced',

                ) ;
              @endphp
              {!!  Form::select('status', Input::old('status'), ['class' => 'form-control' ]) !!}
              @endif
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('quote_date', 'Quote Date :', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-3">
               
                {!! Form::date('quote_date', Input::old('quotation_date'), ['class' => 'form-control', 'placeholder' => 'Quote Date']) !!}
            </div>
            {!! Form::label('price', 'Price :', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-3">
                {!! Form::text('price', Input::old('price'), ['class' => 'form-control', 'placeholder' => 'Price']) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('description', 'Description', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-3">
                {!! Form::textarea('description', Input::old('description'), ['class' => 'form-control', 'rows' => 3]) !!}
                
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
@endsection