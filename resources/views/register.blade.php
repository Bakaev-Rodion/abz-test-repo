<head>
    <title>Registration Form</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div class="container">
    <form id="actionForm" action="{{ route('api.v1.register') }}" method="POST" enctype="multipart/form-data">
        <input type="text" name="token" required placeholder="Registration token">
        <input type="text" name="name" required placeholder="Name">
        <input type="email" name="email" required placeholder="Email">
        <input type="text" name="phone" required placeholder="Phone">
        <input type="number" name="position_id" required placeholder="Position id">
        <input type="file" name="photo" required accept=".jpg,.jpeg">
        <button type="submit">Register</button>
    </form>
</div>
<script>
    document.getElementById('actionForm').addEventListener('submit', function(event) {
        event.preventDefault();
        let formData = new FormData(this);
        let token = formData.get('token');
        fetch('{{ route('api.v1.register') }}', {
            method: 'POST',
            body: formData,
            headers: {
                'Token': token
            }
        })
            .then(response => response.json())
            .catch(error => {
                console.error('Error submitting form:', error);
            });
    });
</script>
</body>
