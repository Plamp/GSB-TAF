<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
       "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
  <head>
    <title>Intranet du Laboratoire Galaxy-Swiss Bourdin</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
<!--    <link href="./styles/styles.css" rel="stylesheet" type="text/css" />-->
    <link rel="shortcut icon" type="image/x-icon" href="./images/favicon.ico" />
	<?
 if(!isset($_SESSION["type"]))
 {
 $_SESSION["type"]=0;
 }
$type=$_SESSION["type"];
     
if($type==0)
{
/*header("Location:cAccueil.php");*/?>
<link href="./styles/styles.css" rel="stylesheet" type="text/css" />
<?
}
else
{
/*header("Location:comptAccueil.php");*/
?>
<link href="./styles/comptstyles.css" rel="stylesheet" type="text/css" />
<?
}

?>
</head>
  <body>
    <div id="page">
      <div id="entete">
        <img src="./images/logo.jpg" id="logoGSB" alt="Laboratoire Galaxy-Swiss Bourdin" title="Laboratoire Galaxy-Swiss Bourdin" />
        <h1>Suivi du remboursement des frais</h1>
      </div>
