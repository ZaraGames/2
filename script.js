document.getElementById('usernameForm').addEventListener('submit', function(event) {
    event.preventDefault();
    
    const username = document.getElementById('username').value;
    const resultDiv = document.getElementById('result');

    // Clear the result div and show loading
    resultDiv.innerHTML = 'Checking username...';

    fetch('check_username.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'username=' + encodeURIComponent(username)
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        let result = '<ul>';
        for (const [platform, status] of Object.entries(data)) {
            result += `<li>${platform}: ${status}</li>`;
        }
        result += '</ul>';
        resultDiv.innerHTML = result;
    })
    .catch(error => {
        console.error('Error:', error);
        resultDiv.innerHTML = `An error occurred: ${error.message}`;
    });
});
