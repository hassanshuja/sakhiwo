@extends('layouts.welcome')

@section('content')
    <div class="title m-b-md">
        {{ config('app.name') }}
    </div>
    <div class="m-b-md">
        <br/>
        <img src="logo.png" width="900" height="304" title="Logo of a company" alt="Logo of a company" />
    </div>
@endsection