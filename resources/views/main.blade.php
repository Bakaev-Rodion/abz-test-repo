<head>
    <title>Main</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div class="container">
    <button onclick="getPositionPage()">Positions</button>
    <button onclick="getTokenPage()">Token</button>
    <button onclick="getRegistrationPage()">Registration</button>
    <button onclick="getUsersPage()">Users</button>
</div>
</body>
<script>
    function getPositionPage() {
        window.location.href = '{{ route('positions') }}';
    }
    function getTokenPage() {
        window.location.href = '{{ route('token') }}';
    }
    function getRegistrationPage() {
        window.location.href = '{{ route('register') }}';
    }
    function getUsersPage() {
        window.location.href = '{{ route('users') }}';
    }
</script>
