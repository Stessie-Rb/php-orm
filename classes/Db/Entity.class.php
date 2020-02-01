<?php
namespace DB;

require_once(ROOT_PATH."/classes/Db/DbPetitesAnnonces.class.php");

class Entity
{
    protected $tableName;
    protected $pkName;
    protected $values;

    public function __construct($tableName, $pkName)
    {
        $this->tableName = $tableName;
        $this->pkName = $pkName;
        $this->values = array();
    }

    public function hydrate($values)
    {
        $this->values = $values;
    }

    public function __call($method, $params)
    {
        $func = substr($method, 0, 3);

        //récupèration de tout ce qu'il y a après le type de méthode
        $columnName = substr($method, 3);

        //on remplace les caractère majuscules pour passer de la notation lower camel case 
        //à une notation type colonne de BDD (ex: idUtilisateur devient id_utilisateur)
        $columnName = preg_replace("/[A-Z]/", '_$0', $columnName);
        $columnName = trim($columnName, '_');
        $columnName = strtolower($columnName);

        if ($func == "get") {
            return $this->values[$columnName];
        } else if ($func == "set") {
            $this->values[$columnName] = $params[0];
        } else {
            throw new Exception("Le nom de méthode est inconnu");
        }
    }
    public function save()
    {
        $mybdd = \DB\DbPetitesAnnonces::getCurrentInstance();
        $columns = array();
        $taggedValues= array();
        print_r($this->values);
        foreach ($this->values as $key => $value) {
            array_push($taggedValues, "'" . $value . "'");
            array_push($columns, $key);
        }
        $columns = implode(',', $columns);
        $stringTaggedValues = implode(',', $taggedValues);
        try {
            $requete = 'INSERT INTO ' . $this->tableName . '(' . $columns . ') VALUES (' . $stringTaggedValues . ');';

            $preparedRequest = $mybdd->prepare($requete);
            //TODO: on duplicate key (chaque $key de $this->values = $stringTaggedValues)
            
            echo($requete);
            foreach($taggedValues as $value){
                $preparedRequest->bindParam($value, $value);
            }
            $preparedRequest->execute();
        } catch (PDOException $e) {
            echo("Erreur dans la requête : ".$e->getMessage()) ;
        }
    }
}
