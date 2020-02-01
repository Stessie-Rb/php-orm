<?php
include(ROOT_PATH."/libs/html.lib.php");
require(ROOT_PATH."/classes/Db/DbPetitesAnnonces.class.php");
$mybdd = \DB\DbPetitesAnnonces::getCurrentInstance();

try{
    $annonceRecherchee = $mybdd->prepare("SELECT id_annonce, titre, contenu, date, prix, id_categorie, id_utilisateur FROM annonces WHERE id_annonce = :id_annonce") ;
    $idAnnonce = $_GET["annonce"];
    $annonceRecherchee->bindParam(':id_annonce', $idAnnonce, PDO::PARAM_INT);
    $annonceRecherchee->execute();
    $annonce= $annonceRecherchee->fetch();
    
    $annonceRecherchee->closeCursor();
    
    $requeteCategories = $mybdd->query('SELECT id_categorie, libelle FROM categories ORDER BY libelle ASC');
    $categories = array();
    while($categorie= $requeteCategories->fetch()){
        $categories[$categorie["id_categorie"]] = $categorie["libelle"];
    }
    $requeteCategories->closeCursor();
}
catch(PDOException $e ){
    die($e->getMessage());
}
if($annonce == false){
    require(ROOT_PATH ."/pages/pageErreur.main.php");
}
else{
    echo("<form action=\"?page=annonces/annonce-modifier-action\" method=\"post\" enctype=\"multipart/form-data\">");
    echo("\n \t<table>"
    ."\n \t \t <tbody>"
        
        ."\n \t \t \t <tr>"
            ."\n \t \t \t \t<th> <label for=\"new_category\">Catégorie: </label></th>"
            ."\n \t \t \t \t<td>"
);
            
    echo(form_select("new_category", $categories, null, ""));
           
    echo("\n \t \t \t \t</td>"
        ."\n \t \t \t</tr>"

        ."\n \t \t \t <tr>"
            ."\n \t \t \t \t<th> <label for=\"new_title\" title=\"Maximum 100 caractères\">Titre: </label></th>"
                ."\n \t \t \t \t<td>"
                    ."<input required type=\"text\" maxlength=\"100\" id=\"new_title\" name=\"new_title\" value=\"" .htmlspecialchars($annonce["titre"]) ."\" />"
                ."\n \t \t \t \t</td>"
        ."\n \t \t \t</tr>"

        ."\n \t \t \t<tr>"
            ."\n \t \t \t \t<th> <label for=\"new_price\">Prix: </label></th>"
                ."\n \t \t \t \t<td>"
                    ."<input type=\"number\" id=\"new_price\" name=\"new_price\" value=\"" .htmlspecialchars($annonce["prix"]) ."\" />"
                ."\n \t \t \t \t </td>"
        ."\n \t \t \t </tr>"
        
        ."\n \t \t \t <tr>"
            ."\n \t \t \t \t<th> <label for=\"new_content\">Contenu: </label></th>"
                ."\n \t \t \t \t<td>"
            ."<textarea required id=\"new_content\" name=\"new_content\" rows=\"8\" cols=\"20\">" .htmlspecialchars($annonce["contenu"]) ."</textarea>"
        ."\n \t \t \t \t </td>"
        ."\n \t \t \t</tr>"

        ."\n \t \t \t <tr>"
            ."\n \t \t \t \t<td>"
            ."<input type=\"hidden\" name=\"id_annonce\" value=\"" .htmlspecialchars($annonce["id_annonce"]) ."\" />"
            ."\n \t \t \t \t </td>"
        ."\n \t \t \t</tr>"

        ."\n \t \t \t <tr>");

    echo("\n \t \t \t \t <td>"
        . input_button("Valider", "Valider")
    ."\n \t \t \t \t </td>"
."\n \t \t \t</tr>"
);
    echo("\n \t \t </tbody>" ."\n \t </table>");
    echo("\n </form>");
}
