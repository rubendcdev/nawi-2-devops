<!DOCTYPE html>
<html>
<head>
	<title>Registro de Taxista</title>

	<!-- Bootstrap y FontAwesome -->
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">

	<!-- Estilos de autenticación -->
	<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>
<div class="container">
	<div class="d-flex justify-content-center h-100">
		<div class="card p-4">
			<div class="card-header text-center">
				<h3>Registro de Taxista</h3>
			</div>
			<div class="card-body">
				<form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
					@csrf

					<div class="form-group">
						<label>Nombre</label>
						<input type="text" name="name" class="form-control" required>
						@error('name') <small class="text-danger">{{ $message }}</small> @enderror
					</div>

					<div class="form-group">
						<label>Correo electrónico</label>
						<input type="email" name="email" class="form-control" required>
						@error('email') <small class="text-danger">{{ $message }}</small> @enderror
					</div>

					<div class="form-group">
						<label>Contraseña</label>
						<input type="password" name="password" class="form-control" required>
						@error('password') <small class="text-danger">{{ $message }}</small> @enderror
					</div>

					<div class="form-group">
						<label>Confirmar contraseña</label>
						<input type="password" name="password_confirmation" class="form-control" required>
					</div>
					<div class="form-check mb-3">
						<input type="checkbox" name="terminos" class="form-check-input" required>
						<label class="form-check-label">Acepto los términos y condiciones</label>
					</div>

					<div class="form-group">
						<button type="submit" class="btn login_btn">Registrarse</button>
					</div>
				</form>
			</div>
			<div class="card-footer text-center">
				¿Ya tienes una cuenta? <a href="{{ route('login') }}" class="text-warning">Inicia sesión aquí</a>
			</div>
		</div>
	</div>
</div>
</body>
</html>
