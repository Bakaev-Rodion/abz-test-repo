<head>
    <title>Show Users</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div class="container">
    <form id="actionForm" action="{{ route('api.v1.users') }}" method="GET" enctype="multipart/form-data">
        <input type="text" name="page" id="page" placeholder="Page">
        <input type="text" name="count" id="count" placeholder="Count">
        <button type="submit">Get users</button>
    </form>
    <div id="usersList">
        <div id="userContainer" class="user-container"></div>
        <div class="pagination">
            <button id="prevPage" disabled>Previous</button>
            <span id="pageInfo"></span>
            <button id="nextPage" disabled>Next</button>
        </div>
    </div>
</div>
<script>

    let usersPerPage= 0;
    let currentPage =0;
    const prevPageBtn = document.getElementById('prevPage');
    const nextPageBtn = document.getElementById('nextPage');
    const pageInfo = document.getElementById('pageInfo');

    document.getElementById('actionForm').addEventListener('submit', function(event) {
        event.preventDefault();
        currentPage = document.getElementById('page').value;
        usersPerPage = document.getElementById('count').value;
        fetchData(currentPage);
    });

    function fetchData(page){
        fetch(`http://abz.loc/api/v1/users?count=${usersPerPage}&page=${page}`, {
            method: 'GET',
        })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    displayUsers(data.users);
                    updatePaginationControls(data.page, data.total_pages, data.prev_page_url, data.next_page_url);
                } else {
                    userContainer.innerHTML = `<p>Message: ${data.message}</p>`;
                }
            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });
    }


    function displayUsers(users) {
        const userContainer = document.getElementById('userContainer');
        userContainer.innerHTML = '';
        users.forEach(user => {
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
        });
    }

    function updatePaginationControls(page, totalPages, prevPageUrl, nextPageUrl) {
        currentPage = page;
        pageInfo.textContent = `Page ${page} of ${totalPages}`;
        prevPageBtn.disabled = !prevPageUrl;
        nextPageBtn.disabled = !nextPageUrl;
    }

    prevPageBtn.addEventListener('click', () => {
        if (currentPage > 1) {
            fetchData(currentPage - 1);
        }
    });

    nextPageBtn.addEventListener('click', () => {
        fetchData(currentPage + 1);
    });

   // fetchData(currentPage);
</script>
</body>
