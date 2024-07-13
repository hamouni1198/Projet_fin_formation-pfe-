<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../css./payment.css">
  <title>payment</title>

</head>

<body>
<input type="hidden" id="id_panier">
<input type="hidden" id="id_client">
<input type="hidden" id="totalPrix">
<input type="hidden" id="quantiteAchete">

  <section class="main-container">
    <div class="content-container">

      <div class="cards">
        <div class="card-front">
          <img src="../logo./card-logo.svg" alt="logo" width="70px">
          <p class="cardNumberP">0000 0000 0000 0000</p>
          <div>
            <span class="nameSpan">Mega Joeut</span>
            <span>
              <span class="monthSpan">04</span>/
              <span class="yearSpan">23</span>
            </span>
          </div>
        </div>
        <div class="card-back">
          <p class="cvcP">123</p>
        </div>
      </div>

      <form class="form">
        <label for="name">Nome de propeite de la carte</label>
        <input type="text" name="name" class="name" placeholder="Ex.: Ian V de Souza" maxlength="28" autocomplete="off">
        <p class="empty">nome dans la carte</p>

        <label for="card-number">Numero de la carte</label>
        <input type="text" name="card-number" class="cardNumber" placeholder="Ex.: 1234 5678 9123 0000" maxlength="19"
          autocomplete="off">
        <p class="empty">Numero de la carte</p>
        <div class="date-cvc">
          <div class="date">
            <label for="date">Exp Date (jj/AA)</label>
            <input type="text" name="month" id="month" placeholder="JJ" maxlength="2">
            <input type="text" name="year" id="year" placeholder="AA" maxlength="2">
          </div>
          <div class="cvc">
            <label for="date">CVC</label>
            <input type="text" name="cvc" id="cvc" placeholder="Ex.: 123" maxlength="3">
            <p class="empty">code de validation.</p>
          </div>
        </div>
        <label for="name">Adresse </label>
        <input type="text" name="name" class="name" placeholder="Ex.: Rue 11 Nr 14" maxlength="28" autocomplete="off">
        <p class="empty">Votre adresse</p>
           
          <button type="submit" id="confermer">Confirmar</button>
        </div>

    </form>
    </div>
  </section>
  <div class="succes" id="succes">
    <div class="icon">
    <i class="fa-solid fa-check"></i>
    </div>
    <div class="text">
        <h3>Succés!</h3>
        <p>l'opération est faite avec succès</p>

    </div>
    </div>

  <script src="../js/ajax.js"></script>

  <script src="../js./payment.js"></script>

</body>

</html>