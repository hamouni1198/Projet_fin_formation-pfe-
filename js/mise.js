
//affiche ferme popup ajouter
document.getElementById('ajouter').addEventListener('click', function() {
    document.getElementById('ajouterp').style.display = 'flex';

      });
  document.getElementById('closePopup').addEventListener('click', function() {
    document.getElementById('ajouterp').style.display = 'none';

  });
 //close vue detail
  $('#vueC').click(function() {
    $('#vueD').css('display', 'none');
});

//clos modifiepopup
document.getElementById('close').addEventListener('click', function() {
    document.getElementById('modifiep').style.display = 'none';
});


//ajouter popup
function openTab(tabName) {
    var categorieTab = document.getElementById('ca');
    var produitTab = document.getElementById('pr');
    var suivantBtn = document.getElementById('suivant');
    var precedentBtn = document.getElementById('precedent');
    var enregistreBtn = document.getElementById('button');
    var button = document.getElementById('bu')
    var partie1 =document.getElementById('partie1')
    var partie2 =document.getElementById('partie2')

    

    if (tabName === 'pr') {
        categorieTab.classList.add('active-tab');
        produitTab.classList.remove('active-tab');
        precedentBtn.style.display = 'block';
        suivantBtn.style.display = 'none';
        enregistreBtn.style.display = 'block';
        button.style.left='1008px'
        partie1.style.color='black';
        partie2.style.color='rgb(190 184 51)';


    } else if (tabName === 'ca') {
        categorieTab.classList.remove('active-tab');
        produitTab.classList.add('active-tab');
        precedentBtn.style.display = 'none';
        suivantBtn.style.display = 'block';
        enregistreBtn.style.display = 'none';
        button.style.left='1119px';
        partie1.style.color='rgb(190 184 51)';
        partie2.style.color='black';

    }
}
document.getElementById("annuler").addEventListener("click", function() {
    location.reload();
});



//edit popup
function openTabEdite(tabName) {
    var categorieTab = document.getElementById('categorie');
    var produitTab = document.getElementById('produit');
    var suivantBtn = document.getElementById('suivan');
    var precedentBtn = document.getElementById('preceden');
    var enregistreBtn = document.getElementById('enregistrer');
    var button = document.getElementById('butt')
    var partie1 =document.getElementById('partie1')
    var partie2 =document.getElementById('partie2')
    

    if (tabName === 'produit') {
        categorieTab.classList.add('active-ta');
        produitTab.classList.remove('active-ta');
        precedentBtn.style.display = 'block';
        suivantBtn.style.display = 'none';
        enregistreBtn.style.display = 'block';
        button.style.left='1008px'
        partie1.style.color='black';
        partie2.style.color='rgb(190 184 51)';

    } else if (tabName === 'categorie') {
        categorieTab.classList.remove('active-ta');
        produitTab.classList.add('active-ta');
        precedentBtn.style.display = 'none';
        suivantBtn.style.display = 'block';
        enregistreBtn.style.display = 'none';
        button.style.left='1119px';
        partie1.style.color='rgb(190 184 51)';
        partie2.style.color='black';
    }
}
document.getElementById("annule").addEventListener("click", function() {
    location.reload();
});



