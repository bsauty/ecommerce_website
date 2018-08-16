<!-- Cette page est la page membre à laquelle on a accès à partir du menu principal. Son nom est soit "mon compte" si l'on est pas connecté,
soit l'identifiant du membre. Elle affiche les formulaires d'inscription connexion dans le premier cas et les formulaires pour déposer des annonces
dans la colonne de gauche/les formulaires pour gérer le compte dans la colonne de droite dans le second. Si le membre est admin, on rajoute
la fonction qui permet d'examiner les membres qui souhaitent devenir admin -->
            
    
<?php
    // On vérifie que le catchpa est réussi
    $catchpa = false;
    // Ma clé privée
    $secret = "6LeH-T8UAAAAAPXXBh15LvQWRDcobnJnUi5pA7sR";
    // Paramètre renvoyé par le recaptcha
    if (isset($_POST['g-recaptcha-response'])){
    $response = $_POST['g-recaptcha-response'];
    // On récupère l'IP de l'utilisateur
    $remoteip = $_SERVER['REMOTE_ADDR'];
    
    $arrContextOptions=array(
    "ssl"=>array(
        "verify_peer"=>false,
        "verify_peer_name"=>false,
    ),
);  
    $api_url = "https://www.google.com/recaptcha/api/siteverify?secret=" 
        . $secret
        . "&response=" . $response
        . "&remoteip=" . $remoteip ;
    $decode = json_decode(file_get_contents($api_url, false, stream_context_create($arrContextOptions)), true);
    $catchpa = $decode['success'] ;}
    
    
    
    if ($catchpa == true) {
           
    ##ici on vérifie si le compte a été créé ou s'il faut le faire

    if (isset($_POST["login"]) && $_POST["login"] != "" && isset($_POST["mail"]) && $_POST["mail"] != "" &&  isset($_POST["mdp"]) &&
   $_POST["mdp"] != "" && isset($_POST["mdp2"]) && $_POST["mdp2"] != "" && isset($_GET['todo']) && $_GET['todo']=="register") {
    
    $user = Utilisateur::getUtilisateur($dbh, $_POST["login"]);
    
    if ($user == false){
        if (preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{6,}$#', $_POST['mdp'])){
            
        if ($_POST["mdp"] == $_POST["mdp2"] ) {
            if ($_POST["admin"]=="oui"){
            Utilisateur::insererUtilisateur($dbh, $_POST["login"], $_POST["mdp"], $_POST["mail"],2);
                       
        }
        else{
            Utilisateur::insererUtilisateur($dbh, $_POST["login"], $_POST["mdp"], $_POST["mail"],1);
        }
        
        echo<<<END
        <script language=javascript>
        alert("Vous etes inscrit !")
        </script>
END;

        logIn($dbh);
        envoi_mail($_POST['mail'], "leboncoinmodalweb@hotmail.com", "Inscription Lebonoin", "new_registration");
        if (isset($_SESSION["loggedIn"])){
            //Pour luter contre les failles CSRF
            $token = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
            $_SESSION['token'] = $token;

            $_SESSION["login"]=$_POST["login"];
            $statut = Utilisateur::recupererStatut($dbh, $_POST["login"]);
            $_SESSION["statut"]=$statut;
            }
            
        }
        else{
            echo<<<END
            <script language="javascript">
            alert("Les mots de passe sont différents.");
            </script>
END;
            
            }
        }
        else {
            echo<<<END
            <script language="javascript">
            alert("Merci de choisir un mot de passe d'au moins 6 caractères contenant au moins une majuscule, une minuscule un chiffre !");
            </script>
END;
        }
        }
        
    else{
        echo<<<END
            <script language="javascript">
            alert("Cet identifiant est déjà utilisé, merci d'en choisir un autre");
            </script>
END;
        }
    }
    }
    
