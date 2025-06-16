<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso Personal - Hospital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .login-container {
            max-width: 500px;
            margin: 5rem auto;
            padding: 2rem;
            background: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .hospital-logo {
            text-align: center;
            margin-bottom: 1.5rem;
        }
        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-container">
            <div class="hospital-logo">
                <h3 class="text-primary">Sistema Hospitalario</h3>
                <p class="text-muted">Acceso exclusivo para personal</p>
            </div>

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('login.personal') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="document_id" class="form-label">DNI</label>
                    <input 
                        type="text" 
                        class="form-control" 
                        name="document_id" 
                        id="document_id" 
                        maxlength="8" 
                        inputmode="numeric" 
                        pattern="\d{8}"
                        required
                        oninput="this.value = this.value.replace(/\D/g, '').slice(0, 8);"
                        title="Ingrese 8 dígitos numéricos"
                        placeholder="Ingrese su DNI"
                        autofocus
                    >
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label">Contraseña</label>
                    <input 
                        type="password" 
                        class="form-control" 
                        id="password" 
                        name="password" 
                        required
                        placeholder="Ingrese su contraseña"
                    >
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary py-2">Ingresar</button>
                </div>
            </form>

            <div class="mt-3 text-center">
                <small class="text-muted">Sistema seguro de gestión hospitalaria</small>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Validación del DNI antes de enviar el formulario
        document.querySelector('form').addEventListener('submit', function(e) {
            const dniInput = document.getElementById('document_id');
            if (!/^\d{8}$/.test(dniInput.value)) {
                e.preventDefault();
                dniInput.focus();
                alert('El DNI debe tener exactamente 8 dígitos numéricos');
            }
        });
    </script>
</body>
</html>