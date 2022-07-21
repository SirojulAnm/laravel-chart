<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Multiple Lines</title>	
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Chart</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item">
              <a class="nav-link" href="{{ url('peta') }}">Peta</a>
            </li>
            <li class="nav-item active">
              <a class="nav-link" href="{{ url('monitoring') }}">Monitoring</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('actual-vs-bbc') }}">Actual vs BBC</a>
            </li>
          </ul>
        </div>
    </nav>
    <div class="container mt-5 text-center">
        @section('konten')
        <!-- notifikasi form validasi -->
        @if( !empty(Session::get('message_error')) )
        <div class="alert alert-danger" style="margin: 20px 0 0 0;">
            {!! Session::get('message_error') !!}
        </div>
        @endif

        <!-- notifikasi sukses -->
        @if( !empty(Session::get('message')) )
        <div class="alert alert-success" style="margin: 20px 0 0 0;">
            {!! Session::get('message') !!}
        </div>
        @endif
        <h2 class="mb-2">
            Monitoring Panen Harian
        </h2>
        <form action="{{ url('monitoring-upload') }}" method="POST" enctype="multipart/form-data" class="mb-4">
            @csrf
            <div class="form-group mb-1" style="max-width: 500px; margin: 0 auto;">
                <div class="custom-file text-left">
                    <input type="file" name="upload_file" class="custom-file-input" id="customFile" required>
                    <label class="custom-file-label" for="customFile">Choose file</label>
                </div>
            </div>
            <button class="btn btn-primary">Import data</button>
            <a class="btn btn-success" href="{{ url('monitoring-delete') }}">Delete data</a>
        </form>
        <canvas id="myChart" style="width:200%;max-width:800px;margin: 0 auto;"></canvas>
        <label>Tanggal</label>
    </div>
<script>

fetch('http://localhost/testtap/public/monitoring-data')
    .then(function(response) { return response.json(); })
    .then(function(response) {
        if (response.code != 200) {
            console.log(response);
        } else {
            console.log(response);
            var xValues = response.data.tanggal;
            new Chart("myChart", {
                type: "line",
                data: {
                    labels: xValues,
                    datasets: [
                        {
                            data: response.data.actual,
                            borderColor: "red",
                            fill: false,
                            label: 'actual',
                        },
                        {
                            data: response.data.target,
                            borderColor: "green",
                            fill: false,
                            label: 'target',
                        },
                        {
                            data: response.data.bbc,
                            borderColor: "blue",
                            fill: false,
                            label: 'bbc',
                        },
                        {
                            data: response.data.average_actual,
                            borderColor: "yellow",
                            fill: false,
                            label: 'average_actual',
                        }
                    ]
                },
                options: {
                    legend: {display: false},
                    title: {
                        display: true,
                        text: "Monitoring Panen Harian"
                    }
                }
            });
        }
    });
</script>
</body>
</html>