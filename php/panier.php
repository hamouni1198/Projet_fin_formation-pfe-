<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css./panier.css">
    <title>Document</title>
</head>
<body >

        <div class="container flex">
            <div class="structure">
              <h1>Panier</h1>
          
              <table id="table">
                <thead>
                  <tr>
                    <th>Nom de l'article</th>
                   
                    <th>Quantité</th>
                    <th>Price unitaire</th>
                    <th>Sous total</th>
                   
                  </tr>
                </thead>
                <tbody id="all_products">
                  <tr> 
                    <td class="article--name"><div style="margin-right:1rem"><img src="https://picsum.photos/id/237/100/100"></div> <div><h3>Sac de riz<h3/> <a class="remove" id="1">Supprimer</a></div></td>
                  
                      
                      <td class="quantity"> 
                        <button class="qty-minus" id="1">-</button>
                        <input type="text" readonly placeholder="Unit price"  class="qty" value="1" >
                        <button class="qty-plus" id="1">+</button>
                      </td>
                      <td class="price"> 15000 fr</td> 
                      <td class="subtotal">15000 fr</td>
                  </tr>
                 
                </tbody>
                <tfoot>
                  <tr>
                    <td><input type="text" id="name_product" placeholder="Nom de l'article" contenteditable></td>
                    <td><input  type="number" step="1" id="price_product" value="1000" contenteditable></td>
                    <td></td>
            
                    <td><button type="button" id="add_button">Ajouter un article</button></td>
                  </tr>
                </tfoot>
              </table>
              <h2>Total : <span id="total_display">0 fr cfa</span></h2>
            </div>
          </div>
          
          
          <script src="../js./panier.js">
    
          </script>
        
    </body>
</html>