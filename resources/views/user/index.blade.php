@extends('layouts.app')

@section('title')
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1>List Users</h1>
    </div>
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Users</li>
      </ol>
    </div>
  </div>
@endsection

@section('content')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <form id="form" action="{{ route('user.store') }}" method="post">
          @csrf
          <div id="card" class="card bg-primary @if (!$errors->any()) collapsed-card @endif">
            <div class="card-header">
              <h3 class="card-title">Create/Edit User</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas @if ($errors->any()) fa-minus @else fa-plus @endif"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="_username">Username</label>
                    <input type="text" class="form-control @error('username') is-invalid @enderror" id="_username" name="username" placeholder="Enter username" value="{{ old('username') }}">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="_name">Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="_name" name="name" placeholder="Enter name" value="{{ old('name') }}">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="_password">Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="_password" name="password" placeholder="Enter password">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="_confirmation_password">Confirmation Password</label>
                    <input type="password" class="form-control @error('confirmation_password') is-invalid @enderror" id="_confirmation_password" name="confirmation_password"
                           placeholder="Enter confirmation password">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="_location">Location</label>
                <select class="form-control @error('location') is-invalid @enderror" id="_location" name="location">
                  @foreach($location as $item)
                    <option value="{{ $item->id }}">{{ $item->address }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="card-footer">
              <button type="submit" class="btn btn-block btn-success">Submit</button>
            </div>
          </div>
        </form>
      </div>
      @foreach($users as $item)
        <div class="col-lg-3 col-6">
          <div class="small-box bg-dark">
            <div class="inner">
              <ul class="nav flex-column">
                <li class="nav-item">
                  Username <span class="float-right" id="username-{{ $item->id }}">{{ $item->username }}</span>
                </li>
                <li class="nav-item">
                  Name <span class="float-right" id="name-{{ $item->id }}">{{ $item->name }}</span>
                </li>
                <li class="nav-item">
                  Location <span class="float-right">{{ $item->Location->address }}</span>
                  <span class="hide" id="location-{{ $item->id }}">{{ $item->Location->id }}</span>
                </li>
              </ul>
            </div>
            <div class="icon">
              <i class="fa fa-user"></i>
            </div>
            <div class="small-box-footer p-1">
              <div class="row">
                <div class="col-md-6">
                  <button type="button" class="btn btn-block btn-warning btn-xs edit" id="{{ $item->id }}">Edit</button>
                </div>
                <div class="col-md-6">
                  <a href="{{ route('user.delete', $item->id) }}">
                    <button type="button" class="btn btn-block btn-danger btn-xs">Delete</button>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
@endsection

@section('addJs')
  <script>
    $(function () {
      $(document).on('click', '.edit', function () {
        const id = $(this).attr("id");
        const url = "{{ route('user.store', '#id') }}".replace('#id', id);
        const username = $("#username-" + id).html()
        const name = $("#name-" + id).html()
        const location = $("#location-" + id).html()
        $("#_username").val(username);
        $("#_name").val(name);
        $("#_location").val(location);
        $('#form').attr('action', url);
        if ($('#card').hasClass('collapsed-card')) {
          $("[data-card-widget='collapse']").click();
        }
      });
    });
  </script>
@endsection
