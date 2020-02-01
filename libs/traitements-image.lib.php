<?php
function image_resized_dims($max_w, $max_h, $w, $h)
{
    $ratio = $w / $h;
    $ratio_max = $max_w / $max_h;

    // calcul des hauteurs et largeurs finales
    if ($ratio_max < $ratio) {
        $new_w = $max_w;
        $new_h = $max_w / $ratio;
    } else {
        $new_w = $max_h * $ratio;
        $new_h = $max_h;
    }

    return array($new_w, $new_h);
}

function create_thumbnail($image, $max_w, $max_h, $img_dest_path)
{
    //On crée un nom pour la miniature
    $thumbName = "thumb.jpg";
    $thumbnailSrc= imagecreatefromjpeg($image);

    //Crée une image vide 
    $thumbnailDestination= imagecreatetruecolor($max_w, $max_h);

    //On récupère les tailles de notre image source
    $srcWidth = imagesx($thumbnailSrc);
    $srcHeight = imagesy($thumbnailSrc);

    //On récupère celles de la future miniature
    $destinationWidth = imagesx($thumbnailDestination);
    $destinationHeight = imagesy($thumbnailDestination);

    //On fait la miniature (copie, redimensionnement ...)
    $newThumbnail = imagecopyresampled($thumbnailDestination, $thumbnailSrc, 0, 0, 0, 0, $destinationWidth, $destinationHeight, $srcWidth, $srcHeight);
    
    //On affecte l'image nouvellement créée à un fichier 
    $newThumbnail= imagejpeg($thumbnailDestination, $thumbName);

    //On libère la mémoire
    imagedestroy($thumbnailDestination);
}

function insert_logo($logo_src, $img_src ){
    $insertName = "insert.jpg";
    $logo_source = imagecreatefrompng($logo_src);
    $destinationImage = imagecreatefromjpeg($img_src);

    $src_w = imagesx($logo_source);
    $src_h = imagesy($logo_source);

    $dest_w = imagesx($destinationImage);
    $dest_h = imagesy($destinationImage);

    $dest_x = $dest_w - $src_w  -10;
    $dest_y = $dest_h - $src_h  -10;

    imagecopymerge($destinationImage, $logo_source, $dest_x, $dest_y, 0, 0, $src_w, $src_h, 60);

    imagejpeg($destinationImage, $insertName);

}
//insert_logo("ressources/logo-ubs.png", "ressources/bord-de-mer.jpg");

function img_fusion($img_src, $img_to_merge){
    $fusionName = "fusion.jpg";
    $src = imagecreatefromjpeg($img_src);
    $dest = imagecreatefrompng($img_to_merge);

    imagecopy($dest, $src, 0, 0, 0, 0, imagesx($dest), imagesy($dest));
    imagejpeg($dest, $fusionName);

    imagedestroy($dest);
    imagedestroy($src);

}
//img_fusion("ressources/image-test.jpg", "ressources/canal-alpha.png");