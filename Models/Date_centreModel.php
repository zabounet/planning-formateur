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