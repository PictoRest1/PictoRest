<?php

namespace php\Controleur;
use php\Modele\Album as Album;

$id = Album::find(idAlbum)->idUtil;
if ($_SESSION['idUtil'] == $id) {
    echo '<div id="x">X</div>';
} else {
    echo '<div id="+">+</div>';
}