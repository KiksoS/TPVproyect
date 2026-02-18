<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . "/php/autoloader.php";
$security = new Security();
//para comprobar si estas logeado
$security->checkLoggedIn();

$category = isset($_SESSION["categoria"]) ? $_SESSION["categoria"] : "Cafes";
$mesa = isset($_SESSION["mesa"]) ? $_SESSION["mesa"] : "";
$idTicket = isset($_SESSION["idTicket"]) ? $_SESSION["idTicket"] : 0;
$proRepository = new productRepository;
$tickRepository = new TicketRepository;

?>

<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
	<link href="./Assets/css/index.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">
	
	<title>La vaquita</title>
</head>

<body class="vh-min-100 d-flex flex-column">
	<header>
		<!-- nav -->
<nav class="navbar navbar-expand-lg bg-dark" data-bs-theme="dark">
	<div class="container-fluid">

		<a class="navbar-brand" href="#">
			<img src="./Assets/imgs/mesas/logo2.png" alt="Logo" width="55" height="55">
		</a>

		<button class="navbar-toggler" type="button"
			data-bs-toggle="collapse"
			data-bs-target="#navbarSupportedContent"
			aria-controls="navbarSupportedContent"
			aria-expanded="false"
			aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center">

				<li class="nav-item">
					<a class="nav-link active" href="index.php">INICIO</a>
				</li>

				<li class="nav-item">
					<a class="nav-link" href="empleados.php">EMPLEADOS</a>
				</li>

				<li class="nav-item">
					<a class="nav-link" href="caja.php" onclick="return false;">CAJA</a>
				</li>

				<li class="nav-item ms-lg-3">
					<a class="nav-link p-0" href="destroySession.php">
						<img src="./Assets/imgs/log-out.png" alt="Logout" width="40" height="40">
					</a>
				</li>

			</ul>
		</div>

	</div>
</nav>

	</header>

	<!-- MAIN -->
	<main>
		<div class="container">
			<div class="row text-center min-vh-100">
				<!-- LATERAL -->
				<div class="col-12 col-md-3 col-lg-2 bg-dark">
					<ul class="list-unstyled mt-4 lateral">
						<?php
						$categories = $proRepository->getAllCategory();
						foreach ($categories as $cat) {
							print "<li class='pt-5'><a class='text-white text-decoration-none ' href='/categoria.php?categoria=$cat'>$cat</a></li>";
						}
						?>
					</ul>
				</div>
				<!-- CENTRO -->
				<div class="col-12 col-md-8 col-lg-7">
					<div class="container py-4">
						<div class="row text-center ">
							<?php
							if ($mesa == "") {

								print "<h1> Selecciona un numero de Mesa</h1>";
							} else {
								print "<h2 class='mb-4'>MESA $mesa</h2>";
								print $proRepository->drawProductCard($proRepository->getAllCategoryProduct($category));
							}

							?>
						</div>
					</div>
				</div>
				<!-- ASIDE -->
				<div class="col-12 col-lg-3 bg-light">

					<div class="row gy-1 py-1">
						<div class="col-12 text-center py-2">
							<h3 class="m-0 "> MESAS </h3>
						</div>
						<?php for ($i = 1; $i <= 10; $i++): ?>
						<div class="col-6 col-lg-4 mesa">
							<a href="/mesa.php?mesa=<?php echo $i ?>T">
								<img class="img-fluid" src="./Assets/imgs/mesas/<?php echo $i ?>.png" alt="mesa <?php echo $i ?>">
							</a>
						</div>
						<?php endfor; ?>


					</div>
					<div class="row gy-1 py-1">
						<?php for ($i = 1; $i <= 10; $i++): ?>
						<div class="col-6 col-lg-4 mesa">
							<a href="/mesa.php?mesa=<?php echo $i ?>T">
								<img class="img-fluid" src="./Assets/imgs/mesas/<?php echo $i ?>.png" alt="mesa <?php echo $i ?>">
							</a>
						</div>
						<?php endfor; ?>
					</div>
					<!-- Ticket -->
					<div class="row">
						<div class="col-12 text-center bg-dark text-white pt-2">
							<p>TICKET<?php print "   $idTicket" ?></p>
						</div>
						<div class="row ticket text-center">
							<div class="col flex-column ">
								<?php print $tickRepository->drawPreticket($idTicket) ?>


								<?php  if (!empty($tickRepository->getPreticket($idTicket))):
										print "<button class='btn btn-dark bticket' id='open-popup'>Detalles del ticket</button>";
									endif; ?>
								<div class="popup-overlay"></div>
								<div class="popup">
									<button id="close-popup" style="float:right;margin-bottom:20px;">X</button>
									<h2><?= "TICKET" . "\n" . $mesa ?></h2>
									<p>
										<?= $tickRepository->drawTicket($idTicket) ?>
									</p>
									<br>
									<a href="cerradoTicket.php?id=<?php echo $idTicket; ?>"><button class="btn btn-dark">Enviar</button></a>
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
	</main>
	<script src="./Assets/js/index.js"></script>
	<script src="./Assets/js/PopUp.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>