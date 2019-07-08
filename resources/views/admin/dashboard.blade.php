@extends('admin.layouts.admin')

@section('content')

<style>
    .fa {
        opacity: 0.4;
    }
</style>
    <!-- page content -->
    <!-- top tiles -->

    <div id="page-wrapper" style="min-height: 229px;">
            <div class="row">
                <div class="col-lg-12">
                    <h2 class="page-header">Dashboard</h2>
                </div>
                <!-- /.col-lg-12 -->
            </div>

            <div class="row">
                @php 
                    $i=0;
                    $processed_claims = 0;
                    $approved_claims = 0;
                    $checking = 0;
                @endphp
                
                @foreach($prices as $specific)
                    @if($specific->status == '6' || $specific->status == '4' || $specific->status == '7')
                        @php 
                        $processed_claims +=   $specific->quotesCount; 
                        @endphp
                    @endif

                    @if($specific->status == '6' || $specific->status == '7')
                        @php $approved_claims +=   $specific->quotesCount; @endphp
                    @endif
                @endforeach

                            <div class="col-lg-3 col-md-6">
                                <div class="panel panel-primary ">
                                    <div class="panel-heading">
                                        <div class="row" style="color: #fff;">
                                            <div class="col-xs-9">
                                                @foreach($prices as $check)
                                                    @if($check->status == 2)
                                                    @php $checking = 1; @endphp
                                                    <div class="huge"><strong><h3>R {{number_format($check->price)}}</h3></strong></div>
                                                    <div><strong><h5>Ready For Vetting</h5></strong></div>
                                                    @endif
                                                @endforeach
                                                @if($checking == 0)
                                                    
                                                    <div class="huge"><strong><h3>R 0</h3></strong></div>
                                                    <div><strong><h5>Ready For Vetting</h5></strong></div>
                                                @endif
                                                @php $checking = 0; @endphp
                                            </div>
                                            <div class="col-xs-3">
                                                <i class="fa fa-shopping-bag fa-5x"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="#">
                                        <div class="panel-footer">
                                            <span class="pull-left">View Details</span>
                                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                            <div class="clearfix"></div>
                                        </div>
                                    </a>
                                </div>
                            </div>

                                                        <div class="col-lg-3 col-md-6">
                                <div class="panel" style="background: #5cb85c">
                                    <div class="panel-heading">
                                        <div class="row" style="color: #fff;">
                                            <div class="col-xs-9">
                                                @foreach($prices as $check)
                                                    @if($check->status == 6)
                                                    @php $checking = 1; @endphp
                                                    <div class="huge"><strong><h3>R {{number_format($check->price)}}</h3></strong></div>
                                                    <div><strong><h5>Vetted Amounts</h5></strong></div>
                                                    @endif
                                                @endforeach
                                                @if($checking == 0)
                                                    
                                                    <div class="huge"><strong><h3>R 0</h3></strong></div>
                                                    <div><strong><h5>Vetted</h5></strong></div>

                                                @endif
                                                @php $checking = 0; @endphp
                                            </div>
                                            <div class="col-xs-3">
                                                <i class="fa fa-bar-chart fa-5x"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="#">
                                        <div class="panel-footer">
                                            <span class="pull-left">View Details</span>
                                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                            <div class="clearfix"></div>
                                        </div>
                                    </a>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-6">
                                <div class="panel" style="background: #d9534f">
                                    <div class="panel-heading">
                                        <div class="row" style="color: #fff;">
                                            <div class="col-xs-9">
                                                @foreach($prices as $check)
                                                    @if($check->status == 3)
                                                    @php $checking = 1; @endphp
                                                    <div class="huge"><strong><h3>R {{number_format($check->price)}}</h3></strong></div>
                                                    <div><strong><h5>Rejected Internally</h5></strong></div>
                                                    @endif
                                                @endforeach
                                                @if($checking == 0)
                                                    
                                                    <div class="huge"><strong><h3>R 0</h3></strong></div>
                                                    <div><strong><h5>Rejected Internally</h5></strong></div>

                                                @endif
                                                @php $checking = 0; @endphp
                                            </div>
                                            <div class="col-xs-3">
                                                <i class="fa fa fa-user-plus fa-5x"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="#">
                                        <div class="panel-footer">
                                            <span class="pull-left">View Details</span>
                                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                            <div class="clearfix"></div>
                                        </div>
                                    </a>
                                </div>
                            </div>

                    <div class="col-lg-3 col-md-6">
                                
                                <div class="panel panel-primary ">
                                    <div class="panel-heading">
                                        <div class="row" style="color: #fff;">
                                            <div class="col-xs-9">
                                                <div class="huge"><strong><h3>{{$approved_claims}}</h3></strong></div>
                                                <div><strong><h5>Approved Claims</h5></strong></div>
                                            </div>
                                            <div class="col-xs-3">
                                                <i class="fa fa-user-plus fa-5x" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="#">
                                        <div class="panel-footer">
                                            <span class="pull-left">View Details</span>
                                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                            <div class="clearfix"></div>
                                        </div>
                                    </a>
                                </div>
                            </div>

                             <div class="col-lg-3 col-md-6">
                                <div class="panel panel-primary ">
                                    <div class="panel-heading">
                                        <div class="row" style="color: #fff;">
                                            <div class="col-xs-9">
                                                @foreach($prices as $check)
                                                    @if($check->status == 5)
                                                    @php $checking = 1; @endphp
                                                    <div class="huge"><strong><h3>R {{number_format($check->price)}}</h3></strong></div>
                                                    <div><strong><h5>Corrections Ready for vetting</h5></strong></div>
                                                    @endif
                                                @endforeach
                                                @if($checking == 0)
                                                    
                                                    <div class="huge"><strong><h3>R 0</h3></strong></div>
                                                    <div><strong><h5>Corrections Ready for vetting</h5></strong></div>
                                                @endif
                                                @php $checking = 0; @endphp
                                            </div>
                                            <div class="col-xs-3">
                                                <i class="fa fa-support fa-5x"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="#">
                                        <div class="panel-footer">
                                            <span class="pull-left">View Details</span>
                                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                            <div class="clearfix"></div>
                                        </div>
                                    </a>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-6">
                                <div class="panel" style="background: #5cb85c">
                                    <div class="panel-heading">
                                        <div class="row" style="color: #fff;">
                                            <div class="col-xs-9">
                                                @foreach($prices as $check)
                                                    @if($check->status == 7)
                                                    @php $checking = 1; @endphp
                                                    <div class="huge"><strong><h3>R {{number_format($check->price)}}</h3></strong></div>
                                                    <div><strong><h5>Invoiced ToDate</h5></strong></div>
                                                    @endif
                                                @endforeach
                                                @if($checking == 0)
                                                    
                                                    <div class="huge"><strong><h3>R 0</h3></strong></div>
                                                    <div><strong><h5>Invoiced ToDate</h5></strong></div>

                                                @endif
                                                @php $checking = 0; @endphp
                                            </div>
                                            <div class="col-xs-3">
                                                <i class="fa fa fa-user-plus fa-5x"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="#">
                                        <div class="panel-footer">
                                            <span class="pull-left">View Details</span>
                                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                            <div class="clearfix"></div>
                                        </div>
                                    </a>
                                </div>
                            </div>

                             <div class="col-lg-3 col-md-6">
                                <div class="panel" style="background: #d9534f">
                                    <div class="panel-heading">
                                        <div class="row" style="color: #fff;">
                                            <div class="col-xs-9">
                                                @foreach($prices as $check)
                                                    @if($check->status == 4)
                                                    @php $checking = 1; @endphp
                                                    <div class="huge"><strong><h3>R {{number_format($check->price)}}</h3></strong></div>
                                                    <div><strong><h5>Rejected After Vetting By Client</h5></strong></div>
                                                    @endif
                                                @endforeach
                                                @if($checking == 0)
                                                    
                                                    <div class="huge"><strong><h3>R 0</h3></strong></div>
                                                    <div><strong><h5>Rejected After Vetting By Client</h5></strong></div>

                                                @endif
                                                @php $checking = 0; @endphp
                                            </div>
                                            <div class="col-xs-3">
                                                <i class="fa fa fa-user-plus fa-5x"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="#">
                                        <div class="panel-footer">
                                            <span class="pull-left">View Details</span>
                                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                            <div class="clearfix"></div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                    
                           

                 <div class="col-lg-3 col-md-6">
                                <div class="panel panel-primary ">
                                    <div class="panel-heading">
                                        <div class="row" style="color: #fff;">
                                            <div class="col-xs-9">
                                                <div class="huge"><strong><h3>{{$processed_claims}}</h3></strong></div>
                                                <div><strong><h5>Processed Claims</h5></strong></div>
                                            </div>
                                            <div class="col-xs-3">
                                                <i class="fa fa-user-plus fa-5x" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="#">
                                        <div class="panel-footer">
                                            <span class="pull-left">View Details</span>
                                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                            <div class="clearfix"></div>
                                        </div>
                                    </a>
                                </div>
                            </div>

        </div>
    <!-- /top tiles -->
</div>
    <br />
<div id="container" class="col-md-6" style="margin-top: 30px;padding: 20px;min-width: 310px; height: 600px;" data-highcharts-chart="0"></div>

<div id="container" class="col-md-6" style="margin-top: 30px;padding: 20px;min-width: 310px; height: 600px;" data-highcharts-chart="0"></div>


<script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>
 <script type="text/javascript">
$(function() {
     var chart = new Highcharts.Chart(<?php echo json_encode($chartArray) ?>);
  $('#container').chart;
});
</script>

   
@endsection

{{-- @section('scripts')
    @parent
    {{ Html::script(mix('assets/admin/js/dashboard.js')) }}
@endsection

@section('styles')
    @parent
    {{ Html::style(mix('assets/admin/css/dashboard.css')) }}
@endsection --}}
