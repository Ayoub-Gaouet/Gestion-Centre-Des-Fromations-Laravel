<?php

namespace App\Http\Controllers\Client;


use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Configuration;
use App\Models\Client;
use Exception;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Nette\Utils\Image;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Carbon;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $client = auth()->user();
            return Datatables::eloquent(Client::query())
                ->addIndexColumn()
                ->addColumn('action', function ($row) use ($client) {
                    $btn = "";
                    $btn .= '<a href="javascript:void(0)"  data-id="' . $row->id . '"  data-name="'
                        . $row->name . '" data-date_de_naissance="' . $row->date_de_naissance . '"data-genre="' . $row->genre .
                        '"data-tel="' . $row->tel . '" data-email="' . $row->email . '"
                            class="edit btn tooltipped "  data-placement="right" title="Editer"  data-toggle="modal"
                       data-target="#updateModal">
                            <i class="fas fa-edit text-warning"></i> </a>';

                    if ($row->status == 0) {
                        $btn .= ' <a href="javascript:void(0)"  data-id="' . $row->id . '"  data-name="' . "Cliquez sur Oui pour activer l'utilisateur N° " . '"
                            class="desactiver btn tooltipped" data-placement="right" title="Activer" data-toggle="tooltip" >
                             <i class="fas fa-user-check text-primary"></i></a>';
                    } else {
                        if ($row->status == 1) {
                            $btn .= ' <a href="javascript:void(0)"  data-id="' . $row->id . '"  data-name="' . "Cliquez sur Oui pour désactiver l'utilisateur N° " . '"
                            class="desactiver btn tooltipped" data-placement="right" title="Désactiver" data-toggle="tooltip" >
                            <i class="fas fa-user-times text-danger"></i> </a>';
                    }
                }

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view("admin.clients.clients");
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['max:255', 'required', 'string'],
            'date_de_naissance' => ['required', 'date'],
            'genre' => ['max:255', 'required', 'string'],
            'tel' => ['max:255', 'required', 'string'],
            'email' => ['email', 'required'],

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
            $client = new Client();
            $client->name = $request->name;
            $client->date_de_naissance = $request->date_de_naissance;
            $client->genre = $request->genre;
            $client->tel = $request->tel;
            $client->password = $request->password;
            if ($client->email != $request->email) {
                $client->email = $request->email;
                $client->email_verified_at = null;
            }
            $client->save();
            DB::commit();
            if ($client->email_verified_at == null) {
                $client->sendEmailVerificationNotification();
            }
            Alert::success('Success', "Votre client a été ajouter avec succès !");
            return redirect()->back();
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception);
            Alert::warning('Error', "Votre Client a été rejeter !");
            return redirect()->back();
        }
    }


    public function update(Request $request, Client $client)
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
            $client->name = $request->name;
            $client->date_de_naissance = $request->date_de_naissance;
            $client->genre = $request->genre;
            $client->tel = $request->tel;
            if ($client->email != $request->email) {
                $client->email = $request->email;
                $client->email_verified_at = null;
            }
            $client->save();
            DB::commit();
            if ($client->email_verified_at == null) {
                $client->sendEmailVerificationNotification();

            }
            Alert::success('Success', "Votre Client a été modifier avec succès !");
            return redirect()->back();

        } catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception);
            Alert::warning('Error', "Votre Client a été rejeter !");
            return redirect()->back();
        }

    }
    public function desactivateAccount(Client $client)
    {
        DB::beginTransaction();
        try {
            if ($client->status == 0) {
                $client->status = 1;
            } else {
                $client->status = 0;
            }
            $client->save();
            DB::commit();
//            Cache::tags('clients')->flush();
            Alert::success('Success', "Votre compte a été désactiver avec succès !");
            return redirect()->back();
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception);
            Alert::warning('Error', "Votre demande a été rejeter !");
            return redirect()->back();
        }

    }

    public function updateProfile(Request $request)
    {
        $client = Auth::client();

        $validator = Validator::make($request->all(), [
            'name' => 'min:2',
            'email' => ['email'],
        ]);

        if ($validator->fails()) {
            return back()->with('error', 'Erreur modification du compte !');
        }

        $client->name = $request->name;

        if ($client->email != $request->email) {
            $client->email = $request->email;
            $client->email_verified_at = null;
        }

        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $filename = time() . '.' . $image->getClientOriginalExtension();

            $destinationPath = public_path('images/clients');
            $img = Image::make($image->path());
            $img->resize(100, 100, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath . '/' . $filename);
            $client->photo = $filename;
        }


        DB::beginTransaction();
        try {

            $client->save();
            if ($client->email_verified_at == null) {
                $client->sendEmailVerificationNotification();
            }
            DB::commit();
//            Cache::tags('clients')->flush();
            Alert::success('Success', "Profil Modifié!");
            return redirect()->back();
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception);
            Alert::warning('Error', "Erreur modification du compte");
            return redirect()->back();
        }


    }

    public function editPictures()
    {
        $client = Auth::client();
        return view("admin.administration.edit-picture")->with("client", $client);
    }

    public function updateLogo(Request $request)
    {

        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $filename = Helper::generateApikey() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('images/logo');
            $img = Image::make($image->path());
            $file = new Filesystem;
            $file->cleanDirectory('images/logo');
            if ($img->resize(400, 300, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath . '/' . $filename)) {
                Configuration::query()->where("label", "logo")->update(["value" => $filename]);
                Alert::success('Success', "Logo Modifié!");
                return Redirect::back();
            } else {
                Alert::warning('Error', "Erreur modification du Logo");
                return Redirect::back();
            }
        } else {
            Alert::warning('Error', "Aucune photo ajoutée !");
            return Redirect::back();
        }
    }

    public function updateBackground(Request $request)
    {

        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $filename = Helper::generateApikey() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('images/background');
            $img = Image::make($image->path());
            $file = new Filesystem;
            $file->cleanDirectory('images/background');
            if ($img->save($destinationPath . '/' . $filename)) {
                Configuration::query()->where("label", "background")->update(["value" => $filename]);
                Alert::success('Success', "Background Modifié!");
                return Redirect::back();
            } else {
                Alert::warning('Error', "Erreur modification du Background");
                return Redirect::back();
            }
        } else {
            Alert::warning('Error', "Aucune photo ajoutée !");
            return Redirect::back();
        }
    }

    public function giveRoleToClient(Client $client, Request $request)
    {
        try {
            $client->syncRoles([$request->role]);
//            Cache::tags('clients')->flush();
            Alert::success('Success', "Role Affecté avec Succès");
            return redirect()->back();
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception);
            Alert::warning('Error', "Role Affecté avec Succès");
            return redirect()->back();
        }
    }


}
