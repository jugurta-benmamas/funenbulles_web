<?php

namespace App\Controllers;

class c_Home extends BaseController
{
    public function index(): string
    {
        $data = [
            'title' => 'Accueil'
        ];

        return view('home_view', $data);
    }

    public function about()
    {
        $data = [
            'title' => 'À propos'
        ];

        return view('about_view', $data);
    }
}
