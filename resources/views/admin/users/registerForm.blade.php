@extends('admin.layouts.admin')


@section('content')
    <div>
        <div class="container">
            <div class="animate form">
                <section class="login_content">
                    {{ Form::open(['route' => 'admin.create']) }}
                        <h1>{{ __('views.auth.register.header') }}</h1>
                        <div class="col-md-3">
                            <label for="name" class="control-label">User Name</label>
                        </div>
                        <div class="col-md-9">
                            
                            <input type="text" name="name" id="name" class="form-control"
                                   placeholder="{{ __('views.auth.register.input_0') }}"
                                   value="{{ old('name') }}" required autofocus/>
                        </div>
                        <div class="col-md-3">
                            <label for="email" class="control-label">Email</label>
                        </div>
                        <div class="col-md-9">
                            
                            <input type="email" id="email" name="email" class="form-control"
                                   placeholder="{{ __('views.auth.register.input_1') }}"
                                   required/>
                        </div>
                        <div class="col-md-3">
                            <label for="password" class="control-label">Password</label>
                        </div>
                        <div class="col-md-9">
                            
                            <input type="password" id="password" name="password" class="form-control"
                                   placeholder="{{ __('views.auth.register.input_2') }}"
                                   required=""/>
                        </div>
                        <div class="col-md-3">
                            <label for="password_confirmation" class="control-label">Confirm Password</label>
                        </div>
                        <div class="col-md-9">
                            
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control"
                                   placeholder="{{ __('views.auth.register.input_3') }}"
                                   required/>
                        </div>
                        

                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if (!$errors->isEmpty())
                            <div class="alert alert-danger" role="alert">
                                {!! $errors->first() !!}
                            </div>
                        @endif

                        <div>
                            <button type="submit"
                                    class="btn btn-default submit">{{ __('views.auth.register.action_3') }}</button>
                        </div>

                        <div class="clearfix"></div>

                        
                    {{ Form::close() }}
                </section>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    @parent

    {{ Html::style(mix('assets/auth/css/register.css')) }}
@endsection
