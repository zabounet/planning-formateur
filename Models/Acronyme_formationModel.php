<?php
namespace App\Models;
use App\Core\Db;
class Acronyme_formationModel extends Model
{
    protected $id_acronyme_formation;
    protected $acronyme_formation;
    protected $numero_grn;

    public function __construct()
    {
        $class = str_replace(__NAMESPACE__.'\\', '',__CLASS__);
        $this->table = strtolower(str_replace('Model', '', $class));
    }

    public function insertAcronym(string $acronyme, string $grn): void{
        $this->requete("INSERT INTO " . $this->table . "(`acronyme_formation`, `numero_grn`) VALUES(?,?)", [$acronyme, $grn]);
    }

    /**
     * Get the value of id_acronyme_formation
     */
    public function getIdAcronymeFormation() {
        return $this->id_acronyme_formation;
    }

    /**
     * Set the value of id_acronyme_formation
     */
    public function setIdAcronymeFormation($id_acronyme_formation): self {
        $this->id_acronyme_formation = $id_acronyme_formation;
        return $this;
    }

    /**
     * Get the value of acronyme_formation
     */
    public function getAcronymeFormation() {
        return $this->acronyme_formation;
    }

    /**
     * Set the value of acronyme_formation
     */
    public function setAcronymeFormation($acronyme_formation): self {
        $this->acronyme_formation = $acronyme_formation;
        return $this;
    }

    /**
     * Get the value of numero_grn
     */
    public function getNumeroGrn() {
        return $this->numero_grn;
    }

    /**
     * Set the value of numero_grn
     */
    public function setNumeroGrn($numero_grn): self {
        $this->numero_grn = $numero_grn;
        return $this;
    }
}