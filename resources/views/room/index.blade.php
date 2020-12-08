@extends('layouts.app')

@section('title')
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1>List Rooms</h1>
    </div>
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Rooms</li>
      </ol>
    </div>
  </div>
@endsection

@section('content')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <form id="form" action="{{ route('room.store') }}" method="post">
          @csrf
          <div id="card" class="card bg-primary @if (!$errors->any()) collapsed-card @endif">
            <div class="card-header">
              <h3 class="card-title">Create/Edit Room</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas @if ($errors->any()) fa-minus @else fa-plus @endif"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="_name">Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="_name" name="name" placeholder="Enter name" value="{{ old('name') }}">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="_price">Price</label>
                    <input type="text" class="form-control @error('price') is-invalid @enderror" id="_price" name="price" placeholder="Enter price" value="{{ old('price') }}">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="_price">Price</label>
                    <br/>
                    <div class="btn-group btn-group-toggle btn-block" data-toggle="buttons">
                      <label id="male" class="btn btn-outline-danger active">
                        <input type="radio" name="is_man" autocomplete="off" value="1"> MALE
                      </label>
                      <label id="female" class="btn btn-outline-warning">
                        <input type="radio" name="is_man" autocomplete="off" value="0"> FEMALE
                      </label>
                    </div>
                  </div>

                </div>
              </div>
              <div class="form-group">
                <label for="_location">Location</label>
                <select class="form-control @error('location') is-invalid @enderror" id="_location" name="location" value="{{ old('address') }}">
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
      @foreach($rooms as $item)
        <div class="col-lg-3 col-6">
          <div class="small-box bg-dark">
            <div class="inner">
              <ul class="nav flex-column">
                <li class="nav-item">
                  Name <span class="float-right" id="name-{{ $item->id }}">{{ $item->name }}</span>
                </li>
                <li class="nav-item">
                  Price <span class="float-right" id="price-{{ $item->id }}">{{ $item->price }}</span>
                </li>
                <li class="nav-item">
                  Location <span class="float-right">{{ $item->Location->address}}</span>
                  <span class="hide" id="location-{{ $item->id }}">{{ $item->Location->id }}</span>
                </li>
                @if ($item->renter)
                  <li class="nav-item">
                    Renter<span class="float-right" id="renter-{{ $item->id }}">{{ $item->renter }}</span>
                  </li>
                @endif
                <li class="nav-item">
                  Gender
                  <div class="float-right" id="is_man-{{ $item->id }}">{{ $item->is_man ? "Male": "Female" }}</div>
                </li>
                <li class="nav-item">
                  Status<span class="float-right" id="is_bond-{{ $item->id }}">
                    @if ($item->is_bond)
                      Booked
                    @else
                      Available
                    @endif</span>
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
                  <a href="{{ route('room.delete', $item->id) }}">
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
        const url = "{{ route('room.store', '#id') }}".replace('#id', id);
        const name = $("#name-" + id).html()
        const price = $("#price-" + id).html()
        const is_bond = $("#is_bond-" + id).html()
        const is_man = $("#is_man-" + id).html()
        const location = $("#location-" + id).html()
        $("#_name").val(name);
        $("#_price").val(price);
        $("#_location").val(location);
        console.log(is_man);
        if (is_man === "Male") {
          $("#male").addClass('active');
          $("#female").removeClass('active');
        } else {
          $("#male").removeClass('active');
          $("#female").addClass('active');
        }
        $("#_is_bond").val(is_bond);
        $('#form').attr('action', url);
        if ($('#card').hasClass('collapsed-card')) {
          $("[data-card-widget='collapse']").click();
        }
      });
    });
  </script>
@endsection
