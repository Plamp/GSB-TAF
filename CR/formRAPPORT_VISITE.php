<?php
session_start();
$hote ="127.0.0.1" ;
$user ="root";
$mdp  ="";
$db='db_gestioncr';

mysql_connect($hote,$user, $mdp);
mysql_select_db($db);
//________________________________________________________________________________________________________________________________//
//-----------------------------------------------------------Gestion du coefficient-----------------------------------------------//
//________________________________________________________________________________________________________________________________//
function AfficherCoef($id)
{
$reponse = new xajaxResponse();//Création d'une instance de xajaxResponse pour traiter les réponses serveur

$coef='';// Initialisation de la variable $coef
//la selection du coefficient selon le code du praticien choisis
$req = mysql_query("SELECT `PRA_COEFNOTORIETE` FROM `PRATICIEN` where PRA_CODE='".$id."' ") or die(mysql_error()); 

$coef .='<label class="titre">Coefficient:</label>'; 

 while($array = mysql_fetch_array($req))
{

               $coef .='<input type="text" size="6" name="PRA_COEFF" class="zone" disabled id="PRA_COEFF" value="'.$array['PRA_COEFNOTORIETE'].'">';
               
}
$reponse = new xajaxResponse('ISO-8859-1');
$reponse->addAssign("affCoef","innerHTML",$coef); // affichage du contenu de $coef  dans la div affCoef
return $reponse->getXML();
}

require("xajax.inc.php");
$xajax = new xajax(); //On initialise l'objet xajax
$xajax->setCharEncoding('ISO-8859-1');
$xajax->decodeUTF8InputOn();
$xajax->registerFunction("AfficherCoef");
$xajax->processRequests();//Fonction qui va se charger de faire les requetes APRES AVOIR DECLARER NOS FONCTIONS
?>
<html><head>

