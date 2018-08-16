<!-- Cette page regroupe les entêtes et pieds de page, ainsi que les fonctions de connection, déconnexion-->



<?php


function generateheader(){
    echo <<<END
    <html>
    <head>
        <meta charset="utf-8">
        <title>Leboncoin</title>
    	<meta name="description" content="Objets à vendre ou trouvés sur le plateau">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>
        
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/font-awesome.css">
        <link rel="stylesheet" href="css/animate.css">
        <link rel="stylesheet" href="css/style.css">
    

        <script src="js/vendor/modernizr-2.6.1-respond-1.1.0.min.js"></script>
    </head>
    
END;
}

function generatefooter(){
    echo <<<END
        <div id="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9 col-md-8 col-xs-12 text-left">
                        <span>Copyright &copy; 2017 Modal Web</span>
                  </div>
                   <div class=" col-sm-2 ">
                   <div class="text-right">
END;
    if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"]){
    echo <<< END
<form action="index.php?todo=logOut&&page=accueil" method="post">
<div class="row">
   <input type="submit" value="Se déconnecter" />
</div>
</form>
        
END;
    }
    echo <<< END

                    <div class="row">   
                        <br/>
                        <a href="#top" id="go-top">Back to top</a>
                        </div>
                    </div> 
                    </div>
                </div>
            </div> 
        </div>
        
        <script src="js/vendor/jquery-1.11.0.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.0.min.js"><\/script>')</script>
        <script src="js/bootstrap.js"></script>
        <script src="js/plugins.js"></script>
        <script src="js/main.js"></script>
        <script src='https://www.google.com/recaptcha/api.js'></script>
</body>
</html>
END;
}


function passhash($pass){
    $res = "sAlT#?".$pass."@$%SaLt";
    $res = hash('sha256', $res);
    return $res;
}

function logIn($dbh){
    $user = Utilisateur::getUtilisateur($dbh,$_POST['login']);
    $b=false;
    if($user != false){
    $b = Utilisateur::testerMdp($dbh,$user,$_POST['mdp']);
        }
        if ($b == true){
            $_SESSION['loggedIn']=true;
    }
    else{
        sleep(1);
    }
}

function logOut(){
    session_destroy();
    unset($_SESSION['loggedIn']);
    unset($_SESSION['login']);
    unset($_SESSION['statut']);
    unset($_SESSION['token']);
}



function est_connecte(){
    if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']) {
        $res = htmlspecialchars($_SESSION["login"]) ;
    }
    else{
        $res = 'Mon compte';
    }
    return $res;
}

//Cette fonction affiche les miniatures
function printAnnonce($annonce,$statut){
    $id = $annonce["id"];
    $nom = $annonce["nom"];
    $prix = $annonce["prix"];
    $img = $annonce["img1"];
    $cat = $annonce["categorie"];
    $description = $annonce["description"];
    $style="background-image:url(".$img.");";
    if ($statut == 3){?>
        <div class="col-lg-3 col-md-4 col-sm-6" id="annonce">
            <div class='objetsperdu-item'>
                <div class='miniatures' style="background-image:url('images/perdu.jpg');">
                    <div class='perdu'>
                        <div class='txtperdu'><?php echo "<a href='index.php?page=annonce&affichage=$id'>$nom"?>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
   <?php     
        
    }
    else{
?>
    <div class="col-lg-3 col-md-4 col-sm-6 annonce" id="annonce">
        <div class="objetsvente-item">
            <?php echo "<div class='miniatures' style= ";
            echo $style ;
            echo "></div>";?>
            <div class="objetsvente-content">
                <div class="inner-objetsvente">
                    <?php
                    if ($statut == 1)
                    {
                    ?>
                        <h3><?php echo "<a href='index.php?page=annonce&affichage=$id'>$nom"?></a></h3>
                        <p><?php echo "<a href='index.php?page=annonce&affichage=$id'>$prix €"?></a></p>
                        <span hidden ="hidden"><?php echo $cat?></span>
                    <?php
                    }
                    elseif ($statut == 2)
                    {
                    ?>
                        <h3><?php echo "<a href='index.php?page=annonce&affichage=$id'>$nom"?></a></h3>
                    <?php
                    }
                    ?>
                    
                </div>
            </div>
        </div> 
    </div> 
<?php
    }
}

function printLigne($ligne,$statut){
    
?>
    <div class="row">
    <?php
        foreach($ligne as $annonce){
            printAnnonce($annonce,$statut);
        }
    ?>
    </div>
<?php
}



function printAnnonces($dbh,$statut,$requete)
{
    // on récupere toute les annonces correspondant au statut
    $sth = Objet::recupererAnnonces($dbh,$requete);
    $compteur = 0;
    $ligne = array();
    while ($courant = $sth->fetch(PDO::FETCH_ASSOC))
    {
        $annonce = $courant;
        printAnnonce($annonce,$statut);
    }
}


// affiche les quatres dernières annonces d'un statut donné 
function printQuatreDernières($dbh,$statut){
    $sth = Objet::recupererQuatreDerniers($dbh,$statut);
    $ligne = array();
    while ($courant = $sth->fetch(PDO::FETCH_ASSOC)){
        array_push($ligne,$courant);
    }
    printLigne($ligne,$statut);
}

// affiche un message indiquant que le résultat d'une requete est vide
function printVide()
{
?>
<div class="row">
    <div class="col-sm-12 titlebox boxed-filtre">
        Oups, aucun résultat ne correspond à votre recherche...
    </div>
</div>
<?php    
}



function printSlider($img1,$img2){
    if ($img2 == ""){
        echo" <img src=".$img1." class='imgbox' alt=''/>";
    }
    else{
        echo<<<END
            <br/><br/><br/><br/>
            <div class="site-slider">
                <div class="slider">
                    <div class="flexslider">
                        <ul class="slides">
                            <li>
                                <img src="$img1" class="imgbox imgannonce" alt="">
                            </li>
                            <li>
                                <img src="$img2" class="imgbox imgannonce" alt="">
                            </li>
                        </ul>
                    </div> <!-- /.flexslider -->
                </div> <!-- /.slider -->
            </div> <!-- /.site-slider -->
END;
    }
}

function deleteDirectory($dir) {
    if (!file_exists($dir)) {
        return true;
    }

    if (!is_dir($dir)) {
        return unlink($dir);
    }

    foreach (scandir($dir) as $item) {
        if ($item == '.' || $item == '..') {
            continue;
        }

        if (!deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
            return false;
        }

    }

    return rmdir($dir);
}