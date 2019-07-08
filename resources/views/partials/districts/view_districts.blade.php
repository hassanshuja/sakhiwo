@extends('admin.layouts.admin')

{{-- @section('title', __('views.admin.quotes.index.title')) --}}

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
<div class="container">
    <div id="success" class="alert alert-success hidden">
      <strong>Success!</strong> Updated Successfully.
    </div>

    <div id="failed" class="alert alert-danger hidden">
      <strong>Sorry!</strong> Unable to Update Something Went Wrong.
    </div>

    {{-- For adding Districts --}}
    <div id="success_add" class="alert alert-success hidden">
      <strong>Success!</strong> District Added Successfully.
    </div>

    <div id="failed_add" class="alert alert-danger hidden">
      <strong>Sorry!</strong> Unable to Add District Something Went Wrong.
    </div>

    {{-- end adding districts --}}

        <div class="row">
            <div class="col-sm-5">
                <h1 >
                  District Management
                </h1>
            </div><!--col-->
        </div><!--row-->
        <div class="row">

            <div class="pull-right" style="margin-right: 14px;
    background: #f7f7f7;
    border: 1px solid #ccc;
    padding: 9px;">
            <button id="call_add" class="btn btn-default">
                <i class="fa fa-plus" aria-hidden="true"></i>
                ADD District
            </button>
            </div>
        </div>
        </div><!--row-->
            <div class="col">
                <div id="add_div" class="form-group hidden">
                  {!! Form::label('district', 'Disctrict :', ['class' => 'col-lg-2 control-label']) !!}

                    <div class="col-lg-3">
                        {!!  Form::text('district', '', ['class' => 'form-control ',  'required' ]) !!}
                    </div>
                    <div class="col-lg-3">
                        <button id="add" class="btn btn-primary">Add</button>
                        &nbsp;
                        <button id="cancel" class="btn btn-primary">Cancel</button>
                    </div>
                
                </div>
                <div class="table-responsive tablequotes">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>S.No</th>
                            <th>District</th>
                            @if(\Auth::user()->hasRole('administrator'))
                            <th>Delete</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                          @if(count($datas) > 0)
                         @foreach ($datas as $index => $data)

                            <tr data-id="{{$data->id}}">
                                <td>{{ ++$index}}</td>
                                <td data-field='name'">{{ $data->name }}</td>
                                @if(\Auth::user()->hasRole('administrator'))
                                <td><a class="but btn btn-danger" href="{{route('admin.deleteDistrict', [$data->id])}}">Delete</a></td>
                                 @endif
                            </tr>
                        @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div><!--col-->
            
        @if(isset($datas) && count($datas) > 0)
        
        {{ $datas->links() }}
        Results Found {{ $datas->total() }}
        @endif
</div><!--card-->
<script type="text/javascript" src="{{asset('assets/admin/js/table-edits.min.js')}}"></script>

<script>

    $("table tr").editable({

  // enable keyboard support
  keyboard: true,

  // double click to start editing
  dblclick: true,

  // enable edit buttons
  button: true,

  // CSS selector for edit buttons
  buttonSelector: ".edit",

  // uses select dropdown instead of input field
  dropdowns: {},

  // maintains column width when editing
  maintainWidth: true,

  // callbacks for edit, save and cancel actions
  edit: function(values) {
   
  },
  save: function(values) {

    var id = $(this).data('id');
    values['id'] = id;
    console.log(values);
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
    var urls = '{{url('admin/editdistrict')}}' 
    $.post(urls, values, function(data){
        var res = JSON.parse(data);
        if(res.success == true){
            $('#success').removeClass('hidden')
             setTimeout(function(){
                $('#success').addClass('hidden')
            },3000)
        }else{
            $('#failed').removeClass('hidden')
            setTimeout(function(){
                $('#failed').addClass('hidden')
            },3000)
        }
    });
  },
  cancel: function(values) {}
  
});

$('#call_add').click(function(){
    $('#add_div').removeClass('hidden');
})

$('#cancel').click(function(){
    $('#add_div').addClass('hidden')
})

$('#add').click(function(){

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

    var district = $('#district').val();
    if(district == ''){
        alert('Error! Please Insert Some Value')
    }

    var data = {district: district};
    var urls = '{{url('admin/add_district')}}' 
    $.post(urls, data, function(data){
        var res = JSON.parse(data);
        if(res.success_add == true){
            $('#success_add').removeClass('hidden')
             setTimeout(function(){
                $('#success_add').addClass('hidden')
                $('#add_div').addClass('hidden')
                $('#district').val('')
            },3000)
        }else{
            $('#failed_add').removeClass('hidden')
            setTimeout(function(){
                $('#failed_add').addClass('hidden')
            },3000)
        }
    })
})
</script>
@endsection