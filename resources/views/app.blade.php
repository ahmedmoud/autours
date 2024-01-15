{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}

<html>
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
    <title>Autours</title>
    <link rel="icon" type="image/x-icon" href="images/favicon512*256.png" sizes="32x32">
    <link rel="stylesheet" href="../assets/css/styles.min.css" />
    <link rel="stylesheet" href="../assets/css/fontawesome/css/fontawesome.min.css" />
    <link rel="stylesheet" href="../assets/css/fontawesome/css/solid.min.css" />
    <link rel="stylesheet" href="../assets/css/fontawesome/css/brands.min.css" />
    <link rel="stylesheet" href="../assets/css/fontawesome/css/all.min.css" />


    @vite('resources/js/app.js')
    @inertiaHead
</head>
<body>
@inertia
</body>
<script src="../assets/libs/jquery/dist/jquery.min.js"></script>
<script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/sidebarmenu.js"></script>
<script src="../assets/js/app.min.js"></script>
<script src="../assets/libs/apexcharts/dist/apexcharts.min.js"></script>
<script src="../assets/libs/simplebar/dist/simplebar.js"></script>
<script src="../assets/js/dashboard.js"></script>

</html>
