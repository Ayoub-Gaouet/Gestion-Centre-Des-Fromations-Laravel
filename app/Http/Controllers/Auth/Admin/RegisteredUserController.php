<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

use Illuminate\Validation\Rules;
use RealRashid\SweetAlert\Facades\Alert;

class RegisteredUserController extends Controller
{

    public function store(Request $request)
    {

        $validation = Helper::validateRequest($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed', Rules\Password::defaults()],
        ]);

        if ($validation != null) {
            Alert::error('Erreur', $validation);
            return redirect()->back();
        }
        $user = User::create([
            'photo' => "blank.png",
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $user->sendEmailVerificationNotification();
        event(new Registered($user));
        return redirect()->back();
    }


}
