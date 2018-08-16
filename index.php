<?php 
    
require 'utils/utils.php';
require 'utils/requetes.php';
require 'utils/print_forms.php';
require 'utils/envoi_mail.php';

session_name("NomSession");
session_start();
if (!isset($_SESSION['initiated'])) {
    session_regenerate_id();
    $_SESSION['initiated'] = true;
}
$dbh= Database::connect();


//on vérifie la présence de cookies
if (!isset($_SESSION['loggedIn']) && isset($_COOKIE['login']) && isset($_COOKIE['mdp'])){
    $user = Utilisateur::getUtilisateur($dbh,$_COOKIE['login']);
    $b=false;
        if ($user != NULL){
            $b = ($_COOKIE["mdp"] == ($user->mdp));
        }
    if($b){
        //Pour luter contre les failles CSRF
        $token = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
        $_SESSION['token'] = $token;
        
        $_SESSION["loggedIn"]=true;
        $_SESSION["login"]=$_COOKIE["login"];
        $statut = Utilisateur::recupererStatut($dbh, $_COOKIE["login"]);
        $_SESSION["statut"]=$statut;
    }
    else{
        ##on supprime les cookies si ils ne fonctionnent pas, ça évite de faire le test inutilement
        setcookie('mdp', NULL, time());
        setcookie('login', NULL, time());
    }
}

//s'il faut se déconnecter
if (isset($_GET['todo']) && $_GET['todo']=='logOut'){
    logOut();
    echo<<<END
    <script language=javascript>
    alert("Vous êtes déconnecté !")
    </script>
END;
    if(isset($_COOKIE['login']) && isset($_COOKIE['mdp'])){
        setcookie('mdp', '', 0);
        setcookie('login','',0);
    }
}


//s'il faut supprimer une annonce
if (isset($_GET['todo']) && $_GET['todo']=='deleteannonce'&& isset($_GET['id']) && isset($_SESSION['loggedIn']) && isset($_GET['token']) && $_GET['token'] == $_SESSION['token']){
    $objet = Objet::recupererdepuisId($dbh, $_GET['id']);
    if ($objet != NULL){
        if ($_SESSION['statut']==0 || ($_SESSION['login'] == $objet['vendeur'])){
    Objet::supprimerObjet($dbh,$_GET['id']);
    echo<<<END
    <script language=javascript>
    alert("L'annonce a bien été supprimée !")
    </script>
END;
        }
    }
}


if (array_key_exists('page', $_GET)) {
    $askedPage = $_GET['page'];
}
else{
    $askedPage = "accueil";
}

  
generateheader();
require 'content/content_'.$askedPage.'.php';
generatefooter();
