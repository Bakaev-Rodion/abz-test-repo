<head>
    <title>Positions</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div class="form-container">
    <button onclick="showPositions()">Show Positions</button>
</div>
</body>
<script>
    function showPositions() {
        window.location.href = '{{ route('api.v1.positions') }}';
    }
</script>
