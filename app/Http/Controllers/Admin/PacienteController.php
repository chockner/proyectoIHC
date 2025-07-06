<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class PacienteController extends Controller
{
    public function index()
    {
        $pacientes = Patient::with('user.profile')->paginate(10);
        return view('admin.paciente.index', compact('pacientes'));
    }
    public function create()
    {
        return view('admin.paciente.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'document_id' => 'required|digits:8|unique:users,document_id',
            'first_name' => 'required|string|max:255|regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/',
            'last_name' => 'required|string|max:255|regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/',
            'phone' => 'required|string|max:9',
            'email' => 'required|email|max:255|unique:profiles,email',
            'birthdate' => 'required|date',
            'gender' => 'required|in:0,1',
            'civil_status' => 'required|in:0,1,2,3',
            'address' => 'required|string|max:255',
        ]);

        $password = $request->document_id;

        // Crear el usuario
        $user = User::create([
            'role_id' => 3,
            'document_id' => $request->document_id,
            'password' => Hash::make($password),
        ]);

        // Crear el perfil del usuario
        $profile = Profile::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'birthdate' => $request->birthdate,
            'gender' => $request->gender,
            'civil_status' => $request->civil_status,
            'address' => $request->address,
            // otros campos del perfil si es necesario
        ]);

        // Crear el paciente
        Patient::create([
            'user_id' => $user->id,
            // otros campos del paciente si es necesario
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

        return redirect()->route('admin.paciente.index')->with('success', 'Paciente creado correctamente.');
    }

    public function show($id)
    {
        $paciente = Patient::with('user.profile')->findOrFail($id);
        return view('admin.paciente.show', compact('paciente'));
    }

    public function edit($id)
    {
        $paciente = Patient::findOrFail($id);
        return view('admin.paciente.edit', compact('paciente'));
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

        $paciente = Patient::findOrFail($id);
        $paciente->user->update([
            'document_id' => $request->document_id,
        ]);
        
        //$paciente->update([]); // Aquí puedes actualizar los campos específicos del paciente si es necesario
        
        $paciente->user->profile->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'birthdate' => $request->birthdate,
            'gender' => $request->gender,
            'civil_status' => $request->civil_status,
            'address' => $request->address,
        ]);

        // creo que el dni no debe permitir editar ahhhh

        return redirect()->route('admin.paciente.index')->with('success', 'Paciente actualizado correctamente.');
    }

    public function destroy($id)
    {
        $paciente = Patient::findOrFail($id);
        
        if ($paciente->user) {
            if($paciente->user->profile) {
                $paciente->user->profile->delete();
            }
            $paciente->user->delete();
        }
        $paciente->delete();
        
        return redirect()->route('admin.paciente.index')->with('success', 'Paciente eliminado correctamente.');
    }
}
