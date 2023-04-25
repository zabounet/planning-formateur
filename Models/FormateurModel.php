<?php
namespace App\Models;

use App\Core\Db;

class FormateurModel extends Model
{
    protected $id_formateur;
    protected $mail_formateur;
    protected $mdp_formateur;
    protected $nom_formateur;
    protected $prenom_formateur;
    protected $type_contrat_formateur;
    protected $date_debut_contrat;
    protected $date_fin_contrat;
    protected $permissions_utilisateur;
    protected $numero_GRN;
    protected $id_ville;

    public function __construct()
    {
        $class = str_replace(__NAMESPACE__.'\\', '',__CLASS__);
        $this->table = strtolower(str_replace('Model', '', $class));
    }

    // recuperer user by son adresse mail
    public function findOneByEmail(string $email)
    {
        return $this->requete("SELECT * FROM {$this->table} WHERE mail_formateur = ?", [$email])->fetch();
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

    public function setId(int $id){
        $this->id_formateur = $id;
        return $this;
    }

    public function getId(){
        return $this->id_formateur;
    }


    public function setMail(string $email){
        $this->mail_formateur = $email;
        return $this;
    }
    
    public function getMail(){
        return $this->mail_formateur;
    }



    public function setMdp($mdp_formateur){
        $this->mdp_formateur = $mdp_formateur;
        return $this;
    }
    
    public function getMdp(){
        return $this->mdp_formateur;
    }



    public function setNom($nom_formateur){
        $this->nom_formateur = $nom_formateur;
        return $this;
    }
    
    public function getNom(){
        return $this->nom_formateur;
    }



    public function setPrenom($prenom_formateur){
        $this->prenom_formateur = $prenom_formateur;
        return $this;
    }
    
    public function getPrenom(){
        return $this->prenom_formateur;
    }



    public function setTypeContrat($type_contrat_formateur){
        $this->type_contrat_formateur = $type_contrat_formateur;
        return $this;
    }
    
    public function getTypeContrat(){
        return $this->type_contrat_formateur;
    }



    public function setDateDebutContrat($date_debut_contrat){
        $this->date_debut_contrat = $date_debut_contrat;
        return $this;
    }
    
    public function getDateDebutContrat(){
        return $this->date_debut_contrat;
    }



    public function setDateFinContrat($date_fin_contrat){
        $this->date_fin_contrat = $date_fin_contrat;
        return $this;
    }
    
    public function getDateFinContrat(){
        return $this->date_fin_contrat;
    }



    public function setPermissionsUtilisateur($permissions_utilisateur){
        $this->permissions_utilisateur = $permissions_utilisateur;
        return $this;
    }
    
    public function getPermissionsUtilisateur(){
        return $this->permissions_utilisateur;
    }



    public function setNumeroGrn($numero_GRN){
        $this->numero_GRN = $numero_GRN;
        return $this;
    }
    
    public function getNumeroGrnt(){
        return $this->numero_GRN;
    }



    public function setIdVille($id_ville){
        $this->id_ville = $id_ville;
        return $this;
    }
    
    public function getIdVille(){
        return $this->id_ville;
    }
}