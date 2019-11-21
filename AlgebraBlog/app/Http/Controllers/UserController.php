<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    //prikaži sve usere
    public function index()
    {
        $users = User::all();

        return view('users.index', compact('users'));
    }
    // prikaži formu za stavaranje novog usera
    public function create()
    {
        return view('users.create');
    }

    // spremi novo kreiranog usera u bazu
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:191|min:2',
            'email' => 'required|email|max:191|unique:users',
            'password' => 'required|min:3|confirmed'
        ]);

        $user = new User();
        $user->name = $request['name'];
        $user->email = $request['email'];
        $user->password = bcrypt($request['password']);
        $user->save();

        return redirect()->route('users.index')->withFlashMessage("Korisnik $user->name uspješno je kreiran.");
    }

    // prikaži podatke o jednom useru
    public function show($id)
    {
        $user = User::find($id);

        return view('users.show', compact('user'));
    }

    // prikaži formu za uređivanje usera
    public function edit($id)
    {
        $user = User::find($id);

        return view('users.edit', compact('user'));
    }

    // spremi uređenog usera u bazu
    public function update(Request $request, $id)
    {
        // Domaća zadaća
    }

    // obriši usera
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        return redirect()->route('users.index')->withFlashMessage("Korisnik $user->name uspješno je izbrisan.");
    }
}
