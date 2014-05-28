<?php
$hote ="127.0.0.1" ;
$user ="root";
$mdp  ="";
$db='db_gestioncr';
mysql_connect($hote,$user, $mdp);
mysql_select_db($db);
//________________________________________________________________________________________________________________________________//
//-----------------------------------------------------------Gestion des praticiens-----------------------------------------------//
//________________________________________________________________________________________________________________________________//
function AfficherPrat($id)
{
$reponse = new xajaxResponse();//Création d'une instance de xajaxResponse pour traiter les réponses serveur

$prat='';// Initialisation de la variable $prat
//la selection des information selon le nom et code du praticien choisis
$req = mysql_query("SELECT * FROM `praticien` where PRA_CODE='".$id."' ") or die(mysql_error()); 



 while($array = mysql_fetch_array($req))
{
	$prat='	
		<form id="formPraticien">
		<table border=0 font:white>
		<tr><td style="color:white;">Nom : </td><td><input type="text" size="20" name="PRA_NOM"   id="PRA_NOM" value="'.$array['PRA_NOM'].'"></td></tr>	
		<tr><td style="color:white;">Prenom : </td><td><input type="text" size="20" name="PRA_PRENOM"   id="PRA_PRENOM" value="'.$array['PRA_PRENOM'].'"></td></tr>
		<tr><td style="color:white;">Adresse : </td><td><input type="text" size="20" name="PRA_ADRESSE"  id="PRA_ADRESSE" value="'.$array['PRA_ADRESSE'].'"></td></tr>
		<tr><td style="color:white;">Code Postal : </td> <td><input type="text" size="20" name="PRA_CP"   id="PRA_CP" value="'.$array['PRA_CP'].'"></td></tr>
		<tr><td style="color:white;">Ville : </td><td><input type="text" size="20" name="PRA_VILLE"   id="PRA_VILLE" value="'.$array['PRA_VILLE'].'"></td>	</tr>
		<tr><td style="color:white;">Coefficient : </td><td><input type="text" size="20" name="PRA_COEFNOTORIETE"   id="PRA_COEFNOTORIETE" value="'.$array['PRA_COEFNOTORIETE'].'"></td></tr>
		';
		$req2=mysql_query("SELECT TYP_LIBELLE FROM `TYPE_PRATICIEN` where TYP_CODE='".$array['TYP_CODE']."' ") or die(mysql_error()); 
		 while($array2 = mysql_fetch_array($req2))
			{
			$prat .='<tr><td style="color:white;">Fonction: </td> <td><input type="text" size="20" name="TYP_LIBELLE"   id="TYP_LIBELLE" value="'.$array2['TYP_LIBELLE'].'"></td></tr>';		
			}
		$prat .='</table></form>';
               
}
$reponse = new xajaxResponse('ISO-8859-1');
$reponse->addAssign("affPrat","innerHTML",$prat); // affichage du contenu de $prat  dans la div affPrat
return $reponse->getXML();
}

require("xajax.inc.php");
$xajax = new xajax(); //On initialise l'objet xajax
$xajax->setCharEncoding('ISO-8859-1');
$xajax->decodeUTF8InputOn();
$xajax->registerFunction("AfficherPrat");
$xajax->processRequests();//Fonction qui va se charger de faire les requetes APRES AVOIR DECLARER NOS FONCTIONS
?>
<html><head>
<?php 
$xajax->printJavascript(); /* Affiche le Javascript */
//--------------------------------------------------------------------------------------------------------------------//
//--------------------------------------------------------------fin ajax----------------------------------------------//
//--------------------------------------------------------------------------------------------------------------------//
?>
	<title>formulaire PRATICIEN</title>
</head>
<?php
include "menuCR.php";
?>
<div name="droite" style="float:left;width:80%;">
	<div name="bas" style="margin : 10 2 2 2;clear:left;background-color:77AADD;color:white;height:88%;">
		<h1> Praticiens </h1>
		<form name="formListeRecherche" >
			<select name="lstPrat" class="titre" id="PRA_NUM" onChange="xajax_AfficherPrat(document.getElementById('PRA_NUM').value);">
            <option value="00">Selectionnez le praticien</option>
	<?php
$requetePraticien="select * from praticien ";
$resultatPraticien=mysql_query($requetePraticien);
while($maLigne=mysql_fetch_array($resultatPraticien))
{
	$idPrat=$maLigne["PRA_CODE"];
	$nomPrat=$maLigne["PRA_NOM"];
	$prenomPrat=$maLigne["PRA_PRENOM"];


	?>			
    
		<option value="<?php echo $idPrat?>"><?php echo $nomPrat." ".$prenomPrat?></option>
       
		<?php		
}	

	//Coefficient

?>
 
</select>	
<?
//____________________________________________________________________________________________________________________________________________//
//-------------------------------------------------------Remplissage des info du praticiens --------------------------------------------------//
//____________________________________________________________________________________________________________________________________________//

?> <div id="affPrat" style="margin : 10 2 2 2;clear:left;background-color:77AADD;color:'white';height:88%;" ></div>
<?php 
//--------------------------------------------------------------------------------------------------------------------------------------------------//
//----------------------------------------------------------------Fin info--------------------------------------------------------------------------//
//--------------------------------------------------------------------------------------------------------------------------------------------------//
?>

	
	</div>
</div>
</body>
</html>