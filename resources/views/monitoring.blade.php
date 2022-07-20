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
        <h2 class="mb-4">
            Monitoring Panen Harian
        </h2>
        <form action="{{ url('monitoring-upload') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group mb-4" style="max-width: 500px; margin: 0 auto;">
                <div class="custom-file text-left">
                    <input type="file" name="upload_file" class="custom-file-input" id="customFile" required>
                    <label class="custom-file-label" for="customFile">Choose file</label>
                </div>
            </div>
            <button class="btn btn-primary">Import data</button>
            <a class="btn btn-success" href="{{ url('peta-delete') }}">Delete data</a>
        </form>
        <canvas id="myChart" style="width:200%;max-width:800px"></canvas>
    </div>
<script>
var tanggal = "{{ json_encode($tanggal) }}";
var actual = "{{ json_encode($actual) }}";
console.log(tanggal);
console.log(actual);

var xValues = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31];

new Chart("myChart", {
    type: "line",
    data: {
        labels: xValues,
        datasets: [
            {
                data: [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31],
                borderColor: "red",
                fill: false
            },
        ]
    },
    options: {
        legend: {display: false}
    }
});
</script>
</body>
</html>