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
  <div class="row">
    <div class="col-md-12">
      <form id="form" action="{{route('location.store')}}" method="POST">
        @csrf
        <div id="card" class="card bg-primary @if(!$errors->any()) collapse-card @endif">
          <div class="card-header">
            <h3 class="card-title">Edit/Delete Location</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas @if(!$errors->any()) fa-minus @else fa-plus @endif"></i>
              </button>
            </div>
          </div>
          <div class="card-body">
            <div class="form-group">
              <label for="_address">Location Address</label>
              <input type="text" class="form-control @error('address') is-invalid @enderror" id="_address" name="address" placeholder="Input address" value="{{old('address')}}"/>
            </div>
          </div>
          <div class="card-footer">
            <button type="submit" class="btn btn-block btn-xs btn-success">Submit</button>
          </div>
        </div>
      </form>
    </div>
    <div class="col-md-12">
      <table class="table table-bordered" id="data">
        <thead>
        <tr>
          <th>Id</th>
          <th>Address</th>
          <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach ($locations as $item)
          <tr>
            <td>{{$item->id}}</td>
            <td id="address-{{ $item->id }}">{{$item->address}}</td>
            <td>
              <div class="row">
                <div class="col-md-3">
                  <button type="button" class="btn btn-block btn-warning btn-xs edit" id="{{$item->id}}">Edit</button>
                </div>
                <div class="col-md-3">
                  <button type="button" class="btn btn-block btn-danger btn-xs">Delete</button>
                </div>
              </div>
            </td>
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>
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
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "responsive": true
      });
    });
  </script>
  <script>
    $(function () {
      $(document).on('click', '.edit', function () {
        const id = $(this).attr('id');
        const url = "{{route('location.store','#id')}}".replace('#id', id);
        const address = $("#address-" + id).html();
        $("#_address").val(address);
        $('#form').attr('action', url);
        if ($('#card').hasClass('collapsed-card')) {
          $("[data-card-widget='collapse']").click();
        }
      });
    });

  </script>

@endsection
