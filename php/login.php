<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hilfbox Login</title>
    <link rel="stylesheet" href="../css./login.css">
</head>
<body>
    <div class="container">
        <div class="left-section">
            <div class="welcome-message">
                <div class="logo">
                    <img src="../logo/img1.jpg" alt="Hilfbox Logo">
                </div>
                <h1>Mega Jouet</h1>
                <p>We are a community together helping thousands of people out there who are struggling.</p>
              
            </div>
        </div>
        <div class="right-section">
            <div class="form-container">
                <h2>Get Started</h2>
                <p>Already have an account? <a href="#">Sign In</a></p>
                <form>
                    <div class="input-group">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" placeholder="Roseanne Park">
                    </div>
                    <div class="input-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="roseannepark@gmail.com">
                    </div>
                    <div class="input-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Password">
                    </div>
                    <button type="submit">Sign Up</button>
                </form>
                <div class="social-signup">
                    <p>Or sign up with</p>
                    <div class="social-icons">
                        <a href="#"><img src="google.png" alt="Google"></a>
                        <a href="#"><img src="twitter.png" alt="Twitter"></a>
                        <a href="#"><img src="facebook.png" alt="Facebook"></a>
                    </div>
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
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        window.location.href = 'mise.php?succes';
                    } else {
                        // Effacer les messages d'erreur précédents
                        document.getElementById('userError').textContent = '';
                        document.getElementById('passwordError').textContent = '';
                        document.getElementById('errorMessage').textContent = '';

                        // Afficher les nouveaux messages d'erreur
                        if (response.message.username) {
                            document.getElementById('userError').textContent = response.message.username;
                        }
                        if (response.message.password) {
                            document.getElementById('passwordError').textContent = response.message.password;
                        }
                        if (response.message.invalid) {
                            var errorMessage = response.message.invalid;
                            alert(errorMessage);
                        }
                    }
                } else {
                    console.error('Une erreur s\'est produite');
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
