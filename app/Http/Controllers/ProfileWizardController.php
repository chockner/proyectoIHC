<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\Profile;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Secretary;
use App\Models\Specialty;

class ProfileWizardController extends Controller
{
    // Paso 1: Datos personales comunes
    public function step1()
    {
        // Verificar si ya tiene perfil completo
        $user = Auth::user();
        if ($user->profile && 
            $user->profile->first_name && 
            $user->profile->last_name && 
            $user->profile->email) {
            return redirect()->route('dashboard');
        }

        return view('profile_wizard.step1');
    }

    public function postStep1(Request $request)
    {
        // Validaciones para datos personales
        $user = Auth::user();
        $emailRule = 'required|email';
        
        // Si el usuario ya tiene un perfil, excluir su propio email de la validación unique
        if ($user->profile) {
            $emailRule .= '|unique:profiles,email,' . $user->profile->id;
        } else {
            $emailRule .= '|unique:profiles,email';
        }
        
        $validated = $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'birthdate' => 'required|date|before:today',
            'gender' => 'required|in:F,M',
            'phone' => 'required|string|max:12',
            'email' => $emailRule,
            'civil_status' => 'nullable|in:S,C,V,D',
            'region' => 'nullable|string|max:100',
            'province' => 'nullable|string|max:100',
            'district' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:70',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Convertir letras a números según la convención de la base de datos
        $validated['gender'] = $this->convertGenderToNumber($validated['gender']);
        if (isset($validated['civil_status'])) {
            $validated['civil_status'] = $this->convertCivilStatusToNumber($validated['civil_status']);
        }

        // Manejar subida de foto
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('profiles', 'public');
            $validated['photo'] = $photoPath;
        }

        // Guardar datos en sesión para el siguiente paso
        session(['profile_data' => $validated]);

