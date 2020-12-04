@extends('layouts.guest')

@section('content')
  <div class="login-box">
    <div class="login-logo">
      <a href="{{ route('welcome') }}"><b>SOE</b><small>Catalog</small></a>
    </div>

    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Register a new membership</p>

        <form action="{{ route('register') }}" method="post">
          @csrf
          <div class="input-group">
            <input id="_first_name" name="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" placeholder="First Name" value="{{ old('first_name') }}" required
                   autofocus>
            <div class="input-group-append">
              <div class="input-group-text">
                <label for="_first_name" class="fas fa-user-edit"></label>
              </div>
            </div>
          </div>
          <div class="mb-3">
            @error('first_name')
            <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>
          <div class="input-group">
            <input id="_last_name" name="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" placeholder="Last Name" value="{{ old('last_name') }}">
            <div class="input-group-append">
              <div class="input-group-text">
                <label for="_last_name" class="fas fa-user-edit"></label>
              </div>
            </div>
          </div>
          <div class="mb-3">
            @error('last_name')
            <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>
          <div class="input-group">
            <input id="_email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" value="{{ old('email') }}">
            <div class="input-group-append">
              <div class="input-group-text">
                <label for="_email" class="fas fa-envelope"></label>
              </div>
            </div>
          </div>
          <div class="mb-3">
            @error('email')
            <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>
          <div class="input-group">
            <input id="_phone" name="phone" type="number" class="form-control @error('phone') is-invalid @enderror" placeholder="Phone Number" value="{{ old('phone') }}">
            <div class="input-group-append">
              <div class="input-group-text">
                <label for="_phone" class="fas fa-phone"></label>
              </div>
            </div>
          </div>
          <div class="mb-3">
            @error('phone')
            <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>
          <div class="input-group">
            <input id="_username" name="username" type="text" class="form-control @error('username') is-invalid @enderror" placeholder="Username" value="{{ old('username') }}">
            <div class="input-group-append">
              <div class="input-group-text">
                <label for="_username" class="fas fa-user"></label>
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
          <div class="input-group">
            <input id="password_confirmation" name="password_confirmation" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Confirm Password">
            <div class="input-group-append">
              <div class="input-group-text">
                <label for="password_confirmation" class="fas fa-lock"></label>
              </div>
            </div>
          </div>
          <div class="mb-3">
            @error('password')
            <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>
          <div class="form-group">
            <label for="_address">Full Address</label>
            <textarea id="_address" name="address" class="form-control  @error('address') is-invalid @enderror" rows="3" placeholder="Enter your full address ...">{{ old('address') }}</textarea>
          </div>
          <div class="mb-3">
            @error('address')
            <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>
          <div class="row mb-2">
            <div class="col-8"></div>
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block">Register</button>
            </div>
          </div>
        </form>

        <a href="{{ route('login') }}" class="text-center">I already have a membership</a>
      </div>
    </div>
  </div>
@endsection