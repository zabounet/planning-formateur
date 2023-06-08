<?php

namespace App\Controllers;

use App\Core\Form;
use App\Core\Refresh;
use App\Core\AlgorithmePaques;
use App\Models\FormationModel;
use App\Models\FormateurModel;
use DateTime;

class AdminController extends Controller
{
    public function index(): void
    {

        $this->render('/main/index');
    }

    // Liste des formations
    public function formationsHome(): void
    {

        if (!isset($_SESSION['admin'])) {
            header('Location: /planning/public/');
            exit;
        }

        $formation = new FormationModel;

        // Jointure pour récupèrer l'ensemble des informations importantes relatives à la formation
        $infosFormation = $formation->joinInformations(
            [
                'id_formation',
                'nom_formation',
                'description_formation',
                'candidats_formation',
                'date_debut_formation',
                'date_fin_formation',
                'Formation.numero_grn',
                'nom_formateur',
                'prenom_formateur',
                'designation_type_formation',
                'nom_ville'
            ],
            "Formation",
            [
                'Formateur',
                'Ville',
                'Type_formation'
            ],
            [
                'id_formateur',
                'id_ville',
                'id_type_formation'
            ]
        );

        if (isset($_POST['Delete'])) {

            $formation->delete('Date_centre', 'id_formation', $_POST['ID']);
            $formation->delete('Date_certif', 'id_formation', $_POST['ID']);
            $formation->delete('Date_ran', 'id_formation', $_POST['ID']);
            $formation->delete("Date_pae", "id_formation", $_POST['ID']);
            $formation->delete("Interruption", "id_formation", $_POST['ID']);
            $formation->delete("Date_intervention", "id_formation", $_POST['ID']);
            $formation->delete('Formation', 'id_formation', $_POST['ID']);

            Refresh::refresh('/planning/public/index.php?p=admin/formationsHome');
            exit;
        }

        // Si une recherche est effectuée, alors recupère les informations correspondantes à la recherche
        if (isset($_POST['search_d']) && !empty($_POST['search_d'])) {
            $infosFormation = $formation->search(
                [
                    'id_formation',
                    'nom_formation',
                    'description_formation',
                    'candidats_formation',
                    'date_debut_formation',
                    'date_fin_formation',
                    'Formation.numero_grn',
                    'nom_formateur',
                    'prenom_formateur',
                    'designation_type_formation',
                    'nom_ville'
                ],
                "Formation",
                $_POST['search_d'],
                [
                    'nom_formation',
                    'nom_formateur',
                    'prenom_formateur',
                    'Formation.numero_grn',
                    'nom_ville',
                    'designation_type_formation'
                ],
                [
                    'Formateur',
                    'Ville',
                    'Type_formation'
                ],
                [
                    'id_formateur',
                    'id_ville',
                    'id_type_formation'
                ]
            );
            $search = $_POST['search_d'];
            $this->render('admin/formationsHome', compact('infosFormation', 'search'), 'formations');
        } else {
            $this->render('admin/formationsHome', compact('infosFormation',), 'formations');
        }
    }

