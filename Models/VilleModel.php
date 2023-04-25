<?php
namespace App\Models;
class VilleModel extends Model
{
    protected $id_ville;
    protected $nom_ville;

    public function __construct()
    {
        $class = str_replace(__NAMESPACE__.'\\', '',__CLASS__);
        $this->table = strtolower(str_replace('Model', '', $class));
    }

    /**
     * Get the value of id_ville
     */
    public function getIdVille() {
        return $this->id_ville;
    }

    /**
     * Set the value of id_ville
     */
    public function setIdVille($id_ville): self {
        $this->id_ville = $id_ville;
        return $this;
    }

    /**
     * Get the value of nom_ville
     */
    public function getNomVille() {
        return $this->nom_ville;
    }

    /**
     * Set the value of nom_ville
     */
    public function setNomVille($nom_ville): self {
        $this->nom_ville = $nom_ville;
        return $this;
    }
}