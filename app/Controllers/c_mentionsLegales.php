<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class c_mentionsLegales extends BaseController
{
    public function index(){
        $data = [
            'title' => "Mentions Legales",
            'titre' => "Mentions Légales",
        ];
        return view('mentionsLegales_view', $data);
    }
}