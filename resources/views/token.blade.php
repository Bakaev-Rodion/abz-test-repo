<head>
    <title>Get Token</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div class="form-container">
    <button onclick="getToken()">Get token</button>
</div>
</body>
<script>
    function getToken() {
        window.location.href = '{{ route('api.v1.token') }}';
    }
</script>
