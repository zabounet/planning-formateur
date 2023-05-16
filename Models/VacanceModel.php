<?php
namespace App\Models;

class VacanceModel extends FormateurModel
{
    protected $id_vacanse;
    protected $date_debut_vacance;
    protected $date_fin_vacance;    

    public function setIdVacanse(int $id_vacanse){
        $this->id_vacanse = $id_vacanse;
        return $this;
    }

    public function setDateDebutVacance(int $dateDebut){
        $this->date_debut_vacance = $dateDebut;
        return $this;
    }

    public function setDateFInVacance(int $dateFin){
        $this->date_fin_vacance = $dateFin;
        return $this;
    }
   
}