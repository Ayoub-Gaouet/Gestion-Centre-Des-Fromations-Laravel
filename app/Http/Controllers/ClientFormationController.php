<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Formation;
use Illuminate\Http\Request;

class ClientFormationController extends Controller

{
    public function index()
    {
        $clients = Client::all();
        $formations = Formation::all();
        return view("client_formation.formation", compact('formations','clients'));
    }

}
