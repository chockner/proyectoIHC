<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;

/* ADMIN CONTROLLERS */
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\SecretariaController;
use App\Http\Controllers\Admin\EspecialidadController;
use App\Http\Controllers\Admin\PacienteController;
use App\Http\Controllers\Admin\HistorialMedicoController;
use App\Http\Controllers\Admin\HorarioController;

/* SECRETARIA CONTROLLERS */
use App\Http\Controllers\Secretaria\CitaController;

/* PACIENTE CONTROLLERS */
use App\Http\Controllers\Paciente\AgendarCitaController;

Route::view('/', 'home')->name('home');
Route::view('/login', 'auth.login')->name('login');

// Login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/login/personal', [LoginController::class, 'showLoginPersonalForm'])->name('login.personal');
Route::post('/login/personal', [LoginController::class, 'loginPersonal'])/* ->name('login.personal.store') */;

// Register
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

// profile edit
Route::middleware('auth')->group(function () {
    Route::get('/perfil/editar', [ProfileController::class, 'edit'])->name('perfil.edit');
    Route::put('/perfil/actualizar', [ProfileController::class, 'update'])->name('perfil.update');
});

Route::get('/dashboard', function () {
    $user = auth()->user();

    return match ($user->role->name) {
        'admin' => app(\App\Http\Controllers\DashboardController::class)->adminDashboard(),
        'secretaria' => app(\App\Http\Controllers\DashboardController::class)->secretariaDashboard(),
        'doctor' => app(\App\Http\Controllers\DashboardController::class)->doctorDashboard(),
        'paciente' => app(\App\Http\Controllers\DashboardController::class)->pacienteDashboard(),
    
        // otros roles aquí
        default => abort(403),
    };
})->middleware('auth')->name('dashboard');

/* Admin Routes */

