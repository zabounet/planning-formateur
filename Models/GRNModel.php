<?php
namespace App\Models;

use App\Core\Db;

class GRNModel extends Model
{
    protected $numero_grn;
    protected $nom_grn;

    public function __construct()
    {
        $class = str_replace(__NAMESPACE__.'\\', '',__CLASS__);
        $this->table = strtolower(str_replace('Model', '', $class));
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

    /**
     * Get the value of nom_grn
     */
    public function getNomGrn() {
        return $this->nom_grn;
    }

    /**
     * Set the value of nom_grn
     */
    public function setNomGrn($nom_grn): self {
        $this->nom_grn = $nom_grn;
        return $this;
    }
}