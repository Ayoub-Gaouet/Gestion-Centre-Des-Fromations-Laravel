<?php

namespace App\Http\Controllers\Formation;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Formateur;
use App\Models\Formation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Mockery\Exception;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class FormationController  extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $user = auth()->user();
            return Datatables::eloquent(Formation::query()->with("formateur"))
                ->addIndexColumn()
                ->addColumn('action', function ($row) use ($user) {
                    $btn = "";
                    $btn .= '<a href="javascript:void(0)"  data-id="' . $row->id . '"  data-name="'
                        . $row->name . '" data-description="' . $row->description . '"data-date_debut ="' . $row->date_debut  .
                        '"data-date_fin ="' . $row->date_fin  . '"data-duree ="' . $row->duree
                        . '"data-lieu="' . $row->lieu . '" data-prix="' . $row->prix . '" data-is_terminated="' . $row->is_terminated . '"
                            data-max_places="' . $row->max_places . '"data-formateur="' . $row->formateur_id . '"
                            class="edit btn tooltipped "  data-placement="right" title="Editer"  data-toggle="modal"
                       data-target="#updateModal">
                            <i class="fas fa-edit text-warning"></i> </a>';
                    $btn .= '<a href="javascript:void(0)"  data-id="' . $row->id . '"
                            class="delete_formation btn tooltipped" data-placement="right" title="Delete" data-toggle="url" >
                            <i class="fas fa-trash text-danger"></i> </a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $formateurs = Formateur::all();
        return view("admin.formations.formations")->with('formateurs', $formateurs);
    }
    public function store(Request $request)
    {
        $validation = Helper::validateRequest($request, [
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
            'date_debut' => ['required', 'date'],
            'date_fin' => ['required', 'date'],
            'duree' => ['required', 'integer'],
            'lieu' => ['required', 'string'],
            'prix' => ['required', 'numeric'],
            'is_terminated' => ['required', 'boolean'],
            'max_places' => ['required', 'integer', 'min:1'],
            'formateur' => ['required', 'integer', Rule::exists('formateurs','id')],
        ]);

        if ($validation != null) {
            Alert::error('Erreur', $validation);
            return redirect()->back();
        }

        DB::beginTransaction();
        try {
            $formation = new Formation();
            $formation->name = $request->name;
            $formation->description = $request->description;
            $formation->date_debut = $request->date_debut;
            $formation->date_fin = $request->date_fin;
            $formation->duree = $request->duree;
            $formation->lieu = $request->lieu;
            $formation->prix = $request->prix;
            $formation->is_terminated = $request->is_terminated;
            $formation->max_places = $request->max_places;
            $formation->formateur_id = $request->formateur;
            $formation->save();

            DB::commit();
            Alert::success('Success', "La formation a été ajoutée avec succès !")->persistent("ok");
            return redirect()->back();
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception);
            Alert::warning('Error', "La formation n'a pas pu être ajoutée !")->persistent("ok");
            return redirect()->back();
        }
    }
    public function update(Request $request, $id)
    {
        $validation = Helper::validateRequest($request, [
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
            'date_debut' => ['required', 'date'],
            'date_fin' => ['required', 'date'],
            'duree' => ['required', 'integer', 'min:1'],
            'lieu' => ['required', 'string'],
            'prix' => ['required', 'numeric', 'min:0'],
            'is_terminated' => ['required', 'boolean'],
            'max_places' => ['required', 'integer', 'min:1'],
            'formateur' => ['required', 'integer', Rule::exists('formateurs','id')],
        ]);

        if ($validation != null) {
            Alert::error('Erreur', $validation);
            return redirect()->back();
        }

        DB::beginTransaction();
        try {
            $formation = Formation::findOrFail($id);
            $formation->name = $request->name;
            $formation->description = $request->description;
            $formation->date_debut = $request->date_debut;
            $formation->date_fin = $request->date_fin;
            $formation->duree = $request->duree;
            $formation->lieu = $request->lieu;
            $formation->prix = $request->prix;
            $formation->is_terminated = $request->is_terminated;
            $formation->max_places = $request->max_places;
            $formation->formateur_id = $request->formateur;
            $formation->save();

            DB::commit();
            Alert::success('Success', "La formation a été mise à jour avec succès !")->persistent("ok");
            return redirect()->back();
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception);
            Alert::warning('Error', "La mise à jour de la formation a échoué !")->persistent("ok");
            return redirect()->back();
        }
    }

    public function destroy(Formation $formation)
    {
        DB::beginTransaction();
        try {
            $formation->delete();
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