    // Modifier les informations d'une formation
    public function modifierFormation(): void
    {
        if (!isset($_SESSION['admin'])) {
            header('Location: /planning/public/');
            exit;
        }

        if (Form::validate(
            $_POST,
            [
                'type',
                'grn',
                'acronyme',
                'description',
                'offre',
                'date-debut-formation',
                'date-fin-formation',
                'ville'
            ],
            [
                'date-debut-ran',
                'date-fin-ran',
                'date-debut-entreprise',
                'date-fin-entreprise',
                'date-debut-centre',
                'date-fin-centre',
                'date-debut-certification',
                'date-fin-certification',
                'date-debut-interruption',
                'date-fin-interruption',
                'referent-formateur',
                'formateur',
                'date-debut-intervention',
                'date-fin-intervention'
            ]
        )) {
            $database = new FormationModel;

            // Né récupère que l'id place à la toute fin de l'URL. L'esperluette est nécessaire afin de permettre l'utilisation de 2 paramètres dans l'URL.
            $currentId = str_replace("/planning/public/index.php?p=admin/modifierFormation&?id=", "", $_SERVER['REQUEST_URI']);

            //Récupèration du nom de la ville pour composer l'id de la formation
            $villeNom = $database->getOne("nom_ville", "Ville", "id_ville", $_POST['ville']);

            //Si un formateur référent a été assigné, attribuer sa valeur. Sinon, donner l'id 1 (correspondant à non attribué).
            $referent = isset($_POST['referent-formateur']) ? $_POST['referent-formateur'] : 1;

            // Instanciation d'objets DateTime afin de pouvoir convertir les valeurs au bon format
            $debutFormation = new DateTime($_POST["date-debut-formation"]);
            $finFormation = new DateTime($_POST["date-fin-formation"]);

            //Création de l'id de la formation
            $nomFormation = $_POST["grn"] . " " . $_POST["acronyme"] . " " . $_POST["offre"] . " : " . $debutFormation->format('d-m-Y') . " - " . $finFormation->format('d-m-Y') . " " . $villeNom['nom_ville'];

            // Mise à jour des informations
            $database->update(
                'Formation',
                [
                    'nom_formation',
                    'acronyme_formation',
                    'description_formation',
                    'candidats_formation',
                    'date_debut_formation',
                    'date_fin_formation',
                    'id_type_formation',
                    'numero_grn',
                    'id_formateur',
                    'id_ville'
                ],
                [
                    $nomFormation,
                    $_POST['acronyme'],
                    $_POST['description'],
                    $_POST['candidats'],
                    $_POST['date-debut-formation'],
                    $_POST['date-fin-formation'],
                    $_POST['type'],
                    $_POST['grn'],
                    $referent,
                    $_POST['ville']
                ],
                ['id_formation'],
                [$currentId]
            );

            // Supprime l'ensemble des informations existantes pour cette formation dans les tables de periodes
            // afin d'éviter les doublons.
            $deleteRan = $database->delete('Date_ran', 'id_formation', $currentId);
            $deletePae = $database->delete('Date_pae', 'id_formation', $currentId);
            $deleteCentre = $database->delete('Date_centre', 'id_formation', $currentId);
            $deleteCertif = $database->delete('Date_certif', 'id_formation', $currentId);
            $deleteInterventions = $database->delete('Date_intervention', 'id_formation', $currentId);
            $deleteInterruptions = $database->delete('Interruption', 'id_formation', $currentId);

            // Boucles d'insertion de chaque périodes 
            if (isset($_POST['date-debut-entreprise'])) {
                $periodesEntreprise = count($_POST['date-debut-entreprise']);
                for ($i = 0; $i < $periodesEntreprise; $i++) {
                    if ($_POST['date-debut-entreprise'][$i] !== "" && $_POST['date-fin-entreprise'][$i] !== "") {
                        $database->insertPeriode("Date_pae", $_POST['date-debut-entreprise'][$i], $_POST['date-fin-entreprise'][$i], $currentId);
                    }
                }
            }

            if (isset($_POST['date-debut-centre'])) {
                $periodesCentre = count($_POST['date-debut-centre']);
                for ($i = 0; $i < $periodesCentre; $i++) {
                    if ($_POST['date-debut-centre'][$i] !== "" && $_POST['date-fin-centre'][$i] !== "") {
                        $database->insertPeriode("Date_centre", $_POST['date-debut-centre'][$i], $_POST['date-fin-centre'][$i], $currentId);
                    }
                }
            }

            if (isset($_POST['date-debut-ran'])) {
                $periodesRan = count($_POST['date-debut-ran']);
                for ($i = 0; $i < $periodesRan; $i++) {
                    if ($_POST['date-debut-ran'][$i] !== "" && $_POST['date-fin-ran'][$i] !== "") {
                        $database->insertPeriode("Date_ran", $_POST['date-debut-ran'][$i], $_POST['date-fin-ran'][$i], $currentId);
                    }
                }
            }

            if (isset($_POST['date-debut-certification'])) {
                $periodesCertif = count($_POST['date-debut-certification']);
                for ($i = 0; $i < $periodesCertif; $i++) {
                    if ($_POST['date-debut-certification'][$i] !== "" && $_POST['date-fin-certification'][$i] !== "") {
                        $database->insertPeriode("Date_certif", $_POST['date-debut-certification'][$i], $_POST['date-fin-certification'][$i], $currentId);
                    }
                }
            }

            if (isset($_POST['date-debut-interruption'])) {
                $periodesInterruption = count($_POST['date-debut-interruption']);
                for ($i = 0; $i < $periodesInterruption; $i++) {
                    if ($_POST['date-debut-interruption'][$i] !== "" && $_POST['date-fin-interruption'][$i] !== "") {
                        $database->insertPeriode("Interruption", $_POST['date-debut-interruption'][$i], $_POST['date-fin-interruption'][$i], $currentId);
                    }
                }
            }

            if (isset($_POST['date-debut-intervention'])) {
                $periodesFormateurs = count($_POST['date-debut-intervention']);
                for ($i = 0; $i < $periodesFormateurs; $i++) {
                    if ($_POST['date-debut-intervention'][$i] !== "" && $_POST['date-fin-intervention'][$i] !== "") {
                        $database->insertPeriodeIntervention("Date_intervention", $_POST['date-debut-intervention'][$i], $_POST['date-fin-intervention'][$i], $_POST['formateur'][$i], $currentId);
                    }
                }
            }
            Refresh::refresh('/planning/public/index.php?p=admin/formationsHome');
        }

        $formation = new FormationModel;
        $formateur = new FormateurModel;

        // Né récupère que l'id place à la toute fin de l'URL. L'esperluette est nécessaire afin de permettre l'utilisation de 2 paramètres dans l'URL.
        $currentId = str_replace("/planning/public/index.php?p=admin/modifierFormation&?id=", "", $_SERVER['REQUEST_URI']);

        // Infos sur la formation actuelle
        $infosCurrent = $formation->getOne('*', 'Formation', 'id_formation', $currentId);

        // Récupération du tableau contenant les informations nécessaire à la création des menus déroulants de la page.
        $infosFormation = $formation->getInformations();

        //Récupèration des periodes de date relatives à la formation
        $infosRan = $formation->getBy(['date_debut_ran', 'date_fin_ran'], 'Date_ran', ['id_formation'], [$currentId]);
        $infosPae = $formation->getBy(['date_debut_pae', 'date_fin_pae'], 'Date_pae', ['id_formation'], [$currentId]);
        $infosCertif = $formation->getBy(['date_debut_certif', 'date_fin_certif'], 'Date_certif', ['id_formation'], [$currentId]);
        $infosCentre = $formation->getBy(['date_debut_centre', 'date_fin_centre'], 'Date_centre', ['id_formation'], [$currentId]);
        $infosInterruption = $formation->getBy(['date_debut_interruption', 'date_fin_interruption'], 'Interruption', ['id_formation'], [$currentId]);
        // Récupères les id des formateurs ayant des périodes d'activités pour cette formation.
        // Retourne un tableau d'objet contenant chacun une ligne du résultat.
        $idInterventions = $formation->getBy(['id_formateur'], 'Date_intervention', ['id_formation'], [$currentId]);

        $interventions_formateurs = array();
        // Boucle pour récupèrer l'id formateur de chaque objets dans un seul tableau.
        for ($i = 0; $i < count($idInterventions); $i++) {
            $formateurs = [
                "id" => $idInterventions[$i]->id_formateur
            ];
            $interventions_formateurs[] = $formateurs['id'];
        };
        if (count($interventions_formateurs) > 0) {

            //Récupère les interventions des formateurs en fonction de leur ID
            $dates_interventions_formateurs = $formateur->getDatesById(
                ['Formateur.id_formateur'],
                ['date_debut_intervention', 'date_fin_intervention'],
                'Formateur',
                ['Date_intervention', 'Date_intervention'],
                ['Date_intervention'],
                ['Formateur'],
                ['id_formateur'],
                'id_formateur',
                $interventions_formateurs
            );

            $infosInterventions = array();
            // Boucle pour chacune des dates récupèrées
            for ($j = 0; $j < count($dates_interventions_formateurs); $j++) {
                // Explose les chaînes de caractères date_debut et date_fin

                $date_debut_intervention = $dates_interventions_formateurs[$j]['date_debut_intervention'];
                $debutIntervention = explode(",", $date_debut_intervention);

                $date_fin_intervention = $dates_interventions_formateurs[$j]['date_fin_intervention'];
                $finIntervention = explode(",", $date_fin_intervention);

                // $debutIntervention = explode(",",$dates_interventions_formateurs[$j]['date_debut']);
                // $finIntervention = explode(",",$dates_interventions_formateurs[$j]['date_fin']);
                // Pour chaque factions créées par l'explosion, les attribue dans un tableau avec l'id du formateur correspondant.
                for ($z = 0; $z < count($debutIntervention); $z++) {
                    $interventions = [
                        "debut" => $debutIntervention[$z],
                        "fin" => $finIntervention[$z],
                        "id" => $dates_interventions_formateurs[$j]['id_formateur']
                    ];
                    $infosInterventions[] = $interventions;
                }
            }
        }else{
            $infosInterventions = array();
        }

        $this->render('admin/modifierFormation', compact('infosCurrent', 'infosFormation', 'infosRan', 'infosRan', 'infosPae', 'infosCertif', 'infosCentre', 'infosInterruption', 'infosInterventions'), 'formations');
    }

