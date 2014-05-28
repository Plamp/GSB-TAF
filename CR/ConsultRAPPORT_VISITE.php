<?php
$hote ="127.0.0.1" ;
$user ="root";
$mdp  ="";
$db='db_gestioncr';
mysql_connect($hote,$user, $mdp);
mysql_select_db($db);
//________________________________________________________________________________________________________________________________//
//-----------------------------------------------------------Gestion des rapport--------------------------------------------------//
//________________________________________________________________________________________________________________________________//
function AfficherRapport($id)
{
$reponse = new xajaxResponse();//Création d'une instance de xajaxResponse pour traiter les réponses serveur

$rapport='';// Initialisation de la variable $rapport
//la selection du rapport selon le code du rapport choisis
$req = mysql_query("SELECT * FROM `rapport_visite` where RAP_CODE='".$id."' ") or die(mysql_error()); 

//recuperation des information du rapport
$resultRap=mysql_query("SELECT * FROM `rapport_visite` where RAP_CODE='".$id."' ");
while ($maLigne=mysql_fetch_array($resultRap))
{
$matricule=$maLigne["VIS_MATRICULE"];
$praCode=$maLigne["PRA_CODE"];
$rapDate=$maLigne["RAP_DATE"];
$bilan=$maLigne["RAP_BILAN"];
$motifID=$maLigne["MOTIF_ID"];
}
//recuperation des info du visiteur depuis son matricule

$reqVisiteur=mysql_query("select VIS_NOM,VIS_PRENOM from visiteur where VIS_MATRICULE='".$matricule."'") or die(mysql_error());
while($recupVisiteur=mysql_fetch_array($reqVisiteur))
{
$nom=$recupVisiteur["VIS_NOM"];
$prenom=$recupVisiteur["VIS_PRENOM"];
$visiteur=$nom.' '.$prenom;	
}
//recuperation des info du praticien depuis son code
$reqPrat=mysql_query("select PRA_NOM, PRA_PRENOM,PRA_VILLE,TYP_LIBELLE from praticien natural join type_praticien where PRA_CODE='".$praCode."' ");
while($recupPrat=mysql_fetch_array($reqPrat))
{
$nom=$recupPrat["PRA_NOM"];
$prenom=$recupPrat["PRA_PRENOM"];
$ville=$recupPrat["PRA_VILLE"];
$fonction=$recupPrat["TYP_LIBELLE"];
$infoPrat=$nom.' '.$prenom.', '.$fonction;
}

//recuperation du motif de la visite depuis son identifiant
$reqMotif=mysql_query("select MOTIF_LIB from motif where MOTIF_ID='".$motifID."'");
while($recupMotif=mysql_fetch_array($reqMotif))
{
	$motif=$recupMotif["MOTIF_LIB"];
}

//recuperation des produits présentés depuis le numéro du rapport
$reqPresentation=mysql_query("select MED_DEPOTLEGAL,BOOL_DOC from presentation where RAP_CODE=".$id."");
$num_Ligne=mysql_num_rows($reqPresentation);
$i=1;
while($recupPresent=mysql_fetch_array($reqPresentation))
{
		$depot=$recupPresent["MED_DEPOTLEGAL"];
	//recuperation du libellé du medicament depuis son depotLegal
	$reqMedicament=mysql_query("select MED_NOMCOMMERCIAL from medicament where MED_DEPOTLEGAL='".$depot."'");
	while($recupProduit=mysql_fetch_array($reqMedicament))
	{
		$bool=$recupPresent["BOOL_DOC"];
		$produit1=$recupProduit["MED_NOMCOMMERCIAL"];
		if ($i==1)
		{
			
			
				if($bool == "1")
				{
					$doc1="avec la documentation";
				}
				else
				{
					$doc1="sans la documentation";
				}
					if($bool == "1")
				{
					$doc2="avec la documentation";
				}
				else
				{
					$doc2="sans la documentation";
				}
		}
		else
		{
			$produit2=$recupProduit["MED_NOMCOMMERCIAL"];
				if($bool == "1")
	{
		$doc1="avec la documentation";
	}
	else
	{
		$doc1="sans la documentation";
	}
		}
	}
	

	$i++;
}

//formation de la consultation
 while($array = mysql_fetch_array($req))
{
	$rapport.='<p style="margin-left:10px;margin-right:10px;">Numéro du rapport :'.$id.'<br />
			   Visiteur concerné : '.$visiteur.'<br />
			   Visite chez : '.$infoPrat.' pour le motif suivant : '.$motif.'<br />
			   Date de la visite: '.$rapDate.'<br /><br />
			   Le visiteur a déclaré dans son bilan : '.$bilan.'<br /><br />';
			   if (isset($produit1))
			   {
			   $rapport.='Lors de sa visite, '.$visiteur.' a présenté les medicaments suivants:<br />';
			   if($num_Ligne==2)
			   {
				$rapport.=' --> '.$produit1.' '.$doc1.' <br />
							--> '.$produit2.' '.$doc2.' <br />				
				';   
			   }
			   else
			   {
				   $rapport.=' --> '.$produit1.' '.$doc1.' <br />';
			   }
			   }
	$rapport.='<br /> il a aussi présenté les echantillons suivant :<br />';
	//recherche des echantillons
	$reqEchantillons=mysql_query("select MED_NOMCOMMERCIAL,OFF_QTE from offrir natural join medicament where RAP_CODE=".$id."");
	while($recupEchant=mysql_fetch_array($reqEchantillons))
	{
	$nom=$recupEchant["MED_NOMCOMMERCIAL"];
	$qte=$recupEchant["OFF_QTE"];
	$rapport.='-->'.$nom.' au nombre de '.$qte.' <br />';
	}
	$rapport.='
				</p>';
}
$reponse = new xajaxResponse('ISO-8859-1');
$reponse->addAssign("affRapport","innerHTML",$rapport); // affichage du contenu de $rapport  dans la div affRapport
return $reponse->getXML();
	
}

