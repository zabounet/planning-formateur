<?php
namespace App\Models;

use App\Core\Db;

class Date_paeModel extends Model
{
    protected $id_date_pae;
    protected $date_debut_pae;
    protected $date_fin_pae;

    public function __construct()
    {
        $class = str_replace(__NAMESPACE__.'\\', '',__CLASS__);
        $this->table = strtolower(str_replace('Model', '', $class));
    }

    public function insertPAE( string $debutPAE, string $finPAE, int $id, string $formateur) {
       return $this->requete("INSERT INTO " . $this->table . "(date_debut_pae, date_fin_pae, id_formation, id_formateur) VALUES('$debutPAE', '$finPAE', '$id', '$formateur')", [$debutPAE, $finPAE, $id, $formateur]);
    }   

    /**
     * Get the value of id_date_pae
     */
    public function getIdDatePae() {
        return $this->id_date_pae;
    }

    /**
     * Set the value of id_date_pae
     */
    public function setIdDatePae($id_date_pae): self {
        $this->id_date_pae = $id_date_pae;
        return $this;
    }

    /**
     * Get the value of date_debut_pae
     */
    public function getDateDebutPae() {
        return $this->date_debut_pae;
    }

    /**
     * Set the value of date_debut_pae
     */
    public function setDateDebutPae($date_debut_pae): self {
        $this->date_debut_pae = $date_debut_pae;
        return $this;
    }

    /**
     * Get the value of date_fin_pae
     */
    public function getDateFinPae() {
        return $this->date_fin_pae;
    }

    /**
     * Set the value of date_fin_pae
     */
    public function setDateFinPae($date_fin_pae): self {
        $this->date_fin_pae = $date_fin_pae;
        return $this;
    }
}