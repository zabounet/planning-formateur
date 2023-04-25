<?php
namespace App\Models;

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

    public function getColors(){
        return $this->requete("SELECT * FROM {$this->table}")->fetch();
    }

    public function setIdCouleur($couleur_id): self {
        $this->couleur_id = $couleur_id;
        return $this;
    }
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
        $this->requete("UPDATE " . $this->table . " SET
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
    }

    
     
}