##ici on vérifie si l'on est déjà connecté où s'il faut le faire
    
 if(isset($_GET['todo']) && $_GET['todo']=='logIn'){
    logIn($dbh);
    if (isset($_SESSION['loggedIn'])){
    //Pour luter contre les failles CSRF
    $token = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
    $_SESSION['token'] = $token;
    
    $_SESSION["login"]=$_POST["login"];
    $statut = Utilisateur::recupererStatut($dbh, $_POST["login"]);
    $_SESSION["statut"]=$statut;
    echo<<<END
        <script language="javascript">
        alert("Vous êtes connecté !");
        </script>
END;
    }else{
        echo<<<END
        <script language="javascript">
        alert("Identifiants incorrects !");
        </script>
END;
    }
    }
    
## si l'utilisateur le souhaite au moment de se connecter, on enregistre un cookies avec son id et son mdp, à supprimer à Y+1
    
if(isset($_POST['cookies']) && $_POST['cookies'] == "ouicookies"){
    setcookie('login', $_POST['login'], time() + 365*24*3600, null, null, false, true); 
    setcookie('mdp', passhash($_POST['mdp']), time() + 365*24*3600, null, null, false, true); 
}

## enregistrement d'un objet à vendre

if(isset($_POST["titre"]) && $_POST["titre"] != "" && isset($_POST["categorie"]) && $_POST["categorie"] != "0" &&  
   isset($_POST["description"]) &&  $_POST["description"] != "" && isset($_POST["lieu"]) && $_POST["lieu"] != "" &&
   isset($_FILES['img1']) && isset($_GET['todo']) && $_GET['todo'] == "objetvendre" && isset($_POST['prix'])){
   $extensions_valides = array( 'jpg' , 'jpeg' , 'gif' , 'png' );
   $extension_upload = strtolower(  substr(  strrchr($_FILES['img1']['name'], '.')  ,1)  );
        if (! in_array($extension_upload,$extensions_valides)){
            echo<<<END
        <script language="javascript">
        alert("L'image 1 n'a pas le bon format !");
        </script>
END;
        }
        else{
   if ($_FILES['img1']['error'] == 0) {
   if ($_FILES['img1']['size'] < 5000000) {
        //On crée le dossier de l'annonce
        $interdit=array(">", "<",  ":", "*","\\", "/", "|", "?", "\"", "'", "}","{", " ", "²", "&", ",", ";",".",":","§","%","µ","*","ù","¨","£","€","@","=","+","¤","`","~","é","è","à","ë",'ê',"â","ô","ö");
        $titresansespace=str_replace($interdit,'',$_POST["titre"]);
        $dossier = time().$titresansespace;
        mkdir('annonces/vente/'.$dossier);
        $destination1 = "annonces/vente/".$dossier."/img1.".$extension_upload;
        $resultat = move_uploaded_file($_FILES['img1']['tmp_name'],$destination1);
        if ($_FILES['img2']["name"] == ""){      
            if ($resultat){
            Objet::creerObjet($dbh, $_POST['titre'],$_POST['description'],$_POST['prix'], $_POST['lieu'],1, $_POST['categorie'], $destination1, "", $_SESSION["login"], date('d M Y'));
            echo<<<END
        <script language="javascript">
        alert("L'annonce est postée !");
        </script>
END;
            
        }
        }
        else{
           if ($_FILES['img2']['error'] == 0){
               $extension_upload = strtolower(  substr(  strrchr($_FILES['img2']['name'], '.')  ,1)  );
                   if (! in_array($extension_upload, $extensions_valides)){
                       echo<<<END
        <script language="javascript">
        alert("L'image 2 n'a pas le bon format !");
        </script>
END;
                   }
                   elseif ($_FILES['img2']['size'] < 5000000) {
                   $destination2 = "annonces/vente/".$dossier."/img2.".$extension_upload;
                   $resultat = move_uploaded_file($_FILES['img2']['tmp_name'],$destination2);
                   if ($resultat){
                   Objet::creerObjet($dbh, $_POST['titre'],$_POST['description'],$_POST['prix'], $_POST['lieu'],1, $_POST['categorie'], $destination1, $destination2, $_SESSION["login"], date('d M Y'));
                   echo<<<END
        <script language="javascript">
        alert("L'annonce est postée !");
        </script>
END;
                   }
                   }else{echo<<<END
        <script language="javascript">
        alert("L'image 2 est trop lourde !");
        </script>
END;
               }
           } else{
echo<<<END
        <script language="javascript">
        alert("Erreur d'upload de l'image 2 !");
        </script>
END;
        }
        } 
   }else{echo<<<END
        <script language="javascript">
        alert("L'image 1 est trop lourde !");
        </script>
END;
   }
   }
   else{
    echo<<<END
        <script language="javascript">
        alert("Erreur d'upload de l'image 1!");
        </script>
END;
    }
   }
}


