		<!DOCTYPE HTML>
		<html lang="pt-BR">
		<head>
			<meta charset="UTF-8">
			<title>Crachá - Flex Virtual Airlines </title>
			<meta property="og:title" content="Cartão Identificação Flex Virtual Airlines" />
		</head>

		<body>
			<div>
				<?php
				$nome = "2";
				$prefixo = "JDDLLLL";

				$endereco = 'cards/' . $prefixo . '.png';

				$validador = file_exists($endereco);

				?>

				<form action="cartao.php" method="POST" enctype="multipart/form-data">


					<input type="hidden" name="nome" value="<?php echo $nome ?>"> <p />
					<input type="hidden" name="exp" placeholder="01/2016"> <p />
					<input type="hidden" name="natural" size=15 maxlength=15 placeholder="Brasiliense" > <p />
					<input type="hidden" name="cargo" size=3 maxlength=3 style="text-transform:uppercase" placeholder="CEO" > <p />
					<input type="hidden" name="prefixo" size=7 maxlength=7 style="text-transform:uppercase" value="<?php echo $prefixo ?>"> <p />
					<label>Foto 3x4 <b>(Deve possuir tamanho próximo de [4.62cm X 4.8cm] ou [131px X 136px]) <b>:</label>
					<input type="file" name="fileUpload" accept="image/*">

					<input type="submit" value="<?php if ($validador == TRUE){echo "Renovar";} else {echo "Criar";} ?>">


				</form>


				<?php



				if ($validador == TRUE){

					echo "<img src='$endereco'/>";
				} else {
					$endereco = 'cards/padrao.png';

					echo "<img src='$endereco'/>";
					echo "Voce ainda nao possui cartao criado! Selecione criar para que o cartao seja gerado!";
				}

				?>
			</div>
		</body>
		</html>

