<?php
namespace App\Models;

use App\Core\Db;

class CouleursModel extends Model
{
    protected $couleur_id;
    protected $couleur_centre;            
    protected $couleur_pae;               
    protected $couleur_certif;            
    protected $couleur_ran;               
    protected $couleur_vacance_demandees; 
    protected $couleur_vacance_validee;   
    protected $couleur_tt;                
    protected $couleur_ferie;             
    protected $couleur_weekend;           
    protected $couleur_interruption;      
    protected $couleur_MNSP;              
    protected $couleur_itinerant; 

    public function __construct()
    {
        $class = str_replace(__NAMESPACE__.'\\', '',__CLASS__);
        $this->table = strtolower(str_replace('Model', '', $class));
    }

    public function setIdCouleur($couleur_id): self {
        $this->couleur_id = $couleur_id;
        return $this;
    }

    // Récupère les couleurs actuellements inscrites en base de données afin de les restituer dans la page.
    public function setSessionCoulors(): void{
       $_SESSION['color'] = $this->requete("SELECT * FROM " . $this->table)->fetch(Db::FETCH_ASSOC);
       // Supprime l'id car il est inutile.
       unset($_SESSION['color']['couleur_id']);
    }

    
    // Récupère l'ensemble des couleurs et mets à jour l'ensemble des enregistrements en base de données
    public function updateCouleur(string $couleur_centre, 
                                  string $couleur_pae, 
                                  string $couleur_certif, 
                                  string $couleur_ran, 
                                  string $couleur_vacance_demandees, 
                                  string $couleur_vacance_validee,
                                  string $couleur_tt ,
                                  string $couleur_ferie ,
                                  string $couleur_weekend ,
                                  string $couleur_interruption ,
                                  string $couleur_MNSP ,
                                  string $couleur_itinerant){
    $result = $this->requete("UPDATE " . $this->table . " SET
        `couleur_centre` = ?, 
        `couleur_pae` = ?, 
        `couleur_certif` = ?, 
        `couleur_ran` = ?, 
        `couleur_vacance_demandees` = ?, 
        `couleur_vacance_validee` = ?, 
        `couleur_tt` = ?, 
        `couleur_ferie` = ?, 
        `couleur_weekend` = ?, 
        `couleur_interruption` = ?, 
        `couleur_MNSP` = ?, 
        `couleur_itinerant` = ?
        WHERE couleur_id = 1" 
        ,[  $couleur_centre,
            $couleur_pae,
            $couleur_certif,
            $couleur_ran,
            $couleur_vacance_demandees,
            $couleur_vacance_validee,
            $couleur_tt ,
            $couleur_ferie ,
            $couleur_weekend ,
            $couleur_interruption ,
            $couleur_MNSP ,
            $couleur_itinerant]);

            if ($result !== false) {
                // The update was successful
                return true;
            } else {
                // The update failed
                return false;
            }
    }

   
    
    public function getId(){
        return $this->couleur_id;
    }

    public function setCouleurCentre($couleur_centre){
        $this->couleur_centre = $couleur_centre;
        return $this;
    }
    
    public function getCouleurCentre(){
        return $this->couleur_centre;
    }

    public function setCouleurPae($couleur_pae){
        $this->couleur_pae = $couleur_pae;
        return $this;
    }
    
    public function getCouleurPae(){
        return $this->couleur_pae;
    }

    public function setCouleurRan($couleur_ran){
        $this->couleur_ran = $couleur_ran;
        return $this;
    }
    
    public function getCouleurRan(){
        return $this->couleur_ran;
    }

    public function setCouleurVacanceDemandees($couleur_vacance_demandees){
        $this->couleur_vacance_demandees = $couleur_vacance_demandees;
        return $this;
    }
    
    public function getCouleurVacanceDemandees(){
        return $this->couleur_vacance_demandees;
    }

    public function setCouleurVacanceValidee($couleur_vacance_validee){
        $this->couleur_vacance_validee = $couleur_vacance_validee;
        return $this;
    }
    
    public function getCouleurVacanceValidee(){
        return $this->couleur_vacance_validee;
    }

    public function setCouleurTt($couleur_tt){
        $this->couleur_tt = $couleur_tt;
        return $this;
    }
    
    public function getCouleurTt(){
        return $this->couleur_tt;
    }

    public function setCouleurFerie($couleur_ferie){
        $this->couleur_ferie = $couleur_ferie;
        return $this;
    }
    
    public function getCouleurFerie(){
        return $this->couleur_ferie;
    }

    public function setCouleurWeekend($couleur_weekend){
        $this->couleur_weekend = $couleur_weekend;
        return $this;
    }
    
    public function getCouleurWeekend(){
        return $this->couleur_weekend;
    }

    public function setCouleurInterruption($couleur_interruption){
        $this->couleur_interruption = $couleur_interruption;
        return $this;
    }
    
    public function getCouleurInterruption(){
        return $this->couleur_interruption;
    }

    public function setCouleurMnsp($couleur_MNSP){
        $this->couleur_MNSP = $couleur_MNSP;
        return $this;
    }
    
    public function getCouleurMnsp(){
        return $this->couleur_MNSP;
    }

    public function setCouleurItinerant($couleur_itinerant){
        $this->couleur_itinerant = $couleur_itinerant;
        return $this;
    }
    
    public function getCouleurItinerant(){
        return $this->couleur_itinerant;
    }


     
}