<?php 
$xajax->printJavascript(); /* Affiche le Javascript */
//--------------------------------------------------------------------------------------------------------------------//
//--------------------------------------------------------------fin ajax----------------------------------------------//
//--------------------------------------------------------------------------------------------------------------------//
//Si le bouton Valider est cliqué
if (isset($_POST['valider']) && ($_POST['valider'])=="Valider")
{

//On intègre les variables qui vont bien(
$rapNum=$_POST["RAP_NUM1"];


$motifId=$_POST["RAP_MOTIF"];
//Si le motif est autre, on l'insère avec l'id AUT+numAuto
if ($motifId=="AUT")
	{
		$numAut=1;
				do
		{
			
			$sqlGetAUT=("SELECT MOTIF_ID FROM motif WHERE MOTIF_ID like 'AUT".$numAut."';");
			
			$sqlGetAUTRes=mysql_query($sqlGetAUT);
			$sqlGetAUTTest=mysql_fetch_array($sqlGetAUTRes);
			if (!(empty($sqlGetAUTTest))) $numAut++;			
		}
		while(!(empty($sqlGetAUTTest)));
		
		$motifId="AUT$numAut";
		$motifLib=$_POST['RAP_MOTIFAUTRE'];
		$sqlMotifAUT=("INSERT INTO motif VALUES ('".$motifId."', '".$motifLib."');");
		echo $sqlMotifAUT;
		$sqlMotifAUTRes=mysql_query($sqlMotifAUT);
		}
$rapBilan=$_POST["RAP_BILAN"];
$rapDate=$_POST["RAP_DATE2"];
$dateVisite=$_POST["RAP_DATEVISITE"];

//Si le médecin est un remplaçant non répertorié
if (isset($_POST['PRA_REMPLACANT']) && $_POST['PRA_REMPLACANT']=="AUT") 
{ 
	$boolRempl=true;
	//On génère le numéro auto max du praticien (dernier numéro+1)
	$sqlNumPRA=("SELECT MAX(PRA_CODE)+1 bob FROM praticien;");
	$sqlNumPRARes=mysql_query($sqlNumPRA);
	$sqlGetNumPRA=mysql_fetch_array($sqlNumPRARes);
	$numPra=$sqlGetNumPRA['bob'];
	$nomRempl=$_POST["PRA_REMPLACANT_AUT"];
	$prenomRempl=$_POST["PRA_REMPLACANT_AUT_PRENOM"];
	
	//On insère ces nouvelles données dans la table praticien
	$sqlInsertPraticien=("INSERT INTO praticien(PRA_CODE, PRA_NOM, PRA_PRENOM,TYP_CODE) VALUES(".$numPra.", '".$nomRempl."', '".$prenomRempl."','RT');");
	echo $sqlInsertPraticien ;
	$sqlInsertPraticienRes=mysql_query($sqlInsertPraticien);
	echo $sqlInsertPraticien;
}
//On prépare l'intégration des médicaments prescrits
//On récupère le premier médicament obligatoirement prescrit
$prod1=$_POST["PROD1"];
//On va chercher le numéro de présentation (MAX+1)
$sqlNumPRE=("SELECT MAX(PRE_CODE)+1 boby FROM presentation");
$sqlNumPRERes=mysql_query($sqlNumPRE);
$sqlGetNumPRE=mysql_fetch_array($sqlNumPRERes);
$numPre=$sqlGetNumPRE['boby'];

//echo $_SESSION["visMatricule"]."test";

// ----- INTEGRATION GENERALE DU FORMULAIRE ------

if (isset($boolRempl) && isset($_POST["PRA_REMPLACANT"]) && $boolRempl==false) {
$pra_code=$_POST["PRA_REMPLACANT"];
$numPra=$pra_code;
}
else
{
$numPra=$_POST["PRA_NUM"];	
}
//INSERTION
$sqlValidRapport=("INSERT INTO rapport_visite (VIS_MATRICULE, RAP_CODE, PRA_CODE, RAP_DATE, RAP_BILAN, MOTIF_ID) 
VALUES('".$_SESSION['visMatricule']."', ".$rapNum.", ".$numPra.", '".$rapDate."', '".$rapBilan."', '".$motifId."');");
echo $sqlValidRapport;

$sqlValidRapportRes=mysql_query($sqlValidRapport);

	//Récupération de tous les échantillons offert (expliqué par Frédéric, merci à lui).
	$noEch=1;
	while(isset($_POST["PRA_ECH".$noEch]))
	{
		//On intègre le résultat séléctionner à chaque tour dans la boucle.
		$echPrescrit=$_POST['PRA_ECH'.$noEch];
		$echQte=$_POST['PRA_QTE'.$noEch];
		$mat=$_SESSION["visMatricule"];
		$sqlEchRes=mysql_query("INSERT INTO offrir VALUES ('".$mat."', ".$rapNum.", '".$echPrescrit."', ".$echQte.");");
		echo "INSERT INTO offrir VALUES ('".$mat."', ".$rapNum.", '".$echPrescrit."', ".$echQte.");";
		$noEch++;
	}
//Si la documentation a été offerte (checkbox)
if (ISSET($_POST["RAP_DOC1"])) $doc1=1; else $doc1=0;
//On effectue la requete
$sqlInsertMED=("INSERT INTO presentation (PRE_CODE, MED_DEPOTLEGAL, BOOL_DOC,RAP_CODE) VALUES (".$numPre.", '".$prod1."', ".$doc1.",".$rapNum.");");
echo $sqlInsertMED;
$sqlInsertMEDRes=mysql_query($sqlInsertMED);
//Si le visiteur sélectionne un autre médicament
if ($_POST["PROD2"]!="AUC")
{
	$prod2=$_POST["PROD2"];
	if (ISSET($_POST["RAP_DOC2"])) $doc2=1; else $doc2=0;
	$sqlInsertMED2=("INSERT INTO presentation (PRE_CODE, MED_DEPOTLEGAL, BOOL_DOC,RAP_CODE) VALUES (".$numPre.", '".$prod2."', ".$doc2.",".$rapNum.");");
	echo $sqlInsertMED2;
	$sqlInsertMEDRes2=mysql_query($sqlInsertMED2);
}

}

?>
<title>formulaire RAPPORT_VISITE</title>
<style type="text/css">
<!-- body {background-color: white; color:5599EE; } 
label.titre { width : 180 ; background-color: 77AADD; clear:left; float:left; } 
.zone { width : 30car ; float : left; color:5599EE } -->
</style>
<script language="javascript">
function selectionne(pValeur, pSelection,  pObjet) {
	//active l'objet pObjet du formulaire si la valeur sélectionnée (pSelection) est égale à la valeur attendue (pValeur)
	if (pSelection==pValeur) 
	{ formRAPPORT_VISITE.elements[pObjet].disabled=false; }
	else { formRAPPORT_VISITE.elements[pObjet].disabled=true; }
}
function deselectionne(pValeur, pSelection,  pObjet) {
	//active l'objet pObjet du formulaire si la valeur sélectionnée (pSelection) est égale à la valeur attendue (pValeur)
	if (pSelection==pValeur) 
	{ formRAPPORT_VISITE.elements[pObjet].disabled=true; }
	else { formRAPPORT_VISITE.elements[pObjet].disabled=false; }
}

//_______________________________________________________________________________________________________________________________________//
//---------------------------------------------------- Fonction vidant la liste des echantillons------------------------------------------//
//_______________________________________________________________________________________________________________________________________//
</script>
<script language="javascript">
function vide(pNumero) {
	var test=pNumero+1;
	
if (document.getElementById("PRA_ECHO"+pNumero).value=="AUC")
{
		
	document.getElementById("but"+pNumero+"").setAttribute("hidden","true");
	document.getElementById("PRA_QTE"+pNumero+"").setAttribute("hidden","true");

		while(pNumero<10)
	{
		pNumero++;
		
document.getElementById("label"+pNumero).remove(true);
document.getElementById("but"+pNumero).remove(true);
document.getElementById("PRA_QTE"+pNumero).remove(true);
//suppression des selects
var id = 'PRA_ECHO'+pNumero, // objet à supprimer
    noeud = document.getElementById(id).parentNode, // parent
    enfant = noeud.childNodes, // enfants
    longueur = enfant.length; // nombre enfants
for(i=0; i<longueur; i++){ // parcours enfants
    // si on trouve le bon id, et que ce n'est pas un node texte
    if(enfant[i].nodeType == 1 && enfant[i].id==id)
    {
        noeud.removeChild(enfant[i]);// le remove
		break;
    }
	}
//fin while
}
//fin if
	}
else if(!document.getElementById("but"+test))
	{
document.getElementById("but"+pNumero).removeAttribute("hidden");document.getElementById("PRA_QTE"+pNumero).removeAttribute("hidden");
}
	
}
</script>
<script language="javascript">

function ajoutLigne( pNumero){//ajoute une ligne de produits/qté à la div "lignes"     
	//masque le bouton en cours
	if(pNumero<10)
	{	
	document.getElementById("but"+pNumero).setAttribute("hidden","true");
	pNumero++;										//incrémente le numéro de ligne
	var laDiv=document.getElementById("lignes");	//récupère l'objet DOM qui contient les données
	var titre = document.createElement("label") ;	//crée un label
	laDiv.appendChild(titre) ;						//l'ajoute à la DIV
	titre.setAttribute("class","titre") ;
	titre.setAttribute("id","label"+pNumero);			//définit les propriétés
	titre.innerHTML= "   Produit : "+pNumero+"";
	var liste = document.createElement("select");	//ajoute une liste pour proposer les produits
	laDiv.appendChild(liste) ;
	liste.setAttribute("name","PRA_ECH"+pNumero) ;
	liste.setAttribute("class","zone");
	liste.setAttribute("id","PRA_ECHO"+pNumero) ;
	liste.setAttribute("onChange","vide("+pNumero+");");
	//remplit la liste avec les valeurs de la première liste construite en PHP à partir de la base
	liste.innerHTML=formRAPPORT_VISITE.elements["PRA_ECH1"].innerHTML;
	var qte = document.createElement("input");
	laDiv.appendChild(qte);
	qte.setAttribute("name","PRA_QTE"+pNumero);
	qte.setAttribute("size","2"); 
	qte.setAttribute("id","PRA_QTE"+pNumero);
	qte.setAttribute("class","zone");
	qte.setAttribute("type","text");
	qte.setAttribute("hidden","true");
	var bouton = document.createElement("input");
	laDiv.appendChild(bouton);
	//ajoute une gestion évenementielle en faisant évoluer le numéro de la ligne
	bouton.setAttribute("onClick","ajoutLigne("+ pNumero +");");
	bouton.setAttribute("type","button");
	bouton.setAttribute("value","+");
	bouton.setAttribute("class","zone");	
	bouton.setAttribute("hidden","true");
	bouton.setAttribute("id","but"+ pNumero);
	}
	else
	{
	document.getElementById("but"+pNumero).setAttribute("hidden","true");
	}
}
</script>	<?php
//________________________________________________________________________________________________________________________________//
//------------------------------------------------------------Affichage-----------------------------------------------------------//
//________________________________________________________________________________________________________________________________//
?>
<?php
include "menuCR.php";
?>
<div name="droite" style="margin-top:15;float:left;width:80%;background-attachment:fixed;background-repeat:repeat-y;background-color:77AADD;">
<div name="bas" style="margin : 10 2 2 2;clear:left;background-color:77AADD;color:white;height:92%;">
<form name="formRAPPORT_VISITE" method="post" action="">
<h1> Rapport de visite </h1>
<?php
//__________________________________________________________________________________________________________________________________________//
//------------------------------------------------------------Automatisation du numéro------------------------------------------------------//
//__________________________________________________________________________________________________________________________________________//

$requeteNumRap="select MAX(RAP_CODE)+1 as numRap from rapport_visite";
$resultatNumRap=mysql_query($requeteNumRap);
while($maLigne=mysql_fetch_array($resultatNumRap))	
{
	$numRapport=$maLigne["numRap"];
	?>
		<label class="titre">Numéro :</label>
		<input type="text" disabled size="10" name="RAP_NUM" class="zone" value="<?php echo $numRapport?>"/>
		<input type="hidden"  size="10" name="RAP_NUM1" class="zone" value="<?php echo $numRapport?>"/>
		<?php
}
//--------------------------------------------------------------------------------------------------------------------------------------------------//
//------------------------------------------------------------Fin d'automatisation------------------------------------------------------------------//
//--------------------------------------------------------------------------------------------------------------------------------------------------//
$date=date("Y-m-d");
?>

<label class="titre">Date visite :</label><input type="date" size="10" name="RAP_DATEVISITE" class="zone" value="<?=$date?>" />

<?php

//__________________________________________________________________________________________________________________________________________//
//------------------------------------------------------------Choix du praticien------------------------------------------------------------//
//__________________________________________________________________________________________________________________________________________//
?>

<label class="titre">Praticien :</label><select  name="PRA_NUM" class="zone" id="PRA_NUM" onChange="xajax_AfficherCoef(document.getElementById('PRA_NUM').value);">
<option value="00">Selectionnez le praticien</option>
<?php
$requetePraticien="select * from praticien where TYP_CODE!='RT'";
$resultatPraticien=mysql_query($requetePraticien);
while($maLigne=mysql_fetch_array($resultatPraticien))
{
	$idPrat=$maLigne["PRA_CODE"];
	$nomPrat=$maLigne["PRA_NOM"];
	$prenomPrat=$maLigne["PRA_PRENOM"];
	$coefPrat=$maLigne["PRA_COEFNOTORIETE"];
echo $coefPrat;
	?>			
    
		<option value="<?php echo $idPrat?>"><?php echo $nomPrat." ".$prenomPrat?></option>
       
		<?php		
}	
echo $coefPrat;
	//Coefficient

?>
 
</select>

<?php 
//--------------------------------------------------------------------------------------------------------------------------------------------------//
//------------------------------------------------------------------Fin Praticien-------------------------------------------------------------------//
//--------------------------------------------------------------------------------------------------------------------------------------------------//

//____________________________________________________________________________________________________________________________________________//
//-----------------------------------------------------------Remplissage de " COEFFICIENT " --------------------------------------------------//
//____________________________________________________________________________________________________________________________________________//

?> <div id="affCoef" ></div>
<?php 
//--------------------------------------------------------------------------------------------------------------------------------------------------//
//----------------------------------------------------------------Fin coefficient-------------------------------------------------------------------//
//--------------------------------------------------------------------------------------------------------------------------------------------------//
?>

<label class="titre">Remplaçant :</label><input type="checkbox" class="zone" onClick="selectionne(true,this.checked,'PRA_REMPLACANT');
selectionne(false,this.checked,'PRA_NUM');if(this.value!='false')PRA_REMPLACANT_AUT.value ='';selectionne(false,this.Unchecked,'PRA_REMPLACANT_AUT');"/>

<?php
//_______________________________________________________________________________________________________________________________________//
//-------------------------------------------------------Choix du remplaçant ------------------------------------------------------------//
//_______________________________________________________________________________________________________________________________________//
?>

<select name="PRA_REMPLACANT" disabled="disabled" class="zone" onClick="selectionne('AUT',this.value,'PRA_REMPLACANT_AUT'); if(this.value!='AUT')PRA_REMPLACANT_AUT.value ='';"  />
<?php
$requetePraticien="select * from praticien where TYP_CODE='RT'";
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
?>
<option Value="AUT">Autre</option>
</select>



<?php
 //--------------------------------------------------------------------------------------------------------------------------------------------------//
 //----------------------------------------------------------------Fin Remplaçant--------------------------------------------------------------------//
 //--------------------------------------------------------------------------------------------------------------------------------------------------//
?>
<input type="text" name="PRA_REMPLACANT_AUT" class="zone" disabled />
<?php
?>
<input type="hidden" size="19"  name="RAP_DATE2" class="zone" value="<?php echo $date?>"/>

<?php
//_____________________________________________________________________________________________________________________________________________//
// ------------------------------------------------------------Liste déroulante motif----------------------------------------------------------//
//_____________________________________________________________________________________________________________________________________________//

?>
<label class="titre">Motif :</label><select  name="RAP_MOTIF" class="zone" onClick="selectionne('AUT',this.value,'RAP_MOTIFAUTRE');if(this.value!='AUT')RAP_MOTIFAUTRE.value ='';">
<?php
$requete="select * from motif  where MOTIF_ID like '___' and MOTIF_ID!='AUT'";
$resultat=mysql_query($requete);
while($maLigne=mysql_fetch_array($resultat))
{
	$idMotif=$maLigne["MOTIF_ID"];
	$libMotif=$maLigne["MOTIF_LIB"];
	?>			
		<option value="<?php echo $idMotif?>"><?php echo $libMotif ?></option>";
	<?php		
}	
?>
<option value="AUT">Autre</option>";
</select>
<?php

//--------------------------------------------------------------------------------------------------------------------------------------------------//
//---------------------------------------------------------------fin liste motif--------------------------------------------------------------------//
//--------------------------------------------------------------------------------------------------------------------------------------------------//
?>

<input type="text" name="RAP_MOTIFAUTRE" class="zone" disabled="disabled" />

<label class="titre">Bilan :</label><textarea rows="5" cols="50" name="RAP_BILAN" class="zone" ></textarea>
<label class="titre" ><h3> Eléments présentés </h3></label>
<?php
//__________________________________________________________________________________________________________________________________________________//
//--------------------------------------------------------Liste déroulante produit -----------------------------------------------------------------//
//__________________________________________________________________________________________________________________________________________________//

$reqProduit="Select MED_DEPOTLEGAL,MED_NOMCOMMERCIAL,FAM_LIBELLE from medicament natural join famille order by FAM_CODE";
$resultatProduit=mysql_query($reqProduit);
$resultatProduit2=mysql_query($reqProduit);

//--------------------------------------------------------------------Produit1-----------------------------------------------------------------------//
?>
<label class="titre" >Produit 1 : </label>
<select name="PROD1" class="zone">
<?php
while($maLigne=mysql_fetch_array($resultatProduit))
{
$id=$maLigne["MED_DEPOTLEGAL"];
$nom=$maLigne["MED_NOMCOMMERCIAL"];
$famille=$maLigne["FAM_LIBELLE"];
	?>			
		<option value="<?php echo $id?>"><?php echo $nom." ".$famille ?></option>";
	<?php
}
?>
</select><label id="DOC1" class="titre">Documentation offerte :</label><input name="RAP_DOC1" id='RAP_DOC2' type="checkbox" class="zone" />
<?php
//--------------------------------------------------------------------Produit2-----------------------------------------------------------------------//
?>
<label class="titre" >Produit 2 : </label>
<select name="PROD2" class="zone" onClick="if(this.value=='AUC'){
DOC2.style.display='none';}else{
DOC2.style.display='';
}
;">
<option value="AUC">Aucun</option>
<?php
while($maLigne2=mysql_fetch_array($resultatProduit2))
{
$id=$maLigne2["MED_DEPOTLEGAL"];
$nom=$maLigne2["MED_NOMCOMMERCIAL"];
$famille=$maLigne2["FAM_LIBELLE"];
	?>			
		<option value="<?php echo $id?>"><?php echo $nom." ".$famille ?></option>";
	
	<?php
}

