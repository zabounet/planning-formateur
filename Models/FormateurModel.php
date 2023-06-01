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
        $sql = "INSERT INTO date_vacance (date_debut_vacances, date_fin_vacances, id_formateur) 
        VALUES (?, ?, ?)";

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
        $sql = "INSERT INTO Date_teletravail (jour_teletravail, date_demande_changement, date_prise_effet, id_formateur)
        VALUES (?, ?, ?, ?)";

        $result = $this->requete($sql, [$jour_teletravail, $date_demande_changement, $date_prise_effet, $id_formateur]);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    public function updateJoursTeletravail(string $jour_teletravail, string $date_demande_changement,string $date_prise_effet ,int $id_formateur): bool
    {
        $sql = "UPDATE Date_teletravail SET 
        `jour_teletravail` = ?,
        `date_demande_changement` = ?,
        `date_prise_effet` = ?
        Where id_formateur = ? AND `validation` IS NULL " ;

        $result = $this->requete($sql, [$jour_teletravail, $date_demande_changement, $date_prise_effet, $id_formateur]);
        
        if ($result->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }



     // inserer une notification dans table notification a partir de un demande
     public function creatrNotification( string $description, string $date, string $date_notification,string $role,INT $id_formateur,string $type )
     {
        $sql = "INSERT INTO Notification (description_notification, date, date_notification, role, id_formateur,type )
        VALUES (?, ?, ?, ?, ?, ?)";

        $result = $this->requete($sql, [$description, $date, $date_notification, $role, $id_formateur,$type]);

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
