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
        <form id="form" action="{{ route('room.store') }}" method="POST">
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
                    <label for="is_man">Gender</label>
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
                  Price <span class="float-right" id="price-{{ $item->id }}">{{  number_format($item->price, 2, ',', '.') }}</span>
                </li>
                <li class="nav-item">
                  Location <span class="float-right">{{ $item->Location->address}}</span>
                  <span class="hide" id="location-{{ $item->id }}">{{ $item->Location->id }}</span>
                </li>
                <li class="nav-item">
                  Gender
                  <div class="float-right" id="is_man-{{ $item->id }}">{{ $item->is_man ? "Male": "Female" }}</div>
                </li>
                @if ($item->renter)
                  <li class="nav-item">
                    Renter<span class="float-right" id="renter-{{ $item->id }}">{{ $item->renter }}</span>
                  </li>
                  <li class="nav-item">
                    Join Date<span class="float-right" id="join-{{$item->id}}">{{ \Carbon\Carbon::parse($item->join)->format('d/m/Y') }}</span>
                  </li>
                  <li class="nav-item">
                    End Date<span class="float-right" id="end-{{$item->id}}">{{ \Carbon\Carbon::parse($item->end)->format('d/m/Y') }}</span>
                  </li>
                  <li class="nav-item">
                    Item<span class="float-right" id="item-{{$item->id}}">{{ number_format($item->item, 2, ',', '.') }}</span>
                  </li>
                  <li class="nav-item" id="item-{{$item->id}}">
                    Payment
                    <span class="float-right" id="item-{{$item->id}}">
                      @if ($item->payment)
                      <a>Paid</a>
                      @else
                      <a>Not Paid</a>
                      @endif
                    </span>
                  </li>
                @else
                  <li class="nav-item">
                    Renter<span class="float-right">-</span>
                  </li>
                  <li class="nav-item">
                    Join Date<span class="float-right">-</span>
                  </li>
                  <li class="nav-item">
                    End Date<span class="float-right">-</span>
                  </li>
                  <li class="nav-item">
                    Item<span class="float-right">-</span>
                  </li>
                  <li class="nav-item" id="item-{{$item->id}}">
                    Payment <span class="float-right" id="item-{{$item->id}}">-</span>
                  </li>
                @endif
                <li class="nav-item">
                  Total Price<span class="float-right" id="item-{{$item->id}}">{{ number_format($item->item+$item->price, 2, ',', '.') }}</span>
                </li>
                <li class="nav-item">
                  Status
                <button type="button" id="is_bond-{{ $item->id }}" class="btn btn-default float-right btn-xs" data-toggle="modal" data-target="#modal-rent-{{$item->id}}" >
                  @if ($item->is_bond||$item->renter)
                  <a style="color: red">Booked</a>
                  @else
                  <a style="color: green">Available</a>
                  @endif
                </button>
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
        <div class="modal fade" id="modal-rent-{{$item->id}}" style="display: none;">
          <form id="form-rent" action="{{route('room.rent',$item->id)}}" method="post" >
            @csrf
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title float-left">
                    @if ($item->is_bond)
                    Edit Rent
                    @else
                    Add Rent
                    @endif
                  </h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                  <span class="float-Left" id="name-{{ $item->id }}">Room: {{ $item->name }}</span>
                  <input type="text" value="{{old('renter',$item->renter)}}" placeholder="Enter renter name" id="_renter" name="renter" class="form-control"/>
                  <input type="hidden" id="room" name="room" value="{{$item->id}}" />
                  <br />
                  <input type="text" value="{{old('item',$item->item)}}" placeholder="Enter item price" id="item" name="item" class="form-control" />
                  <br />
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="payment">Payment Status</label>
                      <br/>
                      <div class="btn-group btn-group-toggle btn-block" data-toggle="buttons">
                        <label id="not-paid" class="btn btn-outline-danger active">
                          <input type="radio" name="payment" @if(old('payment',$item->payment) == false) checked @endif autocomplete="off" value="0"> NOT PAID
                        </label>
                        <label id="paid" class="btn btn-outline-warning">
                          <input type="radio" name="payment" @if(old('payment',$item->payment) == true) checked @endif autocomplete="off" value="1"> PAID
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <a href="{{ route('room.deleteRenter', $item->id) }}">
                    <button type="button" class="btn btn-danger">Delete Renter</button>
                  </a>
                  @if ($item->is_bond)
                  <button type="submit" name="action" value="extend" data-id="{{$item->id}}" class="btn btn-secondary">Extend Rent Date</button>
                  <button type="submit" name="action" value="edit" data-id="{{$item->id}}" class="btn btn-primary">Save Changes</button>
                  @else
                  <button type="submit" name="action" value="add" data-id="{{$item->id}}" class="btn btn-primary">Save New Renter</button>
                  @endif
                </div>
              </div>
            </div>
          </form>
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
