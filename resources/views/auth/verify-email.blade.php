@extends('layouts.guest')

@section('content')
  <div class="login-box w-75">
    <div class="login-logo">
      <a href="{{ route('welcome') }}"><b>SOE</b><small>Catalog</small></a>
    </div>
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg text-xs">
          Thanks for signing up! Before getting started,
          could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email,
          we will gladly send you another.
        </p>
        <div class="row">
          <div class="col-md-6">
            <form action="{{ route('verification.send') }}" method="post">
              @csrf
              <button type="submit" class="btn btn-primary btn-block">Resend Verification Email</button>
            </form>
          </div>
          <div class="col-md-6">
            <form action="{{ route('logout') }}" method="post">
              @csrf
              <button type="submit" class="btn btn-primary btn-block">Logout</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('addCss')
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
  <!-- Toastr -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}">
@endsection

@section('addJs')
  <!-- SweetAlert2 -->
  <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
  <!-- Toastr -->
  <script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>

  <script>
    $(function () {
      const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 6000
      });

      @if(session('status') == 'verification-link-sent')
      Toast.fire({
        icon: 'success',
        title: 'A new verification link has been sent to the email address you provided during registration.'
      })
      @endif

      @if ($errors->any())
      @foreach ($errors->all() as $error)
      Toast.fire({
        icon: 'error',
        title: @json($error)
      })
      @endforeach
      @endif
    });
  </script>
@endsection
