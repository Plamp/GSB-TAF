<?php
$hote="127.0.0.1";
$user="root";
$mdp ="";
$db='db_gestionCR';
mysql_connect($hote,$user,$mdp);
mysql_select_db($db);
require("xajax.inc.php");
//________________________________________________________________________________________________________________________________//
//-----------------------------------------------------------Gestion des visiteurs------------------------------------------------//
//________________________________________________________________________________________________________________________________/
function AfficherInfo($id){
$reponse2=new xajaxResponse();//Création d'une instance de xajaxResponse pour traiter les réponses serveur
$info='';// Initialisation de la variable $info
//la selection des information selon le nom et code du praticien choisis
$req2=mysql_query("SELECT VIS_NOM,VIS_PRENOM,VIS_ADRESSE,VIS_CP,VIS_VILLE,SEC_CODE FROM `VISITEUR` where VIS_MATRICULE='".$id."'ORDER BY VIS_NOM "); 
while($array = mysql_fetch_array($req2))
{
$info .='<label class="titre">NOM :</label><input type="text" size="25" name="VIS_NOM" class="zone "value="'.$array['VIS_NOM'].'" />
<label class="titre">PRENOM :</label><input type="text" size="50" name="Vis_PRENOM" class="zone" value="'.$array['VIS_PRENOM'].'" />
<label class="titre">ADRESSE :</label><input type="text" size="50" name="VIS_ADRESSE" class="zone" value="'.$array['VIS_ADRESSE'].'"/>
<label class="titre">CP :</label><input type="text" size="5" name="VIS_CP" class="zone" value="'.$array['VIS_CP'].'" />
<label class="titre">VILLE :</label><input type="text" size="30" name="VIS_VILLE" class="zone" value="'.$array['VIS_VILLE'].'" />';

}$reponse2=new xajaxResponse('ISO-8859-1');
$reponse2->addAssign("affInfo","innerHTML",$info); // affichage du contenu de $visiteur  dans la div affInfo
return $reponse2->getXML();
}
//________________________________________________________________________________________________________________________________//
//-----------------------------------------------------------Gestion des Visiteurs------------------------------------------------//
//________________________________________________________________________________________________________________________________//?>
<?php
function AfficherVisiteur($id)
{
$reponse = new xajaxResponse();//Création d'une instance de xajaxResponse pour traiter les réponses serveur
$Visiteur='';// Initialisation de la variable $prat
//la selection des information selon le nom et code du praticien choisis
$req = mysql_query("SELECT VIS_MATRICULE,VIS_NOM,VIS_PRENOM FROM VISITEUR where DEP_CODE='".$id."' ORDER BY VIS_NOM") or die(mysql_error()); 
$Visiteur .='<select id="idVisiteur" onChange="xajax_AfficherInfo(this.value);">';// on commence la declaration de la liste des Visiteurs.
$Visiteur .='<option value="00">Selectionnez le/la visiteur</option>';
while($array= mysql_fetch_array($req))
{$Visiteur .='<option value="'.$array['VIS_MATRICULE'].'">'.$array['VIS_NOM'].' '.$array['VIS_PRENOM'].'</option>';         
}
$Visiteur .='</select><br>';

$reponse = new xajaxResponse('ISO-8859-1');
$reponse->addAssign("affVisiteur","innerHTML",$Visiteur); // affichage du contenu de $Visiteur  dans la div affVisiteur
return $reponse->getXML();
}
$xajax = new xajax(); //On initialise l'objet xajax
$xajax->setCharEncoding('ISO-8859-1');
$xajax->decodeUTF8InputOn();
$xajax->registerFunction("AfficherVisiteur");
$xajax->registerFunction("AfficherInfo");
$xajax->processRequests("AfficherVisiteur","AfficherInfo");//Fonction qui va se charger de faire les requetes APRES AVOIR DECLARER NOS FONCTIONS
?><html><head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<?php 
$xajax->printJavascript(); /* Affiche le Javascript */
//--------------------------------------------------------------------------------------------------------------------//
//--------------------------------------------------------------fin ajax----------------------------------------------//
//--------------------------------------------------------------------------------------------------------------------//
?>
	<title>formulaire VISITEUR</title>
	<style type="text/css">
		<!-- body {background-color: white; color:5599EE; } 
			.titre { width : 180 ;  clear:left; float:left; } 
			.zone { width : 30car ; float : left; color:7091BB } -->
	</style>
</head>
<body>
<div name="haut" style="margin: 2 2 2 2 ;height:6%;"><h1><img src="logo.jpg" width="100" height="60"/>Gestion des visites</h1></div>
<div name="gauche" style="float:left;width:18%; background-color:white; height:100%;">
	<h2>Outils</h2>
	<ul><li>Comptes-Rendus</li>
		<ul>
			<li><a href="formRAPPORT_VISITE.php" >Nouveaux</a></li>
			<li>Consulter</li>
		</ul>
		<li>Consulter</li>
		<ul><li><a href="formMEDICAMENT.php" >M&eacute;dicaments</a></li>
			<li><a href="formPRATICIEN.php" >Praticiens</a></li>
			<li><a href="formVISITEUR.php" >Autres visiteurs</a></li>
		</ul>
	</ul>
</div>
<div name="droite" style="float:left;width:80%;">
	<div name="bas" style="margin : 10 2 2 2;clear:left;background-color:77AADD;color:white;height:88%;">

		<h1> Visiteurs </h1>
        <select name="lstDept" id="lstDept1" class="titre" onClick="xajax_AfficherVisiteur(this.value);">
        <?php
		$reqDepartement="Select DEP_CODE,DEP_NOM from DEPARTEMENT";
		$resDepartement=mysql_query($reqDepartement);
		while($Ligne=mysql_fetch_array($resDepartement))
		{
			?>
        <option value="<?=$Ligne['DEP_CODE']?>"><?php echo($Ligne['DEP_NOM']);?></option>
		<?php
        }
	
		?>
		</select>
      
		<div name="affVisiteur" id="affVisiteur" ></div>
        <br />
        <div name="affInfo" id="affInfo"></div>
	
	
	</div>
</div>
</body>
</html>