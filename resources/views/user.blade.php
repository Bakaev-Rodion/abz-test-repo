<head>
    <title>Get User</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body  onload="getInfo()" >

<div class="container">
    <div id="userContainer">
    </div>
</div>
<script>
    function getInfo() {
        fetch('{{ route('api.v1.getUser', $id) }}', {
            method: 'GET',
        })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                const userContainer = document.getElementById('userContainer');
                if (data.success) {
                    displayUser(data.user)
                } else {
                    userContainer.innerHTML = `<p>Message: ${data.message}</p>`;
                }
            })
            .catch(error => {
                console.error('Error submitting form:', error);
            });
    }

    function displayUser(user) {
        const userContainer = document.getElementById('userContainer');
        userContainer.innerHTML = '';
        const userDiv = document.createElement('div');
        userDiv.className = 'user';
        userDiv.innerHTML = `
                    <p>Name: ${user.name}</p>
                    <p>Email: ${user.email}</p>
                    <p>Phone: ${user.phone}</p>
                    <p>Position: ${user.position}</p>
                    <img src="../../public/storage/${user.photo}" alt="${user.name}" width="100">
                `;
        userContainer.appendChild(userDiv);
    }
</script>
</body>
