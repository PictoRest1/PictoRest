<?php
namespace php\Controleur;

class uploadImage {

    public static function upload() {
        $nomOrigine = $_FILES['fichier']['name'];
        $elementsChemin = pathinfo($nomOrigine);
        $extensionFichier = $elementsChemin['extension'];
        $extensionsAutorisees = array("jpeg", "jpg", "gif", "svg");
        if (!(in_array($extensionFichier, $extensionsAutorisees))) {
            echo "Le fichier n'a pas l'extension attendue";
        } else {    
            // Copie dans le repertoire du script avec un nom
            // incluant l'heure a la seconde pres 
            $repertoireDestination = dirname('/PictoRest/images/');
            $nomDestination = "image_".date("YmdH").".".$extensionFichier;

            if (move_uploaded_file($_FILES["fichier"]["tmp_name"],$repertoireDestination.$nomDestination)) {
                echo "Le fichier temporaire ".$_FILES["fichier"]["tmp_name"].
                        " a été déplacé vers ".$repertoireDestination.$nomDestination;
            } else {
                echo "Le fichier n'a pas été uploadé (trop gros ?) ou ".
                        "Le déplacement du fichier temporaire a échoué".
                        " vérifiez l'existence du répertoire ".$repertoireDestination;
            }
        }
    }
}