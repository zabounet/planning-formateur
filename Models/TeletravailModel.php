<?php
namespace App\Models;

class TeletravailModel extends FormateurModel
{

    protected $id_teletravail;
    protected $jour_teletravail;
    protected $date_demande_changement;
    protected $date_prise_effet;



    public function setIdTeletravail(int $id_teletravail){
        $this->id_teletravail = $id_teletravail;
        return $this;
    }
    public function setJourTeletravail(string $jour_teletravail){
        $this->jour_teletravail = $jour_teletravail;
        return $this;
    }
    public function setDateDemandeChangement(string $date_demande_changement){
        $this->date_demande_changement = $date_demande_changement;
        return $this;
    }
    public function setDatePriseEffet(string $date_prise_effet): self{
        $this->date_prise_effet = $date_prise_effet;
        return $this;
    }
}