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

          console.log(response); // Affiche les données récupérées dans la console

          var produits = response.produit;
          if (produits.length > 0) {
              for (var i = 0; i < produits.length; i++) {
                  var produit = produits[i];
                  var nom =document.getElementById('nom');
                  nom.text=produit.nam;
                  var img=document.getElementById('img1')
                  var imgUrls = produit.img.split(',');
                  var firstUrl = imgUrls[0];
                  var imageUrl = '../images/' + firstUrl;
                  var imgElement = $('<img>').attr('src', imageUrl).attr('alt', produit.nom); // Assumant que le nom de la colonne est 'nom'
                  img.attr =imgElement
              }
          } 
      },
      error: function(xhr, status, error) {
          console.error('Erreur AJAX : ' + status + ' - ' + error);
      }
  });
});
