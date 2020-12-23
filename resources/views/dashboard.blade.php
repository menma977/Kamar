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
        <a href="#" class="small-box-footer">
          More info <i class="fas fa-arrow-circle-right"></i>
        </a>
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
        <a href="#" class="small-box-footer">
          More info <i class="fas fa-arrow-circle-right"></i>
        </a>
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
        <a href="#" class="small-box-footer">
          More info <i class="fas fa-arrow-circle-right"></i>
        </a>
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
        <a href="#" class="small-box-footer">
          More info <i class="fas fa-arrow-circle-right"></i>
        </a>
      </div>
    </div>
    <!-- BAR CHART -->
    <div class="card card-warning col-md-12">
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
          <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; weight:100%;"></canvas>
        </div>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->

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
          <canvas id="historyBarChart" style="min-height: 250px; height: 250px; max-height: 250px; weight:100%;"></canvas>
        </div>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
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
          label               : 'Booked Rooms',
          backgroundColor     : 'red',
          data                : @json($bookedRooms)
        },
        {
          label               : 'All Rooms',
          backgroundColor     : 'green',
          data                : @json($allRooms)
        },
      ]
      }

      var barChartCanvas = $('#barChart').get(0).getContext('2d')
      var barChartData = $.extend(true, {}, barChartData)
      var temp0 = barChartData.datasets[0]
      var temp1 = barChartData.datasets[1]
      barChartData.datasets[0] = temp1
      barChartData.datasets[1] = temp0

      var barChartOptions = {
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

      var barChart = new Chart(barChartCanvas, {
        type: 'bar',
        data: barChartData,
        options: barChartOptions
      })
    })
  </script>

  <script>
    $(function (){
      var labels = @json($location).map(function(e){
        return e.address
      });
      const history = @json($history);

      const data = new Array();
      const dataTes = new Array();

      var dynamicColors = function() {
            var r = Math.floor(Math.random() * 255);
            var g = Math.floor(Math.random() * 255);
            var b = Math.floor(Math.random() * 255);
            return "rgb(" + r + "," + g + "," + b + ")";
         };

      for (const prop in history){
        const dataLoc =[];

        Object.keys(history[prop]).forEach(function(key) {
          dataTes.push(history[prop][key]);
        });

        data.push({
          label               : 'x',
          backgroundColor     : '#fff',
          data                : dataTes,
        });

      }

      var historyBarChartData = {
        labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
        datasets: data
      }

      var barChartCanvas = $('#historyBarChart').get(0).getContext('2d')
      var historyBarChartData = $.extend(true, {}, historyBarChartData)

      var barChartOptions = {
        responsive              : false,
        maintainAspectRatio     : true,
        datasetFill             : false,
        scales: {
          xAxes: [{
            type: 'time',
            time: {
              displayFormats: {
                quarter: 'MMM',
                unit: 'month'
              }
            }
          }],
          yAxes: [{
            ticks: {
                min: 0,
                stepSize: 1
            }
          }]
        }
      }
      console.log(historyBarChartData);
      setTimeout(function(){
        var barChart = new Chart(barChartCanvas, {
          type: 'bar',
          data: historyBarChartData,
          options: barChartOptions
        });
      },5000);

    });
  </script>
@endSection
