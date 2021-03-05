@extends('layouts.app')

@section('title')
<div class="row mb-2">
  <div class="col-sm-6">
    <h1>Home</h1>
  </div>
  <div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
      <li class="breadcrumb-item">Dashboard</li>
    </ol>
  </div>
</div>
@endsection

@section('content')
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-3 col-6">
      <div class="small-box bg-info">
        <div class="inner">
          <h3>{{$rooms}}</h3>

          <p>Total Room</p>
        </div>
        <div class="icon">
          <i class="fas fa-chart-pie"></i>
        </div>
      </div>
    </div>
      <div class="col-lg-3 col-6">
      <div class="small-box bg-info">
        <div class="inner">
          <h3>{{$locationCount}}</h3>

          <p>Location</p>
        </div>
        <div class="icon">
          <i class="fas fa-flag"></i>
        </div>
      </div>
    </div>
      <div class="col-lg-3 col-6">
      <div class="small-box bg-danger">
        <div class="inner">
          <h3>{{$roomsBooked}}</h3>

          <p>Booked Rooms</p>
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
      </div>
      </div>
      <div class="col-lg-3 col-6">
      <div class="small-box bg-success">
        <div class="inner">
          <h3>{{$roomsAvailable}}</h3>

          <p>Available Rooms</p>
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
      </div>
    </div>
    <!-- BAR CHART -->
    <div class="card card-success col-md-12">
      <div class="card-header">
        <h3 class="card-title">Booked Rooms Chart</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
          <button type="button" class="btn btn-tool" data-card-widget="remove">
            <i class="fas fa-times"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <div class="chart col-md-12">
          <canvas id="barChart" style="min-height: 250px; height: 250px; width:100%; max-height: 250px; weight:100%;"></canvas>
        </div>
      </div>
    </div>

    <!-- HISTORY BAR CHART -->
    <div class="card card-warning col-md-12">
      <div class="card-header">
        <h3 class="card-title">Booked Rooms History Chart</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
          <button type="button" class="btn btn-tool" data-card-widget="remove">
            <i class="fas fa-times"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <div class="chart col-md-12">
          <canvas id="historyBarChart" style="min-height: 250px; height: 250px; width:100%; max-height: 250px; weight:100%;"></canvas>
        </div>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
    @if ($rentDue != null)
    <div class="col-12">
      <h3>Rent Due</h3>
    </div>
    @endif
    <br />
    @forelse ($rentDue as $item)
      <!--Rent near due date-->
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
        </div>
      </div>
      <div class="modal fade" id="modal-rent-{{$item->id}}" style="display: none;">
        <form id="form-rent" action="{{route('room.rent',$item->id)}}" method="post" >
          @csrf
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title float-left">Edit Rent</h4>
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
                <button type="submit" name="action" value="extend" data-id="{{$item->id}}" class="btn btn-secondary">Extend Rent Date</button>
                <button type="submit" name="action" value="edit" data-id="{{$item->id}}" class="btn btn-primary">Save Changes</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    @empty
    <div>
    <p> No renter that has not paid with the rent end date less than 5 days</p>
    </div>
    @endforelse
    </div>
  </div>
@endsection

@section('addJs')
  <script src="{{asset('assets/plugins/chart.js/Chart.min.js')}}"></script>
  <script src="{{asset('assets/dist/js/adminlte.min.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>

  <script>
    $(function (){
      var location = @json($location);
      var labels = location.map(function(e){
        return e.address
      });

      var barChartData = {
        labels  : labels,
        datasets: [
        {
          label               : 'All Rooms',
          backgroundColor     : 'green',
          data                : @json($allRooms),
        },
        {
          label               : 'Booked Rooms',
          backgroundColor     : 'red',
          data                : @json($bookedRooms),
        }
      ]
      }

      var barChartCanvas = $('#barChart').get(0).getContext('2d')
      var barChartData = $.extend(true, {}, barChartData)

      var barChart = new Chart(barChartCanvas, {
        type: 'bar',
        data: barChartData,
        options: {
          responsive              : false,
          maintainAspectRatio     : true,
          datasetFill             : false,
          scales: {
            yAxes: [{
                ticks: {
                  min: 0,
                  stepSize: 1
                }
            }]
          }
      }
      })
    })
  </script>

  <script>
    $(function (){
      const history = @json($history);
      const data = new Array();
      const label = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];

      for (var id in history){
        var valueDataset = [];
        //Generate random color
        var r = Math.floor(Math.random() * 255);
        var g = Math.floor(Math.random() * 255);
        var b = Math.floor(Math.random() * 255);
        var color = "rgb(" + r + "," + g + "," + b + ")";

        for(var d in history[id]){
          valueDataset.push(history[id][d]);
        }

        try {
          data.push({
            label               : id,
            backgroundColor     : color,
            data                : valueDataset,
          });
        } catch (error) {
          data.push({
            label               : i,
            backgroundColor     : color,
            data                : [0],
          });
        }
      }

      var historyBarChartData = {
        labels : label,
        datasets: data,
      }

      var historyBarChartCanvas = $('#historyBarChart').get(0).getContext('2d')
      var historyBarChartData = $.extend(true, {}, historyBarChartData)

      var barChart = new Chart(historyBarChartCanvas, {
        type: 'bar',
        data: historyBarChartData,
        options : {
          responsive              : false,
          maintainAspectRatio     : true,
          datasetFill             : false,
          scales: {
            yAxes: [{
              ticks: {
                  min: 0,
                  stepSize: 1
              }
            }]
          }
      }
      });
    });
  </script>
@endSection
