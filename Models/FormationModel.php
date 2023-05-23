<?php
namespace App\Models;

use App\Core\Db;

class FormationModel extends Model{

    protected $id_formation;
    protected $nom_formation;
    protected $acronyme_formation;
    protected $description_formation;
    protected $date_debut_formation;
    protected $date_fin_formation;
    protected $numero_grn;
    protected $id_type_formation;
    protected $id_ville;
    protected $id_formateur;

    public function __construct()
    {
        $class = str_replace(__NAMESPACE__.'\\', '',__CLASS__);
        $this->table = strtolower(str_replace('Model', '', $class));
    }

    // Recupère Les GRN, Villes, Types de formation, acronymes de formation et les formateurs
    public function getInformations(){
        return $infos = [
            'GRNS' => $this->requete("SELECT * FROM `GRN`")->fetchAll(),
            'Formateurs' => $this->requete("SELECT `id_formateur`,`nom_formateur`,`prenom_formateur`,`date_debut_contrat`,`date_fin_contrat` FROM `Formateur`")->fetchAll(),
            'Villes' => $this->requete("SELECT * FROM `Ville`")->fetchAll(),
            'Types' => $this->requete("SELECT * FROM `Type_Formation`")->fetchAll()
        ];
    }

    // Insère les données d'une formation dans la base de données
    public function insertFormation(
        string $nom,
        string $acronyme,
        string $description,
        string $candidats,
        string $debutFormation,
        string $finFormation,
        string $idTypeFormation,
        string $grn,
        string $idFormateur,
        string $idVille
    ): void {

        $this->requete(
            "INSERT INTO " . $this->table . "(
        `nom_formation`,
        `acronyme_formation`, 
        `description_formation`, 
        `candidats_formation`,
        `date_debut_formation`, 
        `date_fin_formation`, 
        `id_type_formation`, 
        `numero_grn`, 
        `id_formateur`, 
        `id_ville`) 
        VALUES(?,?,?,?,?,?,?,?,?,?)",
            [
                $nom,
                $acronyme,
                $description,
                $candidats,
                $debutFormation,
                $finFormation,
                $idTypeFormation,
                $grn,
                $idFormateur,
                $idVille
            ]
        );
    }

    public function getDatesById(array $id_list)
{
    $this->requete("SET sql_mode='';");

    $sql = "SELECT f.id_formation,
            GROUP_CONCAT(dr.date_debut_ran ORDER BY dr.date_debut_ran SEPARATOR ',') AS date_debut_ran,
            GROUP_CONCAT(dr.date_fin_ran ORDER BY dr.date_debut_ran SEPARATOR ',') AS date_fin_ran,
            GROUP_CONCAT(dcf.date_debut_certif ORDER BY dcf.date_debut_certif SEPARATOR ',') AS date_debut_certif,
            GROUP_CONCAT(dcf.date_fin_certif ORDER BY dcf.date_debut_certif SEPARATOR ',') AS date_fin_certif,
            GROUP_CONCAT(dc.date_debut_centre ORDER BY dc.date_debut_centre SEPARATOR ',') AS date_debut_centre,
            GROUP_CONCAT(dc.date_fin_centre ORDER BY dc.date_debut_centre SEPARATOR ',') AS date_fin_centre,
            GROUP_CONCAT(dp.date_debut_pae ORDER BY dp.date_debut_pae SEPARATOR ',') AS date_debut_pae,
            GROUP_CONCAT(dp.date_fin_pae ORDER BY dp.date_debut_pae SEPARATOR ',') AS date_fin_pae
            FROM formation f 
            LEFT JOIN Date_ran dr ON f.id_formation = dr.id_formation
            LEFT JOIN Date_certif dcf ON f.id_formation = dcf.id_formation
            LEFT JOIN Date_centre dcent ON f.id_formation = dc.id_formation
            LEFT JOIN Date_pae dp ON f.id_formation = dp.id_formation
            WHERE f.id_formation IN (";

    $nbId = count($id_list);
    for ($i = 0; $i < $nbId; $i++) {
        if ($i == 0) {
            $virgule = "";
        } else {
            $virgule = ",";
        }
        $sql .= $virgule . $id_list[$i];
    }

    $sql .= ") GROUP BY f.id_formation";

    $result = $this->requete($sql)->fetchAll(Db::FETCH_ASSOC);
    return $result;
}


    // le requet en haut fait le meme chose que 4 requete en bas



    // public function getRanById(array $id_list)
    // {
    //     $this->requete("SET sql_mode='';");

    //     $sql = "SELECT f.id_formation,
    //     GROUP_CONCAT(dr.date_debut_ran ORDER BY dr.date_debut_ran SEPARATOR ',') AS date_debut_ran,
    //     GROUP_CONCAT(dr.date_fin_ran ORDER BY dr.date_debut_ran SEPARATOR ',') AS date_fin_ran
    //     FROM formation f 
    //     JOIN Date_ran dr ON f.id_formation = dr.id_formation
    //     WHERE f.id_formation IN (";

    //     $nbId = count($id_list);
    //     for ($i = 0; $i < $nbId; $i++) {
    //         if ($i == 0) {
    //             $virgule = "";
    //         } else {
    //             $virgule = ",";
    //         }
    //         $sql .= $virgule . $id_list[$i];
    //     }

    //     $sql .= ") GROUP BY f.id_formation";

    //     $result = $this->requete($sql)->fetchAll(Db::FETCH_ASSOC);
    //     return $result;
    // }

    // public function getCertifById(array $id_list)
    // {
    //     $this->requete("SET sql_mode='';");

    //     $sql = "SELECT f.id_formation,
    //     GROUP_CONCAT(dc.date_debut_certif ORDER BY dc.date_debut_certif SEPARATOR ',') AS date_debut_certif,
    //     GROUP_CONCAT(dc.date_fin_certif ORDER BY dc.date_debut_certif SEPARATOR ',') AS date_fin_certif
    //     FROM formation f 
    //     JOIN Date_certif dc ON f.id_formation = dc.id_formation
    //     WHERE f.id_formation IN (";

    //     $nbId = count($id_list);
    //     for ($i = 0; $i < $nbId; $i++) {
    //         if ($i == 0) {
    //             $virgule = "";
    //         } else {
    //             $virgule = ",";
    //         }
    //         $sql .= $virgule . $id_list[$i];
    //     }

    //     $sql .= ") GROUP BY f.id_formation";

    //     $result = $this->requete($sql)->fetchAll(Db::FETCH_ASSOC);
    //     return $result;
    // }

    // public function getCentreById(array $id_list)
    // {
    //     // Nécessaire afin de pouvoir contourner la règle du group by forcant à y mettre l'ensemble des champs du select
    //     $this->requete("SET sql_mode='';");

    //     // Effectues une concaténation de toute les lignes de la table où l'id du formation correspond
    //     // afin de ne retourner qu'une seule ligne par formateurs.
    //     $sql = "SELECT f.id_formation, 
    //     GROUP_CONCAT(dc.date_debut_centre ORDER BY dc.date_debut_centre SEPARATOR ',') AS date_debut_centre, 
    //     GROUP_CONCAT(dc.date_fin_centre ORDER BY dc.date_debut_centre SEPARATOR ',') AS date_fin_centre
    //     FROM formation f 
    //     JOIN Date_centre dc ON f.id_formation = dc.id_formation 
    //     WHERE f.id_formation IN (";

    //     $nbId = count($id_list);
    //     for ($i = 0; $i < $nbId; $i++) {
    //         if ($i == 0) {
    //             $virgule = "";
    //         } else {
    //             $virgule = ",";
    //         }
    //         $sql .= $virgule . $id_list[$i];
    //     }

    //     $sql .= ") GROUP BY f.id_formation";

    //     $result = $this->requete($sql)->fetchAll(Db::FETCH_ASSOC);
    //     return $result;
    // }
    // public function getPaeById(array $id_list)
    // {
    //     $this->requete("SET sql_mode='';");

    //     $sql = "SELECT f.id_formation,
    //     GROUP_CONCAT(dp.date_debut_pae ORDER BY dp.date_debut_pae SEPARATOR ',') AS date_debut_pae, 
    //     GROUP_CONCAT(dp.date_fin_pae ORDER BY dp.date_debut_pae SEPARATOR ',') AS date_fin_pae,
    //     FROM formation f 
    //     JOIN Date_pae dp ON f.id_formation = dp.id_formation
    //     WHERE f.id_formation IN (";

    //     $nbId = count($id_list);
    //     for ($i = 0; $i < $nbId; $i++) {
    //         if ($i == 0) {
    //             $virgule = "";
    //         } else {
    //             $virgule = ",";
    //         }
    //         $sql .= $virgule . $id_list[$i];
    //     }

    //     $sql .= ") GROUP BY f.id_formation";

    //     $result = $this->requete($sql)->fetchAll(Db::FETCH_ASSOC);
    //     return $result;
    // }
    
    /**
     * Get the value of id_formation
     */
    public function getIdFormation() {
        return $this->id_formation;
    }

    /**
     * Set the value of id_formation
     */
    public function setIdFormation($id_formation): self {
        $this->id_formation = $id_formation;
        return $this;
    }


    public function getNomFormation() {
        return $this->nom_formation;
    }

    /**
     * Set the value of nom_formation
     */
    public function setNomformation($nom_formation): self {
        $this->nom_formation = $nom_formation;
        return $this;
    }

    /**
     * Get the value of description_formation
     */
    public function getDescriptionFormation() {
        return $this->description_formation;
    }

    /**
     * Set the value of description_formation
     */
    public function setDescriptionFormation($description_formation): self {
        $this->description_formation = $description_formation;
        return $this;
    }

    /**
     * Get the value of date_debut_formation
     */
    public function getDateDebutFormation() {
        return $this->date_debut_formation;
    }

    /**
     * Set the value of date_debut_formation
     */
    public function setDateDebutFormation($date_debut_formation): self {
        $this->date_debut_formation = $date_debut_formation;
        return $this;
    }

    /**
     * Get the value of date_fin_formation
     */
    public function getDateFinFormation() {
        return $this->date_fin_formation;
    }

    /**
     * Set the value of date_fin_formation
     */
    public function setDateFinFormation($date_fin_formation): self {
        $this->date_fin_formation = $date_fin_formation;
        return $this;
    }

    /**
     * Get the value of numero_grn
     */
    public function getNumeroGrn() {
        return $this->numero_grn;
    }

    /**
     * Set the value of numero_grn
     */
    public function setNumeroGrn($numero_grn): self {
        $this->numero_grn = $numero_grn;
        return $this;
    }

    /**
     * Get the value of id_type_formation
     */
    public function getIdTypeFormation() {
        return $this->id_type_formation;
    }

    /**
     * Set the value of id_type_formation
     */
    public function setIdTypeFormation($id_type_formation): self {
        $this->id_type_formation = $id_type_formation;
        return $this;
    }

    /**
     * Get the value of id_formateur
     */
    public function getIdFormateur() {
        return $this->id_formateur;
    }

    /**
     * Set the value of id_formateur
     */
    public function setIdFormateur($id_formateur): self {
        $this->id_formateur = $id_formateur;
        return $this;
    }

    /**
     * Get the value of id_ville
     */
    public function getIdVille() {
        return $this->id_ville;
    }

    /**
     * Set the value of id_ville
     */
    public function setIdVille($id_ville): self {
        $this->id_ville = $id_ville;
        return $this;
    }

    /**
     * Get the value of id_acronyme_formation
     */
    public function getIdAcronymeFormation() {
        return $this->acronyme_formation;
    }

    /**
     * Set the value of id_acronyme_formation
     */
    public function setIdAcronymeFormation($acronyme_formation): self {
        $this->acronyme_formation = $acronyme_formation;
        return $this;
    }
}
;
