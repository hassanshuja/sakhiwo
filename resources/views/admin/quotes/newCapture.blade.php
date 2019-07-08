@extends('admin.layouts.admin')
 
@section('content')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/css/bootstrap-select.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/bootstrap-select.js"></script>

<div class="well">

    {!! Form::open(['url' => 'admin/capturing', 'class' => 'form-horizontal']) !!}

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
                {!!  Form::select('vat_check', $vat_check , Input::old('vat_check'),['class' => 'form-control' ]) !!}
            </div>

            {!! Form::label('contractor_id', 'Contractor Name :', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-3">
                @php 
                $contractors[''] = 'Select Contractor Name';
                @endphp
                {!!  Form::select('contractor_id', $contractors, '', ['class' => 'form-control selectpicker', 'data-live-search' => "true" , 'required' ]) !!}
            </div>
        </div>
 
        <div class="form-group">
            {!! Form::label('job_card_no', 'Job No :', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-3">
                {!! Form::text('job_card_no', Input::old('job_card_no'), ['class' => 'form-control', 'placeholder' => 'Job Card Number']) !!}
            </div>

            {!! Form::label('sub_district', 'Sub Disctrict :', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-3">
                {!! Form::text('sub_district', Input::old('sub_district'), ['class' => 'form-control', 'placeholder' => 'Sub Disctrict']) !!}
            </div>
        </div>
 
        <div class="form-group">
            {!! Form::label('district', 'Disctrict :', ['class' => 'col-lg-2 control-label']) !!}

            <div class="col-lg-3">
                {!! Form::text('district', $value =  Input::old('disctrict') , ['class' => 'col-lg-3 form-control', 'placeholder' => 'District']) !!}
            </div>

            {!! Form::label('problem_type', 'Problem Type :', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-3">
                {{-- {!! Form::text('problem_type', $value = Input::old('problem_type'), ['class' => 'form-control', 'placeholder' => 'Problem Type']) !!} --}}
                @php 
                $problem_type[''] = 'Select Problem Type Name';
                @endphp
                {!!  Form::select('problem_type', $problem_type, '', ['class' => 'form-control selectpicker', 'data-live-search' => "true" , 'required' ]) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('facility_id', 'Facility Name :', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-3">
                @php 
                $facility['0'] = 'Select Facility Name';
                @endphp
                {!!  Form::select('facility_id', $facility,  '0', ['class' => 'form-control selectpicker', 'data-live-search' => "true" , "data-live-search-style"=>"startsWith", 'required' ]) !!}
            </div>
            {!! Form::label('facility_no', 'Facility No :', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-3">
                {!! Form::text('facility_no',$value = Input::old('facility_no'), ['class' => 'form-control', 'placeholder' => 'Facility No']) !!}
            </div>
            
        </div>
 
        <div class="form-group">
            {!! Form::label('inspector', 'District Facility Manager', ['class' => 'col-lg-2 control-label'] )  !!}

            <div class="col-lg-3">
                {!! Form::text('inspector', $value = Input::old('inspector'), ['class' => 'form-control', 'placeholder' => 'DFM']) !!}
               
            </div>
            {!! Form::label('quotation_no', 'Quotation No :', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-3">
                {!! Form::text('quotation_no', $value = Input::old('quotation_no'), ['class' => 'form-control', 'placeholder' => 'Quotation Number']) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('invoice_no', 'Invoice No :', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-3">
                {!! Form::text('invoice_no',$value = Input::old('invoice_no'), ['class' => 'form-control', 'placeholder' => 'Invoice No']) !!}
            </div>
            {!! Form::label('travelling_time', 'Travelling Time :', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-3">
                {!! Form::text('travelling_time', $value = Input::old('travelling_time_amount'), ['class' => 'form-control', 'placeholder' => 'Travelling Time', 'onkeyup' => 'need_khilafah()']) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('travelling_cost', 'Travelling Cost :', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-3">
                {!! Form::text('travelling_cost', $value = Input::old('travelling_cost'), ['class' => 'form-control', 'placeholder' => 'Travelling Cost', 'onkeyup' => 'need_khilafah()']) !!}
            </div>
            {!! Form::label('desludge_delive', 'Desludge & Water Delive :', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-3">
                {!! Form::text('desludge_delive', $value =  Input::old('desludge_delive'), ['class' => 'form-control', 'placeholder' => 'Desludge Delive', 'onkeyup' => 'need_khilafah()']) !!}
            </div>
        </div>
        
        <div class="form-group">
            {!! Form::label('accomodation', 'Accomodation :', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-3">
                {!! Form::text('accomodation', $value = Input::old('accomodation'), ['class' => 'form-control', 'placeholder' => 'Accomodation', 'onkeyup' => 'need_khilafah()']) !!}
            </div>
            {!! Form::label('material_vat_exempt', 'VAT Exempt Materials :', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-3">
                {!! Form::text('material_vat_exempt', $value = Input::old('material_vat_exempt'), ['class' => 'form-control', 'placeholder' => 'VAT Exempt Materials', 'onkeyup' => 'need_khilafah()']) !!}
            </div>
            
 

        </div>

        <div class="form-group">
            {!! Form::label('labour_amount', 'Labour Amount :', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-3">
                {!! Form::text('labour_amount', $value = Input::old('labour_amount'), ['class' => 'form-control', 'placeholder' => 'Labour Amount', 'onkeyup' => 'need_khilafah()']) !!}
            </div>
            {!! Form::label('material_used_amount', 'Material With VAT :', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-3">
                {!! Form::text('material_used_amount', $value = Input::old('material_used_amount'), ['class' => 'form-control', 'placeholder' => 'Material With VAT', 'onkeyup' => 'need_khilafah()']) !!}
            </div>
        </div>



        <div class="form-group">
            {!! Form::label('amount_exc_vat', 'Amount Before VAT :', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-3">
                {!! Form::text('amount_exc_vat',$value = Input::old('amount_exc_vat'), ['class' => 'form-control', 'placeholder' => 'Amount Exc(VAT)', 'readonly'=> 'true']) !!}
            </div>

            {!! Form::label('firs_status', 'Status :', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-3">
                  {!! Form::text('firs_status', 'Capturing', ['class' => 'form-control', 'placeholder' => 'Status', 'readonly']) !!}
                  <input type="hidden" name="status" value="1">
            </div>

        </div>

        <div class="form-group">
            {!! Form::label('quote_date', 'Quote Date :', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-3">
           
               
                {!! Form::date('quote_date', $value = Input::old('quotation_date'), ['class' => 'form-control datepicker', 'placeholder' => 'Quote Date']) !!}
            </div>

            {!! Form::label('price', 'Amount After VAT :', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-3">
                {!! Form::text('price', $value = Input::old('price'), ['class' => 'form-control', 'placeholder' => 'Price' ,'readonly'=> 'true']) !!}
            </div>
        </div>

         <div class="form-group " >
           
             {!! Form::label('description', 'Description', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-3">
                {!! Form::textarea('description', $value = Input::old('description'), ['class' => 'form-control', 'rows' => 3]) !!}
                
            </div>
             
        </div>

            <input type="hidden" name="dist_id" id="dist_id" value="" />
            <input type="hidden" name="sub_dist_id" id="sub_dist_id" value="" />
            <input type="hidden" name="inspector_id" id="inspector_id" value="" />
            <input type="hidden" name="new_quote"  value="1" />

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
           console.log(res)
           console.log(res[0].district)
           $('#district').val(res[0].district)
           $('#sub_district').val(res[0].subdistrict)
           $('#inspector').val(res[0].facility_manager)
           $('#dist_id').val(res.district_id)
           $('#sub_dist_id').val(res.sub_district_id)
           $('#inspector_id').val(res.inspector_id)
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
