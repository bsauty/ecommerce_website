<!--- Cette page affiche une annonce qu'on lui passe en argument dans le GET --->


<?php
if (isset($_GET["affichage"])){
    $objet = Objet::recupererdepuisId($dbh,$_GET['affichage']);
    if ($objet != null){
        
    //s'il y a un mail à envoyer on l'envoie
    if (isset($_GET['todo']) && $_GET['todo']=='sendmail' && isset($_POST['content'])){
        $from = Utilisateur::recupererMail($dbh, $_SESSION['login']);
        $to = Utilisateur::recupererMail($dbh, $objet['vendeur']);
        $subject = "Message par rapport à l'annonce : \"" . $objet['nom'] ." \" ";
        $msg = "
<!DOCTYPE html>
<html>
<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' /> 
<title>Message pour annonce</title>
<body style='margin: 0px 0px 0px 0px; padding: 0px 0px 0px 0px; font-family: Trebuchet MS, Arial, Verdana, sans-serif;'>
 
    
<table width='100%' height='100%' cellpadding='0' style='padding: 20px 0px 20px 0px' background='images/background.jpg' >
    <tr align='center'>
        <td>

            <table style='width:580px; height:108px;' background='images/white.jpg' border='0'>
            <tr>
                <td valign='top' style='width:456px;'>
                    <h1 style='font-size:22px; color:#ec523f;margin-left:20px; margin-top:26px;'>Vous avez reçu un message pour votre annonce leboncoin</h1>
                </td>
                <td valign='top'>
                    <p style='color:#aeaeae; font-size:11px; margin-top:34px;'>Modal web 2017</p>
                </td>
            </tr>
            </table>
      
            
            <table cellpadding='0' cellspacing='0' width='580' background='images/white.jpg' style='padding:0px 0px 0px 0px;'>
            <tr>
                <td>
                    <a href='localhost/leboncoin/' target='_blank'><img src='images/screen1.png' width='500' height='238' style='border:none;margin-left:60px;' /></a>
                </td>
            </tr>
            </table>
      
            
            <table cellpadding='0' cellspacing='0' width='580' background='images/white.jpg' style='padding:30px 0px 0px 0px;'>
            <tr>
                <td valign='top' style='color:#808080; font-size:11px; padding:0px 39px 0px 47px; text-align:justify; line-height:25px;'>
                    <p>".htmlspecialchars($_SESSION['login']) . " vous a envoyé un message sur l'annonce : \"". htmlspecialchars($objet['nom']). "\" publiée sur le site leboncoin le ".$objet['date'].".<br/><br/>\"" . htmlspecialchars($_POST['content'])."\"<br/><br/> Vous pouvez lui répondre à l'adresse : ".$from."</p>
                </td>
            </tr>
            </table>
          
             
            <table style='width:580px; height:148px;' width='580' cellpadding='0' cellspacing='0' background='images/white.jpg' style='padding:0px 0px 0px 0px;'>
            <tr>
                <td>
                    <a href='localhost/leboncoin/page=annonce&affichage=".$_GET['affichage']."' style='display : block; width : 80%;color: white;text-align: center;background-color: #ec523f;padding: 12px 20px;border-radius: 4px;text-transform: uppercase;font-weight: 700;margin-left: 40px;border:none;'target='_blank' >Voir mon annonce</a>
                </td>
            </tr>
            </table>
</body>
</html>
\n";   
        envoi_mail($to, $from, $subject, $msg);
        //On supprimer le contenu de post au cas ou l'utilisateur actualise sa page pour ne pas envoyer plein de mails
        unset($_POST['content']);
    }
      
    $b = true;
    if ($objet["img2"] == ""){
        $b=false;
    }
    $statut = $objet['statut'];
    
?>
<body>
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
                                        <li <?php if($statut==1){echo " class='active'";}?>><a href="index.php#objetsvente">Objets à vendre</a></li>
                                        <li <?php if($statut!=1){echo " class='active'";}?>><a href="index.php#objetstrouve">Objets trouvés</a></li> 
                                        <li><a href="index.php#contact">Contact</a></li>   
                                        <li><a href="index.php?page=membre" class="external" target="_parent" rel="nofollow"><?php $res = est_connecte(); echo $res; ?></a></li> 
                                    </ul>                                    
                                </div> 
                            </div> 
                        </div>                        
                    </div>
                </div> 
            </div> 
</div> 
<br/><br/><br/><br/><br/>
<div class="col-md-offset-1 col-md-5">
    <div class=" boxed">
        <?php
        //ici on affiche soit la description de l'annonce soit le formulaire d'envoi d'un mail
        if (isset($_GET['todo']) && $_GET['todo']=="getmail" && isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']==true){
            print_form_mail($_GET['affichage']);
        }
        else{ 
            if ($statut==1){
                echo "<div class='titlebox'>A vendre </div>";
            }
                if ($statut==2){
                echo "<div class='titlebox'> Trouvé </div>";
            }
                if ($statut==3){
                echo "<div class='titlebox'> Perdu </div>";
            }
            ?>
                <span class="nomannonce">
                <?php echo htmlspecialchars($objet['nom'])?> 
                </span>
                <?php
                if ($statut==1){
                echo "<em> - </em> <span class='prixannonce'>";
                echo $objet["prix"]." €";
                echo "</span>";
                }
                ?>
                <em> - </em>
                <span class="lieuannonce">
                <?php echo htmlspecialchars($objet["lieu"]);?>
                </span>
                <div class="description">
                <?php echo htmlspecialchars($objet["description"]);?>
                </div>
                <?php if (isset($_SESSION['loggedIn']) && $_SESSION['login']==$objet['vendeur']){
                    echo"  <a class='mailbtn col-md-offset-2 col-md-8' href='index.php?todo=deleteannonce&id=";
                    echo $objet['id'];
                    echo '&token=';
                    echo $_SESSION['token'];
                    echo "'>Supprimer mon annonce</a>";
                }
                else{
                    if (isset($_SESSION['loggedIn'])) {
                    echo "<a class='mailbtn col-md-offset-2 col-md-8' href='index.php?page=annonce&affichage=";
                    echo $_GET['affichage'] ;
                    echo "&todo=getmail' >Envoyer un message au vendeur !</a>";
                    }
                    else{
                    echo "<a class='mailbtn col-md-offset-1 col-md-10' href='index.php?page=membre'>Connectez vous pour envoyer un message au vendeur !</a>";
                       }
                    }
                echo "<br/><br/><br/><br/>";
                echo 'Annonce déposée par '.htmlspecialchars($objet["vendeur"]). ' le '.$objet["date"];?>
            </div>
        <?php }?>
    <a class="btn btn-default col-md-offset-2 col-md-8" href='index.php?page=<?php if ($objet['statut'] ==1){echo "objetsvente";}else{echo"objetstrouve";}?>' >Revenir aux annonces</a>
    <p><br/></p>
    <?php if (isset($_SESSION['statut']) && $_SESSION['statut']==0 && $_SESSION['login']!=$objet["vendeur"]){
    echo "<a class='btn btn-default col-md-offset-2 col-md-8' href='index.php?todo=deleteannonce&id=";
    echo $objet['id'];
    echo '&token=';
    echo $_SESSION['token'];
    echo "' >Supprimer l'annonce</a>";
    }
    ?>
    </div>

         <div class="col-md-5">
             <p><br/><br/><br/><br/></p>
             <?php 
             if ($objet['statut']==3){
                 printSlider('images/perdu.jpg','');
             }else{
                 printSlider($objet['img1'],$objet['img2']);
                 
             }?>
        </div>
<?php
}
}
