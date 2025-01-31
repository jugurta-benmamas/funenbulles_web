<?php

namespace App\Controllers;

class c_pratique extends BaseController
{

    public function index()
    {

        $data = [
            'title' => "Infos Pratiques",
        ];
        return view('pratique_view', $data);
    }
}