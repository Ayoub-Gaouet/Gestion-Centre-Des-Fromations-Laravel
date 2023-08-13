<?php

namespace App\Http\Controllers\Formateur;

use App\Models\Formateur;
use DB;
use Exception;
use Illuminate\Http\Request;
use Log;
use RealRashid\SweetAlert\Facades\Alert;
use Validator;
use Yajra\DataTables\Facades\DataTables;

class FormateurController
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $user = auth()->user();
            return Datatables::eloquent(Formateur::query())
                ->addIndexColumn()
                ->addColumn('action', function ($row) use ($user) {
                    $btn = "";

                    $btn .= '<a href="javascript:void(0)"  data-id="' . $row->id . '"  data-name="'
                        . $row->name . '" data-date_de_naissance="' . $row->date_de_naissance . '"data-genre="' . $row->genre .
                        '"data-tel="' . $row->tel . '"data-evaluer="' . $row->evaluer
                        . '" data-email="' . $row->email . '"
                            class="edit btn tooltipped "  data-placement="right" title="Editer"  data-toggle="modal"
                       data-target="#updateModal">
                            <i class="fas fa-edit text-warning"></i> </a>';
                    if ($row->status == 0) {
                        $btn .= ' <a href="javascript:void(0)"  data-id="' . $row->id . '"  data-name="' . "Cliquez sur Oui pour activer le formateur  N° " . '"
                            class="desactiver btn tooltipped" data-placement="right" title="Activer" data-toggle="tooltip" >
                             <i class="fas fa-user-check text-primary"></i></a>';
                    } else {
                        if ($row->status == 1) {
                            $btn .= ' <a href="javascript:void(0)"  data-id="' . $row->id . '"  data-name="' . "Cliquez sur Oui pour désactiver formateur N° " . '"
                            class="desactiver btn tooltipped" data-placement="right" title="Désactiver" data-toggle="tooltip" >
                            <i class="fas fa-user-times text-danger"></i> </a>';
                        }
                    }
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view("admin.formateurs.formateurs");
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['max:255', 'required', 'string'],
            'date_de_naissance' => ['required', 'date'],
            'genre' => ['max:255', 'required', 'string'],
            'tel' => ['max:255', 'required', 'string'],
            'email' => ['email', 'required','unique:clients'],
            'password' => ['required', 'string', 'min:8'],

        ]);

        if ($validator->errors()->any()) {
            $text = "";
            foreach ($validator->errors()->all() as $error) {
                $text = $error . "\n";
            }

            Alert::warning('Error', $text);
            return redirect()->back();
        }

        DB::beginTransaction();
        try {
            $formateur = new Formateur();
            $formateur->name = $request->name;
            $formateur->date_de_naissance = $request->date_de_naissance;
            $formateur->genre = $request->genre;
            $formateur->tel = $request->tel;
            $formateur->evaluer =null;
            $formateur->password = $request->password;
            if ($formateur->email != $request->email) {
                $formateur->email = $request->email;
                $formateur->email_verified_at = null;
            }
            $formateur->save();
            DB::commit();
            Alert::success('Success', "Votre formateur a été ajouté avec succès !");
            return redirect()->back();

        } catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception);
            Alert::warning('Error', "Votre formateur n'a pas été ajouté !");
            return redirect()->back();
        }
    }

    public function update(Request $request, Formateur $formateur)
    {

        $validator = Validator::make($request->all(), [
            'name' => ['max:255', 'required', 'string'],
            'date_de_naissance' => ['required', 'date'],
            'genre' => ['max:255', 'required', 'string'],
            'tel' => ['max:255', 'required', 'string'],
            'email' => ['email', 'required'],
        ]);

        if ($validator->errors()->any()) {
            $text = "";
            foreach ($validator->errors()->all() as $error) {
                $text = $error . "\n";
            }

            Alert::warning('Error', $text);
            return redirect()->back();
        }

        DB::beginTransaction();
        try {
            $formateur->name = $request->name;
            $formateur->date_de_naissance = $request->date_de_naissance;
            $formateur->genre = $request->genre;
            $formateur->tel = $request->tel;
            $formateur->evaluer = $request->evaluer;
            if ($formateur->email != $request->email) {
                $formateur->email = $request->email;
                $formateur->email_verified_at = null;
            }


            $formateur->save();
            DB::commit();
            Alert::success('Success', "Votre formateur a été modifier avec succès !");
            return redirect()->back();

        } catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception);
            Alert::warning('Error', "Votre formateur été rejeter !");
            return redirect()->back();
        }

    }

    public function desactivateAccount(Formateur $formateur)
    {
        DB::beginTransaction();
        try {
            if ($formateur->status == 0) {
                $formateur->status = 1;
            } else {
                $formateur->status = 0;
            }
            $formateur->save();
            DB::commit();
            Alert::success('Success', "Votre compte a été désactiver avec succès !");
            return redirect()->back();
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception);
            Alert::warning('Error', "Votre demande a été rejeter !");
            return redirect()->back();
        }

    }
}
