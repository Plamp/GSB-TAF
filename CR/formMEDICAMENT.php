<?php

//On utilise le formulaire de connexion à la BDD
//include('./include/classConnexion.php');

$host="127.0.0.1";
$user="root";
$mdp="";
$db="db_gestioncr";
mysql_connect("$host","$user","$mdp") or die(mysql_error());
mysql_select_db("$db");

	//------------------------------------//
	//On gère le nombre max de médicaments//
	//------------------------------------//
	$sqlMax="SELECT count(*) nombre FROM medicament";
	$resMax=mysql_query($sqlMax);
	$linMax=mysql_fetch_array($resMax);
	$nbMax=$linMax['nombre']-1;

		//------------------------------------//
		//	Bouton Précedent	      //
		//------------------------------------//

	//Si le bouton Précédent est utilisé
	if (ISSET($_POST['precedent']) && $_POST['precedent']="<" )
	{
	$num=$_POST['num'];
	//Si c'est pas le premier
		if(!$num==0)
		{
		$num=$num-1;
		}
		else //Sinon on l'envoie au dernier
		{
		$num=$nbMax;
		}
	}
	else
	{

		//------------------------------------//
		//		Bouton Suivant	      //
		//------------------------------------//

		//Si le bouton Précédent est utilisé
	if (ISSET($_POST['suivant']) && $_POST['suivant']=">")	
	{
		$num=$_POST['num'];
		//Si le nombre n'est pas le dernier
		if ($num!=$nbMax)
		{
		$num=$num+1;	
		}
		else //Sinon on l'envoie au premier
		{
		$num=0;
		}
	}
	else
	{
		if (!(ISSET($_POST['suivant'])) && (!(ISSET($_POST['precedent'])))) $num=0; 
		}
	}


	//-----------------------------------------------//
	//		Affichage des Medicaments	 //
	//---------------------------------------------- //

	//Script d'affichage des données des médicaments
	$sqlMedicament="SELECT MED_DEPOTLEGAL, MED_NOMCOMMERCIAL, MED_COMPOSITION, FAM_CODE, MED_EFFETS, MED_CONTREINDIC, MED_PRIXECHANTILLON FROM medicament LIMIT $num,1";
	echo $sqlMedicament;
	$resMedicament=mysql_query($sqlMedicament);

	//On récupère toutes les données qu'on stock dans des variables
	while($ligne=mysql_fetch_array($resMedicament))
	{
		$depotlegal=$ligne['MED_DEPOTLEGAL'];
		$nomcommercial=$ligne['MED_NOMCOMMERCIAL'];
		$famcode=$ligne['FAM_CODE'];
		$composition=$ligne['MED_COMPOSITION'];
		$effet=$ligne['MED_EFFETS'];
		$contreindic=$ligne['MED_CONTREINDIC'];
		$prixechantillon=$ligne['MED_PRIXECHANTILLON'];
		if(EMPTY($prixechantillon));
	}





?>
<html>
<head>
	<title>formulaire MEDICAMENT</title>
	<style type="text/css">
		<!-- body {background-color: white; color:5599EE; } 
			label.titre { width : 180 ;  clear:left; float:left; } 
			.zone { width : 30car ; float : left; color:7091BB } -->
	</style>
<?php
include "menuCR.php";
?>
<div name="droite" style="float:left;width:80%;">
	<div name="bas" style="margin : 10 2 2 2;clear:left;background-color:77AADD;color:white;height:88%;">
	<form name="formMEDICAMENT" method="post" action="formMEDICAMENT.php">
		<h1> Pharmacopee </h1>
		<input type="hidden" name="num" value="<?php echo $num?>" />
		<label class="titre">DEPOT LEGAL :</label><input type="text" size="10" name="MED_DEPOTLEGAL" class="zone" value="<?php echo $depotlegal?>"/>
		<label class="titre">NOM COMMERCIAL :</label><input type="text" size="25" name="MED_NOMCOMMERCIAL" class="zone" value="<?php echo $nomcommercial?>" />
		<label class="titre">FAMILLE :</label><input type="text" size="5" name="FAM_CODE" class="zone" value="<?php echo $famcode?>" />
		<label class="titre">COMPOSITION :</label><textarea rows="5" cols="50" name="MED_COMPOSITION" class="zone" ><?php echo $composition?></textarea>
		<label class="titre">EFFETS :</label><textarea rows="5" cols="50" name="MED_EFFETS" class="zone"><?php echo $effet?></textarea>
		<label class="titre">CONTRE INDIC. :</label><textarea rows="5" cols="50" name="MED_CONTREINDIC" class="zone"><?php echo $contreindic?></textarea>
		<label class="titre">PRIX ECHANTILLON :</label><input type="text" size="7" name="MED_PRIXECHANTILLON" class="zone" value="<?php IF (!EMPTY($prixechantillon)){ echo $prixechantillon;} else{ echo "0";}?>" />
		<label class="titre">&nbsp;</label><input class="zone" type="submit" name="precedent" value="<" /><input class="zone" type="submit" name="suivant" value=">" />
	</form>
	</div>
</div>
</body>
</html>
