<?php
namespace App\Models;

class ProfilModel extends FormateurModel
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

}