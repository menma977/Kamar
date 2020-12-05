@extends('layouts.app')

@section('title')
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1>List Location</h1>
    </div>
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Locations</li>
      </ol>
    </div>
  </div>
@endsection

@section('content')
<div class="col-md-12">
  <table class="table table-bordered" id="data">
    <thead>
    <tr>
      <th>Id</th>
      <th>Address</th>
    </tr>
    </thead>
    <tbody>
      @foreach ($locations as $item)
        <tr>
          <td>{{$item->id}}</td>
          <td>{{$item->address}}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection


@section('addCss')
<!--Data Tables-->
  <link rel="stylesheet" href="{{asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}"/>
  <link rel="stylesheet" href="{{asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}"/>
@endsection

@section('addJs')
  <!--Data Tables-->
<script src="{{asset('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>

<script>
  $(function () {
    $('#data').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching":true,
      "ordering":true,
      "info":true,
      "autoWidth":true,
      "responsive":true
    });
  });


</script>

@endsection
