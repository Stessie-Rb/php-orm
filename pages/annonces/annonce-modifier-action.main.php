<?php 
include(ROOT_PATH."/libs/http.lib.php");
require(ROOT_PATH."/classes/Db/DbPetitesAnnonces.class.php");
$mybdd = \DB\DbPetitesAnnonces::getCurrentInstance();

$idAnnonce= htmlspecialchars($_POST["id_annonce"]);
$idCategorie= htmlspecialchars($_POST["new_category"]);
$titre= htmlspecialchars($_POST["new_title"]);
$prix= htmlspecialchars($_POST["new_price"]);
$contenu = htmlspecialchars($_POST["new_content"]);

try {
    $updateAd= $mybdd->prepare('UPDATE annonces SET id_categorie= (:new_id_categorie), titre= (:new_title), 
    prix= (:new_price), contenu= (:new_content) WHERE id_annonce= (:id_annonce)');
    $updateAd->execute(array(
        'id_annonce'=> $idAnnonce,
        'new_id_categorie'=> $idCategorie,
        'new_title'=> $titre,
        'new_price'=> $prix,
        'new_content'=> $contenu, 
    )); 
}
catch ( PDOException $e ) {
        die("Erreur dans la requête : ".$e->getMessage()) ;
}
if($updateAd == true)
    http_redirect("?page=annonces/liste-annonces");
else
    require(ROOT_PATH ."/pages/pageErreur.main.php");

