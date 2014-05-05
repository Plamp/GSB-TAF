<?php  
/** 
 * Script de contrôle et d'affichage du cas d'utilisation "Se connecter"
 * @package default
 * @todo  RAS
 */
  $repInclude = './include/';
  require($repInclude . "_init.inc.php");
  
  // est-on au 1er appel du programme ou non ?
  $etape=(count($_POST)!=0)?'validerConnexion' : 'demanderConnexion';
  
  if ($etape=='validerConnexion') { // un client demande à s'authentifier
      // acquisition des données envoyées, ici login et mot de passe
      $login = lireDonneePost("txtLogin");
      $mdp = lireDonneePost("txtMdp");   
      $lgUser = verifierInfosConnexion($idConnexion, $login, $mdp) ;
      // si l'id utilisateur a été trouvé, donc informations fournies sous forme de tableau
      if ( is_array($lgUser) ) { 
          affecterInfosConnecte($lgUser["id"], $lgUser["login"]);
      }
      else {
          ajouterErreur($tabErreurs, "Pseudo et/ou mot de passe incorrects");
      }
  }
  if ( $etape == "validerConnexion" && nbErreurs($tabErreurs) == 0) {
        if (estVisiteurConnecte() ) {
          $idUser = obtenirIdUserConnecte() ;
          $lgUser = obtenirDetailVisiteur($idConnexion, $idUser);
          $nom = $lgUser['nom'];
          $prenom = $lgUser['prenom'];
          $type = $lgUser['typeMembre'];
		$_SESSION["type"]=$type;
      }
     header("Location:cAccueil.php");
}

  require($repInclude . "_entete.inc.php");
  //require($repInclude . "_sommaire.inc.php");
  
?>
<!-- Division pour le contenu principal -->
    <div id="contenu">
<!--      <h2>Identification utilisateur</h2>-->
<?php
          if ( $etape == "validerConnexion" ) 
          {
              if ( nbErreurs($tabErreurs) > 0 ) 
              {
                echo toStringErreurs($tabErreurs);
              }
          }
?>               
      <form id="frmConnexion" action="" method="post">
      <fieldset>
	<legend><h3><b>Identification utilisateur</b></h3></legend> <!-- <div class="corpsForm"> -->
        <input type="hidden" name="etape" id="etape" value="validerConnexion" />
      <table border=0px>
	<tr>
	<td>
        <label for="txtLogin" accesskey="n">* Login : </label>
        </td>
	<td>
	<input type="text" id="txtLogin" name="txtLogin" maxlength="20" size="15" value="" title="Entrez votre login" />
      </td>
      </tr>
	<tr>
	<td>
        <label for="txtMdp" accesskey="m">* Mot de passe : </label>
        </td>
	<td>
	<input type="password" id="txtMdp" name="txtMdp" maxlength="8" size="15" value=""  title="Entrez votre mot de passe"/>
	</td>
<!--	<tr>
	<td>
	* Type :</td> 
<td><select name="typeMembre">
		<option value="">Visiteur</option>
		<option value="">Comptable</option>
	</select>
	</td></tr>-->
     <!-- </div>
      <div class="piedForm">-->
        <tr><td><input type="submit" id="ok" value="Valider" />
<input type="reset" id="annuler" value="Effacer" /></td></tr>
<!--      </div>-->
	</table>
	</fieldset>
      </form>
    </div>
<?php
    require($repInclude . "_pied.inc.html");
    require($repInclude . "_fin.inc.php");
?>
