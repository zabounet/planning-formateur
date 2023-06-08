<?php
namespace App\Core;

class Form{

    private $formCode = '';

    public function create(): string{
        return $this->formCode;
    }

    // Valide si tous les champs du formulaire sont remplis
    public static function validate(array $form, array $champsObligatoires, array $champsFacultatifs = []): bool{

        // On parcourt les champs
        foreach($champsObligatoires as $champObligatoire){
            // Si le champ est absent ou vide dans le formulaire
            if(!isset($form[$champObligatoire]) || empty($form[$champObligatoire])){
                return false;
            } 
        }
        // Si le paramètre $champsFacultatif n'est pas vide
        foreach($champsFacultatifs as $champFacultatif){
                // Si les champs sont remplis et non vide
                if(isset($form[$champFacultatif]) && !empty($form[$champFacultatif])){
                    //
                }
            }
        return true;
    }

    
    static function Argon2IDOptions(): array
    {
        $options = [
            'memory_cost' => 64 * 1024,   // 64MB memory cost
            'time_cost' => 4,             // 4 iterations
            'threads' => 2,               // 2 threads
        ];
        return $options;
    }
}