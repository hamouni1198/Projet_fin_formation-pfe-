<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tutorial</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- CSS -->
    <link href="../css./vueProduit.css" rel="stylesheet">
    <meta name="robots" content="noindex,follow" />

  </head>

  <body>
  
  <main class="container">
    <div class="left-column">
    <img data-image="black" id="imageProduit" src="" alt="Product Image">
<img data-image="blue" src="" alt="">
<img data-image="red" class="active" src="" alt="">

    </div>
    <input type="hidden" name="id_produit" id="produitId">


    <div class="right-column">
      <div class="product-description">
        <span id='cat'></span>
        <h1 id="nam"></h1>
        <p id="desc"></p>
      </div>

      <div class="product-configuration">
        <div class="product-color">
          <div class="color-choose">
              <div>
                <input data-image="red" type="radio" id="red" name="color" value="red" checked>
                <label for="red"></label>
              </div>
              <div>
                <input data-image="blue" type="radio" id="blue" name="color" value="blue">
                <label for="blue"><span></span></label>
              </div>
              <div>
                <input data-image="black" type="radio" id="black" name="color" value="black">
                <label for="black"><span></span></label>
              </div>
            </div>

          </div>

          <div class="quantity-container">
    <button class="quantity-button" id="decrease">-</button>
    <input type="text" id="quantity" value="1" data-available-quantity="5" readonly>
    <button class="quantity-button" id="increase">+</button>
</div>



        <!-- Cable Configuration -->
        <div class="cable-config">
          <span></span>
          <div class="cable-choose">
            <button id="age"></button>
            <button id="sexe"></button>
            <button id="quantite"></button> <br>
            <div class="product-price">

            <span id="product-price"></span>
            </div>

          </div>
        </div>
      </div>
 
  
 
      <!-- Product Pricing -->
      <div class="product-price">
        <button class="cart-btn" id="addToCart">Ajouter au Panier</button>
      </div>
    </div>
  </main>
  <div class="succes" id="succes">
    <div class="icon">
    <i class="fa-solid fa-check"></i>
    </div>
    <div class="text">
        <h3>Succés!</h3>
        <p>l'opération est faite avec succès</p>

    </div>
    </div>

    <!-- Scripts -->
    <script src="../js./ajax.js" charset="utf-8"></script>
    <script src="../js./vueProduit.js" charset="utf-8"></script>
  </body>
</html>

        