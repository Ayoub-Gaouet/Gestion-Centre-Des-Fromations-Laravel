<?php

namespace App\Http\Controllers\Inscription;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Formation;
use App\Models\Inscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Mockery\Exception;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
class InscriptionController  extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $user = auth()->user();
            return Datatables::eloquent(Inscription::query()->with(["client", "formation"]))
                ->addIndexColumn()
                ->addColumn('action', function ($row) use ($user) {
                    $btn = "";
                    $btn .= '<a href="javascript:void(0)"  data-id="' . $row->id .  '"data-date_inscription ="' . $row->date_inscription  .
                        '"data-montant ="' . $row->montant  . '"data-etat ="' . $row->etat
                        . '"data-eval="' . $row->eval . '" data-dateEval="' . $row->date_eval . '" data-commentaire="' . $row->commentaire . '"
                         data-client="' . $row->client_id . '" data-formation="' . $row->formation_id .'"
                        class="edit btn tooltipped "  data-placement="right" title="Editer"  data-toggle="modal"
                   data-target="#updateModal">
                        <i class="fas fa-edit text-warning"></i> </a>';
                    $btn .= '<a href="javascript:void(0)"  data-id="' . $row->id . '"
                        class="delete_inscription btn tooltipped" data-placement="right" title="Delete" data-toggle="url" >
                        <i class="fas fa-trash text-danger"></i> </a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $clients = Client::all();
        $formations = Formation::all();
        return view("admin.inscriptions.inscriptions")->with(['clients' => $clients, 'formations' => $formations]);
    }

    public function store(Request $request)
    {
        $validation = Helper::validateRequest($request, [
            'date_inscription' => ['required', 'date'],
            'montant' => ['required', 'numeric'],
            /*'etat' => ['required', 'boolean'],
            'eval' => ['required', 'integer', 'min:1', 'max:10'],
            'date_eval' => ['required', 'date'],
            'commentaire' => ['required', 'string'],*/
            'client' => ['required', 'integer', Rule::exists('clients', 'id')],
            'formation' => ['required', 'integer', Rule::exists('formations', 'id')],
        ]);

        if ($validation != null) {
            Alert::error('Erreur', $validation);
            return redirect()->back();
        }

        DB::beginTransaction();
        try {
            $inscription = new Inscription();

            $inscription->date_inscription = $request->date_inscription;
            $inscription->montant = $request->montant;
            $inscription->etat = "1";
            $inscription->eval = $request->eval;
            $inscription->date_eval = $request->date_eval;
            $inscription->commentaire = $request->commentaire;
            $inscription->client_id = $request->client;
            $inscription->formation_id = $request->formation;
            $inscription->save();

            DB::commit();
            Alert::success('Success', "L'inscription a été ajoutée avec succès !")->persistent("ok");
            return redirect()->back();
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception);
            Alert::warning('Error', "L'inscription n'a pas pu être ajoutée !")->persistent("ok");
            return redirect()->back();
        }
    }
    public function update(Request $request, $id)
    {
        $validation = Helper::validateRequest($request, [
            'date_inscription' => ['required', 'date'],
            'montant' => ['required', 'numeric'],
            /*'etat' => ['required', 'boolean'],
            'eval' => ['required', 'integer', 'min:1', 'max:10'],
            'date_eval' => ['required', 'date'],
            'commentaire' => ['required', 'string'],*/
            'client' => ['required', 'integer', Rule::exists('clients', 'id')],
            'formation' => ['required', 'integer', Rule::exists('formations', 'id')],
        ]);

        if ($validation != null) {
            Alert::error('Erreur', $validation);
            return redirect()->back();
        }

        DB::beginTransaction();
        try {
            $inscription = Inscription::findOrFail($id);
            $inscription->date_inscription = $request->date_inscription;
            $inscription->montant = $request->montant;
            $inscription->etat = "1";
            $inscription->eval = $request->eval;
            $inscription->date_eval = $request->date_eval;
            $inscription->commentaire = $request->commentaire;
            $inscription->client_id = $request->client;
            $inscription->formation_id = $request->formation;
            $inscription->save();

            DB::commit();
            Alert::success('Success', "L'inscription a été mise à jour avec succès !")->persistent("ok");
            return redirect()->back();
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception);
            Alert::warning('Error', "La mise à jour de l'inscription a échoué !")->persistent("ok");
            return redirect()->back();
        }
    }


    public function destroy(Inscription $inscription)
    {
        DB::beginTransaction();
        try {
            $inscription->delete();
            DB::commit();
            Alert::success('Success', "La Formation a été supprimé avec succès !")->persistent("ok");
            return redirect()->back();
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception);
            Alert::warning('Error', "La Formation  n'a pas été supprimé !")->persistent("ok");
            return redirect()->back();
        }
    }

}
