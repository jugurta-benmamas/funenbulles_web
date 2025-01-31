<?php

namespace App\Controllers;


class c_contact extends BaseController
{

    public function index(){
        $data=[
            'title' => "Contact",
            'titre' => "Contactez-nous"
        ];
        return view('contact_view',$data);
    }
    public function valider()
    {
        $data=[
            'title' => "Validation",
            'titre' => "Merci pour votre message"
        ];
        return view('contact_succes_view',$data);
    }
}