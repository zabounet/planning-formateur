<?php
namespace App\Models;

use App\Core\Db;

class Model extends Db{

    // Table de la base de données
    protected $table;
    // Instance de Db
    private $db;

    public function getAll(){
        $query = $this->requete('SELECT * FROM ' . $this->table);
        return $query->fetchAll();
    }

    // Retourne tous les résultats correspondants au critères
    public function getBy(array $criteres){
        $champs = [];
        $valeurs = [];

        // On boucle pour éclater le tableau
        foreach($criteres as $champ => $valeur){
            //Select * From Participants WHERE $champ = $valeur
            if($valeur !== null && $champ != 'db' && $champ != 'table'){
                $champs[] = "$champ = ?";
                $valeurs[] = $valeur;
            }
        }
        // On transforme le tableau de champs en une chaine de caractères
        $liste_champs = implode(' AND ', $champs);

        return $this->requete('SELECT * FROM ' . $this->table . ' WHERE ' . $liste_champs, $valeurs)->fetchAll();
    }

    // Retourne un seul résultat basé sur un ID
    public function getOne(int $id){
        return $this->requete("SELECT * FROM " . $this->table . " WHERE Id_Participant = '$id'")->fetch();
    }

    // Créé une ligne de données via les informations reçues
    public function create(){
        $champs = [];
        $inter = [];
        $valeurs = [];

        // On boucle pour éclater le tableau
        foreach($this as $champ => $valeur){
            // Insert into participants 
            if($valeur !== null && $champ != 'db' && $champ != 'table'){
                $champs[] = $champ;
                $inter[] = "?";
                $valeurs[] = $valeur;
            }
        }
        // On transforme le tableau de champs en une chaine de caractères
        $liste_champs = implode(', ', $champs);
        $liste_inter = implode(', ', $inter);

        return $this->requete('INSERT INTO ' . $this->table . '(' . $liste_champs . ') VALUES (' . $liste_inter .')', $valeurs);
    }

    // Met à jour les informations d'une ligne depuis un ID et les informations reçue
    public function update(int $id){
        $champs = [];
        $valeurs = [];

        // On boucle pour éclater le tableau
        foreach($this as $champ => $valeur){
            // Insert into participants 
            if($valeur !== null && $champ != 'db' && $champ != 'table'){
                $champs[] = "$champ = ?";
                $valeurs[] = $valeur;
            }
        }
        $valeurs[] = $id;
        // On transforme le tableau de champs en une chaine de caractères
        $liste_champs = implode(', ', $champs);

        // On exécute la requete
        return $this->requete('UPDATE ' . $this->table . ' SET ' . $liste_champs . ' WHERE Id_Participant = ?', $valeurs);
    }

    // Transforme les données reçue et les transforme afin de correspondre au noms des accesseurs correspondants
    public function hydrate($donnees){
        foreach($donnees as $key => $value){
            // On récupère le nom du setter correspondant à la clé
            // Nom -> setNomFormateur
            $setter = 'set'.ucwords($key, '_');
            $setter = str_replace(ucwords('_' . $this->table, '_'), '' ,$setter);
            $setter = str_replace('_', '', $setter);

            // On vérifie si le setter existe
            if(method_exists($this, $setter)){
                // On appelle le setter
                $this->$setter($value);
            }
        }
        return $this;
    }

  

    // Supprime une ligne de la bdd avec son id
    public function delete(int $id){
        //id dans un array car requete prend comme 2eme argument un array.
        return $this->requete("DELETE FROM " . $this->table . " WHERE Id_Participant = ?", [$id]);
    }

    public function requete(string $sql, array $attributs = null){
        //On récupère l'instance de DB
        $this->db = Db::getInstance();

        if($attributs !== null){
            // Requete préparée
            $query = $this->db->prepare($sql);
            $query->execute($attributs);
            
            return $query;

        } else{
            // Requete simple
            return $this->db->query($sql);
        }
    }
}