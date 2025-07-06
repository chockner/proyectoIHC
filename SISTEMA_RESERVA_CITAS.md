# Sistema de Reserva de Citas - Hospital SaludIntegra

## Descripción General

Se ha implementado un sistema completo de reserva de citas médicas para pacientes, que consta de 4 pasos secuenciales:

1. **Paso 1: Selección de Especialidad**
2. **Paso 2: Selección de Médico**
3. **Paso 3: Selección de Fecha y Hora**
4. **Paso 4: Confirmación y Pago**

## Características Implementadas

### ✅ Funcionalidades Completadas

#### 1. Controlador Principal (`AgendarCitaController`)
- **Métodos implementados:**
  - `create()` - Paso 1: Selección de especialidad
  - `seleccionarMedico()` - Paso 2: Selección de médico
  - `seleccionarFechaHora()` - Paso 3: Selección de fecha y hora
  - `confirmacion()` - Paso 4: Confirmación y pago
  - `store()` - Guardar cita y procesar pago
  - `getHorariosDisponibles()` - API para obtener horarios disponibles
  - Métodos CRUD completos para gestión de citas

#### 2. Vistas Implementadas
- **Paso 1:** `paso1-especialidad.blade.php`
  - Grid de especialidades con iconos
  - Buscador de especialidades
  - Validación de selección

- **Paso 2:** `paso2-medico.blade.php`
  - Lista de médicos por especialidad
  - Información detallada de cada médico
  - Fotos de perfil (si están disponibles)

- **Paso 3:** `paso3-fecha-hora.blade.php`
  - Calendario interactivo
  - Horarios disponibles en tiempo real
  - Validación de disponibilidad

- **Paso 4:** `paso4-confirmacion.blade.php`
  - Resumen completo de la cita
  - Múltiples métodos de pago
  - Subida de comprobantes
  - Términos y condiciones

#### 3. Gestión de Citas
- **Vista de listado:** `citas/index.blade.php`
  - Tabla con todas las citas del paciente
  - Filtros por estado y especialidad
  - Paginación
  - Acciones rápidas

- **Vista de detalles:** `citas/show.blade.php`
  - Información completa de la cita
  - Estado del pago
  - Acciones disponibles

#### 4. Sistema de Pagos
- **Métodos de pago soportados:**
  - Pago en línea (validación automática)
  - Transferencia/Yape/Plin (con comprobante)
  - Pago en clínica

- **Gestión de comprobantes:**
  - Subida de archivos (JPG, PNG, PDF)
  - Validación de tamaño (máximo 5MB)
  - Almacenamiento seguro

#### 5. Validaciones y Seguridad
- Validación de disponibilidad de horarios
- Verificación de conflictos de citas
- Validación de archivos subidos
- Transacciones de base de datos
- Middleware de autenticación

## Estructura de Base de Datos

### Tablas Principales
- `specialties` - Especialidades médicas
- `doctors` - Médicos con sus especialidades
- `schedules` - Horarios de los médicos
- `appointments` - Citas programadas
- `payments` - Información de pagos
- `patients` - Información de pacientes

### Relaciones Implementadas
- Un médico pertenece a una especialidad
- Un médico tiene múltiples horarios
- Una cita pertenece a un paciente, médico y horario
- Un pago pertenece a una cita

## Rutas Implementadas

