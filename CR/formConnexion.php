<?php session_start();


	/* This script will allow users which there're triing to connect, and it will get the user's statut */

	//Atempt to connect on the user's table

	$host					= '127.0.0.1';
	$db						= 'db_gestionCR';

	$mdp					= '';
	$usr					= 'root';

	mysql_connect($host, $usr, $mdp);
	mysql_select_db($db);



	if ((ISSET($_POST['loginSub'])) && ($_POST['loginSub']=="Connexion"))
	{
		$mdpCon = $_POST['loginMdp'];
		$usrCon = $_POST['loginMat'];
		$sqlLogin = "SELECT VIS_MATRICULE, VIS_DATEEMBAUCHE FROM VISITEUR WHERE VIS_MATRICULE = '$usrCon' AND VIS_DATEEMBAUCHE = '$mdpCon'";
		$sqlResult = mysql_query($sqlLogin);
		$sqlLine = mysql_fetch_array($sqlResult);
		
		$VerifMat=$sqlLine['VIS_MATRICULE'];
		$VerifMDP = $sqlLine['VIS_DATEEMBAUCHE'];
		if ((!EMPTY($VerifMat)) && (!EMPTY($VerifMDP)))
			{
			$_SESSION['visMatricule']=$VerifMat;
				header('Location: formRAPPORT_VISITE.php');
				
			}
		else
			{
				echo "<font color='red'>Erreur combinaison Login / Mot de Passe";
				echo ($sqlLogin);
			}

	}

	?>
	<html>

	<head>
		<title>
			Connexion - GSB
		</title>
	</head>
		
	<body bgcolor="#B4C7E8">
	<img src="./images/logo.png" />

	<div id="form" style="display:block; margin-left:37%; margin-right:40%; border:2; border-style:solid; padding:5px; background-color:#7AAFFF">
		<form name="fLogin" method="post">
		
		<table >
		
			<tr>
				<td>
					Matricule :
				</td>
				<td>
				<input type="text" name="loginMat" />
				</td>
			</tr>
			
			<tr>
				<td>
					Mot de passe :
				</td>
				<td>
				<input type="password" name="loginMdp" />
				</td>
			</tr>
			
			<tr>
				<td></td>
				<td align="right"><input type="submit" name="loginSub" value="Connexion" />
			</tr>
			
		</table>
		
		</form>
	</div>
	</body>
	</html>
