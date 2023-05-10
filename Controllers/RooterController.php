<?php

namespace App\Controllers;

use App\Core\Form;
use App\Models\FormateurModel;
use App\Models\FormationModel;
use DateTime;

class RooterController extends Controller{

    public function index(){

        if(Form::validate($_POST, ['rechercher'])){

            $formation = new FormationModel;
            $formateur = new FormateurModel;

            $_POST['lieu'] !== "default" ? $centre = $_POST['lieu'] : $centre = "Aucun" ;
            foreach($_POST['grns'] as $grns){
                $grns !== "default" ? $grn = $grns : $grn = "Aucun" ;
            }

            if(is_null($_POST['formateurs'])){
                echo "Veuillez choisir au moins un formateur";
                exit;
            }else{
                $_POST['formateurs'] === $_POST['nbFormateurs'] ? $formateursSelectionnes = "Aucun" : $formateursSelectionnes = $_POST['formateurs'] ;
            }


            $formations = $formation->getByIn(['*'],'formation', ['numero_grn', 'id_formateur', 'id_ville'],[$grn, $_POST['formateurs'], $centre]);

            $nbformation = count($formations);
            for($i = 0 ;$i < $nbformation ; $i++){

            }

            $formateurs = $formateur->getInterventionById($formateursSelectionnes);
            foreach ($formateurs as $formateur) {
                $date_debut_activite = $formateur['date_debut'];
                $date_debut_array = explode(",", $date_debut_activite);
                // var_dump($date_debut_array);
                $date_fin_activite = $formateur['date_fin'];
                $date_fin_array = explode(",", $date_fin_activite);

                $dates_interventions_formateurs = array();

                $test = count($date_debut_array);
                for ($i = 0; $i < $test; $i++) {
                    $dates_formateur[] = [
                        "id_formateur" => $formateur['id_formateur'],
                        "debut" => $date_debut_array[$i],
                        "fin" => $date_fin_array[$i]
                    ];
                }

                $dates_interventions_formateurs[] = $dates_formateur;
            }

            $date_debut_tableau = new DateTime($_POST['date_debut']);
            $date_fin_tableau = new DateTime($_POST['date_fin']);

            $nbJours = $date_fin_tableau->diff($date_debut_tableau)->days + 1;


            $mois31 = array('1', '3', '5', '7', '8', '10', '12');
            $mois30 = array('4', '6', '9', '11');

            $current_date_year = clone $date_debut_tableau;
            $last_date_year = clone $date_fin_tableau;
            $yearDebut = $current_date_year->format('L');
            $yearFin = $last_date_year->format('L');

            $current_date_year = clone $date_debut_tableau;
            $current_date_month = clone $date_debut_tableau;
            $current_date_dayName = clone $date_debut_tableau;
            $current_date_day = clone $date_debut_tableau;
            $current_date_dayForYears = clone $date_debut_tableau;
            $current_date_dayForMonths = clone $date_debut_tableau;

            $count = 0;
            $countFormateurs = count($formateurs);
            $countDates = count($dates_interventions_formateurs[0]);

            $html = "<div class='main-container'> <div class='tableau-container'> <table> <thead> <tr> <th rowspan = 4>Afpa</th>";
            for ($i = 0; $i < $nbJours; $i++) {
                $annee = $current_date_year->format('Y');
                $dernierJour = $current_date_dayForYears->format('m-d');

                if($yearDebut || $yearFin){
                    $count++;
                    if($count == 366 || ($i + 1) == $nbJours || $dernierJour === "12-31"){
                        $html .= "<th colspan='$count'>" . $annee . "</th> ";

                        $count = 0;
                    }
                }else{
                    $count++;
                    if($count == 365 || ($i + 1) == $nbJours || $dernierJour === "12-31"){
                    $html .= "<th colspan='$count'>" . $annee . "</th> ";

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

                if (in_array($mois, $mois31)) {
                    $count++;
                    if ($numeroJour === "31" || ($i + 1) == $nbJours) {
                        switch ($mois) {
                            case 1: {
                                    $mois = "Janvier";
                                    $html .= "<th colspan='$count'>" . $mois . "</th> ";
                                    break;
                                }
                            case 3: {
                                    $mois = "Mars";
                                    $html .= "<th colspan='$count'>" . $mois . "</th> ";
                                    break;
                                }
                            case 5: {
                                    $mois = "Mai";
                                    $html .= "<th colspan='$count'>" . $mois . "</th> ";
                                    break;
                                }
                            case 7: {
                                    $mois = "Juillet";
                                    $html .= "<th colspan='$count'>" . $mois . "</th> ";
                                    break;
                                }
                            case 8: {
                                    $mois = "Août";
                                    $html .= "<th colspan='$count'>" . $mois . "</th> ";
                                    break;
                                }
                            case 10: {
                                    $mois = "Octobre";
                                    $html .= "<th colspan='$count'>" . $mois . "</th> ";
                                    break;
                                }
                            case 12: {
                                    $mois = "Décembre";
                                    $html .= "<th colspan='$count'>" . $mois . "</th> ";
                                    break;
                                }
                        }
                        $numeroJour = $current_date_dayForMonths->format('j');
                        $count = 0;
                    }
                }

                if(in_array($mois, $mois30)){
                    $count++;
                    if($numeroJour === "30" || ($i + 1) == $nbJours){
                        switch($mois){
                            case 4:{
                                $mois = "Avril";
                                $html .= "<th colspan='$count'>" . $mois . "</th> ";
                                break;
                            }
                            case 6:{
                                $mois = "Juin";
                                $html .= "<th colspan='$count'>" . $mois . "</th> ";
                                break;
                            }
                            case 9:{
                                $mois = "Septembre";
                                $html .= "<th colspan='$count'>" . $mois . "</th> ";
                                break;
                            }
                            case 11:{
                                $mois = "Novembre";
                                $html .= "<th colspan='$count'>" . $mois . "</th> ";
                                break;
                            }
                            
                        }
                        $numeroJour = $current_date_dayForMonths->format('j');
                        $count = 0;
                    }
                }

                if ($mois === "2") {
                    $count++;
                    if ($yearDebut || $yearFin) {
                        if ($numeroJour == 29 || ($i + 1) == $nbJours) {
                            $mois = "Février";
                            $html .= "<th colspan='$count'>" . $mois . "</th> ";

                            $numeroJour = $current_date_dayForMonths->format('j');
                            $count = 0;
                        }

                    } else {
                        if ($numeroJour == 28 || ($i + 1) == $nbJours) {
                            $mois = "Février";
                            $html .= "<th colspan='$count'>" . $mois . "</th> ";

                            $numeroJour = $current_date_dayForMonths->format('j');
                            $count = 0;
                        }
                    }
                }
                $current_date_month->modify("+1 day");
                $current_date_dayForMonths->modify("+1 day");
            }

            $html .= "</tr> <tr> ";
            for ($i = 0; $i < $nbJours; $i++) {
                $jourNom = $current_date_dayName->format('N');
                switch ($jourNom) {
                    case 1: {
                            $jourNom = "Lun";
                            break;
                        }
                    case 2: {
                            $jourNom = "Mar";
                            break;
                        }
                    case 3: {
                            $jourNom = "Mer";
                            break;
                        }
                    case 4: {
                            $jourNom = "Jeu";
                            break;
                        }
                    case 5: {
                            $jourNom = "Ven";
                            break;
                        }
                    case 6: {
                            $jourNom = "Sam";
                            break;
                        }
                    case 7: {
                            $jourNom = "Dim";
                            break;
                        }
                }
                $current_date_dayName->modify("+1 day");
                $html .= "<th>" . $jourNom . "</th> ";
            }

            $html .= '</tr> <tr> ';
            for ($i = 0; $i < $nbJours; $i++) {
                $jour = $current_date_day->format('j');
                $current_date_day->modify("+1 day");
                $html .= "<th>" . $jour . "</th> ";
            }
            $html .= "</tr> <tbody> <tr> ";

            // Création d'un tableau vide pour stocker les périodes de chaque formateur
            $formateur_periodes = array();

            // Boucle pour parcourir tous les formateurs
            for ($z = 0; $z < $countFormateurs; $z++) {

                // Clonage de la date de début du tableau pour éviter de modifier l'objet original
                $current_date_dayForFormateurs = clone $date_debut_tableau;
                $current_date_Weekends = clone $date_debut_tableau;

                // Ajout du nom et prénom du formateur dans la première colonne du tableau
                $html .= "<th>" . $formateurs[$z]['nom_formateur'] . ' ' . $formateurs[$z]['prenom_formateur'] . "</th> ";
                
                // Création d'un tableau vide pour stocker les périodes du formateur en cours
                $formateur_periodes[$formateurs[$z]['id_formateur']] = array();

                // Boucle pour parcourir tous les jours du tableau
                for ($i = 0; $i < $nbJours; $i++){
                    
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

                    // Récupération de la période courante
                    $periode = $current_date_dayForFormateurs->format('Y-m-d');
                    $weekend = $current_date_Weekends->format('N');

                    // Vérification si le formateur a une période pour le jour en cours
                    $trainer_has_period = false;
                    foreach ($formateur_periodes[$formateurs[$z]['id_formateur']] as $period) {
                        if ($periode >= $period['debut'] && $periode <= $period['fin']) {
                            $trainer_has_period = true;
                            break;
                        }
                    }

                    // Ajout de la case avec la couleur correspondante en fonction de la présence ou non d'une période pour le formateur
                    if ($trainer_has_period) {
                        if($weekend === "6" || $weekend === "7"){
                            $html .= "<th style='background-color: var(--weekendCell);'></th> ";
                        }
                        else{
                            $html .= "<th style='background-color: var(--greenCell);'></th> ";
                        }
                    } else {
                        if($weekend === "6" || $weekend === "7"){
                            $html .= "<th style='background-color: var(--weekendCell);'></th> ";
                        }
                        else{
                            $html .= "<th style='background-color: var(--emptyCell);'></th> ";
                        }
                    }
                    // Incrémentation de la date pour passer au jour suivant
                    $current_date_Weekends->modify("+1 day");
                    $current_date_dayForFormateurs->modify("+1 day");
                }
                // Fermeture de la ligne correspondant au formateur en cours
                $html .= "</tr>";
            }            
            $html .= "</tbody> </table> </div> </div>";


            echo $html;
        }











        $formation = new FormationModel;
        $formateur = new FormateurModel;
        $formateurs = $formateur->getFormateur();
        $GRNs = $formateur->getAll('GRN');
        $villes = $formation->getAll('ville');



        $this->render('main/index' ,compact('GRNs','formateurs','villes'), 'main');
    }
}