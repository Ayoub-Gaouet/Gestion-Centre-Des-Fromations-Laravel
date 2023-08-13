<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Formateur;
use App\Models\Formation;
use App\Models\Inscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */

    public function index()
    {
        $formation = Formation::query()->count();
        $formations = Formation::query()->withCount('inscriptions')->get();
        $formateur = Formateur::query()->count();
        $formateurs = Formateur::query()->get();

        $clientAvgAge = Client::query()->get()->avg(function ($client) {
            return Carbon::parse($client->date_de_naissance)->age;
        });

        $formateurAvgAge = Formateur::query()->get()->avg(function ($formateur) {
            return Carbon::parse($formateur->date_de_naissance)->age;
        });

        return view("admin.welcome")
            ->with('formation', $formation)
            ->with('formateur', $formateur)
            ->with('formations', $formations)
            ->with('formateurs', $formateurs)
            ->with('clientAvgAge', $clientAvgAge)
            ->with('formateurAvgAge', $formateurAvgAge);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
