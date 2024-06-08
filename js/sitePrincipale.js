'use strict';



/**
 * add event on element
 */

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
$(document).ready(function() {
  $.ajax({
    url: 'produitAffiche.php',
    type: 'GET',
    dataType: 'json',
    success: function(response) {
      var produits = response.produits;
      var output = ""; // Initialiser la variable pour stocker le contenu HTML

      var i = 0;
      while (i < produits.length) {
        var produit = produits[i];
        var imageSrc = "../images/" + produit.img; // Chemin de l'image
        var nomProduit = produit.nam; // Nom du produit

        // Concaténer le HTML pour chaque produit
        output += `<li class="scrollbar-item">
        <div class="category-card">
          <figure class="card-banner img-holder" style="--width: 330; --height: 300;">
            <img src="${imageSrc}" alt="${nomProduit}"
              class="img-cover" id="img${i + 1}">
          </figure>
          <h3 class="h3">
            <a href="#" class="card-title" id="abd${i + 1}">${nomProduit}</a>
          </h3>
          <div id="produitsContainer"></div>
        </div>
      </li>`;;
        i++;
      }
     
      // Insérer le contenu HTML dans la section appropriée
      $('#navbar').html(output);

      // Redimensionner les images après leur chargement
    
    },
    error: function(jqXHR, textStatus, errorThrown) {
      let errorMsg = `<tr><td colspan='4'>Erreur de chargement des produits: ${textStatus}</td></tr>`;
      if (errorThrown) {
        errorMsg += `<tr><td colspan='4'>Détails de l'erreur: ${errorThrown}</td></tr>`;
      }
      $('#resultats tbody').html(errorMsg);
    }
  });
});

