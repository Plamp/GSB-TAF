<?  $repInclude = './include/';
require($repInclude . "_init.inc.php");

require($repInclude . "_entete.inc.php");
require($repInclude . "_sommaire.inc.php");


?>
<html>
<head>
<meta http-equiv="content-type" content="text/html" charset="utf-8" />
<title>Validation des frais de visite</title>

<div id="contenu">
</head>
<body>
<h2>Validation des frais par visiteur</h2>
<?
// -------------------------------------------------------Validation de la fiche ------------------------------------------------//
if(isset($_POST["HorsClass"]) && $_POST["HorsClass"]=="Terminer")
{
	// Recuperation données

	$id=$_POST["id_Visiteur"];
	$mois=$_POST["reqMois"];

	$montant=$_POST["montant"];
	$nbJusti=$_POST["nbJusti"];

	//Requete

	$req="Update FicheFrais set montantValide=$montant , nbJustificatifs=$nbJusti, idEtat='VA' where idVisiteur='$id' and mois='$mois'";
	//echo $req;
	//Resultat

	$res=mysql_query($req);

}
// ------------------------------------------------Modification du hors forfait ------------------------------------------//
if(isset($_POST["FraisHorsForfait"]) && $_POST["FraisHorsForfait"]=="Modifier")
{
	// recuperation données

	$id=$_POST["id_Visiteur"];
	$mois=$_POST["reqMois"];
	$idHF=$_POST["id_HF"]; 

	$date=$_POST["hfDate1"];
	$lib=$_POST["hfLib1"];
	$montant=$_POST["hfMont1"];

	// Requete

	$req="Update LigneFraisHorsForfait set date='$date', libelle='$lib' , montant='$montant' where idVisiteur='$id' and mois='$mois' and id='$idHF'";

	//Resultat

	$res=mysql_query($req);

}
// -----------------------------------------------Suppression du hors forfait -----------------------------------------//
if(isset($_POST["FraisHorsForfait"]) && $_POST["FraisHorsForfait"]=="Supprimer")
{
	//recuperation données

	$id=$_POST["id_Visiteur"];
	$mois=$_POST["reqMois"];
	$idHF=$_POST["id_HF"];

	//Requete
	$req="Delete from LigneFraisHorsForfait where idVisiteur='$id' and mois='$mois' and id='$idHF'";

	//Resultat

	$res=mysql_query($req);

}
// ---------------------------------------------Modification des frais forfaits ------------------------------------------//
if(isset($_POST["FraisForfait"]) && $_POST["FraisForfait"]=="Modifier")
{
	// recuperation données
	$id=$_POST["id_Visiteur"];
	$mois=$_POST["reqMois"];

	$etape=$_POST["etape"];
	$km=$_POST["km"];
	$nuitee=$_POST["nuitee"];
	$repas=$_POST["repas"];

	//requetes

	$req1="Update LigneFraisForfait set quantite=$etape where idVisiteur='$id' and mois='$mois' and idFraisForfait='ETP'";
	$req2="Update LigneFraisForfait set quantite=$km where idVisiteur='$id' and mois='$mois' and idFraisForfait='KM'";
	$req3="Update LigneFraisForfait set quantite=$nuitee where idVisiteur='$id' and mois='$mois' and idFraisForfait='NUI'";
	$req4="Update LigneFraisForfait set quantite=$repas where idVisiteur='$id' and mois='$mois' and idFraisForfait='REP'";

	//Resultat

	$res1=mysql_query($req1);
	$res2=mysql_query($req2);
	$res3=mysql_query($req3);
	$res4=mysql_query($req4);

}


// ---------------------------------------------------AFFICHAGE--------------------------------------------------//

