<?php

namespace App\Controllers;

use App\Models\m_auteurs;

class c_auteurs extends BaseController
{

    public function index(){

        $model = new m_auteurs();
        $data = [
            'title' => "Les auteur(e)s",
            'titre' => "Ils seront parmis nous cette année : ",
            'auteurs' => $model->recupAuteurs(2025)
        ];
        return view('auteurs_view', $data);
    }

}