//inserer produit
$(document).ready(function(){
    $('#button').click(function(e){
        e.preventDefault();
        if(validateForm()){ 
            console.log('clicked');
            var type = $('#type').val();
            var sexe = $('#sexe').val();
            var nom = $('#nome').val();
            var stock = $('#stock').val();
            var prix = $('#prix').val();
            var age = $('#age').val();
            var desc = $('#desc').val();
            var date = $('#date').val();
            var files = $('#fileimg')[0].files; // Ajoutez cette ligne pour récupérer les fichiers sélectionnés

            var fileNames = [];
            for (var i = 0; i < files.length; i++) {
                fileNames.push(files[i].name);
            }
            
            
            let formData = new FormData();
            for (var i = 0; i < files.length; i++) {
                formData.append('fileImg[]', files[i]); // Notez l'utilisation de fileImg[] pour envoyer plusieurs fichiers
            }
            
            formData.append('typeSend', type);
            formData.append('sexeSend', sexe);
            formData.append('nomSend', nom);
            formData.append('stockSend', stock);
            formData.append('prixSend', prix);
            formData.append('ageSend', age);
            formData.append('descSend', desc);
            formData.append('dateSend', date);

            $.ajax({
                url: "insertion.php",
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {
            
                    setTimeout(function() {
                        // Afficher le toast
                        document.getElementById('succes').style.display = 'inline-flex';
                        document.getElementById('succes').style.zIndex = '1';
                        document.getElementById('succes').classList.add('succes');
            
                        // Masquer le toast après 3 secondes (3000 millisecondes)
                        setTimeout(function() {
                            document.getElementById('succes').style.display = 'none';
                            location.reload(); // Recharger la page
                        }, 1000);
                    }, 100); // Afficher le toast après 1 seconde
                },
                error: function(xhr, status, error) {
                   // Fonction exécutée si la requête AJAX échoue
            
                    // Attendez un moment avant d'afficher le toast
                    setTimeout(function() {
                        // Afficher le toast
                        document.getElementById('error').style.display = 'inline-flex';
                        document.getElementById('error').style.zIndex = '1';
                        document.getElementById('error').classList.add('error');
            
                        // Masquer le toast après 3 secondes (3000 millisecondes)
                        setTimeout(function() {
                            document.getElementById('error').style.display = 'none';
                            location.reload(); // Recharger la page
                        }, 1000);
                    }, 100); // Afficher le toast après 1 seconde
                }
            });
        }
    });

    function validateForm() {
        var isValid = true;
        $('#form input, #form select, #form textarea').each(function(){
            if($(this).val() === ''){
                isValid = false;
                return false; 
            }
        });
        if(!isValid) {
            alert('Veuillez remplir tous les champs.');
        }
        return isValid;
    }
});





//affiche avec filtre
$(document).ready(function() {
    // Gestionnaire de clic sur le bouton de filtrage
    $('#filtre').click(function() {
        // Récupération des valeurs des champs de filtrage
        var type = $('#typ').val();
        var sexe = $('#sex').val();
        var date = $('input[name="dat"]').val();

        // Envoi de la requête Ajax vers filtration.php
        $.ajax({
            url: 'filtration.php',
            method: 'POST',
            dataType: 'json',
            data: {
                type: type,
                sexe: sexe,
                date: date
            },
            success: function(data) {
                var output = "";
                // Construction du contenu HTML à partir des données reçues
                for (var i = 0; i < data.length; i++) {
                    output += "<tr><input type='hidden' name='categorie_id' value='" + data[i].id_categorie + "'><input type='hidden' name='produit_id' value='" + data[i].id_produit + "'><td>" + data[i].typ_cat + "</td><td>" + data[i].sexe + "</td><td>" + data[i].nam + "</td><td>"  + data[i].prix + "</td><td>" + data[i].age +"</td><td>" + data[i].date_creation+"</td id='etat'><td>"  + "</td><td class='bu'><button class='b2' id='b2' data-categorie-id='" + data[i].id_categorie + "'><i class='fa-solid fa-trash-can'></i></button><button class='vue' id='vue' data-produit-id='" + data[i].id_produit + "'><i class='fa-solid fa-eye'></i> </button><button class='b3' id='modifie' data-produit-id='" + data[i].id_produit + "'><i class='fas fa-edit'></i> </button></td></tr>";
                }
                // Injection du contenu HTML dans l'élément avec l'ID 'resultats'
                $('#resultats').html(output);

                // Réinitialisation des champs de filtrage
                $('#typ').val('');
                $('#sex').val('');
                $('input[name="dat"]').val('');
            }
        });
    });

 

    // Gestionnaire de clic sur le bouton de fermeture de la popup
   
});





//affiche sans filtre
$(document).ready(function() {
    var type = $('#typ').val();
    var sexe = $('#sex').val();
    var date = $('input[name="dat"]').val();

    $.ajax({
        url: 'affiche.php',
        method: 'POST',
        dataType: 'json',
        data: {
            type: type,
            sexe: sexe,
            date: date
        },
        success: function(data) {
            var output = "";
            if (data.length > 0) {
            for (var i = 0; i < data.length; i++) {
                output += "<tr><input type='hidden' name='categorie_id' value='" + data[i].id_categorie + "'><input type='hidden' name='produit_id' value='" + data[i].id_produit + "'><td>" + data[i].typ_cat + "</td><td>" + data[i].sexe + "</td><td>" + data[i].nam + "</td><td>"  + data[i].prix + "</td><td>" + data[i].age +"</td><td>" + data[i].date_creation+"</td id='etat'><td>"  + "</td><td class='bu'><button class='b2' id='b2' data-categorie-id='" + data[i].id_categorie + "'><i class='fa-solid fa-trash-can'></i></button><button class='vue' id='vue' data-produit-id='" + data[i].id_produit + "'><i class='fa-solid fa-eye'></i> </button><button class='b3' id='modifie' data-produit-id='" + data[i].id_produit + "'><i class='fas fa-edit'></i> </button></td></tr>";

                ;
            }
            }else {
                output = "<tr><td colspan='7'>Aucun produit trouvé</td></tr>";
            }
            $('#resultats').html(output);
        }
    });
});