// ----------------------------------------------Visiteur selectionné -------------------------------------------//
if(isset($_POST["action"]) && $_POST["action"]=="Valider")
{
	?>
		<form name="SelectMois" method="POST" action="">
		<h3>Choisir le mois de la fiche de frais :</h3>
		</br> 
		<!--LISTE DEROULANTE VISITEURS-->
		<?
		$id=$_POST["lesVisiteurs"];
	$req="select * from Visiteur where id='$id'";
	$res=mysql_query($req);
	while($ligne=mysql_fetch_array($res))
	{

		$nom=$ligne["nom"];
		$prenom=$ligne["prenom"];

	}
	?>
		<input type="text" disabled name="id_visiteur" value="<?=$nom." ".$prenom?>" />
		<input type="hidden" name="id_Visiteur" value="<?=$id?>" />

		<!--FIN LISTE DEROULANTE VISITEURS-->

		<!--LISTE DEROULANTE MOIS-->
		<select name="lesMois" class="zone" method="POST">
		<?
		$req="select mois from FicheFrais where idVisiteur='$id' and idEtat='CL'";
	$res=mysql_query($req);
	while($ligne=mysql_fetch_array($res))
	{
		?><option value="<?=$ligne['mois']?>">
			<?echo $ligne['mois'];?>
			</option><?
	}
	?>
		</select>
		<!--FIN LISTE DEROULANTE MOIS-->
		<input type="submit" name="action" value="Suite" />
		</form>
		<?
}
// ----------------------------------------------------------- Mois selectionné -----------------------------------------//
else if(isset($_POST["action"]) && $_POST["action"]=="Suite")
{
	?>

		</br>
		<!--LISTE DEROULANTE VISITEURS-->
		<?
		$id=$_POST["id_Visiteur"];
	$req="select * from Visiteur where id='$id'";
	$res=mysql_query($req);
	while($ligne=mysql_fetch_array($res))
	{

		$nom=$ligne["nom"];
		$prenom=$ligne["prenom"];

	}
	?>
		<input type="text" disabled name="id_visiteur" value="<?=$nom." ".$prenom?>" />
		<!--FIN LISTE DEROULANTE VISITEURS-->
		<!--------------------------------------------------------------------------------------------!>

		<!--LISTE DEROULANTE MOIS-->
		<?
		$mois=$_POST["lesMois"];
	?>
		<input type="text" name="Mois" value="<?=$mois?>" disabled />
		<!--FIN LISTE DEROULANTE MOIS-->

		<form name="formValidFrais" method="post" action="">
		<input type="hidden" name="reqMois" value="<?=$mois?>" />
		<input type="hidden" name="id_Visiteur" value="<?=$id?>" />
		</br>		
		<h2>Frais au forfait </h2>
		</br>
		<!--                   requete                     --!>


		<?
		$montantTF=0;
	$request=mysql_query("select * from LigneFraisForfait inner join FraisForfait on LigneFraisForfait.idFraisForfait=FraisForfait.id where idVisiteur='$id' and mois='$mois'");

	while($line=mysql_fetch_array($request))
	{
		if($line['idFraisForfait']=='REP')
		{
			$montant=$line["montant"];
			$repas=$line['quantite'];
			$montantTF=$montantTF+$montant*$repas;
		}
		if($line['idFraisForfait']=='NUI')
		{
			$montant=$line["montant"];
			$nuitee=$line['quantite'];
			$montantTF=$montantTF+$montant*$nuitee;	
		}
		if($line['idFraisForfait']=='ETP')
		{
			$montant=$line["montant"];
			$etape=$line['quantite'];
			$montantTF=$montantTF+$montant*$etape;
		}
		if($line['idFraisForfait']=='KM')
		{
			$montant=$line["montant"];
			$km=$line['quantite'];
			$montantTF=$montantTF+$montant*$km;
		}
	}
	?>
		<table style="color:white;" border="1">
		<tr><th>Etape</th><th>KM</th><th>Nuits</th><th>Repas</th><th>Modification</th></tr>
		<tr align="center"><td width="150" ><input type="text" size="3" name="etape" value="<?=$etape?>"/></td>
		<td width="150"><input type="text" size="3" name="km" value="<?=$km?>"/></td> 
		<td width="150"> <input type="text" size="3" name="nuitee" value="<?=$nuitee?>"/></td>
		<td width="150"> <input type="text" size="3" name="repas"  value="<?=$repas?>"/></td>
		<td><input type="submit" name="FraisForfait" value="Modifier"/></td>
		</tr>
		</table>
		</form>
		</br>
		<h2>Hors Forfait</h2>
		</br>
		<table style="color:white;" border="1">
		<tr><th>Date</th><th>Libelle</th><th>Montant</th><th>Suppression</th><th>Modification</th></tr>

		<?
		$montantTHF=0;
	$req=mysql_query("select * from LigneFraisHorsForfait where idVisiteur='$id' and mois='$mois'");
	while($line=mysql_fetch_array($req))
	{
		$lib=$line['libelle'];
		$date=$line['date'];
		$montant=$line['montant'];
		$idHF=$line["id"];
		?>
			<form name="FormValidHorsForfait" method="POST" action="" >
			<input type="hidden" name="reqMois" value="<?=$mois?>" />
			<input type="hidden" name="id_Visiteur" value="<?=$id?>" />

			<tr align="center">
			<td width="100" ><input type="text" size="8" name="hfDate1" value="<?=$date?>"/></td>
			<td width="120"><input type="text" size="20" name="hfLib1" value="<?=$lib?>"/></td>
			<td width="90"> <input type="text" size="10" name="hfMont1" value="<?=$montant?>"/></td>
			<td width="80">
			<input type="Submit" name="FraisHorsForfait" value="Supprimer" />                                         
			</td>
			<td><input type="submit" name="FraisHorsForfait" value="Modifier"/></td>
			</tr>
			<input type="hidden" name="id_HF" value="<?=$idHF?>" />
			<?
			$montantTHF=$montantTHF+$montant;
		?>
			</form>
			<?
	}
	?>
		</table>
		</form>
		<form name=HorsClass method="POST" action"" >
		<input type="hidden" name="reqMois" value="<?=$mois?>" />
		<input type="hidden" name="id_Visiteur" value="<?=$id?>" />

		<p class="titre"></p>
		Nb Justificatifs: <input type="text" class="zone" size="4" name="nbJusti"/> Montant à rembourser: <?echo $montantTF+$montantTHF ?> 
		<input type="hidden" name="montant" value="<?=$montantTF+$montantTHF?>" />

		<p class="titre" /><label class="titre">&nbsp;</label><input class="zone"type="reset" /><input type="submit" name="HorsClass" value="Terminer"  />
		</form>

		<?
}
// -------------------------------------------------- Visiteur non selectionné ------------------------------------------//
else
{

	?> 
		<h3> Choisir le visiteur :</h3>
		<form name="choixVisiteur" method="POST" action="">


		<!--LISTE DEROULANTE VISITEURS-->
		<select name="lesVisiteurs" class="zone" method="POST">
		<?
		$req="select * from Visiteur inner join FicheFrais on Visiteur.id = FicheFrais.idVisiteur where typeMembre=0 and idEtat='CL'";
	$res=mysql_query($req);
	while($ligne=mysql_fetch_array($res))
	{
		?>
			<option value=<?=$ligne['id']?>>
			<?echo $ligne['nom']." ".$ligne['prenom'];?>
			</option>
			<?
	}
	?>
		</select>
		<!--FIN LISTE DEROULANTE VISITEURS-->
		<!--------------------------------------------------------------------------------------------!>
		<input type="submit" name="action" value="Valider">
		</form>
		<?
}
?>
</div>
</body>
<?

require($repInclude . "_pied.inc.html");
require($repInclude . "_fin.inc.php");
?>


</html>
