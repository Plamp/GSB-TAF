<?
$repInclude='./include/';
require($repInclude . "_init.inc.php");

// page inaccessible si visiteur non connecté
if (!estVisiteurConnecte())
{
	header("Location: cSeConnecter.php");
}
require($repInclude . "_entete.inc.php");
require($repInclude . "_sommaire.inc.php");
?>
<html>
<head>
<title>Suivi de paiement des Fiches de frais</title>
</head>
<body>
<div id="contenu">
<?
if(isset($_POST["Remboursement"]) && $_POST["Remboursement"]=="Valider")
{
	$mois=$_POST["reqMois"];
	$idVisiteur=$_POST["idVisiteur"];
	$reqMaJ="Update FicheFrais set idEtat='RB' where idVisiteur='$idVisiteur' and mois='$mois'";
	$result=mysql_query($reqMaJ);
}

if(isset($_POST["action"]) && $_POST["action"]=="Mise en paiement")
//détail
{
	?>
		<form name="formRembourseFrais" method="POST" action="">
		<?
		$id=$_POST["id"];
	$req="select * from Visiteur where id='$id'";
	$resultat=mysql_query($req);
	while($maLigne=mysql_fetch_array($resultat))
	{
		$nom=$maLigne["nom"];
		$prenom=$maLigne["prenom"];
	}
	?>
		<form name="formRembourseFrais" method=POST" action ="">
		<input type="text" name="nomVisiteur" disabled value="<?=$nom." ".$prenom?>"/>
		Mois:
		<?
		$mois=$_POST["mois"];
	?>
		<input type="text" name="mois" disabled value="<?=$mois?>"/>
		<?
		//frais forfaitisé
		$req="select * from FraisForfait";
	$result=mysql_query($req);
	while($line=mysql_fetch_array($result))		
	{
		$idFrais=$line["id"];
		$req="select idVisiteur, quantite from LigneFraisForfait where idVisiteur='$id' and mois='$mois' and idFraisForfait='$idFrais' group by idVisiteur";
		$result=mysql_query($req);
		while($line=mysql_fetch_array($result))
		{
			$quantite=$line["quantite"];
		}
	}
	?>
		</br>
		</br>
		<h2 align="center"><p align="center">Frais au forfait</p></h2>
		<fieldset>
		</br>

		<table>
		<th width="15">Quantité/P.U:</th>
		<?
		//QTT Frais forfaitisé
		$req="select * from FraisForfait";
	$result=mysql_query($req);
	while($line=mysql_fetch_array($result))
	{
		$nomEtape=$line["libelle"];
		?>
			<th><?=$nomEtape?> </th>
			<?

	}
	?>
		<th>Montant total</th>
		<tr><td></td>
		<?
		$req="select * from FraisForfait";
	$result=mysql_query($req);
	$montantTotal=0;
	while($line=mysql_fetch_array($result))
	{
		echo("<td width='80'>");
		$idFrais=$line["id"];
		$PU=$line["montant"];
		$req1="select quantite from LigneFraisForfait where idVisiteur='$id' and mois=$mois and idFraisForfait='$idFrais' group by idVisiteur";
		$result1=mysql_query($req1);
		while($line1=mysql_fetch_array($result1))
		{
			$quantite=$line1["quantite"];
		}
		echo ($quantite." / ".$PU."€");
		$montantTotal=$montantTotal+$quantite*$PU;
		echo("</td>");
	}
	?>
		<td width='80'>
		<?echo $montantTotal."€";?>
		</td>
		</tr>
		</table>
		</br>
		</fieldset>
		</br>
		<?
		$req="select * from LigneFraisHorsForfait where idVisiteur='$id' and mois='$mois'";
	$result=mysql_query($req);
	if(mysql_num_rows($result)>0)
	{
		?>
			<p class="titre"/>
			<h2><p align="center">Hors Forfait</p></h2>
			</p>
			</br>
			<fieldset>
			</br>
			<table>
			<tr><th>Date</th><th>Libelle</th><th>Montant</th></tr>
			<?
			//quantite Frais hors farfait
			$req="select * from LigneFraisHorsForfait where idVisiteur='$id' and mois='$mois'";
		$result=mysql_query($req);
		$montantTotalHF=0;
		while($line=mysql_fetch_array($result))
		{
			$idFHF=$line["id"];
			?>
				<tr>
				<td width='80'>
				<?
				$date=$line["date"];
			$lib=$line["libelle"];
			$montant=$line["montant"];
			echo $date
				?>
				</td>
				<td size=80><? echo $lib ?></td>
				<td><? echo $montant ?></td>
				</tr>
				<?
				$montantTotalHF=$montantTotalHF+$montant;
		}?>
		</table>
			<h3> Montant total = <? echo $montantTotalHF?></h3>
			<?
	}
	else
	{
	$montantTotalHF=0;	?>
			<class="titre"/><h2><p align="center">Il n'y a pas de frais hors forfait ce mois-ci</p></h2></p>
			<?
			?>
			</fieldset>
			<?
	}
	?>
		</br>
		<p class="titre"><h2>Hors Classification</h2></p>
		<?
		?>
		</br>
		<fieldset>
		</br>
		<table>
		<th width="80">Justificatif</th><th width="80">Montant</th><tr><td>
		<?
		$req="select * from FicheFrais where idVisiteur='$id' and mois=$mois";
	$result=mysql_query($req);
	while($line=mysql_fetch_array($result))
	{
		$nbJusti=$line["nbJustificatifs"];
		$montantValide=$line["montantValide"];
	}
	echo $nbJusti ?></td><td>
		<? echo $montantValide ?></td>
		<input type="hidden" name="reqMois" value="<?=$mois?>"/>
		<input type="hidden" name="idVisiteur" value="<?=$id?>"/>
		</tr>
		</table>
		</br>
		</fieldset>
		</br>
		<p class="titre"/><h2><p align="center">Montant total à rembourser:<b><? echo $montantTotal+$montantTotalHF?></b></p></h2>
		</br>
		<p align="center"><input type="submit" name="Remboursement" Value="Valider"/></p>
		</form><?
}
else
{
	?>
		</br>
		</br>
		<?
		$req="select * from FicheFrais where idEtat='VA'";
	$result=mysql_query($req);
	if(mysql_num_rows($result)>0)
	{
		?>
			<h2>Choisir la fiche a remboursée:</h2>
			<?
			//montant total des fiches
			?>
			<table>
			<th>Nom</th><th>Prenom</th><th>Mois</th><th>Montant</th><th>Action</th>
			<?
			while($line=mysql_fetch_array($result))
			{
				?>
					<tr>

					<form name="formValidFrais" method="POST" action="">
					<?

					$idVisiteur=$line["idVisiteur"];
				$mois=$line["mois"];
				$req="select * from Visiteur where id='$idVisiteur'";
				$result=mysql_query($req);
				while($line=mysql_fetch_array($result))
				{
					$nom=$line["nom"];
					$prenom=$line["prenom"];
					?>
						<input type="hidden" name="id" value="<?=$idVisiteur?>"/>
						<td><input type="text" name="nom" size="15" value="<?=$nom?>"/></td>
						<td><input type="text" name="prenom" size="15" value="<?=$prenom?>"/></td>
						<td><input type="text" name="mois" size="6" value="<?=$mois?>"/></td>
						<?
				}
				$req1="select * from LigneFraisForfait where idVisiteur='$idVisiteur' and mois='$mois'";
				$result1=mysql_query($req1);
				$montantTotal=0;
				while($line1=mysql_fetch_array($result1))
				{
					$quantite=$line1["quantite"];
					$idFraisF=$line1["idFraisForfait"];
					$req2="Select * from FraisForfait where id='$idFraisF'";
					$result2=mysql_query($req2);
					while($line2=mysql_fetch_array($result2))
					{
						$coefEtape=$line2["montant"];
					}
					$multi=$coefEtape*$quantite;
					$montantTotal=$montantTotal+$multi;
					$req3="Select SUM(montant) as montantHF from LigneFraisHorsForfait where mois='$mois' and idVisiteur='$idVisiteur'";
					$result3=mysql_query($req3);
					while($line3=mysql_fetch_array($result3))
					{
						$montantHF=$line3["montantHF"];
					}
				}
				$montantTotal=$montantTotal+$montantHF;
				?>
					<td>
					<input type="text" name="MontantTotal" size="12" value="<?=$montantTotal?>"/>
					</td>
					<td>
					<input type="submit" name="action" value="Mise en paiement"/></td>
					</tr>
										
					</form>
					<?				
			}

		?>
			</table>
			<?

	}
	else
	{
		?>
			<h2>Aucune fiche à rembourser</h2>
			<?
	}
	?>

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
