<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\User;
use App\Models\Profile; // Assuming you have a Profile model
use App\Models\Specialty; // Assuming you have a Specialty model
use Illuminate\Support\Facades\Hash;

class DoctorController extends Controller
{
    public function index()
    {
    
        /* $doctores = Doctor::all(); */
        $doctores = Doctor::with('user.profile')->paginate(5);
        return view('admin.doctor.index', compact('doctores'));
    }

    public function create()
    {
        $specialty = Specialty::all(); // Assuming you have a Specialty model
        return view('admin.doctor.create', compact('specialty'));
    }
    
    public function store(Request $request)
    {
        /* dd($request->all()); */

        $request->validate([
            'document_id' => 'required|string|max:8|unique:users,document_id',
            'specialty_id' => 'required|exists:specialties,id',
            'license_code' => 'required|string|max:6',
            'experience_years' => 'required|integer|min:0',
        ]);
        
        $password = $request->document_id;

        $user = User::create([
            'role_id' => 2,
            'document_id' => $request->document_id,
            'password' => Hash::make($password),
        ]);

        Profile::create([
            'user_id' => $user->id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
        ]);
        
        Doctor::create([
            'user_id' => $user->id,
            'specialty_id' => $request->specialty_id,
            'license_code' => $request->license_code,
            'experience_years' => $request->experience_years,
        ]);
        return redirect()->route('admin.doctor.index')->with('success', 'Doctor creado exitosamente.');
    }

    public function show($id)
    {
        $doctor = Doctor::findOrFail($id);
        return view('admin.doctor.show', compact('doctor'));
    }

    public function edit($id)
    {
        $doctor = Doctor::findOrFail($id);
        $specialty =  Specialty::all(); // Assuming you have a Specialty model  
        /* return view('admin.doctor.edit', compact('doctor')); */
        return view('admin.doctor.edit', compact('doctor', 'specialty'));
    }

    public function update(Request $request, $id)
    {
        $doctor = Doctor::findOrFail($id);
        $doctor->update($request->all());
        return redirect()->route('admin.doctor.index')->with('success', 'Doctor updated successfully.');
    }

    public function destroy($id)
    {
        $doctor = Doctor::findOrFail($id);
        $doctor->delete();
        return redirect()->route('admin.doctor.index')->with('success', 'Doctor deleted successfully.');
    }
}
