@if(count($mid_array)> 0)	
<table class="table  table-striped table-bordered table-condensed table-hover" id="tb">
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
<th height="294" >Total</th>
</tr>
</thead>
<tbody>
@php 
$i=0;
$j=2;
@endphp
@foreach ($mid_array as $index => $res)
<tr>
<td>{{$res['contractor_name']}}</td>
@php while($i < 32) { @endphp 
@if(isset($res[$problem_type[$i]->name]))
<td>{{$res[$problem_type[$i]->name.'-price']}}</td>
@else

<td>0</td>
@endif
@php 
if($i == 31){
@endphp
  <td>=SUM({{'B'.$j.':'.'AG'.$j}})</td>
@php
$j++;
}
$i++;
}
$i=0;

@endphp 
</tr>
@endforeach  
<tr>
<td>Total</td>
@php 

$contractor_count = count($mid_array) + 1;

$increm = 'Z';
$inits = 'B';
for($i =$inits ; $i <= $increm ; $i++){
 
 if($inits == 'Z')
  {
    $inits = 'AA' ;
    $increm = 'AH';
  }

  if($i == 'AH'){
    $final_count = $contractor_count +1;
@endphp
    <td>=SUM({{'B'.$final_count}}:{{'AG'.$final_count}})</td>
@php
    break;
  }


 @endphp
<td>=SUM({{$i.'1'}}:{{$i.$contractor_count}})</td>
@php 

}

@endphp
</tr>          
</tbody>
</table>
@endif


