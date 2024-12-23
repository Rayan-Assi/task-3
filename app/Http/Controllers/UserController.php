<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function MakeLoginForm()
    {
        return view('auth.login');
    }

    public function loginUser(Request $request)
    {  /* dd($request); */
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate();
            return redirect()->route('posts.index');
        }
        return back()->withErrors(["message" => "invalid email or password"]);
    }

    public function index()
    {
        $users = User::all();
        return view('users.index', compact("users"));
    }

    public function create()
    {
        /* $this->authorize('manageUser', User::class); */
        return view('users.login2');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'UserName' => 'required|string|max:55',
            'UserEmail' => 'required|string|email|max:255',
            'UserPassword' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->UserName,
            'email' => $request->UserEmail,
            'password' => Hash::make($request->UserPassword),
            'is_admin' => false
        ]);
        return redirect()->route("users.index");
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'UserName' => 'required|string|max:55',
            'UserEmail' => 'required|string|email|max:255',
            'UserPassword' => 'required|string|min:8|confirmed',
        ]);

        $user = User::findOrFail($id);
        $user->update([
            'name' => $request->UserName,
            'email' => $request->UserEmail,
            'password' => Hash::make($request->UserPassword),
        ]);
        return redirect()->route('users.index');
    }

    public function destroy($id)
    {
        $user_id = User::findOrFail($id);
        $user_id->delete();
        return redirect()->route("users.index");
    }
}
