
  <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<style>
	td, th{
		font-size:11px;
	}
	.foots{
		width:33%;
		float:left;
	}
</style>
  <div class="container" >
  	<div class="row">
  		<h1>Vetting Report</h1>
  		@php $i= 0; @endphp
		@foreach($search as $dist_name)

			@if($dist_name->district == $search[0]->district)
				@php $bhanda = 1; @endphp
			@else
				@php $bhanda = 0; break; @endphp
			@endif
			@php $i++ @endphp
		@endforeach
  		@if($bhanda ==  1)
  			<h3>{{$search[0]->district}}</h3>
  		@endif
  		
  	</div>
 <table class="table table-responsive table-striped table-bordered table-condensed table-hover">
                        <thead>
	                        <tr>
								<th style="width: 7%;">Date</th>
								<th >Supplier</th>
								<th style="width: 8%;" >Facility</th>
								<th >District</th>
								<th style="width: 5%;">Sub District</th>
								<th style="width: 6%;">Facility Nr</th>
								<th style="width: 5%;">Inspector</th>
								<th style="width: 6%;">Job card No</th>
								<th style="width: 10%;">Service Desc</th>
								<th style="width: 8%;">Quotation Nr</th>
								<th >Amount Exc VAT</th>
								<th>Amount Inc VAT</th>
	                        </tr>
                        </thead>
                        <tbody>
						@php

						$tot_exc = 0;
						$tot_price = 0;
						@endphp
                         @foreach ($search as $index => $res)
                         @php
                         $tot_exc += $res->amount_excluding_vat;
                         $tot_price += $res->price;
                         @endphp
                            <tr>
								<td style="width: 7%;">{{date('Y-m-d', strtotime($res->quotation_date))}}</td>
								<td style="width: 5%;">{{$res->contractor_name}}</td>
								<td style="width: 8%;">{{$res->facility_name}}</td>
								<td style="width: 5%;">{{$res->district}}</td>
								<td style="width: 5%;">{{$res->sub_district}}</td>
								<td style="width: 6%;">{{$res->facility_no}}</td>
								<td style="width: 6%;">{{$res->inspector_name}}</td>
								<td style="width: 8%;">{{$res->job_card_number}}</td>
								<td style="width: 10%;">{{$res->description}}</td>
								<td>{{$res->quotation_no}}</td>
								<td class="ex_vat">{{$res->amount_excluding_vat}}</td>
								<td class="price">{{$res->price}}</td>
                            </tr>
                        @endforeach
                    		<tr>
                    			<td colspan="10">Total</td>
                    			<td id="tot_vat_ex">{{$tot_exc}}</td>
                    			<td id="tot_price">{{$tot_price}}</td>
                    		</tr>
                    		
                        </tbody>
                    </table>

                    <div class="row" style="margin-top: 100px;margin-left:30px">
                    	<div>
                    		<div class="foots">
                    			Date:_______________________
                    		</div>
                    		<div class="foots">
                    			Signature:__________________________
                    		</div>
                    		<div class="foots">
                    			Initial & Surname:_______________________
                    		</div>
                    	</div>
                    </div>
                </div>
      

