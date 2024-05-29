<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/login.css">
    <title>Login</title>
</head>

<body>
    <div class="container">
        <div class="card">
            <form methode="POST" id="loginForm" >
                <h1 class="titre">Mega Jouet</h1>
                <input type="text" placeholder="Username" name="nom" autocomplete="off">
                <span style="color:red; font-size: 15px; text-align: center;" id="userError"></span>
                <input type="password" placeholder="Password" name="code" autocomplete="off">
                <span style="color:red; font-size: 15px; text-align: center;" id="passwordError"></span>

                <input type="submit" value="Login" name="sub" class="b1">

            </form>
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
