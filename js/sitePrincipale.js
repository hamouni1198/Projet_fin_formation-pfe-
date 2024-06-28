'use strict';

const addEventOnElem = function (elem, type, callback) {
  if (elem.length > 1) {
    for (let i = 0; i < elem.length; i++) {
      elem[i].addEventListener(type, callback);
    }
  } else {
    elem.addEventListener(type, callback);
  }
}



/**
 * navbar toggle
 */

const navToggler = document.querySelector("[data-nav-toggler]");
const navbar = document.querySelector("[data-navbar]");
const navbarLinks = document.querySelectorAll("[data-nav-link]");

const toggleNavbar = function () {
  navbar.classList.toggle("active");
  navToggler.classList.toggle("active");
}

addEventOnElem(navToggler, "click", toggleNavbar);


const closeNavbar = function () {
  navbar.classList.remove("active");
  navToggler.classList.remove("active");
}

addEventOnElem(navbarLinks, "click", closeNavbar);



/**
 * active header when window scroll down to 100px
 */

const header = document.querySelector("[data-header]");
const backTopBtn = document.querySelector("[data-back-top-btn]");

const activeElemOnScroll = function () {
  if (window.scrollY > 100) {
    header.classList.add("active");
    backTopBtn.classList.add("active");
  } else {
    header.classList.remove("active");
    backTopBtn.classList.remove("active");
  }
}

addEventOnElem(window, "scroll", activeElemOnScroll);



//affiche produit

$(document).ready(function() {
  // AJAX call to fetch products and display them
  $.ajax({
    url: 'produitAffiche.php',
    type: 'GET',
    dataType: 'json',
    success: function(response) {
      var produits = response.produits;
      var output = "";

      produits.forEach(function(produit) {
        var imageUrls = produit.img.split(',');
        var nomProduit = produit.nam.trim();
        var prix = produit.prix;

        var imageSrcDefault = imageUrls[0] ? imageUrls[0].trim() : '';
        var imageSrcHover = imageUrls[1] ? imageUrls[1].trim() : '';

        output += `
        <input type='hidden' name='categorie_id' value='${produit.id_categorie}'>
        <input type='hidden' name='produit_id' value='${produit.id_produit}'>
          <li>
            <div class="product-card">
              <div class="card-banner img-holder" style="--width: 360; --height: 360;">
                <img src="../images/${imageSrcDefault}" width="500" height="500" loading="lazy" alt="${nomProduit}" class="img-cover default" id='imgP' data-categorie-id="${produit.id_categorie}" data-produit-id="${produit.id_produit}">
                <img src="../images/${imageSrcHover}" width="360" height="360" loading="lazy" alt="${nomProduit}" class="img-cover hover" id='imgP' data-categorie-id="${produit.id_categorie}" data-produit-id="${produit.id_produit}">
                <button class="card-action-btn" aria-label="add to cart" title="Add To Cart">
                  <ion-icon name="bag-add-outline" aria-hidden="true"></ion-icon>
                </button>
              </div>
              <div class="card-content">
                <div class="wrapper">
                  <div class="rating-wrapper">
                    <ion-icon name="star" aria-hidden="true"></ion-icon>
                    <ion-icon name="star" aria-hidden="true"></ion-icon>
                    <ion-icon name="star" aria-hidden="true"></ion-icon>
                    <ion-icon name="star" aria-hidden="true"></ion-icon>
                    <ion-icon name="star" aria-hidden="true"></ion-icon>
                  </div>
                  <span class="span">(1)</span>
                </div>
                <h3 class="h3">
                  <a href="#" class="card-title">${nomProduit}</a>
                </h3>
                <data class="card-price" value="${prix}">${prix} MAD</data>
              </div>
            </div>
          </li>`;
      });

      $('#navbar').html(output); // Display products in the designated HTML element
    },
    error: function(jqXHR, textStatus, errorThrown) {
      console.error('AJAX Error:', textStatus, errorThrown);
      var errorMsg = `<li>Erreur de chargement des produits: ${textStatus}</li>`;
      $('#navbar').html(errorMsg);
    }
  });

  // Click event handler for product images
  $(document).ready(function(){
    $(document).on('click', '#imgP', function() {
      var categorieId = $(this).data('categorie-id');
      var produitId = $(this).data('produit-id');
    

        $.ajax({
            url: 'TraitementVueProduit.php',
            method: 'POST',
            data: {
                'click_edite': true,
                'id_produit': produitId,
                'id_categorie': categorieId
            },
            success: function(response) {
                // Rediriger vers la page vueProduit avec les données reçues
                window.location.href = 'vueProduit.php?id_produit=' + produitId + '&id_categorie=' + categorieId;
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error: " + status, error);
            }
        });
    });
});
});

//login
document.getElementById('user').addEventListener('click', function() {
  // Add a class to trigger the transition
  document.getElementById('login').classList.add('show');

});




//login
$(document).ready(function() {
  $(document).on('click', '#loginUser', function(e) {
    e.preventDefault(); // Empêche la soumission du formulaire par défaut
    
    if (validateForm()) {
      var nom = $('#username').val();
      var email = $('#Email').val();
      var tel = $('#tel').val();

      console.log('Nom:', nom);
      console.log('Email:', email);
      console.log('Téléphone:', tel);

      $.ajax({
        url: 'adduser.php',
        method: 'POST',
        dataType: 'text',
        data: {
          tel: tel,
          email: email,
          nom: nom,
        },
        success: function(response) {
          console.log(response);
          $('#login').hide(); // Masquer la popup
        },
        error: function(xhr, status, error) {
          console.error(error);
        }
      });
    }
  });

  function validateForm() {
    var isValid = true;
    $('#loginCl input').each(function(){
      if ($(this).val() === '') {
        isValid = false;
        return false; 
      }
    });
    if (!isValid) {
      alert('Veuillez remplir tous les champs.');
    }
    return isValid;
  }
});

