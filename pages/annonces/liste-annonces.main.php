<?php
include(ROOT_PATH."/libs/html.lib.php"); 
require(ROOT_PATH."/classes/Db/DbPetitesAnnonces.class.php");
$mybdd = \DB\DbPetitesAnnonces::getCurrentInstance();

try{
    if (isset($_GET['categorie']) ) {
        $annonces = $mybdd->prepare("SELECT id_annonce, titre, contenu, date, prix, id_categorie, id_utilisateur FROM annonces WHERE id_categorie = :id_categorie") ;
        $categorie = $_GET["categorie"];
        $annonces->bindParam(':id_categorie', $categorie, PDO::PARAM_INT);
        $annonces->execute();
    }
    else {
        $annonces= $mybdd->query('SELECT id_annonce, titre, contenu, date, prix, id_categorie, id_utilisateur FROM annonces ORDER BY id_annonce DESC');
    }
    $resultsAnnonces = array();
    while($annonce= $annonces->fetch()){
        array_push($resultsAnnonces, $annonce);
    }
    $annonces->closeCursor();

}
catch(PDOException $e ){
    die($e->getMessage());
}


echo("<table>" 
    ."\n \t <thead>" 
        ."\n \t \t <tr>"
            ."\n \t \t \t <th>Date</th>"  
            ."\n \t \t \t <th>Titre</th>" 
            ."\n \t \t \t <th>Prix</th>" 
            ."\n \t \t \t<th>Contenu</th>" 
        ."\n \t \t </tr>"
    ."\n \t </thead>" 

    ."\n \t <tbody>"     
);
foreach ($resultsAnnonces as $annonce) {
    echo("\n \t \t <tr>" 
            ."\n \t \t \t <td>" .htmlspecialchars($annonce["date"]) ."</td>"
            ."\n \t \t \t <td id=\"title\">" .htmlspecialchars($annonce["titre"]) ."</td>"
            ."\n \t \t \t <td>" .htmlspecialchars($annonce["prix"]) ."</td>"
            ."\n \t \t \t <td id=\"ad-content\">" .htmlspecialchars(substr($annonce["contenu"], 0, 150)) ."</td>"
            ."\n \t \t \t <td>"
    );
                echo(anchor("?page=annonces/annonce-modifier&annonce=" .$annonce["id_annonce"], "Modifier", "")
            ."</td>" 
        ."\n \t \t </tr>");
};
echo("\n \t </tbody>" 
."\n </table>");




