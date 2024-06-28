$(document).ready(function() {

  $('.color-choose input').on('click', function() {
      var headphonesColor = $(this).attr('data-image');

      $('.active').removeClass('active');
      $('.left-column img[data-image = ' + headphonesColor + ']').addClass('active');
      $(this).addClass('active');
  });

});


$(document).ready(function() {
  
  var urlParams = new URLSearchParams(window.location.search);
  var produitId = urlParams.get('id_produit');
  var categorieId = urlParams.get('id_categorie');

  // Faire une requête AJAX pour récupérer les détails du produit
  $.ajax({
      url: 'TraitementVueProduit.php',
      method: 'POST',
      data: {
          'id_produit': produitId,
          'id_categorie': categorieId
      },
      dataType: 'json',
      success: function(response) {
          // Mettre à jour l'interface avec les données reçues
          $('#nam').text(response.nam);
          $('#cat').text(response.typ_cat);
          $('#desc').text(response.description);
          $('#product-price').text( response.prix + " DHS");
          $('#age').text(response.age + " ans");
          $('#sexe').text(response.sexe);
          $('#quantite').text( response.stock);
          $('#quantity').attr('data-available-quantity', response.stock);
          $('#quantity').attr('data-minimum-quantity', 1);
          $('#produitId').text(response.id_produit);



    
// Split the response to get the image URLs
var imgUrls = response.img.split(',');

// Define a list of selectors for the img elements
var imgSelectors = ['#imageProduit', 'img[data-image="blue"]', 'img[data-image="red"]'];

// Loop through the image URLs and assign them to the corresponding img elements
for (var i = 0; i < imgUrls.length; i++) {
  var imageUrl = '../images/' + imgUrls[i];

  if (i < imgSelectors.length) {
    $(imgSelectors[i]).attr('src', imageUrl);
  }
}

// Define a list of selectors for the input elements
// Split the response to get the image URLs
var imgUrls = response.img.split(',');

// Define a list of selectors for the input elements
var inputSelectors = ['input[data-image="red"]', 'input[data-image="blue"]', 'input[data-image="black"]'];

// Loop through the image URLs and assign them to the corresponding label elements as background images
for (var j = 0; j < imgUrls.length; j++) {
  // Calculate the index for the input selectors to reverse the order
  var reversedIndex = inputSelectors.length - 1 - j;
  
  var backgroundImageUrl = '../images/' + imgUrls[j];

  if (reversedIndex < inputSelectors.length) {
    var inputElement = $(inputSelectors[reversedIndex]);
    var labelElement = inputElement.next('label');
    labelElement.css('background-image', 'url(' + backgroundImageUrl + ')');
    

    var imgTest = new Image();
    imgTest.onerror = (function(url) {
      return function() {
        console.error('Failed to load image:', url);
      };
    })(backgroundImageUrl);
    imgTest.src = backgroundImageUrl;
  }
}
        },
      error: function(xhr, status, error) {
          console.error("AJAX Error: " + status, error);
      }
  });
});


document.getElementById('increase').addEventListener('click', function(event) {
  event.preventDefault(); // Prevent form submission
  var quantityInput = document.getElementById('quantity');
  var currentValue = parseInt(quantityInput.value);
  quantityInput.value = currentValue + 1;
});

document.getElementById('decrease').addEventListener('click', function(event) {
  event.preventDefault(); // Prevent form submission
  var quantityInput = document.getElementById('quantity');
  var currentValue = parseInt(quantityInput.value);
  if (currentValue > 1) {
      quantityInput.value = currentValue - 1;
  }
});
document.getElementById('age').addEventListener('click', function(event) {
  event.preventDefault(); // Prevent form submission
});

document.getElementById('sexe').addEventListener('click', function(event) {
  event.preventDefault(); // Prevent form submission

});

document.getElementById('quantite').addEventListener('click', function(event) {
  event.preventDefault(); // Prevent form submission

});




$(document).ready(function() {
  $('#addToCart').on('click', function(e) {
    e.preventDefault();
    if (validateForm()) {
      var username = $('#username').val();
      var email = $('#email').val();
      var tel = $('#tel').val();
      var productId = $('#produitId').val();
      var quantity = parseInt($('#quantity').val(), 10);
      var availableQuantity = parseInt($('#quantity').data('available-quantity'), 10);

      if (quantity <= availableQuantity) {
        // Vérification dans la console
        console.log("Données envoyées :", {
          username: username,
          email: email,
          tel: tel,
          productId: productId,
          quantity: quantity
        });

        // Votre code AJAX pour envoyer les données au serveur
        $.ajax({
          url: 'panierTraitement.php',
          method: 'POST',
          data: {
            username: username,
            email: email,
            tel: tel,
            productId: productId,
            quantity: quantity
          },
          success: function(response) {
            // Afficher un message de succès
            $('#succes').css('display', 'flex');
            // Recharger la page après 1 seconde
            setTimeout(function() {
              location.reload();
            }, 1000);
          },
          error: function(xhr, status, error) {
            console.error(error);
            alert('Une erreur s\'est produite lors de l\'ajout du produit au panier.');
          }
        });
      } else {
        alert("La quantité choisie n'est pas disponible en stock.");
      }
    }
  });

  function validateForm() {
    var isValid = true;
    $('#productForm #username,#productForm #email,#productForm #tel').each(function() {
      if ($(this).val() === '') {
        isValid = false;
        alert('Veuillez remplir tous les champs.');
        return false; // Arrêter la boucle each() si un champ est vide
      }
    });
    return isValid;
  }

  
});
