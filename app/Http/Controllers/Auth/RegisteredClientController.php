<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Formation;
use App\Models\Inscription;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredClientController extends Controller
{
    /**
     * Display the login view.
     *
     * @return View
     */
    public function create(Formation $formation)
    {

        return view('auth.register-client', compact('formation'));
    }

    public function store(Request $request, Formation $formation)
    {
        $request->validate([
            'name' => ['max:255', 'required', 'string'],
            'date_de_naissance' => ['required', 'date'],
            'genre' => ['max:255', 'required', 'string'],
            'tel' => ['max:255', 'required', 'string'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:clients'],
        ]);


        // Vérifie si la formation est terminée avant d'autoriser l'inscription
        if ($formation->is_terminated) {
            return redirect()->back()->withErrors(['La formation est terminée.']);
        }
        // Vérifie si le nombre de places dans la formation est complet avant d'autoriser l'inscription
        $inscriptionCount = Inscription::where('formation_id', $formation->id)->count();
        if ($inscriptionCount >= $formation->max_places) {
            return redirect()->back()->withErrors(['Le nombre de places dans la formation est complet.']);
        }

        $user = Client::firstOrCreate([
            'name' => $request->name,
            'date_de_naissance' => $request->date_de_naissance,
            'genre' => $request->genre,
            'tel' => $request->tel,
            'email' => $request->email,
            'password' => Hash::make("123456789"),
        ]);

        $inscription = Inscription::create([
            'date_inscription' => Carbon::now(),
            'montant' => $request->montant,
            'etat' => "1",
            'commentaire' => $request->commentaire,
            'client_id' => $user->id,
            'formation_id' => $formation->id,
        ]);
        return redirect()->back();
    }

}