//delete
$(document).ready(function() {
    $(document).on('click', '#b2', function() {
        var categoryId = $(this).data('categorie-id');
        
        $.ajax({
            url: 'delet.php',
            method: 'POST',
            dataType: 'text', 
            data: {
                categoryId: categoryId 
            },
            success: function(response) {
                setTimeout(function() {
                    // Display success toast
                    $('#succes').css('display', 'inline-flex').css('zIndex', 1).addClass('succes');

                    setTimeout(function() {
                        $('#succes').css('display', 'none');
                        location.reload(); 
                    }, 1000);
                }, 100); 
            },  
            error: function(xhr, status, error) {
                setTimeout(function() {
                    // Display error toast
                    $('#error').css('display', 'inline-flex').css('zIndex', 1).addClass('error');

                    setTimeout(function() {
                        $('#error').css('display', 'none');
                        location.reload(); 
                    }, 1000);
                }, 100); 
            }
        });
    });
});


//modifie affiche
$(document).ready(function(){
    $(document).on('click', '.b3', function() {
        var categorieId = $(this).closest('tr').find('input[name="categorie_id"]').val();
        var produitId = $(this).closest('tr').find('input[name="produit_id"]').val();

        $.ajax({
            url: 'edite.php',
            method: 'POST',
            data: {
                'click_edite': true,
                'id_produit': produitId,
                'id_categorie': categorieId
            },
            success: function(response) {
                if(response.length > 0) {
                    var data = response[0];
                    $('#t').val(data.typ_cat);
                    $('#s').val(data.sexe); 
                    $('#n').val(data.nam); 
                    $('#st').val(data.stock); 
                    $('#p').val(data.prix); 
                    $('#a').val(data.age); 
                    $('#i').val(data.img); 
                    $('#d').val(data.description); 
                    $('#da').val(data.date_creation); 
                    $('#categorieId').val(data.id_categorie); 
                    $('#produitId').val(data.id_produit); 
                    $('#utilisateurId').val(data.id_utilisateur); 




                    document.getElementById('modifiep').style.display = 'flex';
                } else {
                    console.log("No data found");
                }
            }
        });
    });
});

//modifie  envoie formulaire
$(document).ready(function(){
    $('#enregistrer').click(function(e){
    
        e.preventDefault();
            console.log('clicked');
            var type = $('#t').val();
            var sexe = $('#s').val();
            var nom = $('#n').val();
            var stock = $('#st').val();
            var prix = $('#p').val();
            var age = $('#a').val();
            var img = $('#i').val();
            var desc = $('#d').val();
            var date = $('#da').val();
            var categorieId = $('#categorieId').val();
            var produitId = $('#produitId').val();
            var utilisateurId = $('#utilisateurId').val();


            let mydata= {
                typeSend: type,
                sexeSend: sexe,
                nomSend: nom,
                stockSend: stock,
                prixSend: prix,
                ageSend: age,
                imgSend: img,
                descSend: desc,
                dateSend: date,
                id_produit: produitId,
                id_categorie: categorieId,
                id_utilisateur: utilisateurId

            };
            $.ajax({
                url: "Envedite.php",
                method: 'POST',
                data: mydata,
                success: function(data) {
                    // This function runs if the AJAX request is successful
            
                    // Wait for a moment before showing the toast
                    setTimeout(function() {
                        // Display the toast
                        document.getElementById('succes').style.display = 'inline-flex';
                        document.getElementById('succes').style.zIndex = '1';
                        document.getElementById('succes').classList.add('succes');
            
                        // Hide the toast after 3 seconds (3000 milliseconds)
                        setTimeout(function() {
                            document.getElementById('succes').style.display = 'none';
                            location.reload(); // Reload the page
                        }, 1000);
                    }, 100); // Display toast after 1 second
                },
                error: function(xhr, status, error) {
                   // This function runs if the AJAX request is successful
            
                    // Wait for a moment before showing the toast
                    setTimeout(function() {
                        // Display the toast
                        document.getElementById('error').style.display = 'inline-flex';
                        document.getElementById('error').style.zIndex = '1';
                        document.getElementById('error').classList.add('error');
            
                        // Hide the toast after 3 seconds (3000 milliseconds)
                        setTimeout(function() {
                            document.getElementById('error').style.display = 'none';
                            location.reload(); // Reload the page
                        }, 1000);
                    }, 100); // Display toast after 1 second
                }
            });
        
    });

   
});



