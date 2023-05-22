<?php

namespace App\Controllers;

use App\Core\Form;
use App\Models\FormateurModel;

use App\Core\Refresh;
use App\Models\CouleursModel;

class FormateurController extends Controller
{

    public function login(): void
    {
        //on verifie si le formulaire est complet
        if (Form::validate($_POST, ['email', 'password'])) {
            $pass = strip_tags($_POST['password']);
            $FormateurModel = new FormateurModel;
            $Formateur = $FormateurModel->findOneByEmail(strip_tags($_POST['email']));

            // si il trouve pas le mail
            if (!$Formateur) {
                $_SESSION['erreur'] = 'l\'adresse ou pass est pas correct';
                header('location: /planning/public/formateur/login');

                exit;
            }
            //verifier si le mot pass est correct
            if (sha1($pass) === $Formateur->mdp_formateur) {

                var_dump($pass);
                var_dump($Formateur->mdp_formateur);

                // verifier si cest admin ou formateur et le mettre en session
                if ($Formateur->permissions_utilisateur >= 1) {
                    $Formateur = $FormateurModel->setSessionAdmin($Formateur);
                } else {
                    $Formateur = $FormateurModel->setSession($Formateur);
                }

                header('location: /planning/public/');
                exit;
            } else {
                $_SESSION['erreur'] = 'l\'adresse ou passs est pas correct';
                header('location: /planning/public/formateur/login');

                exit;
            }
        }
        // formulaire login
        // $form = new Form;

        // $form->debutForm()
        //     ->labelFor('email', 'E-mail :')
        //     ->ajoutInput('email', 'email', ['class' => 'form-control', 'id' => 'email'])
        //     ->closeLabel()
        //     ->labelFor('password', 'Mot de passe :')
        //     ->ajoutInput('password', 'password', ['class' => 'form-control', 'id' => 'pass'])
        //     ->closeLabel()
        //     ->ajoutInput('submit', 'login', ['class' => 'form-control'])
        //     ->finForm();

        $this->render('/formateur/login', ['loginForm'],'login');
    }

    // logout de session
    public function logout()
    {
        if (isset($_SESSION['formateur'])) {
            unset($_SESSION['formateur']);
            header('location: /planning/public/formateur/login');
            exit;
        }
        if (isset($_SESSION['admin'])) {
            unset($_SESSION['admin']);
            header('location: /planning/public/formateur/login');
            exit;
        }
    }