##enregistrement d'un objet trouvé

if(isset($_POST["titre"]) && $_POST["titre"] != "" && isset($_POST["description"]) && $_POST["description"] != "" &&
   isset($_POST["lieu"]) && $_POST["lieu"] != "" && isset($_FILES['img1']) && isset($_GET['todo']) && $_GET['todo'] == "objettrouve"){
   $extensions_valides = array( 'jpg' , 'jpeg' , 'gif' , 'png' );
   $extension_upload = strtolower(  substr(  strrchr($_FILES['img1']['name'], '.')  ,1)  );
        if (! in_array($extension_upload,$extensions_valides)){
            echo<<<END
        <script language="javascript">
        alert("L'image 1 n'a pas le bon format !");
        </script>
END;
        }
        else{
   if ($_FILES['img1']['error'] == 0) {
   if ($_FILES['img1']['size'] < 5000000) {
        //On crée le dossier de l'annonce
        $interdit=array(">", "<",  ":", "*","\\", "/", "|", "?", "\"", "'", "}","{", " ", "²", "&", ",", ";",".",":","§","%","µ","*","ù","¨","£","€","@","=","+","¤","`","~","é","è","à","ë",'ê',"â","ô","ö");
        $titresansespace=str_replace($interdit,'',$_POST["titre"]);
        $dossier = time().$titresansespace;
        mkdir('annonces/trouve/'.$dossier);
        $destination1 = "annonces/trouve/".$dossier."/img1.".$extension_upload;
        $resultat = move_uploaded_file($_FILES['img1']['tmp_name'],$destination1);
        if ($_FILES['img2']["name"] == ""){      
            if ($resultat){
            Objet::creerObjet($dbh, $_POST['titre'],$_POST['description'],0, $_POST['lieu'],2,"", $destination1, "", $_SESSION["login"], date('d M Y'));
            echo<<<END
        <script language="javascript">
        alert("L'annonce est postée !");
        </script>
END;
            
        }
        }
        else{
           if ($_FILES['img2']['error'] == 0){
               $extension_upload = strtolower(  substr(  strrchr($_FILES['img2']['name'], '.')  ,1)  );
                   if (! in_array($extension_upload, $extensions_valides)){
                       echo<<<END
        <script language="javascript">
        alert("L'image 2 n'a pas le bon format !");
        </script>
END;
                   }
                   elseif ($_FILES['img2']['size'] < 5000000) {
                   $destination2 = "annonces/trouve/".$dossier."/img2.".$extension_upload;
                   $resultat = move_uploaded_file($_FILES['img2']['tmp_name'],$destination2);
                   if ($resultat){
                   Objet::creerObjet($dbh, $_POST['titre'],$_POST['description'],0, $_POST['lieu'],2, " ", $destination1, $destination2, $_SESSION["login"], date('d M Y'));
                   echo<<<END
        <script language="javascript">
        alert("L'annonce est postée !");
        </script>
END;
                   }
                   }else{echo<<<END
        <script language="javascript">
        alert("L'image 2 est trop lourde !");
        </script>
END;
               }
           } else{
echo<<<END
        <script language="javascript">
        alert("Erreur d'upload de l'image 2 !");
        </script>
END;
        }
        } 
   }else{echo<<<END
        <script language="javascript">
        alert("L'image 1 est trop lourde !");
        </script>
END;
   }
   }
   else{
    echo<<<END
        <script language="javascript">
        alert("Erreur d'upload de l'image 1!");
        </script>
END;
    }
   }
}

