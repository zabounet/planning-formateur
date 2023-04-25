<?php
namespace App\Models;

class TeletravailModel extends FormateurModel
{

    protected $id_teletravail;
    protected $jour_teletravail;
    protected $date_demande_changement;
    protected $date_prise_effet;


    public function joinFormateurTeletravail(){
         return $this->requete("SELECT * FROM formateur INNER JOIN date_teletravail ON formateur.id_formateur=date_teletravail.id_formateur;")->fetchAll();
    }
    

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

    public function createJoursTeletravail(string $jour_teletravail, string $date_demande_changement, int $id_formateur): bool{
        $sql = "INSERT INTO date_teletravail (jour_teletravail, date_demande_changement, date_prise_effet, validation, id_formateur)
         VALUES (?, ?, NULL, 0, ?)";

        $result = $this->requete($sql, [$jour_teletravail, $date_demande_changement, $id_formateur]);
        
        if ($result) {
            return true;
        } else {
            return false;
        }

    }
}