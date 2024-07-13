// form verify functions
const empty = document.querySelectorAll('.empty')
const error = document.querySelectorAll('.error')

function isEmpty(input,index){
    input.addEventListener('focus', () => {
        if(input.value === ''){
            empty[index].classList.add('show')
        }
    })

    input.addEventListener('keyup', () => {
        if(input.value === ''){
            empty[index].classList.add('show')
        } else {
            empty[index].classList.remove('show')
        }
    })
}


function isNumber(input,index){
    input.addEventListener('keyup', () => {
        const num = Number(input.value.replaceAll(' ',''));
        if(!num){
            error[index].classList.add('show')
        } else {
            error[index].classList.remove('show')
        }
    })
}


// name
const nameInput = document.querySelector('.name')
const nameSpan = document.querySelector('.nameSpan')

nameInput.addEventListener('keyup', () => {
    nameSpan.innerHTML = nameInput.value;
})

isEmpty(nameInput,0)

//card number
const cardNumberInput = document.querySelector('.cardNumber')
const cardNumberP = document.querySelector('.cardNumberP')

cardNumberInput.addEventListener('keyup', () => {
    let inputLength = cardNumberInput.value.length;
    
    if(inputLength === 4 || inputLength === 9 || inputLength === 14){
        cardNumberInput.value += ' ';
    }

    cardNumberP.innerHTML = cardNumberInput.value;
})

isEmpty(cardNumberInput,1)
isNumber(cardNumberInput,0)

//month 'n year expire date
const monthInput = document.getElementById('month')
const monthSpan = document.querySelector('.monthSpan')

monthInput.addEventListener('keyup', () => {
    monthSpan.innerHTML = monthInput.value;
})

isEmpty(monthInput,2)
isNumber(monthInput,1)

const yearInput = document.getElementById('year')
const yearSpan = document.querySelector('.yearSpan')

yearInput.addEventListener('keyup', () => {
    yearSpan.innerHTML = yearInput.value;
})

isEmpty(yearInput,3)
isNumber(yearInput,2)

//cvc

const cvcInput = document.getElementById('cvc')
const cvcP = document.querySelector('.cvcP')

cvcInput.addEventListener('keyup', () => {
    cvcP.innerHTML = cvcInput.value;
})

isEmpty(cvcInput,4)
isNumber(cvcInput,3)

//Form

const form = document.querySelector('.form')
const succeedForm = document.querySelector('.succeed-form')

function validateForm(i1,i2,i3,i4,i5){
    if(i1.value && i2.value && i3.value && i4.value && i5.value){
        return true
    } else {
        return false
    }
}



form.addEventListener('submit', (e) => {
    e.preventDefault();
    if(validateForm(nameInput,cardNumberInput,monthInput,yearInput,cvcInput)){
        form.classList.add('hide')
        succeedForm.classList.remove('hide')
    }
})





var idPanier = localStorage.getItem("id_panier");
var idClient = localStorage.getItem("id_client");
var total = localStorage.getItem("total");
var quantiteAchete = localStorage.getItem("quantiteAchete");


// Afficher les données dans la div 'panier-summary'
document.getElementById('id_panier').value = idPanier;
document.getElementById('id_client').value = idClient;
document.getElementById('totalPrix').value = total;
document.getElementById('quantiteAchete').value = total;
console.log(total);


//confirmer payment
$(document).ready(function() {
    document.getElementById("confermer").addEventListener("click", function() {
        var id_panier = $('#id_panier').val();
        var id_client = $('#id_client').val();
        var total = $('#totalPrix').val();
        $.ajax({
            url: 'passeCommande.php',
            method: 'POST',
            data: {
                id_panier: id_panier,
                id_client: id_client,
                total: total
            },
            success: function(response) {
                window.location.href='sitePrincipale.php';  
            },
            error: function(xhr, status, error) {
                console.error("Erreur de l'appel AJAX:", error);
                setTimeout(function() {
                    $('#error').css('display', 'inline-flex').css('zIndex', 1).addClass('error');
  
                    setTimeout(function() {
                        $('#error').css('display', 'none');
                    }, 3000); // Durée du toast d'erreur
                }, 0); 
            }
        });
    });
});
