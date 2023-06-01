<?php

namespace App\Models;

use App\Core\Db;

class Model extends Db
{

    // Table de la base de données
    protected $table;
    // Instance de Db
    private $db;

    public function getAll(string $table)
    {
        $query = $this->requete('SELECT * FROM ' . $table);
        return $query->fetchAll();
    }

    // Retourne les résultats de la table correspondants au critères 
    public function getBy(array $rows, string $table, array $conditionCol, array $valeur)
    {

        $nbChamps = count($rows);
        $sql = "SELECT ";
        for ($z = 0; $z < $nbChamps; $z++) {
            if ($z == 0) {
                $writeComma = "";
            } else {
                $writeComma = ", ";
            }

            $sql .= $writeComma . $rows[$z];
        }
        $sql .= " FROM " . $table;

        $nbCond = count($conditionCol);
        $sql .= " WHERE ";
        for ($i = 0; $i < $nbCond; $i++) {
            if ($i == 0) {
                $writeAnd = "";
            } else {
                $writeAnd = " AND ";
            }

            $sql .= $writeAnd . $conditionCol[$i] . " = " . $valeur[$i];
        }
        return $this->requete($sql)->fetchAll();
    }
    // Retourne les résultats de la table correspondants au multiples critères
    public function getByIn(array $rows, string $table, array $conditionCol, array $valeur)
    {

        $nbChamps = count($rows);
        $sql = "SELECT ";
        for ($z = 0; $z < $nbChamps; $z++) {
            if ($z == 0) {
                $writeComma = "";
            } else {
                $writeComma = ", ";
            }

            $sql .= $writeComma . $rows[$z];
        }
        $sql .= " FROM " . $table;

        $nbCond = count($conditionCol);
        $sql .= " WHERE ";
        $iterations = 0;

        // var_dump($valeur); echo "<br><br>";

        for ($i = 0; $i < $nbCond; $i++) {
            if ($valeur[$i] !== "Aucun") {
                if ($i == 0 || $iterations == 0) {
                    $writeAnd = "";
                } else {
                    $writeAnd = " AND ";
                }

                $sql .= $writeAnd . $conditionCol[$i] . " IN (";

                if (is_array($valeur[$i])) {
                    $nbValues = count($valeur[$i]);
                } else {
                    $nbValues = 1;
                }
                for ($j = 0; $j < $nbValues; $j++) {
                    if ($j == 0) {
                        $virgule = "";
                    } else {
                        $virgule = ",";
                    }

                    if (is_array($valeur[$i])) {
                        $sql .= $virgule . $valeur[$i][$j];
                    } else {
                        $sql .= $virgule . $valeur[$i];
                    }
                }
                $sql .= ")";
                $iterations++;
            }
        }

        return $this->requete($sql)->fetchAll();
    }

    // Retourne les résultats d'une colonne
    public function getColumn(string $col, string $table)
    {
        return $this->requete("SELECT " . $col . " FROM " . $table)->fetchAll(Db::FETCH_ASSOC);
    }

    // Retourne un seul résultat basé sur une condition, un nom de colonne et une colonne de condition dans une table donnée
    public function getOne(string $col, string $table, string $conditionCol, string $id)
    {
        return $this->requete("SELECT " . $col . " FROM " . $table . " WHERE " . $conditionCol . " = ?", [$id])->fetch(Db::FETCH_ASSOC);
    }

    // Retourne la valeur de l'id le plus grand en prenant le champ d'id en paramètre
    public function getLastId(string $idRow)
    {
        return $this->requete("SELECT MAX(" . $idRow . ") FROM " . $this->table)->fetch(Db::FETCH_ASSOC);
    }

    // Créé une ligne de données via les informations reçues
    public function create()
    {
        $champs = [];
        $inter = [];
        $valeurs = [];

        // On boucle pour éclater le tableau
        foreach ($this as $champ => $valeur) {
            // Insert into participants 
            if ($valeur !== null && $champ != 'db' && $champ != 'table') {
                $champs[] = $champ;
                $inter[] = "?";
                $valeurs[] = $valeur;
            }
        }
        // On transforme le tableau de champs en une chaine de caractères
        $liste_champs = implode(', ', $champs);
        $liste_inter = implode(', ', $inter);

        return $this->requete('INSERT INTO ' . $this->table . '(' . $liste_champs . ') VALUES (' . $liste_inter . ')', $valeurs);
    }

    // Met à jour les informations d'une ligne depuis un ID et les informations reçue
    public function update(string $table, array $updateCol, array $updateFields, string $updateCond, string $id)
    {

        $sql = "UPDATE " . $table . " SET ";

        $nbChamps = count($updateCol);
        for ($z = 0; $z < $nbChamps; $z++) {
            if ($z == 0) {
                $writeComma = "";
            } else {
                $writeComma = ", ";
            }

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

        return $this->requete($sql);
    }
    // Effectue une requête sur un certain nombre de champs, sur une table, 
    // une chaîne de caractère à chercher et les champs dans lesquels chercher.
    // Possibilité d'effectuer une ou plusieurs jointures afin d'étendre la recherche à plusieurs tables.
    public function search(array $champsSelect, string $table, string $search, array $searchCond, array $tablesJointures = [], array $colonnesJointures = [])
    {

        $nbChamps = count($champsSelect);
        $sql = "SELECT ";
        for ($z = 0; $z < $nbChamps; $z++) {
            if ($z == 0) {
                $writeComma = "";
            } else {
                $writeComma = ", ";
            }

            $sql .= $writeComma . $champsSelect[$z];
        }
        $sql .= " FROM " . $table;

        if (!empty($tablesJointures) && !empty($colonnesJointures)) {
            $nbJoin = count($tablesJointures);
            for ($i = 0; $i < $nbJoin; $i++) {
                $sql .= " JOIN " . $tablesJointures[$i] . " ON " . $table . "." . $colonnesJointures[$i] . " = " . $tablesJointures[$i] . "." . $colonnesJointures[$i];
            }
        }

        $nbCond = count($searchCond);

        if ($nbCond > 0) {
            $sql .= " WHERE ";
            for ($j = 0; $j < $nbCond; $j++) {
                if ($j == 0) {
                    $writeOr = "";
                } else {
                    $writeOr = " OR ";
                }

                $sql .= $writeOr . $searchCond[$j] . " LIKE " . "'%$search%'";
            }
        } else {
            $sql .= " WHERE " . $searchCond[0] . " LIKE " . "'%$search%'";
        }

        return $this->requete($sql)->fetchAll();
    }

    public function getDatesById(array $champSelect, array $date, string $table, array $concatTable, array $tableToJoin, array $joinTable, array $joinCol, string $whereCol, array $id = [])
    {
        // Nécessaire afin de pouvoir contourner la règle du group by forcant à y mettre l'ensemble des champs du select
        $this->requete("SET sql_mode='';");

        $nbChamps = count($champSelect);
        $nbDates = count($date);

        $sql = " SELECT ";

        // Ajouter les champs de sélection à la requête
        for ($i = 0; $i < $nbChamps; $i++) {

            if ($i == 0) {
                $writeComma = "";
            } else {
                $writeComma = ", ";
            }

            $sql .= $writeComma . $champSelect[$i];
        }

        // Effectues une concaténation de toute les lignes de la table "date_intervention" où l'id du formateur correspond
        // afin de ne retourner qu'une seule ligne par formateurs.
        for ($i = 0; $i < $nbDates; $i++) {
            $sql .= ", GROUP_CONCAT(" . $concatTable[$i] . "." . $date[$i] . " ORDER BY " . $concatTable[$i] . "." . $date[$i] . " SEPARATOR ',') AS " . $date[$i];
        }

        // Ajouter la clause FROM avec les tables et les jointures
        $sql .= " FROM " . $table;

        $nbJoin = count($joinTable);
        // $tableToJoin : La table à joindre
        // $joinTable : La table utilisée pour la jointure
        for ($i = 0; $i < $nbJoin; $i++) {
            $sql .= " JOIN " . $tableToJoin[$i] . " ON " . $joinTable[$i] . "." . $joinCol[$i] . " = " . $tableToJoin[$i] . "." . $joinCol[$i];
        }

        if (count($id) > 0) {

            // Ajouter la clause WHERE avec la liste d'identifiants
            $sql .= " WHERE " . $table . "." . $whereCol . " IN (";

            for ($i = 0; $i < count($id); $i++) {
                if ($i == 0) {
                    $writeComma = "";
                } else {
                    $writeComma = ", ";
                }

                $sql .= $writeComma . $id[$i];
            }

            $sql .= ") GROUP BY " . $table . "." . $whereCol;
        }
        else{
            $sql .= " GROUP BY " . $table . "." . $whereCol;
        }

        $result = $this->requete($sql)->fetchAll(Db::FETCH_ASSOC);

        return $result;
    }


    // Effectue une requete sur une liste de champs, à partir d'une table, une liste des tables à joindres et la colonne à utiliser
    // ainsi qu'une liste de conditions supplémentaires et les colonnes qui doivent remplir ces conditions
    public function joinInformations(array $champsSelect, string $table, array $tablesJointures, array $colonnesJointures, array $champCondJointures = [], array $CondJointures = [], bool $hasGroupBy = false, string $groupByField = "", string $sens = "")
    {
        $this->requete("SET sql_mode='';");
        $nbChamps = count($champsSelect);
        $sql = "SELECT ";
        for ($z = 0; $z < $nbChamps; $z++) {
            if ($z == 0) {
                $writeComma = "";
            } else {
                $writeComma = ", ";
            }

            $sql .= $writeComma . $champsSelect[$z];
        }

        $sql .= " FROM " . $table;
        $nbJoin = count($tablesJointures);
        for ($i = 0; $i < $nbJoin; $i++) {
            $sql .= " JOIN " . $tablesJointures[$i] . " ON " . $table . "." . $colonnesJointures[$i] . " = " . $tablesJointures[$i] . "." . $colonnesJointures[$i];
        }
        if (!empty($champCondJointures) && !empty($CondJointures)) {
            $nbChampsCond = count($champCondJointures);
            $nbConds = count($CondJointures);

            if ($nbChampsCond > 0 && $nbConds == $nbChampsCond) {
                $sql .= " WHERE ";
                for ($j = 0; $j < $nbConds; $j++) {
                    if ($j == 0) {
                        $writeAnd = "";
                    } else {
                        $writeAnd = " AND ";
                    }

                    $sql .= $writeAnd . $champCondJointures[$j] . " = " . $CondJointures[$j];
                }
            } else if ($nbChampsCond > 0 && $nbConds > $nbChampsCond) {
                $sql .= " WHERE " . $champCondJointures[0] . " IN (";

                for ($x = 0; $x < $nbConds; $x++) {
                    if ($x == 0) {
                        $writeComma = "";
                    } else {
                        $writeComma = ", ";
                    }
                    $sql .= $writeComma . $CondJointures[$x];
                }
                $sql .= ")";
            } else {
                $sql .= " WHERE " . $champCondJointures[0] . " = " . $CondJointures[0];
            }
        }
        if($hasGroupBy) $sql .= " GROUP BY " . $groupByField . " " . strtoupper($sens);
        return $this->requete($sql)->fetchAll();
    }

    // Insère une période de dates dans une table données contenant 2 champs de date et 1 clé étrangère
    public function insertPeriode(string $table, string $debut, string $fin, string $fk)
    {
        return $this->requete("INSERT INTO " . $table . " VALUES(NULL,?,?,?)", [$debut, $fin, $fk]);
    }
    // Insère une période de dates dans une table données contenant 2 champs de date et 2 clé étrangère
    public function insertPeriodeIntervention(string $table, string $debut, string $fin, string $fk, string $fk2)
    {
        return $this->requete("INSERT INTO " . $table . " VALUES(NULL,?,?,?,?)", [$debut, $fin, $fk, $fk2]);
    }

    // Supprime une ligne de la bdd avec son id
    public function delete(string $table, string $delCond, string $id)
    {
        return $this->requete("DELETE FROM " . $table . " WHERE $delCond = '$id'");
    }

    // Effectue une requête préparées avec des arguments optionnels
    public function requete(string $sql, array $attributs = null)
    {
        //On récupère l'instance de DB
        $this->db = Db::getInstance();

        if ($attributs !== null) {
            // Requete préparée
            $query = $this->db->prepare($sql);
            $result = true;

            try {
                $query->execute($attributs);
            } catch (\PDOException $e) {
                echo "PDOException: " . $e->getMessage() . " (Code " . $e->getCode() . ")";
                // echo "Une erreur lors du traitement des données est survenue. Veuillez contacter l'administrateur du site.";
                $result = false;
            }

            $type = explode(" ", $sql);

            for ($i = 0; $i != 1; $i++) {
                if ($type[0] !== "SET") {
                    $pattern = '/\b(FROM|INSERT INTO|UPDATE|DELETE)\s+`?(\w+)`?(?:\s+|,|$)/i';
                    preg_match_all($pattern, $sql, $match);

                    if (!isset($match[2][0])) {
                        $table = "Inconnu";
                    } else {
                        $table = $match[2][0];
                    }

                    if ($type[0] === "INSERT") {
                        $table = $type[2];
                    }
                    $activite = $type[0] . " Dans " . $table;

                    if (!isset($_SESSION)) {
                        $email = $_POST["email"];
                        $type[0] = "Connexion";

                        $log = "INSERT INTO `Logs`(`user_email`, `activity_type`, `success`) VALUES('$email','$activite',$result)";
                        $prepLog = $this->db->prepare($log);
                        $execLog = $prepLog->execute();
                    } else if ($type[0] !== "SELECT") {

                        if (isset($_SESSION['formateur'])) {
                            $email = $_SESSION['formateur']['mail'];
                        } else if (isset($_SESSION['admin'])) {
                            $email = $_SESSION['admin']['mail'];
                        }

                        $log = "INSERT INTO `Logs`(`user_email`, `activity_type`, `success`) VALUES('$email','$activite',$result)";
                        $prepLog = $this->db->prepare($log);
                        $execLog = $prepLog->execute();
                    }
                }
            }

            return $query;
        } else {
            // Requete simple
            $query = $this->db->prepare($sql);
            $result = true;

            try {
                $query->execute();
            } catch (\PDOException $e) {
                echo "PDOException: " . $e->getMessage() . " (Code " . $e->getCode() . ")";
                // echo "Une erreur lors du traitement des données est survenue. Veuillez contacter l'administrateur du site.";
                $result = false;
            }

            $type = explode(" ", $sql);

            for ($i = 0; $i != 1; $i++) {
                if ($type[0] !== "SET") {
                    $pattern = '/\b(FROM|INSERT INTO|UPDATE|DELETE)\s+`?(\w+)`?(?:\s+|,|$)/i';
                    preg_match_all($pattern, $sql, $match);

                    if (!isset($match[2][0])) {
                        $table = "Inconnu";
                    } else {
                        $table = $match[2][0];
                    }

                    if ($type[0] === "INSERT") {
                        $table = $type[2];
                    }
                    $activite = $type[0] . " Dans " . $table;

                    if (!isset($_SESSION)) {
                        $email = $_POST["email"];
                        $type[0] = "Connexion";

                        $log = "INSERT INTO `Logs`(`user_email`, `activity_type`, `success`) VALUES('$email','$activite',$result)";
                        $prepLog = $this->db->prepare($log);
                        $execLog = $prepLog->execute();
                    } else if ($type[0] !== "SELECT") {

                        if (isset($_SESSION['formateur'])) {
                            $email = $_SESSION['formateur']['mail'];
                        } else if (isset($_SESSION['admin'])) {
                            $email = $_SESSION['admin']['mail'];
                        }

                        $log = "INSERT INTO `Logs`(`user_email`, `activity_type`, `success`) VALUES('$email','$activite',$result)";
                        $prepLog = $this->db->prepare($log);
                        $execLog = $prepLog->execute();
                    }
                }
            }
            return $query;
        }
    }
}