```php
// Rutas de reserva de citas
Route::get('/agendar-cita', [AgendarCitaController::class, 'create']);
Route::post('/agendar-cita/seleccionar-medico', [AgendarCitaController::class, 'seleccionarMedico']);
Route::post('/agendar-cita/seleccionar-fecha-hora', [AgendarCitaController::class, 'seleccionarFechaHora']);
Route::post('/agendar-cita/confirmacion', [AgendarCitaController::class, 'confirmacion']);
Route::post('/agendar-cita', [AgendarCitaController::class, 'store']);
Route::get('/agendar-cita/horarios-disponibles', [AgendarCitaController::class, 'getHorariosDisponibles']);

// Rutas de gestión de citas
Route::get('/citas', [AgendarCitaController::class, 'index']);
Route::get('/citas/{id}', [AgendarCitaController::class, 'show']);
Route::get('/citas/{id}/edit', [AgendarCitaController::class, 'edit']);
Route::put('/citas/{id}', [AgendarCitaController::class, 'update']);
Route::delete('/citas/{id}', [AgendarCitaController::class, 'destroy']);
Route::post('/citas/{id}/confirmar', [AgendarCitaController::class, 'confirm']);
Route::post('/citas/{id}/cancelar', [AgendarCitaController::class, 'cancel']);
```

## Diseño y UX

### Características de Diseño
- **Responsive:** Adaptable a móviles y tablets
- **Accesible:** Cumple estándares de accesibilidad
- **Intuitivo:** Navegación clara y progresiva
- **Consistente:** Diseño uniforme en todas las vistas

### Elementos Visuales
- Barra de progreso en cada paso
- Iconos de Material Design
- Estados visuales claros (seleccionado, disponible, ocupado)
- Colores semánticos (verde para éxito, rojo para error, etc.)

## Funcionalidades Avanzadas

### 1. Calendario Interactivo
- Navegación por meses
- Días disponibles resaltados
- Horarios en tiempo real
- Prevención de doble reserva

### 2. Sistema de Filtros
- Filtro por especialidad
- Filtro por estado de cita
- Búsqueda de especialidades

### 3. Gestión de Estados
- Estados de cita: programada, completada, cancelada
- Estados de pago: pendiente, validado, rechazado
- Transiciones de estado controladas

### 4. Notificaciones
- Mensajes de éxito y error
- Confirmaciones antes de acciones críticas
- Validaciones en tiempo real

## Instalación y Configuración

### Requisitos
- Laravel 10+
- MySQL 8.0+
- PHP 8.1+
- Composer

### Pasos de Instalación
1. Clonar el repositorio
2. Instalar dependencias: `composer install`
3. Configurar archivo `.env`
4. Ejecutar migraciones: `php artisan migrate`
5. Ejecutar seeders: `php artisan db:seed`
6. Configurar almacenamiento: `php artisan storage:link`

### Seeders Disponibles
- `RoleSeeder` - Roles del sistema
- `SpecialtiesSeeder` - Especialidades médicas
- `AdminSeeder` - Usuario administrador
- `DoctorSeeder` - Médicos de prueba
- `ScheduleSeeder` - Horarios de médicos
- `PatientsSeeder` - Pacientes de prueba

## Uso del Sistema

### Para Pacientes
1. Iniciar sesión con credenciales de paciente
2. Ir a "Reservar cita" en el dashboard
3. Seguir los 4 pasos del proceso
4. Gestionar citas desde "Mis citas"

### Credenciales de Prueba
- **Paciente 1:** paciente1@gmail.com / paciente1
- **Paciente 2:** paciente2@gmail.com / paciente2
- etc.

## Tecnologías Utilizadas

- **Backend:** Laravel 10, PHP 8.1
- **Frontend:** Blade, Tailwind CSS, JavaScript
- **Base de Datos:** MySQL
- **Iconos:** Material Icons
- **Validación:** Laravel Validation
- **Archivos:** Laravel Storage

## Próximas Mejoras Sugeridas

1. **Notificaciones por email/SMS**
2. **Recordatorios automáticos**
3. **Sistema de calificaciones**
4. **Chat en vivo con médicos**
5. **Historial médico digital**
6. **Prescripciones electrónicas**
7. **Integración con pasarelas de pago**
8. **App móvil nativa**

## Soporte y Mantenimiento

Para reportar bugs o solicitar nuevas funcionalidades, contactar al equipo de desarrollo.

---

**Desarrollado para el curso de Interacción Humano Computador**
**Hospital SaludIntegra - 2024** 