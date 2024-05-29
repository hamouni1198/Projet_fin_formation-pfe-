<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./mise.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    
    <title>Vue détails</title>
</head>

<body>
    <div class="header">
        <img src="../logo/img1.jpg" alt="">
    </div>
<div class="titrP">
    <h1>Consultation des Produit</h1>
<button id="ajouter">Ajouter <i class="fa-solid fa-plus"></i></button>

</div>
   

    <div class="filtr">
            <div class="filtration">
                <label for="">type:</label>
                <select name="type" id="typ" class="ftyp">
                    <option value=""></option>
                    <?php
                      $server = 'localhost';
                      $bd = 'megajouet';
                      $user = 'root';
                      $password = '';
                      $con = new mysqli($server, $user, $password, $bd);
                    
                    $typ = "SELECT DISTINCT typ_cat FROM categorie";
                    $typresultat = $con->query($typ);

                    while ($filtr = $typresultat->fetch_assoc()) {
                        echo '<option value="' . $filtr['typ_cat'] . '">' . $filtr['typ_cat'] . '</option>';
                    }
                    ?>
                </select>
                
                <label for="">sexe:</label>
                <select name="sexe" id="sex">
                    <option value=""></option>
                    <?php
                    
   
                    $sexe = "SELECT DISTINCT sexe FROM categorie";
                    $sexetype = $con->query($sexe);

                    while ($sexe = $sexetype->fetch_assoc()) {
                        echo '<option value="' . $sexe['sexe'] . '">' . $sexe['sexe'] . '</option>';
                    }
                    ?>
                    
                </select>
                <label for="">date:</label>
                <input type="date" id="dat" name="dat">
                <button name="filtre" class="b1" id="filtre" >filtrer</button> 
                         
            </div>
           
            <Div>
            <?php
                    
   
                    $nombre = "SELECT COUNT(nam) AS total_produits FROM produit;";
                    $nombrepro = $con->query($nombre);

                    while ($nombre = $nombrepro->fetch_assoc()) {
                        echo '<h4>Nombre de Produit:' . $nombre['total_produits'] . '</h4>';
                    }
                    ?>
            </Div>
        </div>

        <div class="table-responsive">
    <table class="table  table-striped table-bordered">
        <thead>
            <tr>
                <th>type</th>
                <th>sexe</th>
                <th>nom</th>
                <th>prix</th>
                <th>age</th>
                <th>Date-Creation</th>
                <th>Etat</th>
                <th>Action</th>

            </tr>
        </thead>
        <tbody id="resultats"> 
            <!-- Your table data goes here -->
        </tbody>
    </table>
</div>



    <div id="ajouterp" class="popup">
        <div class="popup-content">
            <i class="fa-solid fa-xmark"  id="closePopup"></i>
            <h4 id="insertion" style="
    text-align: center;
    color: green;
    letter-spacing: 3px;"></h4>

        <h3>Ajouter Produit</h3>
        <hr>
        <table class="table">
            <tr>
                <td class="tab-links active-link" onclick="openTab('ca')">Catégorie</td>
                <td class="tab-links" onclick="openTab('pr')">Produit</td>
            </tr>
        </table>
        <aside>
            <form action="" id="form" >
            <table >
                <tbody class="tab-contents active-tab et1" id='pr'>
                <tr>
                    <td><label >Type-categorie:</label></td>
                    <td><input type="text" name='typ' id="type" autocomplete="off"></td>
                </tr>
                <tr>
                    <td>Sexe:</td>
                    <td><select name="sexe" id="sexe">
                        <option value=""></option>
                        <option value="garcon">garcon</option>
                        <option value="fille">fille</option>
                    </select>
                    </td>
                </tr>
                </tbody>
            <thead class="tab-contents et1" id='ca'>
            
    
                <tr>
                    <td><label > Nom de Produit:</label></td>
                    <td><input type="text" name='nom' id="nome" autocomplete="off"></td>

                </tr>
                <tr>
                    <td><label >quantité en stock:</label></td>
                    <td><input type="text" name='stock' id="stock" autocomplete="off"></td>

                </tr>
                <tr>
                    <td><label >Prix:</label></td>
                    <td><input type="text" name='prix' id="prix" autocomplete="off"></td>

                </tr>
                <tr>
                    <td><label >Age:</label></td>
                    <td><input type="text" name='age' id="age" autocomplete="off"></td>

                </tr>
                <tr class="images">
                <td colspan="2">
                    <label for="fileimg" class="drop-container" id="dropcontainer">
                        <span class="drop-title">Déposez les fichiers ici</span>
                        ou
                        <input type="file" name="fileImg[]" id="fileimg" accept="image/*" multiple required>
                    </label>
                </td>
            </tr>
                <tr>
                    <td><label >Description:</label></td>
                    <td><textarea name="desc" id="desc" cols="30" rows="5" autocomplete="off"></textarea></td>

                </tr>
                <tr>
                    <td><label >Date de Creation:</label></td>
                    <td><input type="date" name='date' id="date" class="date"></td>
                </tr>
                </thead>
            </table>
            </form>
            <div class="button" id="bu">
                <button type='reset' name='res' class="b4" id="annuler" >Annuler</button>
                <button type='submit' name='sub' class="b6" id="suivant"  onclick="openTab('pr')">Suivant</button>
                <button type='submit' name='sub' class="b7" id="precedent" onclick="openTab('ca')" >precedent</button>
                <button type='submit' name='sub' class="b5" id="button" >Enregistrer</button>
                
            </div>
    </aside>
    </div>
