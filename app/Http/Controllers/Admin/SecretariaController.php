<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Secretary;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Support\Facades\Hash;

class SecretariaController extends Controller
{
    public function index()
    {
        //$secretarias = Secretary::all();
        $secretarias = Secretary::with('user.profile')->paginate(10);
        return view('admin.secretaria.index', compact('secretarias'));
    }

    public function create()
    {
        return view('admin.secretaria.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'document_id' => 'required|string|max:8|unique:users,document_id',
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
        ]);

        $password = $request->document_id;

        $user = User::create([
            'role_id' => 4, // Assuming 3 is the role ID for secretaria
            'document_id' => $request->document_id,
            'password' => Hash::make($password),
        ]);

        Profile::create([
            'user_id' => $user->id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
        ]);

        Secretary::create([
            'user_id' => $user->id,
        ]);

        return redirect()->route('admin.secretaria.index')->with('success', 'Secretaria creada exitosamente.');
    }

    public function show($id)
    {
        $secretaria = Secretary::with('user.profile')->findOrFail($id);
        return view('admin.secretaria.show', compact('secretaria'));
    }
    
    public function edit($id)
    {
        $secretaria = Secretary::with('user.profile')->findOrFail($id);
        return view('admin.secretaria.edit', compact('secretaria'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([

            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
        ]);

        $secretaria = Secretary::findOrFail($id);
        $user = $secretaria->user;

        $user->profile->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
        ]);

        return redirect()->route('admin.secretaria.index')->with('success', 'Secretaria actualizada exitosamente.');
    }

    public function destroy($id)
    {
        $secretaria = Secretary::findOrFail($id);
        if($secretaria->user) {
            if($secretaria->user->profile) {
                $secretaria->user->profile->delete();
            }
            $secretaria->user->delete();
        }
        $secretaria->delete();
        return redirect()->route('admin.secretaria.index')->with('success', 'Secretaria eliminada exitosamente.');
    }
}
