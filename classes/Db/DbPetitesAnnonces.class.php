<?php
namespace DB; 

class DbPetitesAnnonces extends \PDO{
    private static $instance;

    public static function getCurrentInstance(){
        if(self::$instance === null) self::$instance = new DbPetitesAnnonces();
        return self::$instance;

    }

    public static function close(){
        self::$instance = null;
    }

    function __construct(){
        //appel du constructeur parent
        parent::__construct(
            'mysql:host=nomDeLhote;dbname=nomDeBdd;charset=utf8', 'utilisateurDeLaBdd', 'motDePasseDeLutilisateur', 
            array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION)
        );
    }
}