    // Ajouter une nouvelle formation 
    public function ajouterFormation(): void
    {

        if (!isset($_SESSION['admin'])) {
            header('Location: /planning/public/');
            exit;
        }

        if (Form::validate(
            $_POST,
            [
                'type',
                'grn',
                'acronyme',
                'description',
                'offre',
                'date-debut-formation',
                'date-fin-formation',
                'ville'
            ],
            [
                'candidats',
                'date-debut-ran',
                'date-fin-ran',
                'date-debut-entreprise',
                'date-fin-entreprise',
                'date-debut-centre',
                'date-fin-centre',
                'date-debut-certification',
                'date-fin-certification',
                'date-debut-interruption',
                'date-fin-interruption',
                'referent-formateur',
                'formateur',
                'date-debut-intervention',
                'date-fin-intervention'
            ]
        )) {

            //Déclaration des objets model
            $database = new FormationModel;

            //Récupèration du nom de la ville pour composer l'id de la formation
            $villeNom = $database->getOne("nom_ville", "Ville", "id_ville", $_POST['ville']);

            //Si un formateur référent a été assigné, attribuer sa valeur. Sinon, donner l'id 1 (correspondant à non attribué).
            $referent = isset($_POST['referent-formateur']) ? $_POST['referent-formateur'] : 1;

            $debutFormation = new DateTime($_POST["date-debut-formation"]);
            $finFormation = new DateTime($_POST["date-fin-formation"]);

            //Création de l'id de la formation
            $nomFormation = $_POST["grn"] . " " . $_POST["acronyme"] . " " . $_POST["offre"] . " : " . $debutFormation->format('d-m-Y') . " - " . $finFormation->format('d-m-Y') . " " . $villeNom['nom_ville'];

            //Insertion des données dans la table formation
            $database->insertFormation(
                $nomFormation,
                $_POST['acronyme'],
                $_POST['description'],
                $_POST['candidats'],
                $_POST['date-debut-formation'],
                $_POST['date-fin-formation'],
                $_POST['type'],
                $_POST['grn'],
                $referent,
                $_POST['ville']
            );

            $idFormation = $database->getLastId('id_formation');

            if (isset($_POST['date-debut-entreprise'])) {
                $periodesEntreprise = count($_POST['date-debut-entreprise']);
                for ($i = 0; $i < $periodesEntreprise; $i++) {
                    if ($_POST['date-debut-entreprise'][$i] !== "" && $_POST['date-fin-entreprise'][$i] !== "") {
                        $database->insertPeriode("Date_pae", $_POST['date-debut-entreprise'][$i], $_POST['date-fin-entreprise'][$i], $idFormation['MAX(id_formation)']);
                    }
                }
            }
            if (isset($_POST['date-debut-centre'])) {
                $periodesCentre = count($_POST['date-debut-centre']);
                for ($i = 0; $i < $periodesCentre; $i++) {
                    if ($_POST['date-debut-centre'][$i] !== "" && $_POST['date-fin-centre'][$i] !== "") {
                        $database->insertPeriode("Date_centre", $_POST['date-debut-centre'][$i], $_POST['date-fin-centre'][$i], $idFormation['MAX(id_formation)']);
                    }
                }
            }
            if (isset($_POST['date-debut-ran'])) {
                $periodesRan = count($_POST['date-debut-ran']);
                for ($i = 0; $i < $periodesRan; $i++) {
                    if ($_POST['date-debut-ran'][$i] !== "" && $_POST['date-fin-ran'][$i] !== "") {
                        $database->insertPeriode("Date_ran", $_POST['date-debut-ran'][$i], $_POST['date-fin-ran'][$i], $idFormation['MAX(id_formation)']);
                    }
                }
            }
            if (isset($_POST['date-debut-certification'])) {
                $periodesCertif = count($_POST['date-debut-certification']);
                for ($i = 0; $i < $periodesCertif; $i++) {
                    if ($_POST['date-debut-certification'][$i] !== "" && $_POST['date-fin-certification'][$i] !== "") {
                        $database->insertPeriode("Date_certif", $_POST['date-debut-certification'][$i], $_POST['date-fin-certification'][$i], $idFormation['MAX(id_formation)']);
                    }
                }
            }
            if (isset($_POST['date-debut-interruption'])) {
                $periodesInterruption = count($_POST['date-debut-interruption']);
                for ($i = 0; $i < $periodesInterruption; $i++) {
                    if ($_POST['date-debut-interruption'][$i] !== "" && $_POST['date-fin-interruption'][$i] !== "") {
                        $database->insertPeriode("Interruption", $_POST['date-debut-interruption'][$i], $_POST['date-fin-interruption'][$i], $idFormation['MAX(id_formation)']);
                    }
                }
            }
            if (isset($_POST['date-debut-intervention'])) {
                $periodesFormateurs = count($_POST['date-debut-intervention']);
                for ($i = 0; $i < $periodesFormateurs; $i++) {
                    if ($_POST['date-debut-intervention'][$i] !== "" && $_POST['date-fin-intervention'][$i] !== "") {
                        $database->insertPeriodeIntervention("Date_intervention", $_POST['date-debut-intervention'][$i], $_POST['date-fin-intervention'][$i], $_POST['formateur'][$i], $idFormation['MAX(id_formation)']);
                    }
                }
            }
            Refresh::refresh('/planning/public/index.php?p=admin/formationsHome');
        }

        $infos = new FormationModel;

        $infosFormation = $infos->getInformations();

        // Vérifie si la requête est de type 'xmlhttprequest'
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            // Envoie les informations en json afin de pouvoir les lire en javascript
            header('Content-type: application/json');
            echo json_encode($infosFormation['Formateurs']);
            exit;
        } else {
            $this->render('admin/ajouterFormation', compact('infosFormation'), 'formations');
        };
    }

    public function formateursHome(): void
    {

        if (!isset($_SESSION['admin'])) {
            header('Location: /planning/public/');
            exit;
        }

        $formateur = new FormateurModel;

        $infosFormateur = $formateur->joinInformations(
            [
                'id_formateur',
                'nom_formateur',
                'prenom_formateur',
                'mail_formateur',
                'type_contrat_formateur',
                'date_debut_contrat',
                'date_fin_contrat',
                'numero_grn',
                'nom_ville'
            ],
            "Formateur",
            ['Ville'],
            ['id_ville']
        );

        if (isset($_POST['Delete'])) {

            $formateur->update('Formation', ['id_formateur'], ['1'], ['id_formateur'], [$_POST['ID']]);
            $formateur->delete('Date_intervention', 'id_formateur', $_POST['ID']);
            $formateur->delete('Date_MNSP', 'id_formateur', $_POST['ID']);
            $formateur->delete('Date_perfectionnement', 'id_formateur', $_POST['ID']);
            $formateur->delete("Formateur", "id_formateur", $_POST['ID']);

            Refresh::refresh('/planning/public/index.php?p=admin/formateursHome');
            exit;
        }

        if (isset($_POST['search_d']) && !empty($_POST['search_d'])) {
            $infosFormateur = $formateur->search(
                [
                    'id_formateur',
                    'nom_formateur',
                    'prenom_formateur',
                    'mail_formateur',
                    'type_contrat_formateur',
                    'date_debut_contrat',
                    'date_fin_contrat',
                    'numero_grn',
                    'nom_ville'
                ],
                "Formateur",
                $_POST['search_d'],
                [
                    'nom_formateur',
                    'prenom_formateur',
                    'nom_ville',
                    'type_contrat_formateur',
                    'numero_grn'
                ],
                [

                    'Ville'
                ],
                [

                    'id_ville'
                ]
            );
            $search = $_POST['search_d'];
            $this->render('admin/formateursHome', compact('infosFormateur', 'search'), 'formateurs');
        } else {
            $this->render('admin/formateursHome', compact('infosFormateur'), 'formateurs');
        }
    }

    // Ajouter un nouveau formateur dans la base de données
    public function inscriptionFormateur()
    {
        if (!isset($_SESSION['admin'])) {
            header('Location: /planning/public/');
            exit;
        }

        if (Form::validate($_POST, ['inscription'])) {

            // verifier le mail
            $mail = $_POST['email'];
            // if(filter_var($mail, FILTER_VALIDATE_EMAIL)){

            $formateur = new FormateurModel;

            //Création de le mot de pass de la formation
            $mdp_formateur = $_POST["nom"] .  $_POST["prenom"];
            $mdp = password_hash($mdp_formateur, PASSWORD_ARGON2ID, Form::Argon2IDOptions());

            //un formateur n'est pas admin
            $permissions_utilisateur = 0;

            if ($_POST['type_contrat'] === 'CDI') {
                $date_fin_contrat = '0001-01-01';
            } else {
                $date_fin_contrat =  $_POST['date_fin_contrat'];
            }

            $type_contrat = strtoupper($_POST["type_contrat"]);
            //Insertion des données dans la table formation
            $formateur->insertFormateur(
                $_POST['nom'],
                $_POST['prenom'],
                $mail,
                $mdp,
                $type_contrat,
                $_POST['date_debut_contrat'],
                $date_fin_contrat,
                $permissions_utilisateur,
                $_POST['grn'],
                $_POST['ville']
            );


            $_SESSION['success'] = "Formateur ajouté avec succès";
            Refresh::refresh('/planning/public/index.php?p=admin/formateursHome');
            exit;
        } else if (!empty($_POST) && !Form::validate($_POST, ['inscription'])) {
            $_SESSION['error'] = "Formulaire incomplet";
            Refresh::refresh('/planning/public/index.php?p=admin/inscriptionFormateur');
            exit;
        }

        $infos = new FormateurModel;

        $infosFormateur = $infos->getInformations();
        $this->render('admin/inscriptionFormateur', compact('infosFormateur'), 'formateurs');
    }

    // Modifier les informations d'un formateur
    public function modifierFormateur(): void
    {

        if (!isset($_SESSION['admin'])) {
            header('Location: /planning/public/');
            exit;
        }

        if (Form::validate($_POST, ['inscription', 'delete'])) {

            $database = new FormateurModel;
            $permissions_utilisateur = 0;

            // set à 0001-01-01 car le null n'est pas accepté.
            if ($_POST['type_contrat'] === 'CDI') {
                $date_fin_contrat = '0001-01-01';
            } else {
                $date_fin_contrat =  $_POST['date_fin_contrat'];
            }

            // Né récupère que l'id place à la toute fin de l'URL. L'esperluette est nécessaire afin de permettre l'utilisation de 2 paramètres dans l'URL.
            $currentId = str_replace("/planning/public/index.php?p=admin/modifierFormateur&?id=", "", $_SERVER['REQUEST_URI']);

            $database->update(
                'Formateur',
                [
                    'nom_formateur',
                    'prenom_formateur',
                    'mail_formateur',
                    'type_contrat_formateur',
                    'date_debut_contrat',
                    'date_fin_contrat',
                    'numero_grn',
                    'id_ville'
                ],
                [
                    $_POST['nom'],
                    $_POST['prenom'],
                    $_POST['mail'],
                    $_POST['type_contrat'],
                    $_POST['date_debut_contrat'],
                    $date_fin_contrat,
                    $_POST['grn'],
                    $_POST['ville']
                ],
                ['id_formateur'],
                [$currentId]
            );

            Refresh::refresh('/planning/public/index.php?p=admin/formateursHome');
            exit;
        }


          //choisir les jours de teletravail

          if (Form::validate($_POST, ['jourTeletravail'])) {
            // initialisation du tableau qui va contenir les jours sélectionnés
            $jours = array();
            // initialisation du compteur de jours sélectionnés
            $nbreJours = 0;


            $idFormateur = str_replace("/planning/public/index.php?p=admin/modifierFormateur&?id=", "", $_SERVER['REQUEST_URI']);
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

            if ($nbreJours == 0 && empty($teletravaiValide['jour_teletravail'])) {
                $_SESSION['error_teletravail'] = "Vous n'avez rien selectionné.";
            } elseif ($nbreJours > 2) {
                $_SESSION['error_teletravail'] = "Vous ne pouvez pas selectionner plus de 2 jours.";
            } else {

                $joursteletravail = implode(",", $jours); // conversion du tableau en une chaîne de caractères séparés par des virgules
                $date_prise_effet = $_POST['date_prise_effet'];
                $teletravail = new FormateurModel();

                // manip pour envoiyer un reqeutte vers table notification
                $jourstele = implode(" et ", $jours);
                $description = htmlentities(" La manager a saisi pour vouz le télétravail pour " . $jourstele . " à compter du " . date('d-m-Y', strtotime($date_prise_effet)));
                $date_notification = date('Y-m-d H:i:s');

                $table = "Date_teletravail";
                $joursteletravail = implode(",", $jours);
                $teletravail = new FormateurModel();

                $ttValidExists = $teletravail->getByCustom(['validation'],'Date_teletravail',['id_formateur','validation'],['=','='],[$idFormateur, '1']);
                $ttExists = $teletravail->getByCustom(['validation'],'Date_teletravail',['id_formateur','validation'],['=','IS'],[$idFormateur, 'Null']);

                if(!empty($ttExists) || !empty($ttValidExists)){
                    $resultat = $teletravail->updateJoursTeletravailParAdmin($joursteletravail, $dateDemandeChangement, $date_prise_effet, $idFormateur);

                    if ($resultat) {
                        $_SESSION['success_teletravail'] = "Votre demande a été mise à jour avec succès.";
                    } else {
                        $_SESSION['error_teletravail'] = "Une erreur s'est produite lors de l'enregistrement. Veuillez réessayer après quelques instants.";
                    }
                    
                    Refresh::refresh('/planning/public/index.php?p=admin/modifierFormateur&?id=' . $idFormateur);
                    exit;
                }
                $role = 'admin';
                $resultat = $teletravail->createJoursTeletravailParAdmin($joursteletravail, $dateDemandeChangement, $date_prise_effet, $idFormateur);
                $demande = $teletravail->creatrNotification($description, $joursteletravail, $date_notification, $role, $idFormateur, $table);

                if ($resultat) {
                    $_SESSION['success_teletravail'] = "Les jours de télétravail ont été enregistrés avec succès.";
                } else {
                    $_SESSION['error_teletravail'] = "Une erreur s'est produite lors de l'enregistrement. Veuillez réessayer après quelques instants.";
                }

                Refresh::refresh('/planning/public/index.php?p=admin/modifierFormateur&?id=' . $idFormateur);
            exit;
            }
            
        }


        if (Form::validate($_POST, ['intervention', 'Delete'])) {

            $database = new FormateurModel;

            $currentId = str_replace("/planning/public/index.php?p=admin/modifierFormateur&?id=", "", $_SERVER['REQUEST_URI']);

            $database->delete("Date_intervention", "id_intervention", $_POST['intervention']);

            Refresh::refresh('/planning/public/index.php?p=admin/modifierFormateur&?id=' . $currentId);
            exit;
        }

       

        if (Form::validate($_POST, ['MNSP', 'Delete'])) {

            $database = new FormateurModel;

            $currentId = str_replace("/planning/public/index.php?p=admin/modifierFormateur&?id=", "", $_SERVER['REQUEST_URI']);

            $database->delete("Date_MNSP", "id_MNSP", $_POST['MNSP']);

            Refresh::refresh('/planning/public/index.php?p=admin/modifierFormateur&?id=' . $currentId);
            exit;
        }

        if (Form::validate($_POST, ['perfectionnement', 'Delete'])) {

            $database = new FormateurModel;

            $currentId = str_replace("/planning/public/index.php?p=admin/modifierFormateur&?id=", "", $_SERVER['REQUEST_URI']);

            $database->delete("Date_perfectionnement", "id_perfectionnement ", $_POST['perfectionnement'][0]);

            Refresh::refresh('/planning/public/index.php?p=admin/modifierFormateur&?id=' . $currentId);
            exit;
        }

        if (Form::validate($_POST, ['vacance', 'Delete'])) {

            $database = new FormateurModel;

            $currentId = str_replace("/planning/public/index.php?p=admin/modifierFormateur&?id=", "", $_SERVER['REQUEST_URI']);

            $database->delete("date_vacance", "id_vacance ", $_POST['vacance']);

            Refresh::refresh('/planning/public/index.php?p=admin/modifierFormateur&?id=' . $currentId);
            exit;
        }

        if (Form::validate($_POST, ['autre', 'Delete'])) {

            $database = new FormateurModel;

            $currentId = str_replace("/planning/public/index.php?p=admin/modifierFormateur&?id=", "", $_SERVER['REQUEST_URI']);

            $database->delete("date_autre", "id_autre ", $_POST['autre']);

            Refresh::refresh('/planning/public/index.php?p=admin/modifierFormateur&?id=' . $currentId);
            exit;
        }


        if (Form::validate($_POST, ['date-debut-intervention', 'date-fin-intervention'])) {

            $database = new FormateurModel;

            $currentId = str_replace("/planning/public/index.php?p=admin/modifierFormateur&?id=", "", $_SERVER['REQUEST_URI']);

            if (isset($_POST['date-debut-intervention'])) {
                $periodesFormateurs = count($_POST['date-debut-intervention']);
                for ($i = 0; $i < $periodesFormateurs; $i++) {
                    $database->insertPeriodeIntervention("Date_intervention", $_POST['date-debut-intervention'][$i], $_POST['date-fin-intervention'][$i], $currentId, $_POST['intervention'][$i]);
                }
            }

            Refresh::refresh('/planning/public/index.php?p=admin/modifierFormateur&?id=' . $currentId);
            exit;
        }

        if (Form::validate($_POST, ['date-debut-MNSP', 'date-fin-MNSP'])) {

            $database = new FormateurModel;

            $currentId = str_replace("/planning/public/index.php?p=admin/modifierFormateur&?id=", "", $_SERVER['REQUEST_URI']);

            if (isset($_POST['date-debut-MNSP'])) {
                $periodesFormateurs = count($_POST['date-debut-MNSP']);
                for ($i = 0; $i < $periodesFormateurs; $i++) {
                    $database->insertPeriode("Date_MNSP", $_POST['date-debut-MNSP'][$i], $_POST['date-fin-MNSP'][$i], $currentId);
                }
            }

            Refresh::refresh('/planning/public/index.php?p=admin/modifierFormateur&?id=' . $currentId);
            exit;
        }

        if (Form::validate($_POST, ['date-debut-perfectionnement', 'date-fin-perfectionnement'])) {

            $database = new FormateurModel;

            $currentId = str_replace("/planning/public/index.php?p=admin/modifierFormateur&?id=", "", $_SERVER['REQUEST_URI']);

            if (isset($_POST['date-debut-perfectionnement'])) {
                $periodesFormateurs = count($_POST['date-debut-perfectionnement']);
                for ($i = 0; $i < $periodesFormateurs; $i++) {
                    $database->insertPeriode("Date_perfectionnement", $_POST['date-debut-perfectionnement'][$i], $_POST['date-fin-perfectionnement'][$i], $currentId);
                }
            }

            Refresh::refresh('/planning/public/index.php?p=admin/modifierFormateur&?id=' . $currentId);
            exit;
        }

        if (Form::validate($_POST, ['date-debut-vacance', 'date-fin-vacance'])) {

            $database = new FormateurModel;

            $currentId = str_replace("/planning/public/index.php?p=admin/modifierFormateur&?id=", "", $_SERVER['REQUEST_URI']);

            if (isset($_POST['date-debut-vacance'])) {
                $periodesFormateurs = count($_POST['date-debut-vacance']);
                for ($i = 0; $i < $periodesFormateurs; $i++) {
                    //ici j'ai utiliser le reqeute de inser intervention car ca fait le taf pour vacance a cause de validation j'ai besoin de 5 paramétre
                    $database->insertPeriodeIntervention("Date_vacance", $_POST['date-debut-vacance'][$i], $_POST['date-fin-vacance'][$i], 1, $currentId);
                }
            }

            Refresh::refresh('/planning/public/index.php?p=admin/modifierFormateur&?id=' . $currentId);
            exit;
        }

        if (Form::validate($_POST, ['intitule-autre','date-debut-autre', 'date-fin-autre'])) {

            $database = new FormateurModel;

            $currentId = str_replace("/planning/public/index.php?p=admin/modifierFormateur&?id=", "", $_SERVER['REQUEST_URI']);

            if (isset($_POST['date-debut-autre'])) {
                $periodesFormateurs = count($_POST['date-debut-autre']);
                for ($i = 0; $i < $periodesFormateurs; $i++) {
                    //ici j'ai utiliser le reqeute de inser intervention car ca fait le taf pour vacance a cause de validation j'ai besoin de 5 paramétre
                    $database->insertPeriodeIntervention("Date_autre", $_POST['date-debut-autre'][$i], $_POST['date-fin-autre'][$i], $_POST['intitule-autre'][$i], $currentId);
                }
            }

            Refresh::refresh('/planning/public/index.php?p=admin/modifierFormateur&?id=' . $currentId);
            exit;
        }

        
        $formateur = new FormateurModel;

        $currentId = str_replace("/planning/public/index.php?p=admin/modifierFormateur&?id=", "", $_SERVER['REQUEST_URI']);

        $infosCurrent = $formateur->joinInformations(
            [
                'id_formateur',
                'nom_formateur',
                'prenom_formateur',
                'mail_formateur',
                'type_contrat_formateur',
                'date_debut_contrat',
                'date_fin_contrat',
                'numero_grn',
                'nom_ville'
            ],
            "Formateur",
            ['Ville'],
            ['id_ville'],
            ['id_formateur'],
            [$currentId]
        );
        $infosInterventions = $formateur->getBy(['id_intervention', 'date_debut_intervention', 'date_fin_intervention', 'id_formation'], 'Date_intervention', ['id_formateur'], [$currentId]);
        $infosMNSP = $formateur->getBy(['id_MNSP', 'date_debut_MNSP', 'date_fin_MNSP'], 'Date_MNSP', ['id_formateur'], [$currentId]);
        $infosPerfectionnement = $formateur->getBy(['id_perfectionnement', 'date_debut_perfectionnement', 'date_fin_perfectionnement'], 'Date_perfectionnement', ['id_formateur'], [$currentId]);
        $infosVacances = $formateur->getBy(['id_vacance', 'date_debut_vacances', 'date_fin_vacances'], 'date_vacance', ['id_formateur','validation'], [$currentId,1]);
        $teletravailActuel = $formateur->setSessionTeletravail($currentId);
        $infosFormateur = $formateur->getInformations();
        $infosFormation = $formateur->getAll('Formation');
        $infosAutres = $formateur->getBy(['id_autre', 'date_debut_autre', 'date_fin_autre', 'lettre'], 'Date_autre', ['id_formateur'], [$currentId]);

        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            header('Content-type: application/json');
            echo json_encode($infosFormation);
            exit;
        } else {
            $this->render('admin/modifierFormateur', compact('infosCurrent', 'infosFormation', 'infosFormateur', 'infosInterventions', 'infosMNSP', 'infosPerfectionnement','infosVacances','teletravailActuel','infosAutres'), 'formateurs');
        };
    }

    // Afficher l'activité des formateurs selectionnés sur une période de dates données 
    public function activiteFormateurs()
    {
        if (!isset($_SESSION['admin'])) {
            header('Location: /planning/public/');
            exit;
        }

        // variable $html avant recherche
        $html = "<div style='height: 80vh; display:flex; align-items:center; justify-content:center;'> <h1 style='width:60%;text-align:center;'>Veuillez séléctionner une période de dates ainsi que des formateurs afin de consulter leur période d'activités.</h1> </div>";
        $FormateurModel = new FormateurModel;

        if (Form::validate($_POST, ['valider', 'formateurs'])) {
            // Récupérer les dates saisies par l'utilisateur
            $date_debut_calendrier = $_POST['date_debut'];
            $date_fin_calendrier = $_POST['date_fin'];
            // Si aucun formateur n'est selectionné, demande à l'utilisateur d'en selectionner au moins 1
            if (is_null($_POST['formateurs'])) {
                echo "Veuillez choisir au moins un formateur";
                exit;
            } else {
                $_POST['formateurs'] === $_POST['nbFormateurs'] ? $id_formateur = "Aucun" : $id_formateur = $_POST['formateurs'];
            }
            // $id_formateur = $_POST['formateur'];
            // Construire une chaîne de caractères contenant les ID sous forme de liste

            //recupere les date de vacances pour chaque formateur et les place dans un tableau
            $formateurs = $FormateurModel->getDatesById(
                ['Formateur.id_formateur', 'nom_formateur', 'prenom_formateur'],
                ['date_debut_vacances', 'date_fin_vacances', 'validation'],
                'Formateur',
                ['Date_vacance', 'Date_vacance', 'Date_vacance'],
                ['Date_vacance'],
                ['Formateur'],
                ['id_formateur'],
                'id_formateur',
                $id_formateur
            );
            foreach ($formateurs as $formateur) {

                $date_debut_vacences = $formateur['date_debut_vacances'];
                $date_debut_vacences_array = explode(",", $date_debut_vacences);

                $date_fin_vacences = $formateur['date_fin_vacances'];
                $date_fin_vacences_array = explode(",", $date_fin_vacences);

                $validation = $formateur['validation'];
                $validation_array = explode(",", $validation);

                $dates_vacences_formateurs = array();
                $nbVacs = count($date_debut_vacences_array);
                for ($i = 0; $i < $nbVacs; $i++) {
                    $dates_vacences_formateur[] = [
                        "id_formateur" => $formateur['id_formateur'],
                        "debut_vacences" => $date_debut_vacences_array[$i],
                        "fin_vacences" => $date_fin_vacences_array[$i],
                        "validation_vacences" => !empty($validation_array[$i]) ? $validation_array[$i] : 0
                    ];
                }

                $dates_vacences_formateurs[] = $dates_vacences_formateur;
            }

            //recupere les date de MNSP pour chaque formateur et les place dans un tableau
            $formateurs = $FormateurModel->getDatesById(
                ['Formateur.id_formateur', 'nom_formateur', 'prenom_formateur'],
                ['date_debut_MNSP', 'date_fin_MNSP'],
                'Formateur',
                ['Date_MNSP', 'Date_MNSP'],
                ['Date_MNSP'],
                ['Formateur'],
                ['id_formateur'],
                'id_formateur',
                $id_formateur
            );
            foreach ($formateurs as $formateur) {
                $date_debut_MNSP = $formateur['date_debut_MNSP'];
                $date_debut_MNSP_array = explode(",", $date_debut_MNSP);

                $date_fin_MNSP = $formateur['date_fin_MNSP'];
                $date_fin_MNSP_array = explode(",", $date_fin_MNSP);

                $dates_MNSP_formateurs = array();
                $nbMNSP = count($date_debut_MNSP_array);
                for ($i = 0; $i < $nbMNSP; $i++) {
                    $dates_MNSP_formateur[] = [
                        "id_formateur" => $formateur['id_formateur'],
                        "debut_MNSP" => $date_debut_MNSP_array[$i],
                        "fin_MNSP" => $date_fin_MNSP_array[$i],
                    ];
                }

                $dates_MNSP_formateurs[] = $dates_MNSP_formateur;
            }

            //recupere les date de perfectionnement pour chaque formateur et les place dans un tableau
            $formateurs = $FormateurModel->getDatesById(
                ['Formateur.id_formateur', 'nom_formateur', 'prenom_formateur'],
                ['date_debut_perfectionnement', 'date_fin_perfectionnement'],
                'Formateur',
                ['Date_perfectionnement', 'Date_perfectionnement'],
                ['Date_perfectionnement'],
                ['Formateur'],
                ['id_formateur'],
                'id_formateur',
                $id_formateur
            );
            foreach ($formateurs as $formateur) {
                $date_debut_perfectionnement = $formateur['date_debut_perfectionnement'];
                $date_debut_perfectionnement_array = explode(",", $date_debut_perfectionnement);

                $date_fin_perfectionnement = $formateur['date_fin_perfectionnement'];
                $date_fin_perfectionnement_array = explode(",", $date_fin_perfectionnement);

                $dates_perfectionnement_formateurs = array();
                $nbPerfs = count($date_debut_perfectionnement_array);
                for ($i = 0; $i < $nbPerfs; $i++) {
                    $dates_perfectionnement_formateur[] = [
                        "id_formateur" => $formateur['id_formateur'],
                        "debut_perfectionnement" => $date_debut_perfectionnement_array[$i],
                        "fin_perfectionnement" => $date_fin_perfectionnement_array[$i]
                    ];
                }

                $dates_perfectionnement_formateurs[] = $dates_perfectionnement_formateur;
            }

            // Récupérer les dates de télétravail pour chaque formateurs et les place dans un tableau
            $formateurs = $FormateurModel->joinInformations(
                ['Formateur.id_formateur', 'nom_formateur', 'prenom_formateur', 'jour_teletravail', 'date_prise_effet', 'validation'],
                'Formateur',
                ['Date_teletravail'],
                ['id_formateur'],
                ['Formateur.id_formateur'],
                $id_formateur
            );
            foreach ($formateurs as $formateur) {
                $teletravail_formateurs = [
                    "jours" => $formateur->jour_teletravail,
                    "prise_effet" => $formateur->date_prise_effet,
                    "validation" => !empty($formateur->validation) ? $formateur->validation : 0,
                    "id_formateur" => $formateur->id_formateur
                ];

                $dates_teletravail_formateurs[] = $teletravail_formateurs;
            }

            if (count($formateurs) < 1) {
                $teletravail_formateurs = [
                    "jours" => "Rien",
                    "prise_effet" => "Rien",
                    "validation" => "Rien",
                    "id_formateur" => "Rien"
                ];

                $dates_teletravail_formateurs[] = $teletravail_formateurs;
            }

            // Récupérer les dates d'interventions pour chaque formateurs et les place dans un tableau
            $formateurs = $FormateurModel->getDatesById(
                ['Formateur.id_formateur', 'Formateur.nom_formateur', 'Formateur.prenom_formateur', 'type_contrat_formateur', 'Formateur.date_debut_contrat', 'Formateur.date_fin_contrat'],
                ['date_debut_intervention', 'date_fin_intervention', 'id_formation'],
                'Formateur',
                ['Date_intervention', 'Date_intervention', 'Date_intervention'],
                ['Date_intervention'],
                ['Formateur'],
                ['id_formateur'],
                'id_formateur',
                $id_formateur
            );

            foreach ($formateurs as $formateur) {
                $date_debut_activite = $formateur['date_debut_intervention'];
                $date_debut_array = explode(",", $date_debut_activite);
                $date_fin_activite = $formateur['date_fin_intervention'];
                $date_fin_array = explode(",", $date_fin_activite);



                $dates_interventions_formateurs = array();

                $nbInter = count($date_debut_array);
                for ($i = 0; $i < $nbInter; $i++) {
                    $dates_formateur[] = [
                        "id_formateur" => $formateur['id_formateur'],
                        "debut" => $date_debut_array[$i],
                        "fin" => $date_fin_array[$i],
                        "fin_contrat" => $formateur['date_fin_contrat'],
                        "type_contrat" => $formateur['type_contrat_formateur']

                    ];
                }

                $dates_interventions_formateurs[] = $dates_formateur;
            }
            // création d'un objet DateTime avec la date de début entrée
            $date_debut_tableau = new DateTime($_POST['date_debut'], new \DateTimeZone('Europe/Paris'));
            // création d'un objet DateTime avec la date de fin entrée
            $date_fin_tableau = new DateTime(($_POST['date_fin']));

            // Calcul du nombre de jours séparant les 2 dates, + 1 pour ajouter le jour actuel à la différence.
            $nbJours = $date_fin_tableau->diff($date_debut_tableau)->days + 1;

            // Tableau contenant les mois de 31 et 30 jours en nombre
            $mois31 = array('1', '3', '5', '7', '8', '10', '12');
            $mois30 = array('4', '6', '9', '11');

            // Tableau contenant le nom des jours de la semaine en anglais et leur numéro
            $joursSemaine = [
                "lundi" => "1",
                "mardi" => "2",
                "mercredi" => "3",
                "jeudi" => "4",
                "vendredi" => "5",
            ];

            // Clonage des dates de début et fin afin de savoir si l'année est bisextile ou non
            $current_date_year = clone $date_debut_tableau;
            $last_date_year = clone $date_fin_tableau;
            $yearDebut = $current_date_year->format('L');
            $yearFin = $last_date_year->format('L');

            // Clonages des dates de début afin de s'en servir pour l'itération des boucles consitutant les lignes du tableau
            $current_date_year = clone $date_debut_tableau;
            $current_date_month = clone $date_debut_tableau;
            $current_date_dayName = clone $date_debut_tableau;
            $current_date_day = clone $date_debut_tableau;
            $current_date_dayForYears = clone $date_debut_tableau;
            $current_date_dayForMonths = clone $date_debut_tableau;

            // Tableau contenant les jours fériées franças fixes
            $joursFeries = array('01-01', '05-01', '05-08', '07-14', '08-15', '11-01', '11-11', '12-25');

            // Compteur utilisés pour arrêter différentes boucles dans certaines situations
            $count = 0;
            $countFormateurs = count($formateurs);

            // Si aucune date relevées, alors le compteur est à 0
            if (!isset($dates_interventions_formateurs[0])) {
                $countDates = 0;
            } else {
                $countDates = count($dates_interventions_formateurs[0]);
            }

            if (!isset($dates_MNSP_formateurs[0])) {
                $countDatesMNSP = 0;
            } else {
                $countDatesMNSP = count($dates_MNSP_formateurs[0]);
            }

            if (!isset($dates_perfectionnement_formateurs[0])) {
                $countDatesPerf = 0;
            } else {
                $countDatesPerf = count($dates_perfectionnement_formateurs[0]);
            }

            if (!isset($dates_vacences_formateurs[0])) {
                $countDatesVacences = 0;
            } else {
                $countDatesVacences = count($dates_vacences_formateurs[0]);
            }


            // Ouverture du tableau
            $html = "
                        <div class='main-container'> 
                            <div class='tableau-container myTable'> 
                                <table> 
                                    <thead> 
                                        <tr>
                                            <th rowspan = 4>Afpa</th>";

            for ($i = 0; $i < $nbJours; $i++) {
                $annee = $current_date_year->format('Y');
                $dernierJour = $current_date_dayForYears->format('m-d');

                // Si l'une des 2 années des dates renseignées est bisextile, alors passe dans cette boucle.
                if ($yearDebut || $yearFin) {
                    $count++;
                    // Le nombre d'itérations est égal à 366 ou le jour actuel de la boucle est le 31 décembre 
                    if ($count == 366 || ($i + 1) == $nbJours || $dernierJour === "12-31") {
                        // Créé une ligne de taille équivalente au compteur.
                        $html .= "<th class='sticky-container' colspan='$count'> <span>" . $annee . "</span> </th> ";

                        $count = 0;
                    }
                } else {
                    $count++;
                    // Le nombre d'itérations est égal à 365 ou le jour actuel de la boucle est le 31 décembre 
                    if ($count == 365 || ($i + 1) == $nbJours || $dernierJour === "12-31") {
                        // Créé une ligne de taille équivalente au compteur.
                        $html .= "<th class='sticky-container' colspan='$count'> <span>" . $annee . "</span> </th> ";

                        $count = 0;
                    }
                }

                $current_date_year->modify("+1 day");
                $current_date_dayForYears->modify("+1 day");
            }

            $html .= "</tr> <tr>";
            for ($i = 0; $i < $nbJours; $i++) {
                $mois = $current_date_month->format('n');
                $numeroJour = $current_date_dayForMonths->format('j');

                // Si le mois actuel matche avec l'un des mois présent dans le tableau $mois31
                if (in_array($mois, $mois31)) {
                    // Compteur du nombre d'iterations
                    $count++;
                    // Lorsque $numeroJour atteins 31 ou bien que la prochaine boucle sera la dernière
                    if ($numeroJour === "31" || ($i + 1) == $nbJours) {
                        // Le mois est égal à l'un de ces chiffre, 
                        // sa valeur est changée par le nom du mois correspondant et est inscrite dans le tableau
                        // La largeur de la case dépend du nombre d'itérations
                        switch ($mois) {
                            case 1: {
                                    $mois = "Janvier";
                                    break;
                                }
                            case 3: {
                                    $mois = "Mars";
                                    break;
                                }
                            case 5: {
                                    $mois = "Mai";
                                    break;
                                }
                            case 7: {
                                    $mois = "Juillet";
                                    break;
                                }
                            case 8: {
                                    $mois = "Août";
                                    break;
                                }
                            case 10: {
                                    $mois = "Octobre";
                                    break;
                                }
                            case 12: {
                                    $mois = "Décembre";
                                    break;
                                }
                        }

                        $html .= "<th class='sticky-container' colspan='$count'> <span>" . $mois . "<span> </th> ";
                        // Le jour est remis au bon format
                        // Le compteur est remis à 0
                        $count = 0;
                    }
                }
                // Si le mois actuel matche avec l'un des mois présent dans le tableau $mois30
                if (in_array($mois, $mois30)) {
                    // Compteur du nombre d'iterations
                    $count++;
                    // Lorsque $numeroJour atteins 30 ou bien que la prochaine boucle sera la dernière
                    if ($numeroJour === "30" || ($i + 1) == $nbJours) {
                        // Le mois est égal à l'un de ces chiffre, 
                        // sa valeur est changée par le nom du mois correspondant et est inscrite dans le tableau
                        // La largeur de la case dépend du nombre d'itérations
                        switch ($mois) {
                            case 4: {
                                    $mois = "Avril";
                                    break;
                                }
                            case 6: {
                                    $mois = "Juin";
                                    break;
                                }
                            case 9: {
                                    $mois = "Septembre";
                                    break;
                                }
                            case 11: {
                                    $mois = "Novembre";
                                    break;
                                }
                        }
                        $html .= "<th class='sticky-container' colspan='$count'> <span>" . $mois . "</span> </th> ";
                        // Le jour est remis au bon format
                        $numeroJour = $current_date_dayForMonths->format('j');
                        // Le compteur est remis à 0
                        $count = 0;
                    }
                }

                // Si le mois actuel est égal à 2
                if ($mois === "2") {
                    // Compteur du nombre d'iterations
                    $count++;
                    // S'il s'agit d'une année bisextile
                    if ($yearDebut || $yearFin) {
                        // Lorsque $numeroJour atteins 29 ou bien que la prochaine boucle sera la dernière
                        if ($numeroJour == 29 || ($i + 1) == $nbJours) {
                            // Le mois est égal à Février
                            // La largeur de la case dépend du nombre d'itérations
                            $mois = "Février";
                            $html .= "<th class='sticky-container' colspan='$count'><span>" . $mois . "</span> </th> ";

                            $numeroJour = $current_date_dayForMonths->format('j');
                            $count = 0;
                        }
                    } else {
                        // Lorsque $numeroJour atteins 28 ou bien que la prochaine boucle sera la dernière
                        if ($numeroJour == 28 || ($i + 1) == $nbJours) {
                            // Le mois est égal à Février
                            // La largeur de la case dépend du nombre d'itérations
                            $mois = "Février";
                            $html .= "<th class='sticky-container' colspan='$count'> <span>" . $mois . "</span> </th> ";

                            // Le jour est remis au bon format
                            $numeroJour = $current_date_dayForMonths->format('j');
                            // Le compteur est remis à 0
                            $count = 0;
                        }
                    }
                }
                $current_date_month->modify("+1 day");
                $current_date_dayForMonths->modify("+1 day");
            }

            $html .= "</tr> <tr> ";
            for ($i = 0; $i < $nbJours; $i++) {
                // Pour chaque jour, une case est créée. 
                $jourNom = $current_date_dayName->format('N');
                // Le jour est égal à l'un de ces chiffre, 
                // sa valeur est changée par le nom du jour correspondant et est inscrite dans le tableau
                switch ($jourNom) {
                    case 1: {
                            $jourNom = "L";
                            break;
                        }
                    case 2: {
                            $jourNom = "M";
                            break;
                        }
                    case 3: {
                            $jourNom = "M";
                            break;
                        }
                    case 4: {
                            $jourNom = "J";
                            break;
                        }
                    case 5: {
                            $jourNom = "V";
                            break;
                        }
                    case 6: {
                            $jourNom = "S";
                            break;
                        }
                    case 7: {
                            $jourNom = "D";
                            break;
                        }
                }
                $current_date_dayName->modify("+1 day");
                $html .= "<th>" . $jourNom . "</th> ";
            }

            $html .= '</tr> <tr> ';
            for ($i = 0; $i < $nbJours; $i++) {
                // Pour chaque jour, une case contenant le nombre du jour dans le mois est créée.
                $jour = $current_date_day->format('j');
                $current_date_day->modify("+1 day");
                $html .= "<th>" . $jour . "</th> ";
            }
            $html .= "</tr> <tbody> ";

            // Création de tableaux vides pour stocker les périodes de chaque formateur
            $formateur_periodes = array();
            $formateur_vacance = array();
            $formateur_MNSP = array();
            $formateur_perfectionnement = array();
            // Boucle pour parcourir tous les formateurs
            for ($z = 0; $z < $countFormateurs; $z++) {
                // Clonage de la date de début du tableau pour éviter de modifier l'objet original
                $current_date_dayForFormateurs = clone $date_debut_tableau;

                // on verifie que le formateur a bien un contrat apres le date de saisir 
                if (!($formateurs[$z]['date_fin_contrat'] < $_POST['date_debut'] && $formateurs[$z]['type_contrat_formateur'] != "CDI")) {


                    // Ajout du nom et prénom du formateur dans la première colonne du tableau
                    $html .= "<tr class='linge-formateur'>
                                 <th class='sticky-formateur-container'>
                                    <div class='nomFormateurDiv'>
                                        <span>" . $formateurs[$z]['nom_formateur'] . ' ' . $formateurs[$z]['prenom_formateur'] . "</span>
                                    </div>
                                </th> ";

                    // Création d'un tableau vide pour stocker les périodes du formateur en cours
                    $formateur_periodes[$formateurs[$z]['id_formateur']] = array();
                    $formateur_vacance[$formateurs[$z]['id_formateur']] = array();
                    $formateur_MNSP[$formateurs[$z]['id_formateur']] = array();
                    $formateur_perfectionnement[$formateurs[$z]['id_formateur']] = array();

                    // Boucle pour parcourir tous les jours du tableau
                    for ($i = 0; $i < $nbJours; $i++) {

                        // Boucle pour parcourir toutes les dates d'intervention pour trouver les périodes du formateur en cours
                        for ($j = 0; $j < $countDates; $j++) {

                            // Stockage de la période dans le tableau des périodes du formateur en cours
                            if ($dates_interventions_formateurs[0][$j]['id_formateur'] == $formateurs[$z]['id_formateur']) {
                                $formateur_periodes[$formateurs[$z]['id_formateur']][] = array(
                                    'debut' => $dates_interventions_formateurs[0][$j]['debut'],
                                    'fin' => $dates_interventions_formateurs[0][$j]['fin']
                                );
                            }
                        }
                        // Boucle pour parcourir toutes les dates de vacance pour trouver les vacance du formateur en cours
                        for ($v = 0; $v < $countDatesVacences; $v++) {

                            // Stockage de la période dans le tableau des périodes du formateur en cours
                            if ($dates_vacences_formateurs[0][$v]['id_formateur'] == $formateurs[$z]['id_formateur']) {
                                $formateur_vacance[$formateurs[$z]['id_formateur']][] = array(
                                    'debut_vacances' => $dates_vacences_formateurs[0][$v]['debut_vacences'],
                                    'fin_vacances' => $dates_vacences_formateurs[0][$v]['fin_vacences'],
                                    'validation' => $dates_vacences_formateurs[0][$v]['validation_vacences']
                                );
                            }
                        }

                        for ($w = 0; $w < $countDatesMNSP; $w++) {
                            if ($dates_MNSP_formateurs[0][$w]['id_formateur'] == $formateurs[$z]['id_formateur']) {
                                $formateur_MNSP[$formateurs[$z]['id_formateur']][] = array(
                                    'debut_MNSP' => $dates_MNSP_formateurs[0][$w]['debut_MNSP'],
                                    'fin_MNSP' => $dates_MNSP_formateurs[0][$w]['fin_MNSP'],
                                );
                            }
                        }

                        for ($y = 0; $y < $countDatesPerf; $y++) {
                            if ($dates_perfectionnement_formateurs[0][$y]['id_formateur'] == $formateurs[$z]['id_formateur']) {
                                $formateur_perfectionnement[$formateurs[$z]['id_formateur']][] = array(
                                    'debut_perfectionnement' => $dates_perfectionnement_formateurs[0][$y]['debut_perfectionnement'],
                                    'fin_perfectionnement' => $dates_perfectionnement_formateurs[0][$y]['fin_perfectionnement'],
                                );
                            }
                        }

                        // Récupération de la période courante
                        $periodeJourFeries = $current_date_dayForFormateurs->format('m-d');
                        $jourLettre = $current_date_dayForFormateurs->format('N');
                        $periode = $current_date_dayForFormateurs->format('Y-m-d');

                        // Vérification si le formateur a une période pour le jour en cours
                        $formateurAvoirPeriode = false;
                        foreach ($formateur_periodes[$formateurs[$z]['id_formateur']] as $periodeFormateur) {
                            if ($periode >= $periodeFormateur['debut'] && $periode <= $periodeFormateur['fin']) {
                                $formateurAvoirPeriode = true;
                                break;
                            }
                        }

                        // Vérification si le formateur a des vacances pour le jour en cours et si elles sont validées ou en attente
                        $formateurAvoirVacances = 0;
                        foreach ($formateur_vacance[$formateurs[$z]['id_formateur']] as $periode_vacances) {
                            if ($periode >= $periode_vacances['debut_vacances'] && $periode <= $periode_vacances['fin_vacances']) {
                                $formateurAvoirVacances = 1;
                                if ($periode_vacances['validation'] === "1") {
                                    $formateurAvoirVacances = 2;
                                }
                                break;
                            }
                        }

                        $formateurAvoirTeletravail = 0;
                            foreach ($dates_teletravail_formateurs as $periode_teletravail) {
                                if ($periode_teletravail['id_formateur'] === $formateurs[$z]['id_formateur'] && $periode_teletravail['validation'] == 1) {
                                    if ($periode_teletravail['prise_effet'] <= $periode) {
                                        $jours_array = explode(',', $periode_teletravail['jours']);
                                        foreach ($jours_array as $jour) {
                                            if ($jourLettre === $joursSemaine[$jour]) {
                                                $formateurAvoirTeletravail = 1;
                                                break;
                                            }
                                        }
                                    }
                                }
                            }

                        $formateurAvoirMNSP = false;
                        foreach ($formateur_MNSP[$formateurs[$z]['id_formateur']] as $MNSPFormateur) {
                            if ($periode >= $MNSPFormateur['debut_MNSP'] && $periode <= $MNSPFormateur['fin_MNSP']) {
                                $formateurAvoirMNSP = true;
                                break;
                            }
                        }

                        $formateurAvoirPerfectionnement = false;
                        foreach ($formateur_perfectionnement[$formateurs[$z]['id_formateur']] as $perfectionnementFormateur) {
                            if ($periode >= $perfectionnementFormateur['debut_perfectionnement'] && $periode <= $perfectionnementFormateur['fin_perfectionnement']) {
                                $formateurAvoirPerfectionnement = true;
                                break;
                            }
                        }

                        // Ajout de la case avec la couleur correspondante en fonction de la présence ou non d'une période de vacances pour le formateur
                        if ($formateurAvoirVacances !== 0) {
                            if ($formateurAvoirVacances == 2) {
                                $html .= "<td style='background-color: " . $_SESSION['color']['couleur_vacance_validee'] . " ;'></td>";
                            } else if ($formateurAvoirVacances == 1) {
                                $html .= "<td style='background-color: " . $_SESSION['color']['couleur_vacance_demandees'] . " ;'></td> ";
                            }
                        } else {
                            // Ajout de la case avec la couleur correspondante en fonction de la présence ou non d'une période d'intervention pour le formateur
                            if ($formateurAvoirPeriode) {
                                // Si la date actuelle est un jour férié
                                if (
                                    in_array($periodeJourFeries, $joursFeries)
                                    || in_array($periode, AlgorithmePaques::calculatePaques($current_date_year->format('Y')))
                                    || in_array($periode, AlgorithmePaques::calculatePaques($last_date_year->format('Y')))
                                ) {
                                    $html .= "<td style='background-color: " . $_SESSION['color']['couleur_ferie'] . " ;'></td> ";
                                } else {
                                    // Si le jour de la semaine est égal à 6 ou 7
                                    if ($jourLettre === "6" || $jourLettre === "7") {
                                        $html .= "<td style='background-color: " . $_SESSION['color']['couleur_weekend'] . " ;'></td> ";
                                    } else {
                                        if ($formateurAvoirTeletravail) {
                                            $html .= "<td style='background-color: " . $_SESSION['color']['couleur_centre'] . " ; box-shadow: inset 0 0 16px 2px #527cdd; background-color: #0c39a1;'> T </td> ";
                                        } else {
                                            $html .= "<td style='background-color: " . $_SESSION['color']['couleur_centre'] . " ;'></td> ";
                                        }
                                    }
                                }
                            } else {
                                if (
                                    // Si la date actuelle est un jour férié
                                    in_array($periodeJourFeries, $joursFeries)
                                    || in_array($periode, AlgorithmePaques::calculatePaques($current_date_year->format('Y')))
                                    || in_array($periode, AlgorithmePaques::calculatePaques($last_date_year->format('Y')))
                                ) {
                                    $html .= "<td style='background-color: " . $_SESSION['color']['couleur_ferie'] . " ;'></td> ";
                                } else {
                                    // Si le jour de la semaine est égal à 6 ou 7
                                    if ($jourLettre === "6" || $jourLettre === "7") {
                                        $html .= "<td style='background-color: " . $_SESSION['color']['couleur_weekend'] . " ;'></td> ";
                                    } else {
                                        if ($formateurAvoirMNSP) {
                                            $html .= "<td style='background-color: " . $_SESSION['color']['couleur_MNSP'] . " ;'></td> ";
                                        } else if ($formateurAvoirPerfectionnement) {
                                            $html .= "<td style='background-color: " . $_SESSION['color']['couleur_perfectionment'] . " ;'></td> ";
                                        } else {
                                            $html .= "<td style='background-color: var(--emptyCell);'></td> ";
                                        }
                                    }
                                }
                            }
                        }
                        // Incrémentation de la date pour passer au jour suivant
                        $current_date_dayForFormateurs->modify("+1 day");
                    }
                    // Fermeture de la ligne correspondant au formateur en cours
                    $html .= "</tr>";
                }
            }
            // Fermeture de la table
            $html .= "</tbody> </table> </div> </div>";
        }
        $infosFormateur = $FormateurModel->getFormateur();
        isset($_POST['valider']) ? $data = $_POST : $data = "";
        $this->render('admin/activiteFormateur', compact('infosFormateur', 'html', 'data'), 'activite');
    }
    
}
