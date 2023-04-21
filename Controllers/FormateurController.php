<?php

namespace App\Controllers;

use App\Core\Form;
use App\Models\FormateurModel;
use App\Models\VacanceModel;

class FormateurController extends Controller
{

    public function login(): void
    {
        //on verifie si le formulaire est complet
        if(Form::validate($_POST, ['email', 'password'])){
            $pass = strip_tags($_POST['password']);
            $FormateurModel = new FormateurModel;
            $FormateurArray = $FormateurModel->findOneByEmail(strip_tags($_POST['email']));

            if(!$FormateurArray){
                $_SESSION['erreur'] = 'l\'adresse ou pass est pas correct';
                header('location: /planning/public/formateur/login');
                exit; 
            }


            
            //l'utilisateur existe
            $Formateur = $FormateurModel->hydrate($FormateurArray);
        

            //verifier si le mot pass est correct
            if(sha1($pass) === $Formateur->getMdp()){

                if($Formateur->getPermissionsUtilisateur() >= 1){
                    $Formateur->setSessionAdmin();
                }
                else{
                    $Formateur->setSession();
                }
                header('location: /planning/public/');
                exit;
            }else{
                $_SESSION['erreur'] = 'l\'adresse ou passs est pas correct';
                header('location: /planning/public/formateur/login');

                exit; 
            }
        }

        $form = new Form;

        $form->debutForm()
            ->labelFor('email', 'Inserez votre adresse mail')
            ->ajoutInput('email', 'email', ['class' => 'form-control', 'id' => 'email'])
            ->closeLabel()
            ->labelFor('password', 'Inserez votre mot de pass')
            ->ajoutInput('password', 'password', ['class' => 'form-control', 'id' => 'pass'])
            ->closeLabel()
            ->ajoutInput('submit', 'login', ['class' => 'form-control'])
            ->finForm();

         $this->render('/formateur/login', ['loginForm' => $form->create()]);
    }


    public function logout(){
        if(isset($_SESSION['formateur'])){
            unset($_SESSION['formateur']);
            header('location: /planning/public/formateur/login');
            exit; 
        }
        if(isset($_SESSION['admin'])){
            unset($_SESSION['admin']);
            header('location: /planning/public/formateur/login');
            exit; 
        }
        
    }

    public function profil(){
        // if(isset($_POST['modifNom'])){
        //     $nom = '';
        //     $nom.json_encode($_SESSION['formateur']['nom']);
        //     header('')
        // }

        if(Form::validate($_POST, ['date_debut','date_fin'])) {
            // Récupérer les dates de début et de fin de vacances depuis le formulaire
            $dateDebut = $_POST['date_debut'];
            $dateFin = $_POST['date_fin'] ;

            var_dump($_POST);

             // Récupérer l'ID du formateur depuis la session
            $idFormateur = $_SESSION['formateur']['id'];
            
            $vacance = new VacanceModel();
                
            $resultat = $vacance->createDateVacance($dateDebut, $dateFin, $idFormateur);

            if ($resultat) {
                // redirection vers une page de succès
                echo'succsec';
                exit;
            } else {
                // affichage d'un message d'erreur
                echo 'Une erreur est survenue lors de l\'enregistrement.';
            }
    
        }
        $this->render('/formateur/profil');
    }

}

