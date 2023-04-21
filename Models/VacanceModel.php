<?php
namespace App\Models;

class VacanceModel extends FormateurModel
{
    protected $id_vacanse;
    protected $date_debut_vacance;
    protected $date_fin_vacance;


    public function joinFormateurVacance(){
         return $this->requete("SELECT * FROM formateur INNER JOIN date_vacance ON formateur.id_formateur=date_vacance.id_formateur;")->fetchAll();
    }

    public function createDateVacance(string $dateDebut, string $dateFin,int $id_formateur){
            // Prepare the SQL query
            $sql = "INSERT INTO Date_vacance (date_debut_vacances, date_fin_vacances, validation, id_formateur) 
            VALUES (?, ?, 0, ?)";

            // Execute the query with the given parameters
            $result = $this->requete($sql, [$dateDebut, $dateFin, $id_formateur]);

              // Check if the query was successful
              if ($result) {
                return true;
            } else {
                return false;
            }
            
    }
    

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