?>
</select>

<div id="DOC2" style="display:none"><label  class="titre">Documentation offerte :</label><input name="RAP_DOC2" id='RAP_DOC2' type="checkbox" class="zone" /></div>
<?php
//---------------------------------------------------------------------------------------------------------------------------------------------------//
//--------------------------------------------------------------fin liste Produits-------------------------------------------------------------------//
//---------------------------------------------------------------------------------------------------------------------------------------------------//
?>
<label class="titre"><h3>Echantillons</h3></label>
<div class="titre" id="lignes">
<label class="titre" >Produit : 1</label>
<?php
//__________________________________________________________________________________________________________________________________________________//
//--------------------------------------------------------Liste déroulante Echantillons-------------------------------------------------------------//
//__________________________________________________________________________________________________________________________________________________//
?>

<select name="PRA_ECH1" class="zone" id="PRA_ECHO1"  onChange="vide(1);">
<option value="AUC">Aucun</option>
<?php
$resultatEchantillon=mysql_query($reqProduit);

while($maLigne=mysql_fetch_array($resultatEchantillon))
{
$id=$maLigne["MED_DEPOTLEGAL"];
$nom=$maLigne["MED_NOMCOMMERCIAL"];
$famille=$maLigne["FAM_LIBELLE"];
	?>			
		<option value="<?php echo $id?>"><?php echo $nom." ".$famille ?></option>";
	<?php
}
?>
</select>
<?php
//---------------------------------------------------------------------------------------------------------------------------------------------------//
//--------------------------------------------------------------fin liste Echantillons---------------------------------------------------------------//
//---------------------------------------------------------------------------------------------------------------------------------------------------//
?>
<input type="text" name="PRA_QTE1" id="PRA_QTE1" hidden="true" size="2" class="zone" />

<input type="button" id="but1" value="+" hidden="true" onClick="ajoutLigne(1);" class="zone" />			
</div>		
<label class="titre"></label><div class="zone"><input type="reset" value="annuler"></input><input type="submit" name="valider" value="Valider"></input>
</form>
</div>
</div>
</body>
</html>

