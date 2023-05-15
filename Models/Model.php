<?php
namespace App\Models;

use App\Core\Db;

class Model extends Db{

    // Table de la base de données
    protected $table;
    // Instance de Db
    private $db;

    public function getAll(string $table){
        $query = $this->requete('SELECT * FROM ' . $table);
        return $query->fetchAll();
    }

    // Retourne les résultats de la table correspondants au critères 
    public function getBy(array $rows,string $table, array $conditionCol, array $valeur){

        $nbChamps = count($rows);
        $sql = "SELECT ";
        for($z = 0; $z < $nbChamps; $z++){
            if($z == 0){$writeComma = "";}
            else{$writeComma = ", ";}

            $sql .= $writeComma . $rows[$z];
        }
        $sql .= " FROM " . $table;

        $nbCond = count($conditionCol);
        $sql .= " WHERE ";
        for($i = 0; $i < $nbCond; $i++){
            if($i == 0){$writeAnd = "";}
            else{$writeAnd = " AND ";}

            $sql .= $writeAnd . $conditionCol[$i] . " = " . $valeur[$i];
        }
        return $this->requete($sql)->fetchAll();
    }
    // Retourne les résultats de la table correspondants au multiples critères
    public function getByIn(array $rows,string $table, array $conditionCol, array $valeur){

        $nbChamps = count($rows);
        $sql = "SELECT ";
        for($z = 0; $z < $nbChamps; $z++){
            if($z == 0){$writeComma = "";}
            else{$writeComma = ", ";}

            $sql .= $writeComma . $rows[$z];
        }
        $sql .= " FROM " . $table;

        $nbCond = count($conditionCol);
        $sql .= " WHERE ";
        $iterations = 0;

        // var_dump($valeur); echo "<br><br>";

        for($i = 0; $i < $nbCond; $i++){
            if($valeur[$i] !== "Aucun"){
                if($i == 0 || $iterations == 0){$writeAnd = "";}
                else{$writeAnd = " AND ";}

                $sql .= $writeAnd . $conditionCol[$i] . " IN (";

                if(is_array($valeur[$i])) {
                    $nbValues = count($valeur[$i]);
                } else{
                    $nbValues = 1;
                }
                for($j = 0; $j < $nbValues; $j++){
                    if($j == 0){$virgule = "";}
                    else{$virgule = ",";}

                    if(is_array($valeur[$i])){
                        $sql .= $virgule . $valeur[$i][$j];
                    }else{
                        $sql .= $virgule . $valeur[$i];
                    }
                }
                $sql .= ")";
                $iterations++;
            }
        }
        echo $sql;
        return $this->requete($sql)->fetchAll();
    }

    // Retourne les résultats d'une colonne
    public function getColumn(string $col, string $table){
        return $this->requete("SELECT " . $col . " FROM " . $table)->fetchAll(Db::FETCH_ASSOC);
    }

    // Retourne un seul résultat basé sur un ID, un nom de colonne et une colonne de condition dans une table donnée
    public function getOne(string $col, string $table, string $conditionCol, string $id){
        return $this->requete("SELECT " . $col . " FROM " . $table . " WHERE " . $conditionCol . " = '$id'")->fetch(Db::FETCH_ASSOC);
    }

    // Retourne la valeur du dernier id en prenant le champ d'id en paramètre
    public function getLastId(string $idRow){
        return $this->requete("SELECT MAX(". $idRow .") FROM " . $this->table)->fetch(Db::FETCH_ASSOC);
    }

    // Créé une ligne de données via les informations reçues
    public function create(){
        $champs = [];
        $inter = [];
        $valeurs = [];

        // On boucle pour éclater le tableau
        foreach($this as $champ => $valeur){
            // Insert into participants 
            if($valeur !== null && $champ != 'db' && $champ != 'table'){
                $champs[] = $champ;
                $inter[] = "?";
                $valeurs[] = $valeur;
            }
        }
        // On transforme le tableau de champs en une chaine de caractères
        $liste_champs = implode(', ', $champs);
        $liste_inter = implode(', ', $inter);

        return $this->requete('INSERT INTO ' . $this->table . '(' . $liste_champs . ') VALUES (' . $liste_inter .')', $valeurs);
    }

    // Met à jour les informations d'une ligne depuis un ID et les informations reçue
    public function update(string $table, array $updateCol, array $updateFields, string $updateCond, string $id){
        
        $sql = "UPDATE " . $table . " SET ";

        $nbChamps = count($updateCol);
        for($z = 0; $z < $nbChamps; $z++){
            if($z == 0){$writeComma = "";}
            else{$writeComma = ", ";}

            $sql .= $writeComma . $updateCol[$z] . " = '$updateFields[$z]'";
        }

        // $nbCond = count($updateCond);
        // $sql .= " WHERE ";
        // for($i = 0; $i < $nbCond; $i++){
        //     if($i == 0){$writeAnd = "";}
        //     else{$writeAnd = " AND ";}

        //     $sql .= $writeAnd . $updateCond[$i] . " = '$id[$i]'";
        // }

        $sql .= " WHERE " . $updateCond . " = '$id'";

        // echo $sql;die;
        return $this->requete($sql);    
    }
    // Insère une période de dates dans une table données contenant 2 champs de date et 1 une clé étrangère
    public function insertPeriode(string $table, string $debut, string $fin, string $fk) {
        return $this->requete("INSERT INTO " . $table . " VALUES(NULL,?,?,?)", [$debut, $fin, $fk]);
    }  

    public function insertPeriodeIntervention(string $table, string $debut, string $fin, string $fk, string $fk2) {
        return $this->requete("INSERT INTO " . $table . " VALUES(NULL,?,?,?,?)", [$debut, $fin, $fk, $fk2]);
    }  

    // Transforme les données reçue et les transforme afin de correspondre au noms des accesseurs correspondants
    public function hydrate($donnees){
        foreach($donnees as $key => $value){
            // On récupère le nom du setter correspondant à la clé
            // Nom -> setNomFormateur
            $setter = 'set'.ucwords($key, '_');
            $setter = str_replace(ucwords('_' . $this->table, '_'), '' ,$setter);
            $setter = str_replace('_', '', $setter);

            // On vérifie si le setter existe
            if(method_exists($this, $setter)){
                // On appelle le setter
                $this->$setter($value);
            }
        }
        return $this;
    }

    // Supprime une ligne de la bdd avec son id
    public function delete(string $table, string $delCond, string $id){
        //id dans un array car requete prend comme 2eme argument un array.
        return $this->requete("DELETE FROM " . $table . " WHERE $delCond = '$id'");
    }

   

    public function requete(string $sql, array $attributs = null){
        //On récupère l'instance de DB
        $this->db = Db::getInstance();

        if($attributs !== null){
            // Requete préparée
            $query = $this->db->prepare($sql);
            try {
                $query->execute($attributs);
            } catch (\PDOException $e) {
                echo "PDOException: " . $e->getMessage() . " (Code " . $e->getCode() . ")";
            }
            
            return $query;

        } else{
            // Requete simple
            $query = $this->db->prepare($sql);
            try {
                $query->execute();
            } catch (\PDOException $e) {
                echo "PDOException: " . $e->getMessage() . " (Code " . $e->getCode() . ")";
            }

            return $query;
        }
    }
}