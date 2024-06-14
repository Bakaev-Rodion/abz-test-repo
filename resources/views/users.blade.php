<head>
    <title>Show Users</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div class="container">
    <form id="actionForm" action="{{ route('api.v1.users') }}" method="GET" enctype="multipart/form-data">
        <input type="text" name="page" placeholder="Page">
        <input type="text" name="count" placeholder="Count">
        <button type="submit">Get users</button>
    </form>
</div>
</body>
