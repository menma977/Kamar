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
      @foreach($users as $item)
        <div class="col-lg-3 col-6">
          <div class="small-box bg-dark">
            <div class="inner">
              <h3>{{ $item->username }}</h3>
              <p>{{ $item->name }}</p>
              <p>{{ $item->Location->address }}</p>
            </div>
            <div class="icon">
              <i class="fa fa-user"></i>
            </div>
            <div class="small-box-footer p-1">
              <div class="row">
                <div class="col-md-6">
                  <button type="button" class="btn btn-block btn-warning btn-xs">Edit</button>
                </div>
                <div class="col-md-6">
                  <button type="button" class="btn btn-block btn-danger btn-xs">Delete</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      @endforeach

      <div class="col-md-12">
        <table class="table table-bordered">
          <thead>
          <tr>
            <th>#</th>
          </tr>
          </thead>
          <tbody>
          <tr>
            <td>1</td>
          </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection
