<?php

namespace App\Models;

use App\Core\Db;

class FormateurModel extends Model
{
    protected $id_formateur;
    protected $nom_formateur;
    protected $prenom_formateur;
    protected $mail_formateur;
    protected $mdp_formateur;
    protected $type_contrat_formateur;
    protected $date_debut_contrat;
    protected $date_fin_contrat;
    protected $permissions_utilisateur;
    protected $numero_GRN;
    protected $id_ville;

    public function __construct()
    {
        $class = str_replace(__NAMESPACE__ . '\\', '', __CLASS__);
        $this->table = strtolower(str_replace('Model', '', $class));
    }

    // Recupère Les GRN, Villes et Types de contrat
    public function getInformations()
    {
        return $infos = [
            'GRNS' => $this->requete("SELECT * FROM `GRN`")->fetchAll(),
            'Villes' => $this->requete("SELECT * FROM `Ville`")->fetchAll()
        ];
    }
    // Recupère Lesformateur
    public function getFormateur()
    {
        return $infos = [
            'Formateurs' => $this->requete("SELECT `id_formateur`,`nom_formateur`, `prenom_formateur` FROM `Formateur`")->fetchAll(),
        ];
    }
    public function search(array $champsSelect, string $table, string $search, array $searchCond, array $tablesJointures = [], array $colonnesJointures = []){
       
        $nbChamps = count($champsSelect);
        $sql = "SELECT ";
        for($z = 0; $z < $nbChamps; $z++){
            if($z == 0){$writeComma = "";}
            else{$writeComma = ", ";}

            $sql .= $writeComma . $champsSelect[$z];
        }
        $sql .= " FROM " . $table;

        if(!empty($tablesJointures) && !empty($colonnesJointures)){
            $nbJoin = count($tablesJointures);
            for($i = 0; $i < $nbJoin; $i++){
                $sql .= " JOIN " . $tablesJointures[$i] . " ON " . $table . "." . $colonnesJointures[$i] . " = " . $tablesJointures[$i] . "." . $colonnesJointures[$i];
            }
        }

        $nbCond = count($searchCond);

        if($nbCond > 0){
            $sql .= " WHERE ";
            for($j = 0; $j < $nbCond; $j++){
                if($j == 0){$writeOr = "";}
                else{$writeOr = " OR ";}

                $sql .= $writeOr . $searchCond[$j] . " LIKE " . "'%$search%'";
            }
        }else{
            $sql .= " WHERE " . $searchCond[0] . " LIKE " . "'%$search%'";
        }
       
        return $this->requete($sql)->fetchAll();
    
    }

    public function joinInformations(array $champsSelect, string $table, array $tablesJointures, array $colonnesJointures, array $champCondJointures = [], array $CondJointures = [])
    {
        $nbChamps = count($champsSelect);
        $sql = "SELECT ";
        for($z = 0; $z < $nbChamps; $z++){
            if($z == 0){$writeComma = "";}
            else{$writeComma = ", ";}

            $sql .= $writeComma . $champsSelect[$z];
        }

        $sql .= " FROM " . $table;
        $nbJoin = count($tablesJointures);
        for($i = 0; $i < $nbJoin; $i++){
            $sql .= " JOIN " . $tablesJointures[$i] . " ON " . $table . "." . $colonnesJointures[$i] . " = " . $tablesJointures[$i] . "." . $colonnesJointures[$i];
        }
        if(!empty($champCondJointures) && !empty($CondJointures)){
            $nbCond = count($champCondJointures);

            if($nbCond > 0){
                $sql .= " WHERE ";
                for($j = 0; $j < $nbCond; $j++){
                    if($j == 0){$writeAnd = "";}
                    else{$writeAnd = " AND ";}

                    $sql .= $writeAnd . $champCondJointures[$j] . " = " . $CondJointures[$j];
                }
            }else{
                $sql .= " WHERE " . $champCondJointures[0] . " = " . $CondJointures[0];
            }
        }
        return $this->requete($sql)->fetchAll();
    }

    // recuperer user by son adresse mail
    public function findOneByEmail(string $email)
    {
        return $this->requete("SELECT * FROM {$this->table} WHERE mail_formateur = ?", [$email])->fetch();
    }

    public function insertFormateur(
        string $nom_formateur,
        string $prenom_formateur,
        string $mail_formateur,
        string $mdp,
        string $type_contrat,
        string $date_debut_contrat,
        string $date_fin_contrat,
        string $permissions_utilisateur,
        string $numero_GRN,
        string $id_ville
    ): void {

        $this->requete(
            "INSERT INTO " . $this->table . "(
                    `nom_formateur`, 
                    `prenom_formateur`, 
                    `mail_formateur`, 
                    `mdp_formateur`, 
                    `type_contrat_formateur`, 
                    `date_debut_contrat`, 
                    `date_fin_contrat`, 
                    `permissions_utilisateur`, 
                    `numero_grn`, 
                    `id_ville`) 
                    VALUES(?,?,?,?,?,?,?,?,?,?)",
            [
                $nom_formateur,
                $prenom_formateur,
                $mail_formateur,
                $mdp,
                $type_contrat,
                $date_debut_contrat,
                $date_fin_contrat,
                $permissions_utilisateur,
                $numero_GRN,
                $id_ville
            ]
        );
    }

    //cree la session de l'usilateur
    public function setSession()
    {
        $_SESSION['formateur'] =
            [
                'id' => $this->id_formateur,
                'mail' => $this->mail_formateur,
                'prenom' => $this->prenom_formateur,
                'nom' => $this->nom_formateur,
                'permissions_utilisateur' => $this->permissions_utilisateur
            ];
    }

    public function setSessionAdmin()
    {
        $_SESSION['admin'] =
            [
                'id' => $this->id_formateur,
                'mail' => $this->mail_formateur,
                'prenom' => $this->prenom_formateur,
                'nom' => $this->nom_formateur,
                'permissions_utilisateur' => $this->permissions_utilisateur
            ];
    }


    public function updateNomProfil($new_nom, $idFormateur)
    {
        $sql = "UPDATE " . $this->table . " SET nom_formateur = ? WHERE id_formateur = ?";
        $result = $this->requete($sql, [$new_nom, $idFormateur]);
        return $result;
    }
    public function updatePrenomProfil($new_prenom, $idFormateur)
    {
        $sql = "UPDATE " . $this->table . " SET prenom_formateur = ? WHERE id_formateur = ?";
        $result = $this->requete($sql, [$new_prenom, $idFormateur]);
        return $result;
    }
    public function updateMailProfil($new_mail, $idFormateur)
    {
        $sql = "UPDATE " . $this->table . " SET mail_formateur = ? WHERE id_formateur = ?";
        $result = $this->requete($sql, [$new_mail, $idFormateur]);
        return $result;
    }
    public function updateMdpProfil($new_mdp, $idFormateur)
    {
        $sql = "UPDATE " . $this->table . " SET mdp_formateur = ? WHERE id_formateur = ?";
        $result = $this->requete($sql, [$new_mdp, $idFormateur]);
        return $result;
    }

    public function getInterventionById(array $id_list)
    {
        $this->requete("SET sql_mode='';");

        $sql = " SELECT f.id_formateur, f.nom_formateur, f.prenom_formateur, di.id_formation, 
        GROUP_CONCAT(di.date_debut_intervention ORDER BY di.date_debut_intervention SEPARATOR ',') AS date_debut, 
        GROUP_CONCAT(di.date_fin_intervention ORDER BY di.date_debut_intervention SEPARATOR ',') AS date_fin 
        FROM Formateur f 
        LEFT JOIN Date_intervention di ON f.id_formateur = di.id_formateur 
        WHERE f.id_formateur IN (";

        $nbId = count($id_list);
        for($i = 0; $i < $nbId; $i++){
            if($i == 0){
                $virgule = "";
            }
            else{
                $virgule = ",";
            }
           $sql .= $virgule . $id_list[$i];
        }

        $sql .= ") GROUP BY f.id_formateur";
                                
        $result = $this->requete($sql)->fetchAll(Db::FETCH_ASSOC);
        return $result;
    }

    public function setId(int $id)
    {
        $this->id_formateur = $id;
        return $this;
    }

    public function getId()
    {
        return $this->id_formateur;
    }


    public function setMail(string $email)
    {
        $this->mail_formateur = $email;
        return $this;
    }

    public function getMail()
    {
        return $this->mail_formateur;
    }



    public function setMdp($mdp_formateur)
    {
        $this->mdp_formateur = $mdp_formateur;
        return $this;
    }

    public function getMdp()
    {
        return $this->mdp_formateur;
    }



    public function setNom($nom_formateur)
    {
        $this->nom_formateur = $nom_formateur;
        return $this;
    }

    public function getNom()
    {
        return $this->nom_formateur;
    }



    public function setPrenom($prenom_formateur)
    {
        $this->prenom_formateur = $prenom_formateur;
        return $this;
    }

    public function getPrenom()
    {
        return $this->prenom_formateur;
    }



    public function setTypeContrat($type_contrat_formateur)
    {
        $this->type_contrat_formateur = $type_contrat_formateur;
        return $this;
    }

    public function getTypeContrat()
    {
        return $this->type_contrat_formateur;
    }



    public function setDateDebutContrat($date_debut_contrat)
    {
        $this->date_debut_contrat = $date_debut_contrat;
        return $this;
    }

    public function getDateDebutContrat()
    {
        return $this->date_debut_contrat;
    }



    public function setDateFinContrat($date_fin_contrat)
    {
        $this->date_fin_contrat = $date_fin_contrat;
        return $this;
    }

    public function getDateFinContrat()
    {
        return $this->date_fin_contrat;
    }



    public function setPermissionsUtilisateur($permissions_utilisateur)
    {
        $this->permissions_utilisateur = $permissions_utilisateur;
        return $this;
    }

    public function getPermissionsUtilisateur()
    {
        return $this->permissions_utilisateur;
    }



    public function setNumeroGrn($numero_GRN)
    {
        $this->numero_GRN = $numero_GRN;
        return $this;
    }

    public function getNumeroGrnt()
    {
        return $this->numero_GRN;
    }



    public function setIdVille($id_ville)
    {
        $this->id_ville = $id_ville;
        return $this;
    }

    public function getIdVille()
    {
        return $this->id_ville;
    }
}
