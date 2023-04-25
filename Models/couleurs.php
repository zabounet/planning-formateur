<?php
namespace App\Models;

class couleursModel extends Model
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
}