require("xajax.inc.php");
$xajax = new xajax(); //On initialise l'objet xajax
$xajax->setCharEncoding('ISO-8859-1');
$xajax->decodeUTF8InputOn();
$xajax->registerFunction("AfficherRapport");
$xajax->processRequests();//Fonction qui va se charger de faire les requetes APRES AVOIR DECLARER NOS FONCTIONS
?>
<html><head>

<?php 
$xajax->printJavascript(); /* Affiche le Javascript */?>
<?php
//-----------------------------------------------------------Fin ajax-----------------------------------------------//

?>
    <title>formulaire consultation de rapport</title>
</head>
<?php
include "menuCR.php";
?>
<div name="droite" style="float:left;width:80%;">
	<div name="bas" style="margin : 10 2 2 2;clear:left;background-color:77AADD;color:white;height:88%;">
		<h1> Rapport </h1>
			<center><select name="lstRAP" class="titre" id="lstRAP" onChange="if(this.value!='00')xajax_AfficherRapport(document.getElementById('lstRAP').value);">
            <option value="00">Selectionnez le rapport</option>
	<?php
$requeteRapport="select * from rapport_visite ";
$resultatRapport=mysql_query($requeteRapport);
while($maLigne=mysql_fetch_array($resultatRapport))
{
	$idRap=$maLigne["RAP_CODE"];
	$visCode=$maLigne["VIS_MATRICULE"];
	$dateRapport=$maLigne["RAP_DATE"];
$requeteVisiteur="select * from visiteur where VIS_MATRICULE='$visCode'";
$resultatVisiteur=mysql_query($requeteVisiteur);
	while($maLigne2=mysql_fetch_array($resultatVisiteur))
	{
		$nom=$maLigne2["VIS_NOM"];
		$prenom=$maLigne2["VIS_PRENOM"];
	}
	?>			
    
		<option value="<?php echo $idRap?>"><?php echo $dateRapport." rapport de ".$nom." ".$prenom?></option>
       
		<?php	
			
}	
?>
</select></center>
<div id="affRapport" style="height:70%;width:60%;margin-top:40px;margin-left:20%;margin-right:20%;border:2px solid white;color:#333"></div>