//recuperer donne vue detail
$(document).ready(function(){
    $(document).on('click', '.vue', function() {
        var categorieId = $(this).closest('tr').find('input[name="categorie_id"]').val();
        var produitId = $(this).closest('tr').find('input[name="produit_id"]').val();
        $.ajax({
            url: 'vuetraitement.php',
            method: 'POST',
            data: {
                'click_edite': true,
                'id_produit': produitId,
                'id_categorie': categorieId
            },
            success: function(response) {
                    var data = JSON.parse(response);
                    $('#vueD').css('display', 'flex');

                    if(data.length > 0) {
                        var productData = data[0];
                        $('#Vnam').text(productData.nam); 
                        $('#Vquan').text("Quantité:"+productData.stock); 
                        $('#Vprix').text(productData.prix+"Dh"); 
                        $('#Vage').text(productData.age+"ans"); 
                        $('#Vdesc').text(productData.description); 
                        $('#Vdate').text(productData.date_creation);
                        $('#categorieIdVue').val(productData.id_categorie);
                        $('#produitIdVue').val(productData.id_produit);

var imgUrls = productData.img.split(',');

// Récupérer le premier URL
var firstUrl = imgUrls[0];

// Créer l'URL complète de l'image en utilisant le premier URL
var imageUrl = '../images/' + firstUrl;
// Définir l'image de fond de l'élément #Vimg
$('#Vimg').css('background-image', 'url(' + imageUrl + ')');

                        $('#Vimg').css('background-image', 'url(' + imageUrl + ')');


                    } else {
                        console.log("No data found");
                    }
                
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error: " + status, error);
            }
        });
    });
});

//poste produit
document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("poste").addEventListener("click", function() {
        var idProduitVue = document.getElementById("produitIdVue").value;
        var idCategorieVue = document.getElementById("categorieIdVue").value;

        var formData = new FormData();
        formData.append("id_produit_vue", idProduitVue);
        formData.append("id_categorie_vue", idCategorieVue);

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "siteTraitement.php", true);
        xhr.onload = function() {
            console.log(xhr.responseText); // Affiche la réponse dans la console
            
            // Si la réponse est un succès, affiche le toast
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.error) {
                    showAlert(response.error); // Affiche l'alerte avec le message d'erreur
                } else {
                    showToast(); // Affiche le toast de succès
                }
            }
        };
        xhr.send(formData);
    });
    
    function showAlert(message) {
        // Affiche une alerte avec le message spécifié
        alert(message);
    }
    
    function showToast() {
        // Affiche le toast
        document.getElementById('succes').style.display = 'inline-flex';
        document.getElementById('succes').style.zIndex = '1';
        document.getElementById('succes').classList.add('succes');
    
        // Masque le toast après 3 secondes (3000 millisecondes)
        setTimeout(function() {
            document.getElementById('succes').style.display = 'none';
            location.reload(); // Recharge la page
        }, 2000);
    }
});


//delete post
$(function() {
    $(document).on('click', '#retirer', function() {
        var produitId = document.getElementById("produitIdVue").value;
        $.ajax({
            url: 'deletePost.php',
            method: 'POST',
            dataType: 'text', 
            data: { produitId: produitId },
            success: function(response) {
                console.log("Response: ", response); // Log the response
                setTimeout(function() {
                    let successElement = document.getElementById('succes');
                    successElement.style.display = 'inline-flex';
                    successElement.style.zIndex = '1';
                    successElement.classList.add('succes');
                    setTimeout(function() {
                        successElement.style.display = 'none';
                        location.reload();
                    }, 1000);
                }, 100); 
            },  
            error: function(xhr, status, error) {
                console.error("Error: ", error); // Log the error
                setTimeout(function() {
                    let errorElement = document.getElementById('error');
                    errorElement.style.display = 'inline-flex';
                    errorElement.style.zIndex = '1';
                    errorElement.classList.add('error');
                    setTimeout(function() {
                        errorElement.style.display = 'none';
                        location.reload(); 
                    }, 1000);
                }, 100); 
            }
        });
    });
});