##enregistrement d'un objet perdu

if(isset($_POST["titre"]) && $_POST["titre"] != "" && isset($_POST["description"]) && $_POST["description"] != "" &&
   isset($_POST["lieu"]) && $_POST["lieu"] != "" && isset($_GET['todo']) && $_GET['todo'] == "objetperdu"){
        Objet::creerObjet($dbh, $_POST['titre'],$_POST['description'],0, $_POST['lieu'],3,"", "", "", $_SESSION["login"], date('d M Y'));
            echo<<<END
        <script language="javascript">
        alert("L'annonce est postée !");
        </script>
END;
}

##changement de mot de passe

if (isset($_POST["login"]) && $_POST["login"] != "" && isset($_POST["mdp1"]) && $_POST["mdp1"] != "" && isset($_POST["mdp"]) 
    && $_POST["mdp"] != "" && isset($_POST["mdp2"]) && $_POST["mdp2"] != "" && isset($_GET['todo']) && $_GET['todo'] == "passchange"
    && $_POST['login']==$_SESSION['login']){
    $user = Utilisateur::getUtilisateur($dbh, $_POST["login"]);
    
    if (preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{6,}$#', $_POST['mdp1'])){
        
    if ($_POST["mdp1"] == $_POST["mdp2"] ) {
        if ($user == null){
            echo<<<END
        <script language="javascript">
        alert("Le login n'est pas bon !");
        </script>
END;
        }
        else if (!Utilisateur::testerMdp($dbh, $user, $_POST["mdp"])){
            echo<<<END
        <script language="javascript">
        alert("Le mot de passe n'est pas bon !");
        </script>
END;
        }
        else{
            Utilisateur::changeMdp($dbh,$_POST["login"],$_POST["mdp1"]);
            setcookie('mdp', passhash($_POST['mdp1']), time() + 365*24*3600, null, null, false, true); 
        echo<<<END
        <script language="javascript">
        alert("Votre mot de passe a été modifié !");
        </script>
END;
        }
    }
    else{
        echo<<<END
        <script language="javascript">
        alert("Les deux mots de passes sont différents !");
        </script>
END;
    }
    }
    else{
        echo<<<END
        <script language="javascript">
        alert("Merci de choisir un mot de passe d'au moins 6 caractères contenant au moins une majuscule, une minuscule un chiffre !");
        </script>
END;
    }
    
}
   

##suppression du compte
    
if (isset($_POST["login"]) && $_POST["login"] != "" && isset($_POST["mdp"]) && $_POST["mdp"] != "" && isset($_GET['todo']) 
        && $_GET['todo']=="deleteaccount" && isset($_SESSION['login']) && $_POST['login'] == $_SESSION['login'] &&
        isset($_GET['token']) && $_GET['token'] == $_SESSION['token']) {
    $user = Utilisateur::getUtilisateur($dbh, $_POST["login"]);
    if ( $user != null && Utilisateur::testerMdp($dbh, $user, $_POST["mdp"])) {
        Utilisateur::supprimerUtilisateur($dbh,$_POST["login"]);
        Objet::supprimerAnnoncesUtilisateur($dbh,$_POST["login"]);
        logOut($dbh);
        if(isset($_COOKIE['login']) && isset($_COOKIE['mdp'])){
        setcookie('mdp', '', 0);
        setcookie('login','',0);
    }
        echo<<<END
        <script language="javascript">
        alert("Le compte a été supprimé !");
        </script>
END;
    }
    else{
        echo<<<END
        <script language="javascript">
        alert("Le mot de passe n'est pas bon !");
        </script>
END;
        }
}

##procédure pour accepter un nouvel admin

