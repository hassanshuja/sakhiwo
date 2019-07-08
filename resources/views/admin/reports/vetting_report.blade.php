@extends('admin.layouts.admin')

{{-- @section('title', __('views.admin.quotes.index.title')) --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/css/bootstrap-select.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/bootstrap-select.js"></script>
@section('content')
@if(session()->has('success'))
<div class="alert alert-success">
    {{ session()->get('success') }}
</div>
@endif

@if ($errors->any())
            <div class="form-group">
                <div class="alert alert-danger">
              {{ implode('', $errors->all(':message')) }}
            </div>
          </div>
            @endif
<style>
	table{
		background: #fff;
	}
	td{
		font-size:11px;
		color:black;
	}
	th{
		font-size:11px;
	}
</style>
<div class="container">
        <div class="row">
            <div class="col-sm-5 pull-left">
            	<h1>
                Vetting Report
            	</h1>
            </div><!--col-->
        </div><!--row-->
        <div class="row">
    	{!! Form::open(['url' => 'admin/search_vetting', 'class' => 'form-horizontal']) !!}
         <!-- Email -->
	        <div class="form-group">
		        {!! Form::label('status', 'Status:', ['class' => 'col-lg-2 control-label searchtxt pull-left ']) !!}
		            <div class="col-lg-3">
		                @php 
		                $status[''] = 'Select Status';
		                @endphp
		                {!!  Form::select('status', $status,  $value = Input::old('status') ? Input::old('status') : '', ['class' => 'form-control selectpicker searchtxt ', 'data-live-search' => "true" , 'required' ]) !!}
		            </div>
		    </div>
		    <div class="form-group">
					{!! Form::label('contractor_id', 'Contractor Name :', ['class' => 'col-lg-2 control-label searchtxt pull-left']) !!}
		            <div class="col-lg-3">
		                @php 
		                $contractors[''] = 'Select Contractor Name';
		                @endphp
		                {!!  Form::select('contractor_id', $contractors,  $value = Input::old('contractor_id') ? Input::old('contractor_id') : '', ['class' => 'form-control selectpicker searchtxt', 'data-live-search' => "true" , 'required' ]) !!}
		            </div>
			</div>
			<div class="form-group">

		            {!! Form::label('district', 'District Name :', ['class' => 'col-lg-2 control-label searchtxt pull-left']) !!}
		            <div class="col-lg-3">
		                @php 
		                $district[''] = 'Select District Name';
		                @endphp
		                {!!  Form::select('district', $district,  $value = Input::old('district') ? Input::old('district') : '', ['class' => 'form-control selectpicker', 'data-live-search' => "true" , 'required' ]) !!}
		            </div>
		    </div>
		    <div class="form-group">

		            {!! Form::label('vetting_dates', 'Vetting Date :', ['class' => 'col-lg-2 control-label searchtxt  pull-left']) !!}
		            <div class="col-lg-3">
		                
		                {!!  Form::date('vetting_dates', $value = Input::old('vetting_dates') ? Input::old('vetting_dates') : '', ['class' => 'form-control' ]) !!}
		            </div>
		    </div>
		    <div class="form-group" style="margin-left:230px">
		            <button type="submit" class="btn btn-default col-lg-2">
		                Search
		            </button>
		    </div>
	<div class="pull-right">
    	<button class="btn btn-danger" type="button" id="hide_unprocessed">Hide/Unhide Unprocessed</button>
    </div>
    	{!! Form::close() !!}

    </div><!--row-->
    @if(count($search)> 0)
                  <div class="table-responsive">
                  	{!! Form::open(['url' => 'admin/downloadxlsx', 'class' => 'form-horizontal pull-right']) !!}
                  	
                  			{{ Form::hidden('status', Input::old('status')) }}
                  			{{ Form::hidden('contractor_id', Input::old('contractor_id')) }}
                  			{{ Form::hidden('district', Input::old('district')) }}
                  		<button type="submit" class="btn btn-success " >
                  		
                  			Download AS XLS 
                  			<i class="fa fa-file-excel-o" aria-hidden="true"></i>
                  		
                  	</button>
                  	{!! Form::close() !!}

                  	{!! Form::open(['url' => 'admin/downloadpdf', 'class' => 'form-horizontal pull-right']) !!}
                  	
                  			{{ Form::hidden('status', Input::old('status')) }}
                  			{{ Form::hidden('contractor_id', Input::old('contractor_id')) }}
                  			{{ Form::hidden('district', Input::old('district')) }}
                  	<button class="btn btn-default " >
                  			Download AS Pdf 
                  			<i class="fa fa-file-pdf-o" style="color:red"></i>
                  	</button>
                  	{!! Form::close() !!}
                  	
                    <table class="table table-responsive table-striped table-bordered table-condensed table-hover">
                        <thead>
	                        <tr>
								<th style="width: 5.2%;">Vetting Date</th>
								<th >Supplier</th>
								<th >Facility</th>
								<th style="width: 5.2%;">District</th>
								<th>Sub District</th>
								<th style="width: 6%;">Facility Nr</th>
								<th>Inspector</th>
								<th style="width: 7%;">Job card No</th>
								<th>Service Desc</th>
								<th>Quotation Nr</th>
								<th>Amount Exc VAT</th>
								<th>Amount Inc VAT</th>
	                        </tr>
                        </thead>
                        <tbody>
						@php 
							$vettings = ['1' => 'capturing_date',
										'2' => 'approved_date',
										'3' => 'reject_internal_date',
										'4'=> 'reject_vetting_date',
										'5' => 'corrected_date',
										'6' => 'vetting_date',
										'7' => 'invoiced_date'
									];
						@endphp
                         @foreach ($search as $index => $res)

                            <tr class="status-{{$res->status}}">
                            	@if($res->status !=0)
                            	@php 
                            		$status_val = $vettings[$res->status];
                            	@endphp
								<td>{{date('Y-m-d H:i:s', strtotime($res->$status_val))}}</td>
								@else
								<td></td>
								@endif
								<td>{{$res->contractor_name}}</td>
								<td>{{$res->facility_name}}</td>
								<td>{{$res->district}}</td>
								<td>{{$res->sub_district}}</td>
								<td>{{$res->facility_no}}</td>
								<td>{{$res->inspector_name}}</td>
								<td>{{$res->job_card_number}}</td>
								<td>{{$res->description}}</td>
								<td>{{$res->quotation_no}}</td>
								<td>{{$res->amount_excluding_vat}}</td>
								<td>{{$res->price}}</td>
                            </tr>
                        @endforeach
                    
                        </tbody>
                    </table>
                </div>
            @endif
            
            @if($paginating == 1)
		        {{ $search->links() }}
		        Results Found {{ $search->total() }}
	        @endif
            </div><!--col-->
</div><!--container-->
<script>
	$('#pdf').click(function(){
        $.ajaxSetup({
          headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
                
        var status = $('#status').val();
        var contractor_id = $('#contractor_id').val();
        var district = $('#district').val();
        var sendata = {status : status, contractor_id: contractor_id, district: district}

         $.ajax({
          url : '{{route('admin.downloadpdf')}}',
          method : 'post',
          data : sendata,
          success : function(data){
          console.log(data)
          }
      });

    

    });

    $(document).on('click', '#hide_unprocessed', function(){
		$('.status-0').toggle();
	});


</script>
 @endsection;