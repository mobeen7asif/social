@extends('master')

@section('title')
    Welcome!

@endsection

@section('content')

    <div class="row">
        <div class="col-md-6">
            <h3>Sign Up</h3>
            <form action="{{url('/')}}/signup" method="post">
                <div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
                    <label for="email">Your Email</label>
                    <input class="form-control" type="email" name="email" id="email" value="{{old('email')}}">
                </div>

                <div class="form-group {{ $errors->has('first_name') ? 'has-error' : ''}}">
                    <label for="first_name">First Name</label>
                    <input class="form-control" type="text" name="first_name" id="first_name" value="{{old('first_name')}}">
                </div>

                <div class="form-group" {{ $errors->has('password') ? 'has-error' : ''}}>
                    <label for="password">Password</label>
                    <input class="form-control" type="password" name="password" id="password" value="{{old('password')}}">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
                <input type="hidden" name="_token" value="{{ Session::token() }}">
            </form>
        </div>

        <div class="col-md-6">
            <h3>Sign In</h3>
            <form action="{{url('/')}}/signin" method="post">
                <div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
                    <label for="email">Your Email</label>
                    <input class="form-control" type="email" name="email" id="email" value="{{old('email')}}">
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group" {{ $errors->has('password') ? 'has-error' : ''}}>
                    <label for="password">Password</label>
                    <input class="form-control" type="password" name="password" id="password" value="{{old('password')}}">
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
                <input type="hidden" name="_token" value="{{ Session::token() }}">
            </form>
        </div>
    </div>

@endsection