        return redirect()->route('profile.wizard.step2');
    }

    /**
     * Convierte la letra del género a número según la convención de la base de datos
     * F = 0 (femenino), M = 1 (masculino)
     */
    public function convertGenderToNumber($gender)
    {
        return $gender === 'F' ? '0' : '1';
    }

    /**
     * Convierte la letra del estado civil a número según la convención de la base de datos
     * S = 0 (soltero), C = 1 (casado), V = 2 (viudo), D = 3 (divorciado)
     */
    public function convertCivilStatusToNumber($civilStatus)
    {
        $mapping = [
            'S' => '0', // Soltero
            'C' => '1', // Casado
            'V' => '2', // Viudo
            'D' => '3', // Divorciado
        ];
        
        return $mapping[$civilStatus] ?? '0';
    }

    /**
     * Convierte el número del género a texto para mostrar
     * 0 = Femenino, 1 = Masculino
     */
    public function convertGenderToText($gender)
    {
        return $gender === '0' ? 'Femenino' : 'Masculino';
    }

    /**
     * Convierte el número del estado civil a texto para mostrar
     * 0 = Soltero, 1 = Casado, 2 = Viudo, 3 = Divorciado
     */
    public function convertCivilStatusToText($civilStatus)
    {
        $mapping = [
            '0' => 'Soltero/a',
            '1' => 'Casado/a',
            '2' => 'Viudo/a',
            '3' => 'Divorciado/a',
        ];
        
        return $mapping[$civilStatus] ?? 'No especificado';
    }

    // Paso 2: Datos específicos por rol
    public function step2()
    {
        // Verificar que venga del paso 1
        if (!session('profile_data')) {
            return redirect()->route('profile.wizard.step1');
        }

        $user = Auth::user();
        $data = ['user' => $user];

        // Cargar datos específicos según el rol
        if ($user->role->name === 'doctor') {
            $data['specialties'] = Specialty::all();
        }

        return view('profile_wizard.step2', $data);
    }

    public function postStep2(Request $request)
    {
        $user = Auth::user();
        $roleData = [];

        // Validaciones específicas por rol
        if ($user->role->name === 'doctor') {
            $licenseRule = 'required|string|max:6';
            
            // Si ya existe un doctor para este usuario, excluir su propio código de licencia
            if ($user->doctor) {
                $licenseRule .= '|unique:doctors,license_code,' . $user->doctor->id;
            } else {
                $licenseRule .= '|unique:doctors,license_code';
            }

            $validated = $request->validate([
                'license_code' => $licenseRule,
                'specialty_id' => 'required|exists:specialties,id',
                'experience_years' => 'required|integer|min:0|max:50',
                'professional_bio' => 'nullable|string|max:1000',
            ]);

            $roleData = $validated;
            $roleData['specialty_name'] = Specialty::find($validated['specialty_id'])->name;

        } elseif ($user->role->name === 'paciente') {
            $validated = $request->validate([
                'blood_type' => 'nullable|string|max:3',
                'allergies' => 'nullable|string|max:500',
                'vaccination_received' => 'nullable|string|max:500',
                'emergency_contact' => 'nullable|string|max:100',
                'emergency_phone' => 'nullable|string|max:15',
            ]);

            $roleData = $validated;
        } else {
            // Para secretaria y admin - no necesitan campos adicionales
            $roleData = [];
        }

        // Guardar datos del rol en sesión
        session(['role_data' => $roleData]);

        return redirect()->route('profile.wizard.summary');
    }

    // Paso 3: Resumen y confirmación
    public function summary()
    {
        // Verificar que venga de los pasos anteriores
        if (!session('profile_data')) {
            return redirect()->route('profile.wizard.step1');
        }

        // Para secretaria y admin, no necesitan datos específicos por rol
        $user = Auth::user();
        if (in_array($user->role->name, ['secretaria', 'admin']) && !session('role_data')) {
            session(['role_data' => []]);
        }

        // Convertir valores numéricos a texto para mostrar en el resumen
        $profileData = session('profile_data');
        $profileData['gender_text'] = $this->convertGenderToText($profileData['gender']);
        if (isset($profileData['civil_status'])) {
            $profileData['civil_status_text'] = $this->convertCivilStatusToText($profileData['civil_status']);
        }

        return view('profile_wizard.summary', compact('profileData'));
    }

    public function finish(Request $request)
    {
        $user = Auth::user();
        $profileData = session('profile_data');
        $roleData = session('role_data');

        if (!$profileData) {
            return redirect()->route('profile.wizard.step1');
        }

        try {
            // Debug: Log de datos recibidos
            Log::info('ProfileWizardController::finish - Datos recibidos', [
                'user_id' => $user->id,
                'role' => $user->role->name,
                'profile_data' => $profileData,
                'role_data' => $roleData
            ]);

            // Actualizar perfil existente o crear uno nuevo
            if ($user->profile) {
                // Actualizar perfil existente
                $updateData = [
                    'first_name' => $profileData['first_name'],
                    'last_name' => $profileData['last_name'],
                    'email' => $profileData['email'],
                    'phone' => $profileData['phone'],
                    'birthdate' => $profileData['birthdate'],
                    'gender' => $profileData['gender'],
                    'civil_status' => $profileData['civil_status'] ?? null,
                    'region' => $profileData['region'] ?? null,
                    'province' => $profileData['province'] ?? null,
                    'district' => $profileData['district'] ?? null,
                    'address' => $profileData['address'] ?? null,
                ];

                // Solo agregar photo si existe
                if (isset($profileData['photo'])) {
                    $updateData['photo'] = $profileData['photo'];
                }

                $user->profile->update($updateData);
                $profile = $user->profile;
                
                Log::info('Perfil actualizado exitosamente', ['profile_id' => $profile->id]);
            } else {
                // Crear nuevo perfil (caso improbable)
                $createData = [
                    'user_id' => $user->id,
                    'first_name' => $profileData['first_name'],
                    'last_name' => $profileData['last_name'],
                    'email' => $profileData['email'],
                    'phone' => $profileData['phone'],
                    'birthdate' => $profileData['birthdate'],
                    'gender' => $profileData['gender'],
                    'civil_status' => $profileData['civil_status'] ?? null,
                    'region' => $profileData['region'] ?? null,
                    'province' => $profileData['province'] ?? null,
                    'district' => $profileData['district'] ?? null,
                    'address' => $profileData['address'] ?? null,
                ];

                // Solo agregar photo si existe
                if (isset($profileData['photo'])) {
                    $createData['photo'] = $profileData['photo'];
                }

                $profile = Profile::create($createData);
                Log::info('Nuevo perfil creado exitosamente', ['profile_id' => $profile->id]);
            }

            // Crear registro específico según el rol (solo si no existe)
            if ($user->role->name === 'doctor') {
                // Verificar si ya existe un doctor para este usuario
                if (!$user->doctor) {
                    $doctorData = [
                        'user_id' => $user->id,
                        'specialty_id' => $roleData['specialty_id'],
                        'license_code' => $roleData['license_code'],
                        'experience_years' => $roleData['experience_years'],
                    ];

                    // Solo agregar professional_bio si existe
                    if (isset($roleData['professional_bio'])) {
                        $doctorData['professional_bio'] = $roleData['professional_bio'];
                    }

                    Doctor::create($doctorData);
                    Log::info('Nuevo doctor creado exitosamente');
                } else {
                    // Actualizar doctor existente
                    $updateData = [
                        'specialty_id' => $roleData['specialty_id'],
                        'license_code' => $roleData['license_code'],
                        'experience_years' => $roleData['experience_years'],
                    ];

                    // Solo agregar professional_bio si existe
                    if (isset($roleData['professional_bio'])) {
                        $updateData['professional_bio'] = $roleData['professional_bio'];
                    }

                    $user->doctor->update($updateData);
                    Log::info('Doctor actualizado exitosamente');
                }

            } elseif ($user->role->name === 'paciente') {
                // Verificar si ya existe un paciente para este usuario
                if (!$user->patient) {
                    $patientData = [
                        'user_id' => $user->id,
                    ];

                    // Agregar campos opcionales solo si existen
                    if (isset($roleData['blood_type'])) {
                        $patientData['blood_type'] = $roleData['blood_type'];
                    }
                    if (isset($roleData['allergies'])) {
                        $patientData['allergies'] = $roleData['allergies'];
                    }
                    if (isset($roleData['vaccination_received'])) {
                        $patientData['vaccination_received'] = $roleData['vaccination_received'];
                    }
                    if (isset($roleData['emergency_contact'])) {
                        $patientData['emergency_contact'] = $roleData['emergency_contact'];
                    }
                    if (isset($roleData['emergency_phone'])) {
                        $patientData['emergency_phone'] = $roleData['emergency_phone'];
                    }

                    Patient::create($patientData);
                    Log::info('Nuevo paciente creado exitosamente');
                } else {
                    // Actualizar paciente existente
                    $updateData = [];

                    // Agregar campos opcionales solo si existen
                    if (isset($roleData['blood_type'])) {
                        $updateData['blood_type'] = $roleData['blood_type'];
                    }
                    if (isset($roleData['allergies'])) {
                        $updateData['allergies'] = $roleData['allergies'];
                    }
                    if (isset($roleData['vaccination_received'])) {
                        $updateData['vaccination_received'] = $roleData['vaccination_received'];
                    }
                    if (isset($roleData['emergency_contact'])) {
                        $updateData['emergency_contact'] = $roleData['emergency_contact'];
                    }
                    if (isset($roleData['emergency_phone'])) {
                        $updateData['emergency_phone'] = $roleData['emergency_phone'];
                    }

                    if (!empty($updateData)) {
                        $user->patient->update($updateData);
                        Log::info('Paciente actualizado exitosamente');
                    }
                }

            } elseif ($user->role->name === 'secretaria') {
                // Verificar si ya existe una secretaria para este usuario
                if (!$user->secretary) {
                    Secretary::create([
                        'user_id' => $user->id,
                    ]);
                    Log::info('Nueva secretaria creada exitosamente');
                }
            }

            // Limpiar datos de sesión
            session()->forget(['profile_data', 'role_data']);

            Log::info('ProfileWizardController::finish completado exitosamente');

            return redirect()->route('dashboard')
                ->with('success', '¡Perfil completado exitosamente!');

        } catch (\Exception $e) {
            // Log del error para debugging
            Log::error('Error en ProfileWizardController::finish: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            Log::error('Datos que causaron el error:', [
                'profile_data' => $profileData ?? null,
                'role_data' => $roleData ?? null,
                'user_role' => $user->role->name ?? null
            ]);
            
            // En desarrollo, mostrar el error completo
            if (config('app.debug')) {
                return back()->with('error', 'Error al completar el perfil: ' . $e->getMessage() . ' en línea ' . $e->getLine());
            } else {
                return back()->with('error', 'Error al completar el perfil. Por favor, inténtalo de nuevo.');
            }
        }
    }
} 