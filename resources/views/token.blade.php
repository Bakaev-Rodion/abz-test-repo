<head>
    <title>Get Token</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div class="container">
    <button onclick="getToken()">Get token</button>
    <div id="token"></div>
</div>
</body>
<script>
    function getToken() {
        const tokenDiv = document.getElementById('token');
        fetch('{{ route('api.v1.token') }}', {
            method: 'GET',
        }).then(response => response.json())
            .then(data=>{
                if(data.success){
                    tokenDiv.innerHTML = `<p>Token: ${data.token}</p>`;
                } else {
                    tokenDiv.innerHTML = `<p>Message: ${data.message}</p>`;
                }
            })
            .catch(error => {
                console.error('Error submitting form:', error);
            });
    }
</script>
