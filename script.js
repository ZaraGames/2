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
    .then(response => response.json())
    .then(data => {
        let result = '<ul>';
        for (const [platform, available] of Object.entries(data)) {
            result += `<li>${platform}: ${available ? 'Available' : 'Taken'}</li>`;
        }
        result += '</ul>';
        resultDiv.innerHTML = result;
    })
    .catch(error => {
        console.error('Error:', error);
        resultDiv.innerHTML = 'An error occurred while checking the username.';
    });
});
