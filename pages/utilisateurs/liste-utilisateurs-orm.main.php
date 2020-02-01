<?php
require_once ROOT_PATH.'/classes/db/Entities/Utilisateur.class.php' ;
use \Entities\Utilisateur ;

$users = Utilisateur::findAll();
print_r($users);