<?php
namespace App\Controllers;

class AdminController extends Controller{

    public function index(){
        if($this->isAdmin){
            $this->render()
        }
    }

    private function isAdmin(){

        if(isset($_SESSION['user']) && $_SESSION['user']['permissions'] >= 1){
            
        }
    }
}