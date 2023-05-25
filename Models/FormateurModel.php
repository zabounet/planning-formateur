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
    // Recupère Les formateurs
    public function getFormateur()
    {
        return $infos = [
            'Formateurs' => $this->requete("SELECT `id_formateur`, `nom_formateur`, `prenom_formateur` FROM `Formateur`")->fetchAll(),
        ];
    }

    // recuperer user by son adresse mail
    public function findOneByEmail(string $email)
    {
        return $this->requete("SELECT * FROM {$this->table} WHERE mail_formateur = ?", [$email])->fetch();
    }

    // Insertion d'un formateur en base de données
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

    // Insère une demande de jours de congé dans la table date_vacances
    public function createDateVacance(string $dateDebut, string $dateFin, int $id_formateur)
    {
        // Prepare the SQL query
        $sql = "INSERT INTO date_vacance (date_debut_vacances, date_fin_vacances, validation, id_formateur) 
        VALUES (?, ?, 0, ?)";

        // Execute the query with the given parameters
        $result = $this->requete($sql, [$dateDebut, $dateFin, $id_formateur]);

        // Check if the query was successful
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    // Insère une demande de jours de télétravail dans la table date_teletravail
    public function createJoursTeletravail(string $jour_teletravail, string $date_demande_changement,string $date_prise_effet ,int $id_formateur): bool
    {
        $sql = "INSERT INTO Date_teletravail (jour_teletravail, date_demande_changement, date_prise_effet, validation, id_formateur)
        VALUES (?, ?, ?, 0, ?)";

        $result = $this->requete($sql, [$jour_teletravail, $date_demande_changement, $date_prise_effet, $id_formateur]);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    // Récupère les couleurs actuellements inscrites en base de données afin de les restituer dans la page.
    public function setSessionTeletravail(string $id): void{
        $_SESSION['teletravail'] = $this->requete("SELECT * FROM `Date_teletravail` WHERE id_formateur = '$id' AND validation = 1")->fetch(Db::FETCH_ASSOC);
    }

    //cree la session de l'utilisateur
    public function setSession($formateur)
    {
        $_SESSION['formateur'] =
            [
                'id' => $formateur['id_formateur'],
                'mail' => $formateur['mail_formateur'],
                'prenom' => $formateur['prenom_formateur'],
                'nom' => $formateur['nom_formateur'],
                'permissions_utilisateur' => $formateur['permissions_utilisateur']
            ];
    }

    // Crée la session de l'administrateur
    public function setSessionAdmin($formateur)
    {
        $_SESSION['admin'] =
            [
                'id' => $formateur['id_formateur'],
                'mail' => $formateur['mail_formateur'],
                'prenom' => $formateur['prenom_formateur'],
                'nom' => $formateur['nom_formateur'],
                'permissions_utilisateur' => $formateur['permissions_utilisateur']
            ];
    }

    // Fonctions de gestion du profil
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

    // Recupère les dates d'interventions des formateurs selon leur id et effectue une jointure.
    public function getInterventionById(array $id_list)
    {
        // Nécessaire afin de pouvoir contourner la règle du group by forcant à y mettre l'ensemble des champs du select
        $this->requete("SET sql_mode='';");

        // Effectues une concaténation de toute les lignes de la table "date_intervention" où l'id du formateur correspond
        // afin de ne retourner qu'une seule ligne par formateurs.
        $sql = "SELECT f.id_formateur, f.nom_formateur, f.prenom_formateur, di.id_formation, 
        GROUP_CONCAT(di.date_debut_intervention ORDER BY di.date_debut_intervention SEPARATOR ',') AS date_debut, 
        GROUP_CONCAT(di.date_fin_intervention ORDER BY di.date_debut_intervention SEPARATOR ',') AS date_fin 
        FROM Formateur f 
        JOIN Date_intervention di ON f.id_formateur = di.id_formateur 
        WHERE f.id_formateur IN (";

        $nbId = count($id_list);
        for ($i = 0; $i < $nbId; $i++) {
            if ($i == 0) {
                $virgule = "";
            } else {
                $virgule = ",";
            }
            $sql .= $virgule . $id_list[$i];
        }

        $sql .= ") GROUP BY f.id_formateur";

        $result = $this->requete($sql)->fetchAll(Db::FETCH_ASSOC);
        return $result;
    }

    // Recupère les dates de vacance des formateurs selon leur id et effectue une jointure.
    public function getVacancesById(array $id_list)
    {
        $this->requete("SET sql_mode='';");

        $sql = "SELECT f.id_formateur,
        GROUP_CONCAT(dv.date_debut_vacances ORDER BY dv.date_debut_vacances SEPARATOR ',') AS date_debut_vacences, 
        GROUP_CONCAT(dv.date_fin_vacances ORDER BY dv.date_debut_vacances SEPARATOR ',') AS date_fin_vacences,
        GROUP_CONCAT(dv.validation ORDER BY dv.date_debut_vacances SEPARATOR ',') AS validation
        FROM Formateur f 
        JOIN Date_vacance dv ON f.id_formateur = dv.id_formateur 
        WHERE f.id_formateur IN (";

        $nbId = count($id_list);
        for ($i = 0; $i < $nbId; $i++) {
            if ($i == 0) {
                $virgule = "";
            } else {
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
