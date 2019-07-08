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
@if(session()->has('error'))
<div class="alert alert-danger">
    {{ session()->get('error') }}
</div>
@endif

@if($errors->any())
<div class="alert alert-danger">
    <h4>{{$errors->first()}}</h4>
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
                DFM Report
            	</h1>
            </div><!--col-->
        </div><!--row-->
        <div class="row">
    	{!! Form::open(['url' => 'admin/search_filter_dfm', 'class' => 'form-horizontal']) !!}
         <!-- Email -->
	        <div class="form-group">
		        {!! Form::label('problem_type', 'Problem type:', ['class' => 'col-lg-2 control-label searchtxt align-left']) !!}
		            <div class="col-lg-3">
		                @php 
		                $problem_type[''] = 'Select Problem Type';
		                @endphp
		                {!!  Form::select('problem_type', $problem_type,  Input::old('problem_type'), ['class' => 'form-control selectpicker searchtxt', 'data-live-search' => "true" , 'required' ]) !!}
		            </div>
		    </div>
		    <div class="form-group">
					{!! Form::label('contractor_id', 'Contractor Name :', ['class' => 'col-lg-2 control-label searchtxt align-left']) !!}
		            <div class="col-lg-3">
		                @php 
		                $contractors[''] = 'Select Contractor Name';
		                @endphp
		                {!!  Form::select('contractor_id', $contractors,  $value = Input::old('contractor_id') ? Input::old('contractor_id') : '', ['class' => 'form-control selectpicker searchtxt', 'data-live-search' => "true" , 'required' ]) !!}
		            </div>
			</div>
			<div class="form-group">

		            {!! Form::label('district', 'District Name :', ['class' => 'col-lg-2 control-label searchtxt align-left']) !!}
		            <div class="col-lg-3">
		                @php 
		                $district[''] = 'Select District Name';
		                @endphp
		                {!!  Form::select('district', $district,  $value = Input::old('district') ? Input::old('district') : '', ['class' => 'form-control selectpicker', 'data-live-search' => "true" , 'required' ]) !!}
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
	              	{!! Form::open(['url' => 'admin/downloadDFMxlsx', 'class' => 'form-horizontal pull-right']) !!}
                  	{{ Form::checkbox('capturing', '1', '0', ['id' => 'capturing_1' ]) }} Capturing :
                  	{{ Form::checkbox('approved', '2', '0', ['id' => 'approved_2' ]) }} Approved : 
                  	{{ Form::checkbox('reject_internal', '3', '0', ['id' => 'reject_internal_3' ]) }} Rejected Internally : 
                  	{{ Form::checkbox('reject_vetting', '4', '0', ['id' => 'reject_vetting_4' ]) }} Reject After Vetting : 
                  	{{ Form::checkbox('corrected', '5', '0', ['id' => 'corrected_5' ]) }} Corrected : 
                  	{{ Form::checkbox('vetted', '6', '0', ['id' => 'vetted_6' ]) }} Vetted : 
                  	{{ Form::checkbox('invoiced', '7', '0', ['id' => 'invoiced_7' ]) }} Invoiced : 
          			{{ Form::hidden('problem_type', Input::old('problem_type')) }}
          			{{ Form::hidden('contractor_id', Input::old('contractor_id')) }}
          			{{ Form::hidden('district', Input::old('status')) }}
                  	<button type="submit" class="btn btn-success">
                  		Download AS XLS 
                  		<i class="fa fa-file-excel-o" aria-hidden="true"></i>
                  	</button>
                  	{!! Form::close() !!}

                  	{{-- {!! Form::open(['url' => 'admin/downloadpdf', 'class' => 'form-horizontal pull-right']) !!}
                  	
                  			{{ Form::hidden('status', Input::old('status')) }}
                  			{{ Form::hidden('contractor_id', Input::old('status')) }}
                  			{{ Form::hidden('district', Input::old('status')) }}
                  	<button class="btn btn-default " >
                  			Download AS Pdf 
                  			<i class="fa fa-file-pdf-o" style="color:red"></i>
                  	</button>

                  	{!! Form::close() !!} --}}
                  	
                    <table class="table table-responsive table-striped table-bordered table-condensed table-hover">
                        <thead>
	                        <tr>
								<th style="width: 5.2%;">Contractor</th>
								<th >Job Card Number</th>
								<th >Problem Type</th>
								<th >Facility Name</th>
								<th class='capturing_1'>Capturing</th>
								<th class='approved_2'>Approved</th>
								<th class='reject_internal_3'>Rejected Internally</th>
								<th class='reject_vetting_4'>Reject After Vetting By Client</th>
								<th class='corrected_5'>Corrected</th>
								<th class='vetted_6'>Vetted</th>
								<th class='invoiced_7'>Invoiced</th>
	                        </tr>
                        </thead>
                        <tbody>

                         @foreach ($search as $index => $res)
                            <tr class="status-{{$res->status}}">
								<td>{{$res->contractor_name}}</td>
								<td>{{$res->job_card_number}}</td>
								<td>{{$res->facility_name}}</td>
								<td>{{$res->problem_type}}</td>
							@if($res->status == 1)
								<td class='capturing_1'>{{$res->price}}</td>
							@else
								<td class='capturing_1'>0</td>
							@endif
							@if($res->status == 2)
								<td  class='approved_2'>{{$res->price}}</td>
							@else
								<td  class='approved_2'>0</td>
							@endif
							@if($res->status == 3)
								<td class='reject_internal_3'>{{$res->price}}</td>
							@else
								<td class='reject_internal_3'>0</td>
							@endif
							@if($res->status == 4)
								<td class='reject_vetting_4'>{{$res->price}}</td>
							@else
								<td class='reject_vetting_4'>0</td>
							@endif
							@if($res->status == 5)
								<td class='corrected_5'>{{$res->price}}</td>
							@else
								<td class='corrected_5'>0</td>
							@endif
							@if($res->status == 6)
								<td class='vetted_6'>{{$res->price}}</td>
							@else
								<td class='vetted_6'>0</td>
							@endif
							@if($res->status == 7)
								<td class='invoiced_7'>{{$res->price}}</td>
							@else
								<td class='invoiced_7'>0</td>
							@endif
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
	$(document).on('click','#capturing_1, #approved_2, #reject_internal_3,#reject_vetting_4, #corrected_5, #vetted_6, #invoiced_7', function(){
		var id = $(this).attr('id')
		var num = id.split('_').pop();
		$('.'+id).toggle();	
		if($(this).prop('checked')){
			$('.status-'+num).show()
			$(this).val('1')
		}else{
			$('.status-'+num).hide()
			
			$(this).val('0')
		}
	});

	$('.capturing_1, .approved_2, .reject_internal_3,.reject_vetting_4, .corrected_5, .vetted_6, .invoiced_7').hide()

	$(document).on('click', '#hide_unprocessed', function(){
		$('.status-0').toggle();
	})
</script>


@endsection;