<?
	// script de mise a jour des fiches de frais 
	// passage automatique de l'etat CR à CL 
	    // lancement du script le 1er de chaque mois , tot le matin 
	    // changement d'etat uniquement pour les fiches de frais datant des mois precedent 

	

	// information de connexion sur la base de donnée 
	$hote="172.16.52.71";
	$base="PPEGSB";
	$user="root";
	$mdp="ini01";

	$message="Le script  miseAJourCRCL.php a bien etait executer ";


	// connexion a la base de donnée 
	mysql_connect($hote,$user,$mdp) or die ($message="Probleme lors de la connexion a la base de donnée Mysql");
	//selection de la base de travail
        mysql_select_db($base) or die ($message="Probleme lors de la selection de la base de donnée PPEGSB");

	
	//  requete du passage de l'etat de CR à CL 

	$req="update FicheFrais set idEtat='CL', dateModif=current_date where mois<date_format(current_date, '%Y%m') and idEtat='CR'";

	// execution de la requete

	mysql_query($req);

	// r'envoyer dans /var/log/message 

	system("logger $message");


?>
