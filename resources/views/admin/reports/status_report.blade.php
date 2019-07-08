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
            <div>
            	<h1>
                Status Change Report
            	</h1>
            </div><!--col-->
        </div><!--row-->
        {{-- <div class="row">
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

    	</div><!--row--> --}}
    {{-- @if(count($search)> 0) --}}
                  <div class="table-responsive">
                  	{!! Form::open(['url' => 'admin/downloadStatusxlsx', 'class' => 'form-horizontal pull-right']) !!}
                  	

                  		<button type="submit" class="btn btn-success " >
                  		
                  			Download AS XLS 
                  			<i class="fa fa-file-excel-o" aria-hidden="true"></i>
                  		
                  	</button>
                  	{!! Form::close() !!}

                  	{{-- {!! Form::open(['url' => 'admin/downloadpdf', 'class' => 'form-horizontal pull-right']) !!}
                  	
                  			{{ Form::hidden('status', Input::old('status')) }}
                  			{{ Form::hidden('contractor_id', Input::old('contractor_id')) }}
                  			{{ Form::hidden('district', Input::old('district')) }}
                  	<button class="btn btn-default " >
                  			Download AS Pdf 
                  			<i class="fa fa-file-pdf-o" style="color:red"></i>
                  	</button>
					  {!! Form::close() !!}
					   --}}

					  {{-- $one = date_create('2018-11-30 11:39:58');
					  $two = date_create('2018-11-26 08:03:15');
					  
					  
					  $datediff = date_diff($one, $two);
					  //var_dump($datediff);
					  
					  echo $datediff->format('%a'); --}}

                    <table class="table table-responsive table-striped table-bordered table-condensed table-hover">
                        <thead>
	                        <tr>
								<th>Job Card</th>
								<th>Contractor</th>
								<th>Quote Amount</th>
								<th>Captured</th>
								<th>Approved</th>
								<th>Interanl Reject</th>
								<th>Corrected</th>
								<th>Vetting</th>
								<th>Rejected by Client</th>
								<th>Duration In days</th>
								<th>Invoiced date</th>
	                        </tr>
                        </thead>
                        <tbody>
						
                         @foreach ($statusChange as $index => $res)

                            <tr>
								<td>{{$res->job_card_number}}</td>
								<td>{{$res->contractor_name}}</td>
								<td>{{$res->price}}</td>
								<td>{{$res->capturing_date}}</td>
								<td>{{$res->approved_date}}</td>
								<td>{{$res->reject_internal_date}}</td>
								<td>{{$res->corrected_date}}</td>
								<td>{{$res->vetting_date}}</td>
								<td>{{$res->rejected_vetting_date}}</td>
								@if ($res->reject_vetting_date)
								{{-- @php $rejected = Carbon::parse($res->reject_vetting_date); @endphp	 --}}
								<td>{{ $res->capturing_date->diffInDays($res->reject_vetting_date) }}</td>
								@elseif ($res->vetting_date)
								<td>{{ $res->capturing_date->diffInDays($res->vetting_date) }}</td>
								@endif
								{{-- <td>{{ $res->quotation_no}}</td> --}}
								<td>{{$res->invoiced_date}}</td>
                            </tr>
                        @endforeach
                    
                        </tbody>
                    </table>
                </div>
            {{-- @endif --}}
            
            {{-- @if($paginating == 1) --}}
		        {{ $statusChange->links() }}
		        Results Found {{ $statusChange->total() }}
	        {{-- @endif --}}
            </div><!--col-->
</div><!--container-->
<script>
	$('#xldownload').click(function(){
        $.ajaxSetup({
          headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
                

         $.ajax({
          url : '{{route('admin.downloadStatusxlsx')}}',
          method : 'post',
          data : {},
          success : function(data){
          console.log(data)
          }
      });

    

    });


</script>
 @endsection;