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
            'document_id' => 'required|digits:8|unique:users,document_id',
            'first_name' => 'required|string|max:255|regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/',
            'last_name' => 'required|string|max:255|regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/',
            'email' => 'required|email|max:255|unique:profiles,email',
            'phone' => 'required|string|max:9',
            'birthdate' => 'required|date',
            'civil_status' => 'required|in:0,1,2,3',
            'address' => 'required|string|max:255',
            'gender' => 'required|in:0,1',
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
            'phone' => $request->phone,
            'email' => $request->email,
            'birthdate' => $request->birthdate,
            'civil_status' => $request->civil_status,
            'address' => $request->address,
            'gender' => $request->gender,
        ]);

        Secretary::create([
            'user_id' => $user->id,
        ]);

        $user->profile()->create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'birthdate' => $request->birthdate,
            'gender' => $request->gender,
            'civil_status' => $request->civil_status,
            'address' => $request->address,
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
            'document_id' => 'required|digits:8',
            'first_name' => 'required|string|max:255|regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/',
            'last_name' => 'required|string|max:255|regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/',
            'phone' => 'required|digits:9|starts_with:9',
            'email' => 'required|email|max:255',
            'birthdate' => 'required|date',
            'gender' => 'required|in:0,1',
            'civil_status' => 'required|in:0,1,2,3',
            'address' => 'required|string|max:255',
        ]);

        $secretaria = Secretary::findOrFail($id);
        $secretaria->user->update([
            'document_id' => $request->document_id,
        ]);

        $secretaria->user->profile->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'birthdate' => $request->birthdate,
            'gender' => $request->gender,
            'civil_status' => $request->civil_status,
            'address' => $request->address,
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
