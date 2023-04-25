<?php
namespace App\Models;

class Type_FormationModel extends Model
{
    protected $id_type_formation;
    protected $designation_type_formation;

    public function __construct()
    {
        $class = str_replace(__NAMESPACE__.'\\', '',__CLASS__);
        $this->table = strtolower(str_replace('Model', '', $class));
    }

    /**
     * Get the value of id_type_formation
     */
    public function getIdTypeFormation() {
        return $this->id_type_formation;
    }

    /**
     * Set the value of id_type_formation
     */
    public function setIdTypeFormation($id_type_formation): self {
        $this->id_type_formation = $id_type_formation;
        return $this;
    }

    /**
     * Get the value of designation_type_formation
     */
    public function getDesignationTypeFormation() {
        return $this->designation_type_formation;
    }

    /**
     * Set the value of designation_type_formation
     */
    public function setDesignationTypeFormation($designation_type_formation): self {
        $this->designation_type_formation = $designation_type_formation;
        return $this;
    }
}