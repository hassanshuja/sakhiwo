@extends('admin.layouts.admin')
 
@section('content')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/css/bootstrap-select.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/bootstrap-select.js"></script>

<div class="well">

    {!! Form::open(['url' => 'admin/capturing', 'class' => 'form-horizontal']) !!}
    <input type="hidden" name="id" value="{{$getForm[0]->id}}" />
    <input type="hidden" name="dist_id" value="{{$getForm[0]->dist_id}}" />
    <input type="hidden" name="sub_dist_id" value="{{$getForm[0]->sub_dist_id}}" />
    <input type="hidden" name="inspector_id" value="{{$getForm[0]->inspector_id}}" />
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
            @php
                $vat_check = [ 0 => 'Select VAT Registered/Not VAT Registered', 1 => 'Registered', 2 => 'Not Registered'];
            @endphp
            {!! Form::label('vat_check', 'VAT Registered/Not Registered', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-3">
                {!!  Form::select('vat_check', $vat_check, $value = $getForm[0]->reg_unregistered? $getForm[0]->reg_unregistered :  Input::old('vat_check'), ['class' => 'form-control' ]) !!}
            </div>
            {!! Form::label('contractor_id', 'Contractor Name :', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-3">
                @php 
                $contractors[''] = 'Select Contractor Name';
                @endphp
                {!!  Form::select('contractor_id', $contractors,  $value = $getForm[0]->contractor_id ? $getForm[0]->contractor_id : '', ['class' => 'form-control selectpicker', 'data-live-search' => "true" , 'required' => 'required' ]) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('job_card_no', 'Job No :', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-3">
                {!! Form::text('job_card_no', $value = $getForm[0]->job_card_number, ['class' => 'form-control', 'placeholder' => 'Job Card Number']) !!}
            </div>

            {!! Form::label('sub_district', 'Sub Disctrict :', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-3">
                {!! Form::text('sub_district', $value = $getForm[0]->sub_district, ['class' => 'form-control', 'placeholder' => 'Sub Disctrict']) !!}
            </div>
        </div>
 
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

            {!! Form::label('problem_type', 'Problem Type :', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-3">
                {!! Form::text('problem_type', $value = $getForm[0]->problem_type, ['class' => 'form-control', 'placeholder' => 'Problem Type']) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('facility_id', 'Facility Name :', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-3">
                @php 
                $facility[''] = 'Select Facility Name';
                @endphp
                {!!  Form::select('facility_id', $facility,  $value = $getForm[0]->facility_id ? $getForm[0]->facility_id : '0', ['class' => 'form-control selectpicker', 'data-live-search' => "true" ,  'required' ]) !!}
            </div>
            
             {!! Form::label('facility_no', 'Facility No :', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-3">
                {!! Form::text('facility_no',$value = $getForm[0]->facility_no ? $getForm[0]->facility_no:Input::old('facility_no'), ['class' => 'form-control', 'placeholder' => 'facility No', 'required']) !!}
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
            {!! Form::label('quotation_no', 'Quotation No :', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-3">
                {!! Form::text('quotation_no', $value = $getForm[0]->quotation_no ? $getForm[0]->quotation_no:Input::old('quotation_no'), ['class' => 'form-control', 'placeholder' => 'Quotation Number']) !!}
            </div>

        </div>

        <div class="form-group">
            {!! Form::label('invoice_no', 'Invoice No :', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-3">
                {!! Form::text('invoice_no',$value = $getForm[0]->invoice_no ? $getForm[0]->invoice_no:Input::old('invoice_no'), ['class' => 'form-control', 'placeholder' => 'Invoice No']) !!}
            </div>
            {!! Form::label('travelling_time', 'Travelling Time :', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-3">
                {!! Form::text('travelling_time', $value = $getForm[0]->travelling_time_amount ? $getForm[0]->travelling_time_amount: Input::old('travelling_time_amount'), ['class' => 'form-control', 'placeholder' => 'Travelling Time', 'onkeyup' => 'need_khilafah()']) !!}
            </div>
        </div>
 
        <div class="form-group">
            {!! Form::label('travelling_cost', 'Travelling Cost :', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-3">
                {!! Form::text('travelling_cost', $value = $getForm[0]->travelling_cost ? $getForm[0]->travelling_cost: Input::old('travelling_cost'), ['class' => 'form-control', 'placeholder' => 'Travelling Cost', 'onkeyup' => 'need_khilafah()']) !!}
            </div>
            {!! Form::label('desludge_delive', 'Desludge & Water Delive :', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-3">
                {!! Form::text('desludge_delive', $value = $getForm[0]->desludging_water_delive ? $getForm[0]->desludging_water_delive : Input::old('desludge_delive'), ['class' => 'form-control', 'placeholder' => 'Desludge Delive', 'onkeyup' => 'need_khilafah()']) !!}
            </div>
        </div>
        
        <div class="form-group">
            {!! Form::label('accomodation', 'Accomodation :', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-3">
                {!! Form::text('accomodation', $value = $getForm[0]->accomodation ? $getForm[0]->accomodation: Input::old('accomodation'), ['class' => 'form-control', 'placeholder' => 'Accomodation', 'onkeyup' => 'need_khilafah()']) !!}
            </div>
            {!! Form::label('material_vat_exempt', 'VAT Exempt Materials :', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-3">
                {!! Form::text('material_vat_exempt', $value = $getForm[0]->material_vat_exempt ? $getForm[0]->material_vat_exempt:Input::old('material_vat_exempt'), ['class' => 'form-control', 'placeholder' => 'VAT Exempt Materials', 'onkeyup' => 'need_khilafah()']) !!}
            </div>
            
 

        </div>

        <div class="form-group">
            {!! Form::label('labour_amount', 'Labour Amount :', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-3">
                {!! Form::text('labour_amount', $value = $getForm[0]->labour_amount ? $getForm[0]->labour_amount : old('labour_amount'), ['class' => 'form-control', 'placeholder' => 'Labour Amount', 'onkeyup' => 'need_khilafah()']) !!}
            </div>
            {!! Form::label('material_used_amount', 'Material With VAT :', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-3">
                {!! Form::text('material_used_amount', $value = $getForm[0]->material_used_amount ? $getForm[0]->material_used_amount:Input::old('material_used_amount'), ['class' => 'form-control', 'placeholder' => 'Material With VAT', 'onkeyup' => 'need_khilafah()']) !!}
            </div>
        </div>


        <div class="form-group">
            {!! Form::label('amount_exc_vat', 'Amount Before VAT :', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-3">
                {!! Form::text('amount_exc_vat',$value = $getForm[0]->amount_excluding_vat ? $getForm[0]->amount_excluding_vat:Input::old('amount_exc_vat'), ['class' => 'form-control', 'placeholder' => 'Amount Exc(VAT)', 'readonly'=> 'true']) !!}
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
              {!!  Form::select('status', $status, $value = $getForm[0]->status ? $getForm[0]->status:Input::old('status'), ['class' => 'form-control', 'id' => 'status' ]) !!}
              @endif
            </div>


        </div>

        <div class="form-group">
            {!! Form::label('quote_date', 'Quote Date :', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-3">
            <?php 
           
                if($getForm[0]->quotation_date){
                    
                    $quotedate = explode(' ', $getForm[0]->quotation_date);
                   
                }
             ?>
               
                {!! Form::date('quote_date', $value = isset($quotedate[0]) ? $quotedate[0] : Input::old('quotation_date'), ['class' => 'form-control datepicker', 'placeholder' => 'Quote Date']) !!}
            </div>

            {!! Form::label('price', 'Amount After VAT :', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-3">
                {!! Form::text('price', $value = $getForm[0]->price ? $getForm[0]->price:Input::old('price'), ['class' => 'form-control', 'placeholder' => 'Price' ,'readonly'=> 'true']) !!}
            </div>
        </div>

        <div class="form-group reasonDiv" style="<?php $getForm[0]->reason ? 'display:block': 'display:none'?>">
             {!! Form::label('description', 'Description :', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-3">
                {!! Form::textarea('description', $value = $getForm[0]->description ? $getForm[0]->description:Input::old('description'), ['class' => 'form-control', 'rows' => 3]) !!}
                
            </div>

            {!! Form::label('reason', 'Reason :', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-3">
                {!! Form::textarea('reason', $value = $getForm[0]->reason ? $getForm[0]->reason:Input::old('reason'), ['class' => 'form-control', 'placeholder' => 'Reason' ,'rows' => 3]) !!}
            </div>
             
        </div>
        
        <div class="form-group">
            {!! Form::label('updated_by', 'Last Updated By:', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-3">
                {!! Form::text('updated_by', $value = $getForm[0]->updated_by, ['class' => 'form-control', 'readonly'=> 'true']) !!}
            </div>
        </div>

        @php
            if($getForm[0]->completed_status) {
              $completed_data = json_decode($getForm[0]->completed_status, true);
              @endphp
                <div class="row">
                  @php
                      foreach($completed_data as $status => $data) {
                        @endphp
                            <div class="form-group">
                                <label class="col-md-2 control-label">{{ ucwords(str_replace("_", " ", $status))  }} by:</label>
                                @php
                                $Names = array();
                                    foreach($data as $inner) {
                                        foreach($data as $key => $updated_by) {
                                            if(!in_array($updated_by, $Names, true)) {
                                                array_push($Names, $updated_by['name']);
                                            }
                                        }
                                    }
                                    $uniqueNames = array_unique($Names);
                                    @endphp
                                        <div style="padding: 8px 16px;font-size: 14px;color: #000000a6;" class="col-md-8">
                                    @php
                                        foreach($uniqueNames as $name) {
                                            @endphp
                                            <span>{{ $name }} -</span>
                                            @php    
                                        }
                                    @endphp
                                    </div>
                            </div>
                        @php
                      }
                  @endphp
                </div>                
              @php
            }
        @endphp

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
<script>

    $('#status').change(function(){

        var status = this.value;

        if(status == "3" || status == "4"){
            $('.reasonDiv').css('display', 'block');
            document.getElementById('reason').required = true
            console.log(document.getElementById('reason'))

        }else{
            $('.reasonDiv').css('display', 'none');
            document.getElementById('reason').required = false
        }
    })
    
    $('#facility_id').change(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
                
        var facility_id = $(this).val();
        var sendata = {id : facility_id}

         $.ajax({
          url : '{{route('admin.getfacility')}}',
          method : 'post',
          data : sendata,
          success : function(data){
           var res = JSON.parse(data)
           console.log(res[0])
           console.log(res[0].district)
           $('#district').val(res[0].district)
           $('#sub_district').val(res[0].subdistrict)
           $('#inspector').val(res[0].facility_manager)
          }
      });
    });


    function need_khilafah(){
        var labour_amount = !isNaN(parseFloat($('#labour_amount').val())) ? parseFloat($('#labour_amount').val()):0;
        var travelling_time = !isNaN(parseFloat($('#travelling_time').val())) ? parseFloat($('#travelling_time').val()):0;
        var travelling_cost = !isNaN(parseFloat($('#travelling_cost').val())) ? parseFloat($('#travelling_cost').val()):0;
        var desludge_delive = !isNaN(parseFloat($('#desludge_delive').val())) ? parseFloat($('#desludge_delive').val()):0;
        var accomodation = !isNaN(parseFloat($('#accomodation').val())) ? parseFloat($('#accomodation').val()):0;
        var material_vat_exempt = !isNaN(parseFloat($('#material_vat_exempt').val())) ? parseFloat($('#material_vat_exempt').val()):0;
        var material_used_amount = !isNaN(parseFloat($('#material_used_amount').val())) ? parseFloat($('#material_used_amount').val()):0;


        var vat_check = $('#vat_check').val();
        if(vat_check == 0){
            alert('Please Select One Option from Vat Registered OR Not');
            $('#vat_check').css('border','1px solid red')
            return false;
        }else if(vat_check == 1){
            $('#vat_check').css('border','1px solid #ccc');

            var amoun_before_vat = labour_amount + travelling_time + travelling_cost + desludge_delive + accomodation + material_used_amount;
                        //calculating the all amount with vat applicable
            var calc_only_vat = amoun_before_vat * 1.15;
            //adding to vat exempt amount man
            var total =  calc_only_vat + material_vat_exempt;
            //Putting the total amount to be included for the price
            $('#price').val(total.toFixed(2));
            $('#amount_inc_vat').val(total.toFixed(2));
            //adding amount before vat with exempt material to show total amount before vat
            var total_exmpt_material = amoun_before_vat + material_vat_exempt;
            $('#amount_exc_vat').val(total_exmpt_material);

        }else{
            $('#vat_check').css('border','1px solid #ccc');

            var amoun_before_vat = labour_amount + travelling_time + travelling_cost + desludge_delive + accomodation + material_used_amount;

            //adding to vat exempt amount man
            var total =  amoun_before_vat + material_vat_exempt;
            //Putting the total amount to be included for the price
            $('#price').val(total.toFixed(2));
            $('#amount_inc_vat').val('');
            $('#amount_exc_vat').val(total.toFixed(2));
        }
    }

</script>
@endsection