if (isset($_GET['todo']) && $_GET['todo'] == 'admin' && $_SESSION['statut'] == 0 && isset($_GET["login"]) &&
        isset($_GET['token']) && $_GET['token'] == $_SESSION['token']) {
    $user = Utilisateur::getUtilisateur($dbh, $_GET['login']);
    if ($user != NULL){
        Utilisateur::statutAdmin($dbh, $_GET["login"]);
    echo <<<END
    <script language="javascript">
    alert("L'utilisateur a bien été nommé administrateur !");
    </script>
END;
}
}

##Suppression d'une annonce
   
if (isset($_GET['todo']) && $_GET['todo']=='deleteannonce'&& isset($_GET['id']) && isset($_SESSION['loggedIn']) && 
    isset($_GET['token']) && $_GET['token'] == $_SESSION['token']){
    $objet = Objet::recupererdepuisId($dbh, $_GET['id']);
    if ($objet != NULL && $objet['vendeur']==$_SESSION['login']){
    Objet::supprimerObjet($dbh,$_GET['id']);
    echo<<<END
    <script language=javascript>
    alert("L'annonce a bien été supprimée !")
    </script>
END;
    }    
}
?>

<div class="site-header">
                <div class="main-header">
                    <div class="container">
                        <div id="menu-wrapper">
                            <div class="row">
                                <div class="logo-wrapper col-md-2 col-sm-2">
                                    <h1>
                                        <a href="#">Leboncoin</a>
                                    </h1>
                                </div> 
                                <div class="col-md-10 col-sm-10 main-menu text-right">
                                    <div class="toggle-menu visible-sm visible-xs"><i class="fa fa-bars"></i></div>
                                    <ul class="menu-first">
                                        <li><a href="index.php">Accueil</a></li>
                                        <li><a href="index.php#objetsvente">Objets à vendre</a></li>
                                        <li><a href="index.php#objetstrouve">Objets trouvés</a></li> 
                                        <li><a href="index.php#contact">Contact</a></li>   
                                        <li class="active"><a href="index.php?page=membre" class="external" target="_parent" rel="nofollow"><?php $res = est_connecte(); echo $res; ?></a></li> 
                                    </ul>                                    
                                </div> 
                            </div> 
                        </div>                        
                    </div>
                </div> 
            </div> 
</div> 
                
<?php
##ici on décide des formulaires qu'on affiche

if (!isset($_SESSION['loggedIn'])){
    print_form_connexion();
}else{

##on est dans le cas ou l'utilisateur est connecté ici
##formulaire pour déposer une annonce à vendre

if (isset($_POST['annonces']) && $_POST['annonces']=='Vendre un objet'){
    print_form_objetvente();
}

##formulaire pour déclarer un objet trouvé

if (isset($_POST['annonces']) && $_POST['annonces']=="Déclarer un objet trouvé"){
    print_form_objettrouve();
}

##formulaire pour déclarer un objet perdu

if (isset($_POST['annonces']) && $_POST['annonces']=="Déclarer la perte d'un objet"){
    print_form_objetperdu();
}

## on demande à l'utilisateur quel type d'annonce il souhaite déposer

if (!isset($_POST['annonces'])){
    print_form_annonce();
}

##formulaire changement mot de passe

if (isset($_POST['membre']) && $_POST['membre']=="Changer mon mot de passe"){
    print_form_changemdp();
}

##formulaire suppression du compte

if (isset($_POST['membre']) && $_POST['membre']=="Supprimer mon compte"){
    print_form_supprimercompte();
}

##formulaire gestion des demande d'admin

if (isset($_POST['membre']) && $_POST['membre'] == "Gérer la liste des admins" && $_SESSION['statut'] == 0){
    $tab = Utilisateur::demandeAdmin($dbh);
    print_form_admin($tab);    
}

##formulaire qui demande ce que veux faire l'utilisateur

if (!isset($_POST['membre'])){
    print_form_gestioncompte();   
}

if (isset($_POST['membre']) && $_POST['membre']=="Gérer mes annonces"){
    $tab = Objet::recupererAnnoncesVendeur($dbh, $_SESSION['login']);
    print_form_gestionannonces($tab);
}
}
