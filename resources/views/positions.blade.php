<head>
    <title>Positions</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div class="container">
    <button onclick="showPositions()">Show Positions</button>
    <div id="positionList"></div>
</div>
</body>
<script>
    function showPositions() {
        fetch('{{ route('api.v1.positions') }}', {
            method: 'GET',
        })
            .then(response => response.json())
            .then(data=>{
                const positionContainer = document.getElementById('positionList');
                if(data.success){
                    data.positions.forEach( position=> {
                        const positionDiv = document.createElement('div');
                        positionDiv.innerHTML = `<p>${position.position}</p>`;

                        positionContainer.appendChild(positionDiv);
                    });

                } else {
                    positionContainer.innerHTML = `<p>Message: ${data.message}</p>`;
                }
            })
            .catch(error => {
                console.error('Error submitting form:', error);
            });
    }
</script>
