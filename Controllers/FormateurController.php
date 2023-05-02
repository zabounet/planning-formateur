<?php

namespace App\Controllers;

use App\Core\Form;
use App\Models\FormateurModel;
use App\Models\VacanceModel;
use App\Models\TeletravailModel;

use App\Core\Refresh;
use App\Models\CouleursModel;

class FormateurController extends Controller
{

    public function login(): void{
        //on verifie si le formulaire est complet
        if(Form::validate($_POST, ['email', 'password'])){
            $pass = strip_tags($_POST['password']);
            $FormateurModel = new FormateurModel;
            $FormateurArray = $FormateurModel->findOneByEmail(strip_tags($_POST['email']));
            
            // si il trouve pas le mail
            if(!$FormateurArray){
                $_SESSION['erreur'] = 'l\'adresse ou pass est pas correct';
                header('location: /planning/public/formateur/login');
                
                exit; 
            }


            
            //l'utilisateur existe
            $Formateur = $FormateurModel->hydrate($FormateurArray);
        
            
            //verifier si le mot pass est correct
            if(sha1($pass) === $Formateur->getMdp()){

                var_dump($pass);
                var_dump($Formateur->getMdp());

                // verifier si cest admin ou formateur et le mettre en session
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
        // formulaire login
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

    // logout de session
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
       
        // modif profil
        if(Form::validate($_POST, ['modifNom'])){
            if(isset($_SESSION['admin'])){
                $idFormateur = $_SESSION['admin']['id'];
            } elseif(isset($_SESSION['formateur'])) {
                $idFormateur = $_SESSION['formateur']['id'];
            }
            if(isset($_POST['modifNom'])){
                
                $new_nom = $_POST['nom'];
                $profil = new FormateurModel();
                $resultat = $profil->updateNomProfil($new_nom, $idFormateur);
                if ($resultat) {
                    // message succès
                    if(isset($_SESSION['admin'])){
                        $_SESSION['admin']['nom'] = $new_nom;
                    } elseif(isset($_SESSION['formateur'])) {
                        $_SESSION['formateur']['nom'] = $new_nom;
                    }
            
                    Refresh::refresh('/planning/public/formateur/profil');
                exit;  
                } else {
                    //  message d'erreur
                    echo 'Une erreur est survenue lors de l\'enregistrement.';
                }
            }
        }

        // modif prenom
        if(Form::validate($_POST, ['modifPrenom'])){
                if(isset($_SESSION['admin'])){
                    $idFormateur = $_SESSION['admin']['id'];
                } elseif(isset($_SESSION['formateur'])) {
                    $idFormateur = $_SESSION['formateur']['id'];
                }
                if(isset($_POST['modifPrenom'])){
                
                    $new_prenom = $_POST['prenom'];
                    $profil = new FormateurModel();
                    $resultat = $profil->updatePrenomProfil($new_prenom, $idFormateur);
                    if ($resultat) {
                        // message succès
                        if(isset($_SESSION['admin'])){
                            $_SESSION['admin']['prenom'] = $new_prenom;
                        } elseif(isset($_SESSION['formateur'])) {
                            $_SESSION['formateur']['prenom'] = $new_prenom;
                        }
                
                        Refresh::refresh('/planning/public/formateur/profil');
                        exit;  
                    } else {
                        //  message d'erreur
                        echo 'Une erreur est survenue lors de l\'enregistrement.';
                    }
                }
        }

        // modif mail
        if(Form::validate($_POST, ['modifMail'])){
            if(isset($_SESSION['admin'])){
                $idFormateur = $_SESSION['admin']['id'];
            } elseif(isset($_SESSION['formateur'])) {
                $idFormateur = $_SESSION['formateur']['id'];
            }
            if(isset($_POST['modifMail'])){
            
                $new_mail = $_POST['mail'];
                $profil = new FormateurModel();
                $resultat = $profil->updateMailProfil($new_mail, $idFormateur);
                if ($resultat) {
                    // message succès
                    if(isset($_SESSION['admin'])){
                        $_SESSION['admin']['mail'] = $new_mail;
                    } elseif(isset($_SESSION['formateur'])) {
                        $_SESSION['formateur']['mail'] = $new_mail;
                    }
            
                    Refresh::refresh('/planning/public/formateur/profil');
                    exit;  
                } else {
                    //  message d'erreur
                    echo 'Une erreur est survenue lors de l\'enregistrement.';
                }
            }
        }


        // modif pass
        if(Form::validate($_POST, ['verifierMdp'])) {
            if(isset($_POST['current_mdp'])) {
                $pass = $_POST['current_mdp'];
                $FormateurModel = new FormateurModel;
                $Formateur  = $FormateurModel->findOneByEmail($_SESSION['formateur']['mail']);
                
                //l'utilisateur existe
                if(sha1($pass) === $Formateur->mdp_formateur){
                    if(!empty($_POST['new_mdp']) && $_POST['new_mdp'] === $_POST['conf_new_mdp']) {
                        $idFormateur = $_SESSION['formateur']['id'];
                        $new_mdp = sha1($_POST['new_mdp']);
                        $resultat = $FormateurModel->updateMdpProfil($new_mdp, $idFormateur);
                        
                        if ($resultat) {
                        $_SESSION['success'] = "votre changement est bien effectué";
                            Refresh::refresh('/planning/public/formateur/profil');
                            exit;  
                        } else {
                            $_SESSION['error'] = "un error est fait pendant le enregistment merci de le saisir a nouvou";
                        }
                    } else {
                        $_SESSION['error'] = "le new mot de pass est pas match avec sa confirmation de mot de pass";
                        
                    }
                } else {
                    $_SESSION['error'] = "non c'est pas correct";
                }
            }
        }
    

        // choisir la date de vacance
        if(Form::validate($_POST, ['date_debut','date_fin'])) {
            // Récupérer les dates de début et de fin de vacances depuis le formulaire
            $dateDebut = $_POST['date_debut'];
            $dateFin = $_POST['date_fin'] ;

             // Récupérer l'ID du formateur depuis la session
            $idFormateur = $_SESSION['formateur']['id'];
            
            $vacance = new VacanceModel();
                
            $resultat = $vacance->createDateVacance($dateDebut, $dateFin, $idFormateur);

            if ($resultat) {
                // message succès
                Refresh::refresh('/planning/public/formateur/profil');
            exit;  
            } else {
                //  message d'erreur
                echo 'Une erreur est survenue lors de l\'enregistrement.';
            }
        }

        //choisir les jours de teletravail
        
        if (Form::validate($_POST, ['jourTeletravail'])) {
            // initialisation du tableau qui va contenir les jours sélectionnés
            $jours = array(); 
             // initialisation du compteur de jours sélectionnés
            $nbreJours = 0;

            $idFormateur = $_SESSION['formateur']['id'];
            // date de jour pour la date de demande
            $dateDemandeChangement = date('Y-m-d');

            // vérification des jours sélectionnés
            if(isset($_POST['lundi'])) {
                $jours[] = "lundi";
                $nbreJours++;
            }
            if(isset($_POST['mardi'])) {
                $jours[] = "mardi";
                $nbreJours++;
            }
            if(isset($_POST['mercredi'])) {
                $jours[] = "mercredi";
                $nbreJours++;
            }
            if(isset($_POST['jeudi'])) {
                $jours[] = "jeudi";
                $nbreJours++;
            }
            if(isset($_POST['vendredi'])) {
                $jours[] = "vendredi";
                $nbreJours++;
            }
            
            if($nbreJours == 0){
                $_SESSION['error'] = "vous avez 0 jour choisi";
            } elseif($nbreJours > 2) {
                $_SESSION['error'] = "non le max est 2 jours";

            }  else {
                $joursteletravail = implode(",", $jours); // conversion du tableau en une chaîne de caractères séparés par des virgules
                
                 $teletravail = new TeletravailModel();
                 $resultat = $teletravail->createJoursTeletravail($joursteletravail, $dateDemandeChangement ,$idFormateur);
                 if ($resultat) {
                     $_SESSION['succes'] = "Les jours de télétravail ont été enregistrés avec succès.";
                 } else {
                     $_SESSION['erreur'] = "Une erreur est survenue lors de l'enregistrement des jours de télétravail.";
                 }
            }
            $_SESSION['success'] = "votre demande a bien envoyer";
            Refresh::refresh('/planning/public/formateur/profil');
            exit;
        }



        // modif les color
        if(Form::validate($_POST,['send-color'])) {
            
            if(isset($_POST['send-color'])){
                $couleur_centre = $_POST['centre'];
                $couleur_pae = $_POST['pae'];
                $couleur_certif = $_POST['certif'];
                $couleur_ran = $_POST['ran'];
                $couleur_vacance_demandees = $_POST['vacance_demandees'];
                $couleur_vacance_validee = $_POST['vacance_validee'];
                $couleur_tt =  $_POST['couleur_tt'];
                $couleur_ferie = $_POST['ferie'];
                $couleur_weekend = $_POST['weekend'];
                $couleur_interruption = $_POST['interruption'];
                $couleur_MNSP = $_POST['MNSP'];
                $couleur_itinerant = $_POST['itinerant'];
                
                $Couleurs = new CouleursModel();
                $resultat = $Couleurs->updateCouleur($couleur_centre, $couleur_pae, $couleur_certif, $couleur_ran, $couleur_vacance_demandees, $couleur_vacance_validee, $couleur_tt, $couleur_ferie, $couleur_weekend, $couleur_interruption, $couleur_MNSP, $couleur_itinerant);
                if ($resultat) {
                    $_SESSION['color'] = $_POST;
                    $_SESSION['success'] = "Les colors ont été enregistrés avec succès.";
                    Refresh::refresh('/planning/public/formateur/profil');
                 } else {
                     $_SESSION['error'] = "Une erreur est survenue lors de l'enregistrement des jours de télétravail.";
                 }
            }
        }

        
        $colors = new CouleursModel;
        $colors->setSessionCoulors();
        $this->render('/formateur/profil');
    }

    
}

