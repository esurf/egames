@extends('layouts.app')

@section('content')
<div class="container" >
       <a class="navbar-brand" href="{{ url('/welcome') }}">
                    <img src="{{URL::asset('img/ESURF-04.PNG') }}" height="65" class="d-inline-block align-top" alt="">
                </a>
    <div class="row justify-content-center transbox">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">

                    <form method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-sm-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                         <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            </div>
                              <a class="btn btn-link" href="{{ route('register') }}">
                                    {{ __('Create New Account?') }}
                                </a>
                        </div>

  <hr>
                                        <div class="inline-ul text-center d-flex justify-content-center">
                                              <a class="p-2 m-2 fa-lg tw-ic" href="{{ route('social.oauth', 'facebook') }}"><i class="fa fa-facebook white-text"></i></a>
                                            <a class="p-2 m-2 fa-lg li-ic"  href="{{ route('social.oauth', 'google') }}"><i class="fa fa-google white-text"> </i></a>
                                          <!--   <a class="p-2 m-2 fa-lg tw-ic"><i class="fa fa-twitter white-text"></i></a>
                                            <a class="p-2 m-2 fa-lg li-ic"><i class="fa fa-linkedin white-text"> </i></a>
                                            <a class="p-2 m-2 fa-lg ins-ic"><i class="fa fa-instagram white-text"> </i></a> -->

                                        </div>
                    </form>

 <!--     <div class="form-group row">
          <label for="social" class="col-md-4 col-form-label text-md-right">{{ __('') }}</label>
        <div class="col-md-6 col-md-offset-2">
              <p class="lead text-center">Authenticate using your social network account from one of following providers</p>
                    <a href="{{ route('social.oauth', 'facebook') }}" class="btn btn-primary btn-block">
                        Login with Facebook
                    </a> -->
                    <!-- <a href="{{ route('social.oauth', 'twitter') }}" class="btn btn-info btn-block">
                        Login with Twitter
                    </a> -->
                  <!--   <a href="{{ route('social.oauth', 'google') }}" class="btn btn-danger btn-block">
                        Login with Google
                    </a> -->
                   <!--  <a href="{{ route('social.oauth', 'github') }}" class="btn btn-default btn-block">
                        Login with Github
                    </a> -->
       <!--              <hr>
        </div>
    </div> -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
