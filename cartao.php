<?php
require ('lib/WideImage.php');

error_reporting(0);
ini_set('default_charset', 'UTF-8');

			// valida passagem de valores
			// nome do usuario

if (isset($_POST['nome'])) {
	$nome = $_POST['nome'];
}
else {
	$nome = NULL;
}

			// quando foi expedido o cartao

if (strlen($_POST['exp']) > 0) {
	$exp = date('m/Y', strtotime($_POST['exp']));
}
else {
	$exp = " ";
}

			// naturalidade

if (isset($_POST['natural'])) {
	$natural = $_POST['natural'];
}
else {
	$natural = " ";
}

			// possição social dentro da organição

if (isset($_POST['cargo'])) {
	$upword = strtoupper($_POST['cargo']);
	$cargo = $upword . ' - Flex Virtual Airlines';
}
else {
	$cargo = " ";
}

			// código identificador do cartao

if (isset($_POST['prefixo'])) {
	$prefixo = strtoupper($_POST['prefixo']);
}
else {
	$prefixo = " ";
}

			// imagem 3x4 do usuario


if (isset($_FILES['fileUpload']) AND $_FILES['fileUpload']['size'] > 0 ) {

				// Guardando imagem na pasta FOTO

				$ext = strtolower(substr($_FILES['fileUpload']['name'], -4)); //Pegando extensão do arquivo
				$nome_arq = 'foto/' . 'foto3x4' . $ext;
				move_uploaded_file($_FILES['fileUpload']['tmp_name'], $nome_arq); //Fazer upload do arquivo

				// Cortando imagem foto3x4 (WideImage)

				$img = WideImage::load($nome_arq);
				$img = $img->resize(131, 132, 'fill', 'down');
				$img->saveToFile('foto/foto_cortada.gif');
				$img->destroy();

				// Utilizando foto3x4 cortada para formar CARD ID (GD Padrao)

				$img1 = imagecreatefromgif('foto/foto_cortada.gif');
			}
			else {
				$img1 = imagecreatefrompng('padrao.png');
			}

			// Abrindo uma imagem existente
			// foto 3x4
			// A imagem do rosto deve ter 4.62cm(largura) por 4.80cm(comprimento), para funcionar
			// foto base do cartao

			$img2 = imagecreatefrompng('flex1.png');

			// Cor texto

			$textcolor = imagecolorallocate($img2, 9, 31, 81); // Cor branca
			$textcolor2 = imagecolorallocate($img2, 255, 255, 255);

			// Nome da fonte a ser usada

			$font = 'arial.ttf';

			// Textos Fixos

			imagettftext($img2, 13, 0, 175, 110, $textcolor, $font, "Nome:");
			imagettftext($img2, 13, 0, 175, 130, $textcolor, $font, "EXP.:");
			imagettftext($img2, 13, 0, 175, 150, $textcolor, $font, "Natural:");
			imagettftext($img2, 13, 0, 175, 170, $textcolor, $font, "Cargo:");

			// Textos Variavel

			imagettftext($img2, 12, 0, 240, 110, $textcolor2, $font, $nome);
			imagettftext($img2, 12, 0, 240, 130, $textcolor2, $font, $exp);
			imagettftext($img2, 12, 0, 240, 150, $textcolor2, $font, $natural);
			imagettftext($img2, 11, 0, 240, 170, $textcolor2, $font, $cargo);

			// Prefixo

			imagettftext($img2, 13, 0, 185, 240, $textcolor2, $font, $prefixo);

			// Colar imagem 4x4

			imagecopymerge($img2, $img1, 19, 90, 0, 0, imagesx($img1) , imagesy($img1) , 100);


			$endereco = 'cards/' . $prefixo . '.png';
			// verifica a existenia de um arquivo igual no servidor
			if (file_exists($endereco) == 0){

				//salva imagem no servidor

			 imagepng($img2, $endereco, 9);

		 } else {
			unlink($endereco);

				//salva imagem no servidor

			imagepng($img2, $endereco, 9);

		}

			// Remove cache
		imagedestroy($img1);
		imagedestroy($img2);
		unlink('foto/foto3x4.png');
		unlink('foto/foto3x4.jpg');
		unlink('foto/foto_cortada.gif');
			//clearstatcache();

		$redirect = "http://www.voeflexvirtual.com.br/index.php/profile/";
		header("location:$redirect");
		?>