</div>

<div id="modifiep" class="popup">
        <div class="popup-content">
            <i class="fa-solid fa-xmark"  id="close"></i>
            <h4 id="insertion" style="
    text-align: center;
    color: green;
    letter-spacing: 3px;"></h4>
               <input type="hidden" name="id_categorie" id="categorieId">
                <input type="hidden" name="id_produit" id="produitId">
                <input type="hidden" name="id_realisateur" id="utilisateurId">
        <h3>Modifie  Produit</h3>
        <hr>
        <table class="table">
            <tr>
                <td class="tab-links active-link" onclick="openTabEdite('categorie')">Catégorie</td>
                <td class="tab-links" onclick="openTabEdite('produit')">Produit</td>
            </tr>
        </table>
        <aside>

            <table >
                <tbody class="tab-contents active-ta et1" id='produit'>
                <tr>
                    <td><label >Type-categorie:</label></td>
                    <td><input type="text" name='t' id="t" autocomplete="off"></td>
                </tr>
                <tr>
                    <td>Sexe:</td>
                    <td><select name="s" id="s">
                        <option value=""></option>
                        <option value="garcon">garcon</option>
                        <option value="fille">fille</option>
                    </select>
                    </td>
                </tr>
                </tbody>
            <thead class="tab-contents et1" id='categorie'>
            
    
                <tr>
                    <td><label > Nom de Produit:</label></td>
                    <td><input type="text" name='n' id="n" autocomplete="off"></td>

                </tr>
                <tr>
                    <td><label >quantité en stock:</label></td>
                    <td><input type="text" name='st' id="st" autocomplete="off"></td>

                </tr>
                <tr>
                    <td><label >Prix:</label></td>
                    <td><input type="text" name='p' id="p" autocomplete="off"></td>

                </tr>
                <tr>
                    <td><label >Age:</label></td>
                    <td><input type="text" name='a' id="a" autocomplete="off"></td>

                </tr>
                <tr>
                    <td><label>Src-image:</label></td>
                    <td><input type="text" name='i' id="i" autocomplete="off"></td>

                </tr>
                <tr>
                    <td><label >Description:</label></td>
                    <td><textarea name="d" id="d" cols="30" rows="5" autocomplete="off"></textarea></td>

                </tr>
                <tr>
                    <td><label >Date de Creation:</label></td>
                    <td><input type="date" name='da' id="da" class="date"></td>
                </tr>
                </thead>
            </table>

            <div class="button" id="butt">
                <button type='reset' name='res' class="b4" id="annule" >Annuler</button>
                <button type='submit' name='sub' class="b6" id="suivan"  onclick="openTabEdite('produit')">Suivant</button>
                <button type='submit' name='sub' class="b7" id="preceden" onclick="openTabEdite('categorie')" >precedent</button>
                <button type='submit' name='editeData' class="b5" id="enregistrer" >Enregistrer</button>
                
            </div>
    </aside>
    </div>
</div>

        <div class="popup" id='vueD'>
   
   <section class="product-container">
       <i class="fa-solid fa-xmark"  id="vueC"></i>
       <h3>vue détail</h3>
       <hr>
       <div class="produit">
       <div class="imgP" id="Vimg">
        
        </div>
        <div class="infP">
                    <h4 class='nam' id='Vnam'></h4>
                    <h4 id=Vprix></h4>
                    <p id="Vdesc"></p>
                    <h4 id="Vquan"></h4>
                    <h4 id="Vage"></h4>
                    <h4 class='date' id="Vdate"></h4>
                    <div class="button2">
                           <button class="return">returner</button>
   
                               <button class="b1" >Poster</button>
                           </div>

        </div>
        </div>

                 
                         
                          
   
                                   </section>
</div>

<div class="succes" id="succes">
    <div class="icon">
    <i class="fa-solid fa-check"></i>
    </div>
    <div class="text">
        <h3>Succés!</h3>
        <p>l'opération est faite avec succès</p>

    </div>
    </div>


    
    <div class="error" id="error">
    <div class="icon">
    <i class="fa-solid fa-check"></i>
    </div>
    <div class="text">
        <h3>error!</h3>
        <p>l'opération est faite avec succès</p>

    </div>
    </div>

<script src="../js/ajax.js"></script>



    <script src="../js/mise.js"></script>
</body>

</html>
<?php include('insertion.php'); ?>

