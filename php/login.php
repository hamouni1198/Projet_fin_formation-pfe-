<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hilfbox Login</title>
    <link rel="stylesheet" href="../css/login.css">
</head>
<body>
    <div class="container">
        <div class="left-section">
            <div class="welcome-message">
             
                <h1>Mega Jouet</h1>
                <p>We are a community together helping thousands of people out there who are struggling.</p>
            </div>
        </div>
        <div class="right-section">
            <div class="form-container">
                <h2>Get Started</h2>
                <form id="loginForm">
                    <div class="input-group">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="nom" placeholder="Roseanne Park">
                        <div id="userError" class="error-message"></div>
                    </div>
                   
                    <div class="input-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="code" placeholder="Password">
                        <div id="passwordError" class="error-message"></div>
                    </div>
                    <button type="submit">Sign Up</button>
                </form>
                <div id="errorMessage" class="error-message"></div>
                
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('loginForm').addEventListener('submit', function (e) {
                e.preventDefault();

                var formData = new FormData(this);

                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'serveurlogin.php', true);
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            if (xhr.responseText) {
                                try {
                                    var response = JSON.parse(xhr.responseText);
                                    if (response.success) {
                                        window.location.href = 'mise.php?succes';
                                    } else {
                                        document.getElementById('userError').textContent = '';
                                        document.getElementById('passwordError').textContent = '';
                                        document.getElementById('errorMessage').textContent = '';

                                        if (response.message.username) {
                                            document.getElementById('userError').textContent = response.message.username;
                                        }
                                        if (response.message.password) {
                                            document.getElementById('passwordError').textContent = response.message.password;
                                        }
                                        if (response.message.invalid) {
                                            alert(response.message.invalid);
                                        }
                                    }
                                } catch (e) {
                                    console.error('Error parsing JSON response:', e);
                                    console.error('Response text was:', xhr.responseText);
                                }
                            } else {
                                console.error('Empty response received from server');
                            }
                        } else {
                            console.error('Une erreur s\'est produite. Status:', xhr.status);
                        }
                    }
                };
                xhr.send(formData);
            });

            document.getElementById('loginForm').addEventListener('input', function (e) {
                var target = e.target;
                if (target.tagName.toLowerCase() === 'input') {
                    var errorId = target.name + 'Error';
                    document.getElementById(errorId).textContent = '';
                }
            });
        });
    </script>
</body>
</html>