Route::prefix('admin')->middleware(['auth'])->group(function () {
    
    /* admin -> doctor */
    Route::get('/doctors', [DoctorController::class, 'index'])->name('admin.doctor.index');
    Route::get('/doctors/create', [DoctorController::class, 'create'])->name('admin.doctor.create');
    Route::post('/doctors', [DoctorController::class, 'store'])->name('admin.doctor.store');
    Route::get('/doctors/{id}', [DoctorController::class, 'show'])->name('admin.doctor.show');
    Route::get('/doctors/{id}/edit', [DoctorController::class, 'edit'])->name('admin.doctor.edit');
    Route::put('/doctors/{id}', [DoctorController::class, 'update'])->name('admin.doctor.update');
    Route::delete('/doctors/{id}', [DoctorController::class, 'destroy'])->name('admin.doctor.destroy');

    /* admin -> secreataria */
    Route::get('/secretarias', [SecretariaController::class, 'index'])->name('admin.secretaria.index');
    Route::get('/secretarias/create', [SecretariaController::class, 'create'])->name('admin.secretaria.create');
    Route::post('/secretarias', [SecretariaController::class, 'store'])->name('admin.secretaria.store');
    Route::get('/secretarias/{id}', [SecretariaController::class, 'show'])->name('admin.secretaria.show');
    Route::get('/secretarias/{id}/edit', [SecretariaController::class, 'edit'])->name('admin.secretaria.edit');
    Route::put('/secretarias/{id}', [SecretariaController::class, 'update'])->name('admin.secretaria.update');
    Route::delete('/secretarias/{id}', [SecretariaController::class, 'destroy'])->name('admin.secretaria.destroy');

    /* admin -> especialidad */
    Route::get('/especialidades', [EspecialidadController::class, 'index'])->name('admin.especialidad.index');
    Route::post('/especialidades', [EspecialidadController::class, 'store'])->name('admin.especialidad.store');
    Route::put('/especialidad/{id}', [EspecialidadController::class, 'update'])->name('admin.especialidad.update');
    Route::delete('/especialidades/{id}', [EspecialidadController::class, 'destroy'])->name('admin.especialidad.destroy');

    /* admin -> paciente */
    Route::get('/pacientes', [PacienteController::class, 'index'])->name('admin.paciente.index');
    Route::get('/pacientes/create', [PacienteController::class, 'create'])->name('admin.paciente.create');
    Route::post('/pacientes', [PacienteController::class, 'store'])->name('admin.paciente.store');
    Route::get('/pacientes/{id}', [PacienteController::class, 'show'])->name('admin.paciente.show');
    Route::get('/pacientes/{id}/edit', [PacienteController::class, 'edit'])->name('admin.paciente.edit');
    Route::put('/pacientes/{id}', [PacienteController::class, 'update'])->name('admin.paciente.update');
    Route::delete('/pacientes/{id}', [PacienteController::class, 'destroy'])->name('admin.paciente.destroy');

    /* admin -> historial Medico */
    Route::get('/historiales', [HistorialMedicoController::class, 'index'])->name('admin.historialMedico.index');
    Route::get('/historiales/{id}', [HistorialMedicoController::class, 'show'])->name('admin.historialMedico.show');
    Route::get('/historiales/{id}/detail', [HistorialMedicoController::class, 'show_detail'])->name('admin.historialMedico.show_detail');
    Route::get('/historiales/{id}/edit-detail', [HistorialMedicoController::class, 'edit_detail'])->name('admin.historialMedico.edit_detail');
    Route::delete('/historiales/{id}', [HistorialMedicoController::class, 'destroy'])->name('admin.historialMedico.destroy');


    /* admin -> horarios */
    Route::get('/horarios', [HorarioController::class, 'index'])->name('admin.horarios.index');
    Route::get('/horarios/create', [HorarioController::class, 'create'])->name('admin.horarios.create');
    Route::post('/horarios', [HorarioController::class, 'store'])->name('admin.horarios.store');
    Route::get('/horarios/get-doctors/{specialty}', [HorarioController::class, 'getDoctors'])->name('admin.horarios.get-doctors');
    Route::get('/horarios/editar-por-filtros', [HorarioController::class, 'editByFilters'])->name('admin.horarios.edit-by-filters');
    Route::post('/horarios/get-edit-data', [HorarioController::class, 'getEditData'])->name('admin.horarios.get-edit-data');
    Route::post('/horarios/bulk-update', [HorarioController::class, 'bulkUpdate'])->name('admin.horarios.bulk-update');
    Route::get('/horarios/eliminar-por-filtros', [HorarioController::class, 'deleteByFilters'])->name('admin.horarios.delete-by-filters');
    Route::post('/horarios/get-delete-data', [HorarioController::class, 'getDeleteData'])->name('admin.horarios.get-delete-data');
    Route::post('/horarios/bulk-delete', [HorarioController::class, 'bulkDelete'])->name('admin.horarios.bulk-delete');
});

/* Secretaria Routes */
Route::prefix('secretaria')->middleware(['auth'])->group(function () {
    
    /* secretaria -> citas */
    Route::get('/citas', [CitaController::class, 'index'])->name('secretaria.citas.index');

});

/* PACIENTE ROUTES */
Route::prefix('paciente')->middleware(['auth'])->group(function () {
    /* paciente -> agendar cita */
    Route::get('/agendar-cita', [AgendarCitaController::class, 'create'])->name('paciente.agendarCita.create');
    Route::post('/agendar-cita', [AgendarCitaController::class, 'store'])->name('paciente.agendarCita.store');
    Route::get('/agendar-cita/horarios/get-doctors/{specialtyId}/{shift}', [AgendarCitaController::class, 'getDoctors']);
    Route::get('/agendar-cita/paso1', [AgendarCitaController::class, 'createPaso1'])->name('paciente.agendarCita.paso1');
    Route::get('/agendar-cita/horarios/get-available-times/{doctorId}/{shift}/{date}', [AgendarCitaController::class, 'getAvailableTimes']);
    Route::get('/agendar-cita/horarios/get-schedules/{id}/{shift}',[AgendarCitaController::class, 'getSchedules']);



});



