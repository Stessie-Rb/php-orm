<?php
include(ROOT_PATH."/libs/traitements-image.lib.php");

if (isset($_FILES['adPicture']) && $_FILES['adPicture']['error'] == 0) {
    if ($_FILES['adPicture']['size'] <= 5000000) {
        $pictureInfos = pathinfo($_FILES['adPicture']['name']);
        $extensionOfDlPicture = strtolower(substr(strrchr($_FILES['adPicture']['name'], '.'), 1));
        $acceptedExtensions = array('jpg', 'jpeg', 'gif', 'png');
        if (in_array($extensionOfDlPicture, $acceptedExtensions)) {

            //Nom d'image: il sera changé quand le formulaire de dépôt d'annonce sera finalisé  
            $pictureName =  md5(uniqid(rand(), true)) .'.' .basename($_FILES['adPicture']['type']);
            create_thumbnail($_FILES['adPicture']['tmp_name'], 200, 200, ROOT_PATH.'/images/annonces_images/miniatures_annonces/'.$pictureName);
            $picture= move_uploaded_file($_FILES['adPicture']['tmp_name'], ROOT_PATH.'/images/annonces_images/'.$pictureName);
            echo("Image enregistrée, miniature créée");

        } else {
            throw new Exception('L\'extension de l\'image est incorrecte');
        }

    }
} else {
    throw new Exception('Aucune image envoyée ou image trop volumineuse, veuillez réessayer');
}