    public function profil()
    {

        // modif profil
        if (Form::validate($_POST, ['modifNom'])) {
            if (isset($_SESSION['admin'])) {
                $idFormateur = $_SESSION['admin']['id'];
            } elseif (isset($_SESSION['formateur'])) {
                $idFormateur = $_SESSION['formateur']['id'];
            }
            if (isset($_POST['modifNom']) && !empty(trim($_POST['nom']))) {

                $new_nom = $_POST['nom'];
                $profil = new FormateurModel();
                $resultat = $profil->updateNomProfil($new_nom, $idFormateur);
                if ($resultat) {
                    if (isset($_SESSION['admin'])) {
                        $_SESSION['admin']['nom'] = $new_nom;
                    } elseif (isset($_SESSION['formateur'])) {
                        $_SESSION['formateur']['nom'] = $new_nom;
                    }

                    Refresh::refresh('/planning/public/formateur/profil');
                    exit;
                } else {
                    //  message d'erreur
                    $_SESSION['error_profil'] = 'Une erreur est survenue lors de l\'enregistrement.';
                }
            } else {
                $_SESSION['error_profil'] = 'Le nom ne peut pas etre vide.';
            }
        }

        // modif prenom
        if (Form::validate($_POST, ['modifPrenom'])) {
            if (isset($_SESSION['admin'])) {
                $idFormateur = $_SESSION['admin']['id'];
            } elseif (isset($_SESSION['formateur'])) {
                $idFormateur = $_SESSION['formateur']['id'];
            }
            if (isset($_POST['modifPrenom'])  && !empty(trim($_POST['prenom']))) {

                $new_prenom = $_POST['prenom'];
                $profil = new FormateurModel();
                $resultat = $profil->updatePrenomProfil($new_prenom, $idFormateur);
                if ($resultat) {
                    if (isset($_SESSION['admin'])) {
                        $_SESSION['admin']['prenom'] = $new_prenom;
                    } elseif (isset($_SESSION['formateur'])) {
                        $_SESSION['formateur']['prenom'] = $new_prenom;
                    }

                    Refresh::refresh('/planning/public/formateur/profil');
                    exit;
                } else {
                    //  message d'erreur
                    $_SESSION['error_profil'] = 'Une erreur est survenue lors de l\'enregistrement.';
                }
            } else {
                $_SESSION['error_profil'] = 'Le prenom ne peut pas etre vide.';
            }
        }

        // modif mail
        if (Form::validate($_POST, ['modifMail'])) {
            if (isset($_SESSION['admin'])) {
                $idFormateur = $_SESSION['admin']['id'];
            } elseif (isset($_SESSION['formateur'])) {
                $idFormateur = $_SESSION['formateur']['id'];
            }
            if (isset($_POST['modifMail']) && !empty($_POST['mail'])) {
                if(filter_var($_POST['mail'],FILTER_VALIDATE_EMAIL)){
                    $new_mail = filter_var($_POST['mail'],FILTER_VALIDATE_EMAIL);
                    $profil = new FormateurModel();
                    $resultat = $profil->updateMailProfil($new_mail, $idFormateur);
                    if ($resultat) {
                        if (isset($_SESSION['admin'])) {
                            $_SESSION['admin']['mail'] = $new_mail;
                        } elseif (isset($_SESSION['formateur'])) {
                            $_SESSION['formateur']['mail'] = $new_mail;
                        }
    
                        Refresh::refresh('/planning/public/formateur/profil');
                        exit;
                    } else {
                        //  message d'erreur
                        $_SESSION['error_profil'] = 'Une erreur est survenue lors de l\'enregistrement.';
                    }
                } else {
                    $_SESSION['error_profil'] = 'Le adress mail non valide';
                }
            } else {
                $_SESSION['error_profil'] = 'Le adress mail ne pas etre vide';
            }
        }


        // modif pass
        if (Form::validate($_POST, ['verifierMdp'])) {
            if (isset($_POST['current_mdp']) && !empty($_POST['current_mdp'])) {
                $pass = $_POST['current_mdp'];
                $FormateurModel = new FormateurModel;
                $Formateur  = $FormateurModel->findOneByEmail($_SESSION['formateur']['mail']);

                //l'utilisateur existe
                if (sha1($pass) === $Formateur->mdp_formateur) {
                    if (!empty($_POST['new_mdp']) && $_POST['new_mdp'] === $_POST['conf_new_mdp']) {
                        $idFormateur = $_SESSION['formateur']['id'];
                        $new_mdp = sha1($_POST['new_mdp']);
                        $resultat = $FormateurModel->updateMdpProfil($new_mdp, $idFormateur);

                        if ($resultat) {
                            $_SESSION['success_profil'] = "votre changement est bien effectué";
                            Refresh::refresh('/planning/public/formateur/profil');
                            exit;
                        } else {
                            $_SESSION['error_profil'] = "un error est fait pendant le enregistment merci de le saisir a nouvou";
                        }
                    } else {
                        $_SESSION['error_profil'] = "le new mot de pass est pas match avec sa confirmation de mot de pass";
                    }
                } else {
                    $_SESSION['error_profil'] = "non c'est pas correct";
                }
            } else {
                $_SESSION['error_profil'] = "tout dabor faut inserer votre mot de passe actuelle!";
            }
        }


        // choisir la date de vacance
        if (Form::validate($_POST, ['date_debut', 'date_fin'])) {
            if (!empty($_POST['date_debut']) && !empty($_POST['date_fin'])) {
                // Récupérer les dates de début et de fin de vacances depuis le formulaire
                $dateDebut = $_POST['date_debut'];
                $dateFin = $_POST['date_fin'];

                // Récupérer l'ID du formateur depuis la session
                $idFormateur = $_SESSION['formateur']['id'];

                $vacance = new FormateurModel();

                $resultat = $vacance->createDateVacance($dateDebut, $dateFin, $idFormateur);

                if ($resultat) {
                    // message succès
                    $_SESSION['success_vacance'] = 'Votre demende de vacances a bien envoyé.';
                    Refresh::refresh('/planning/public/formateur/profil');
                    exit;
                } else {
                    //  message d'erreur
                    $_SESSION['error_vacance'] = 'Une erreur est survenue lors de l\'enregistrement.';
                }
            } else {
                $_SESSION['error_vacance'] = 'Vous avez pas choisi les deux dates';
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
            if (isset($_POST['lundi'])) {
                $jours[] = "lundi";
                $nbreJours++;
            }
            if (isset($_POST['mardi'])) {
                $jours[] = "mardi";
                $nbreJours++;
            }
            if (isset($_POST['mercredi'])) {
                $jours[] = "mercredi";
                $nbreJours++;
            }
            if (isset($_POST['jeudi'])) {
                $jours[] = "jeudi";
                $nbreJours++;
            }
            if (isset($_POST['vendredi'])) {
                $jours[] = "vendredi";
                $nbreJours++;
            }

            if ($nbreJours == 0) {
                $_SESSION['error_teletravail'] = "vous avez 0 jour choisi";
            } elseif ($nbreJours > 2) {
                $_SESSION['error_teletravail'] = "non le max est 2 jours";
            } else {
                $joursteletravail = implode(",", $jours); // conversion du tableau en une chaîne de caractères séparés par des virgules
                $teletravail = new FormateurModel();
                $resultat = $teletravail->createJoursTeletravail($joursteletravail, $dateDemandeChangement, $idFormateur);
                if ($resultat) {
                    $_SESSION['success_teletravail'] = "Les jours de télétravail ont été enregistrés avec succès.";
                } else {
                    $_SESSION['error_teletravail'] = "Une erreur est survenue lors de l'enregistrement des jours de télétravail.";
                }
            }
            // $teletravail->setSessionTeletravail($idFormateur);
            Refresh::refresh('/planning/public/formateur/profil');
            exit;
        }



        // modif les color
        if (Form::validate($_POST, ['send-color'])) {
            if (isset($_POST['send-color'])) {
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
                    $_SESSION['success_color'] = "Les colors ont été enregistrés avec succès.";
                    Refresh::refresh('/planning/public/formateur/profil');
                } else {
                    $_SESSION['error_color'] = "Une erreur est survenue lors de l'enregistrement des jours de télétravail.";
                }
            }
        }

        if (isset($_SESSION['formateur'])) {
            $teletravailActuel = new FormateurModel;
            $teletravailActuel->setSessionTeletravail($_SESSION['formateur']['id']);
        } elseif (isset($_SESSION['admin'])) {
            $colors = new CouleursModel;
            $colors->setSessionCoulors();
        }
        $this->render('/formateur/profil');
    }
}
