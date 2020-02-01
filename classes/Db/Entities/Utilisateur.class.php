<?php
namespace Entities;

require ROOT_PATH . "/classes/Db/DbPetitesAnnonces.class.php";
require ROOT_PATH . "/classes/Db/Entity.class.php";

class Utilisateur extends \DB\Entity
{

    //constante de classe
    protected const TABLENAME = "utilisateurs";
    protected const PKNAME = "id_utilisateur";
    public function __construct()
    {
        parent::__construct(
            //appel de la constante de classe. Différent de parent::constante qui appelle les constantes de classe parente
            self::TABLENAME,
            self::PKNAME
        );
    }

    public static function findAll()
    {
        $mybdd = \DB\DbPetitesAnnonces::getCurrentInstance();
        try {
            $users = $mybdd->query('SELECT id_utilisateur, nom, prenom, adresse, telephone FROM utilisateurs ORDER BY nom ASC');
            $results = array();
            //fetch renvoie une seule ligne à la fois, fetchall renvoie toutes les lignes de résultats
            while ($user = $users->fetch(\PDO::FETCH_ASSOC)) {
                $userObj = new \Entities\Utilisateur();
                $userObj->hydrate(
                    $user
                );
                array_push($results, $userObj);
            }
            $users->closeCursor();
            return $results;
        } catch (PDOException $e) {
            die($e->getMessage());
        }

    }
}
