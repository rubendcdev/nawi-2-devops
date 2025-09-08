<!DOCTYPE html>
<html>
<head>
	<title>Login Page</title>

	<!-- Bootstrap 4 CDN -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    
	<!-- FontAwesome CDN -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">

	<!-- Estilos personalizados -->
	<style>
		body, html {
			height: 100%;
			margin: 0;
			background-image: url('https://i.ytimg.com/vi/WJIcpzvf1hM/maxresdefault.jpg');
			background-size: cover;
			background-position: center;
			background-repeat: no-repeat;
			font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
		}

		.container {
			height: 100%;
			display: flex;
			align-items: center;
			justify-content: center;
		}

		.card {
			background-color: rgba(0, 0, 0, 0.7);
			color: white;
			width: 400px;
			border-radius: 10px;
			box-shadow: 0 4px 15px rgba(0, 0, 0, 0.7);
		}

		.card-header h3 {
			text-align: center;
		}

		.input-group-text {
			background-color: #ffc107;
			color: black;
		}

		.login_btn {
			background-color: #ffc107;
			color: black;
			font-weight: bold;
			transition: 0.3s ease;
		}

		.login_btn:hover {
			background-color: #e0a800;
			color: white;
		}

		.remember {
			color: #ccc;
			font-size: 0.9rem;
			margin-top: 10px;
		}
	</style>
</head>
<body>
<div class="container">
	<div class="card">
		<div class="card-header">
			<h3>Inicio de Sesión</h3>
		</div>
		<div class="card-body">
			<form action="{{ route('login') }}" method="post">
				@csrf 
				<div class="input-group form-group">
					<div class="input-group-prepend">
						<span class="input-group-text"><i class="fas fa-user"></i></span>
					</div>
					<input type="text" class="form-control" placeholder="Correo" name="email" required>
				</div>
				<div class="input-group form-group">
					<div class="input-group-prepend">
						<span class="input-group-text"><i class="fas fa-key"></i></span>
					</div>
					<input type="password" class="form-control" placeholder="Contraseña" name="password" required>
				</div>
				<div class="row align-items-center remember">
					<input type="checkbox" name="remember"> Recordar contraseña
				</div>
				<div class="form-group mt-3">
					<input type="submit" value="Ingresar" class="btn float-right login_btn">
				</div>
			</form>
		</div>
	</div>
</div>
</body>
</html>
