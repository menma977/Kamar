@extends('layouts.guest')

@section('content')
  <div class="login-box">
    <div class="login-logo">
      <a href="{{ route('welcome') }}"><b>SOE</b><small>Catalog</small></a>
    </div>

    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Sign in to start your session</p>

        <form action="{{ route('login') }}" method="post">
          @csrf
          <div class="input-group">
            <input id="_username" name="username" type="text" class="form-control @error('username') is-invalid @enderror" placeholder="Username" autofocus>
            <div class="input-group-append">
              <div class="input-group-text">
                <label for="_username" class="fas fa-envelope"></label>
              </div>
            </div>
          </div>
          <div class="mb-3">
            @error('username')
            <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>
          <div class="input-group">
            <input id="_password" name="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password">
            <div class="input-group-append">
              <div class="input-group-text">
                <label for="_password" class="fas fa-lock"></label>
              </div>
            </div>
          </div>
          <div class="mb-3">
            @error('password')
            <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>
          <div class="row">
            <div class="col-8">
              <div class="icheck-primary">
                <input id="remember_me" type="checkbox" class="form-checkbox" name="remember">
                <label for="remember_me">
                  Remember Me
                </label>
              </div>
            </div>
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block">Sign In</button>
            </div>
          </div>
        </form>

        @if (Route::has('password.request'))
          <p class="mb-1">
            <a href="{{ route('password.request') }}">I forgot my password</a>
          </p>
        @endif
        @if(Route::has('register'))
          <p class="mb-0">
            <a href="{{ route('register') }}" class="text-center">Register a new membership</a>
          </p>
        @endif
      </div>
    </div>
  </div>
@endsection
