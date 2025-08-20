<!DOCTYPE html>
<html>
<head>
	<title>Registro de Taxista</title>

	<!-- Bootstrap y FontAwesome -->
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">

	<!-- Fuente -->
	<link href="https://fonts.googleapis.com/css?family=Numans" rel="stylesheet">

	<style>
		/* Estilos personalizados */
		html,body{
			background-image: url('https://i.ytimg.com/vi/WJIcpzvf1hM/maxresdefault.jpg');
			background-size: cover;
			background-repeat: no-repeat;
			height: 100%;
			font-family: 'Numans', sans-serif;
		}

		.container{
			height: 100%;
			align-content: center;
		}

		.card {
        margin: auto;
        width: 600px;
        max-height: 90vh; /* Limita la altura máxima */
        overflow-y: auto; /* Activa el scroll si se desborda */
        background-color: rgba(0,0,0,0.5) !important;
        color: white;
    }


		.card-header h3{
			color: white;
		}

		.input-group-prepend span{
			width: 50px;
			background-color: #FFC312;
			color: black;
			border: 0 !important;
		}

		input:focus {
			outline: none !important;
			box-shadow: none !important;
		}

		.login_btn {
			color: black;
			background-color: #FFC312;
			width: 100%;
		}

		.login_btn:hover {
			background-color: white;
			color: black;
		}

		label {
			color: #ccc;
		}

		.form-check-label {
			color: #ccc;
		}

		small.text-danger {
			color: #ff6b6b !important;
		}
	</style>
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
						<label>Nombre completo</label>
						<input type="text" name="name" class="form-control" required>
						@error('name') <small class="text-danger">{{ $message }}</small> @enderror
					</div>

					<div class="form-group">
						<label>Correo electrónico</label>
						<input type="email" name="email" class="form-control" required>
						@error('email') <small class="text-danger">{{ $message }}</small> @enderror
					</div>

					<div class="form-group">
						<label>Teléfono</label>
						<input type="text" name="telefono" class="form-control" required>
						@error('telefono') <small class="text-danger">{{ $message }}</small> @enderror
					</div>

					<div class="form-group">
						<label>Dirección</label>
						<input type="text" name="direccion" class="form-control" required>
						@error('direccion') <small class="text-danger">{{ $message }}</small> @enderror
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

					<div class="form-group">
						<label>Licencia de conducir</label>
						<input type="file" name="licencia" class="form-control-file" required>
						@error('licencia') <small class="text-danger">{{ $message }}</small> @enderror
					</div>

					<div class="form-group">
						<label>Tarjeta de circulación</label>
						<input type="file" name="tarjeta_circulacion" class="form-control-file" required>
						@error('tarjeta_circulacion') <small class="text-danger">{{ $message }}</small> @enderror
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
