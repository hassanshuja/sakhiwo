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
    table-layout: fixed;
    width: 100%;
    white-space: nowrap;
	}
	td{
		font-size:11px;
		color:black;
    width:200px;
    font-family: serif;
	}
	th:not(:first-child){

    transform: rotate(-90deg);
    transform-origin: 48% 67%;
    width:200px;
    font-size: 13px;
    font-family: serif;
	}
  th:first-child, td:first-child{
    width:400px;
    font-family: serif;
  }

</style>

<div class="container">
        <div class="row">
            <div class="col-sm-5 pull-left">
            	<h1>
                Total Report
            	</h1>
            </div><!--col-->
        </div><!--row-->
        <div class="row">
{{--     	{!! Form::open(['url' => 'admin/search_vetting', 'class' => 'form-horizontal']) !!}
         <!-- Email -->
	        <div class="form-group">
		        {!! Form::label('status', 'Status:', ['class' => 'col-lg-2 control-label searchtxt align-left']) !!}
		            <div class="col-lg-3">
		                @php 
		                $status[''] = 'Select Status';
		                @endphp
		                {!!  Form::select('status', $status,  $value = Input::old('status') ? Input::old('status') : '', ['class' => 'form-control selectpicker searchtxt', 'data-live-search' => "true" , 'required' ]) !!}
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

    	{!! Form::close() !!} --}}


    </div><!--row-->
    @if(count($mid_array)> 0)
                  <div class="table-responsive">

                  		<a href="{{route('admin.excel_total')}}" style="color:#fff"><button class="btn btn-success pull-right" >
                  		
                  			Download AS XLS
                  			<i class="fa fa-file-excel-o" aria-hidden="true"></i>
                  		
                  	</button> </a>
                  	
                    <table class="table table-responsive table-striped table-bordered table-condensed table-hover" id="tb">
                        <thead>
	                        <tr class="total-ignore">
                <th height="294" >Contractors</th>
								<th height="294" >Water Treatment</th>
								<th height="294" >WATER PUMPS</th>
								<th height="294" >WATER CARTING</th>
								<th height="294" >UPS</th>
                <th height="294" >ST LUCY WATER CARTING</th>
                <th height="294" >SOLAR SYSTEM</th>
								<th height="294" >SEWER DESLUDGING</th>
                <th height="294" >REFURBISHMENT AND UPGRADES - GB</th>
								<th height="294" >REFURBISHMENT AND UPGRADES - EM</th>
								<th height="294" >REFRIGERATION</th>
								<th height="294" >PREVENTIVE MAINT</th>
                <th height="294" >POWER GENERATORS</th>
								<th height="294" >PLUMBING</th>
								<th height="294" >MORTUARY EQUIPMENT</th>
                <th height="294" >MEDICAL GAS INSTALLATION</th>
                <th height="294" >MADWALENI HOSPITAL SEWER DESLUDG</th>
								<th height="294" >LT ELECTRICAL</th>
                <th height="294" >LAUNDRY EQUIPMENT</th>
                <th height="294" >KITCHEN EQUIPMENT</th>
                <th height="294" >INDUSTRIAL AIR-CONDITIONING</th>
                <th height="294" >HV - ELECTRICAL</th>
                <th height="294" >GENERAL BUILDING</th>
                <th height="294" >GARDEN SERVICES</th>
                <th height="294" >FRERE GEN BUILDI</th>
                <th height="294" >FIRE PREVENTION AND PROTECTION S</th>
                <th height="294" >ELECTRONIC SYSTEMS</th>
                <th height="294" >DOMESTIC AIR CONDITIONING</th>
                <th height="294" >COMPRESSORS AND VACUUM PUMPS</th>
                <th height="294" >CLINIC WATER PUMPS</th>
                <th height="294" >CLEANING & PEST CONTROL</th>
                <th height="294" >BOILERS, STEAM LINES AND CALORIF</th>
                <th height="294" >AUTOCLAVES, STERILIZATION EQUIPM</th>

	                        </tr>
                        </thead>
                        <tbody>

                        @php 
                        $i=0;

                         @endphp
                         @foreach ($mid_array as $index => $res)
                            <tr>
                              <td>{{$res['contractor_name']}}</td>
                            @php 

                            while($i < 32) { @endphp 
                                @if(isset($res[$problem_type[$i]->name]))
                                  <td>{{$res[$problem_type[$i]->name.'-price']}}</td>
                                @else
                                  <td>0</td>
                                @endif
                          @php 
                          $i++;

                        }
                          $i=0;
                         @endphp 
                        
                            </tr>
                        @endforeach
                                                
                        </tbody>
                    </table>
                </div>
            @endif
            
           
            </div><!--col-->
</div><!--container-->
<script type="text/javascript">
 


$('#tb').tableTotal({
  totalRow: true,
  totalCol: true,
});
</script>
 @endsection;