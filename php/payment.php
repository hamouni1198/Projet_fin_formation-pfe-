<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../css./payment.css">
  <title>Interactive card details form</title>

</head>

<body>

  <section class="main-container">
    <div class="content-container">

      <div class="cards">
        <div class="card-front">
          <img src="../logo./card-logo.svg" alt="logo" width="70px">
          <p class="cardNumberP">0000 0000 0000 0000</p>
          <div>
            <span class="nameSpan">IAN VIEIRA</span>
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
        <div class="adresse">
            <div calss="in">
            <label for="adresse">adresse</label>
            <input type="text" name="adresse" id="adresse" placeholder="adresse" maxlength="3">
            <p class="empty">votre adresse.</p>
            </div>
            <h2 id="prix">bonjour</h2>
          </div>
          <button type="submit">Confirmar</button>
        </div>

    </form>
    <input type="hiddden"  id="panier_id" >


      <form class="succeed-form hide">
        <img src="../logo./icon-complete.svg" alt="">
        <h2>OBRIGADO!</h2>
        <p>Seus dados do cartão foram adicionados</p>
        <button type="submit">Voltar</button>
      </form>

    </div>
  </section>
  <script src="../js/ajax.js"></script>

  <script src="../js./payment.js"></script>

</body>

</html>