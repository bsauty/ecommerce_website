<!-- Cette page est la page d'accueil, elle est composée d'un bandeau défilant avec deux images et un aperçu de chaque fonction
du site, avec en bas de page un formulaire d'envoi de mail aux développeurs -->


<?php 
//s'il faut envoyer un mail
if (isset($_GET['todo']) && $_GET['todo']=="sendmail" && isset($_POST["name"]) && isset($_POST["subject"]) &&
        isset($_POST["email"]) && isset($_POST["comments"])){
        $msg = '<html><head></head><body>'.$_POST['name'] ." a envoyé le commentaire suivant : \"" . $_POST['comments']."\" via l'email ". $_POST['email'].'</body></html>';
        envoi_mail("leboncoinmodalweb@hotmail.com", $_POST['email'], $_POST['subject'], $msg);
        // on s'assure que si le mail ne peut partir qu'une fois
        unset($_POST['email']);
}


?>

<body>
           
        <div class="site-main" id="sTop">
             <div class="site-slider">
                <div class="slider">
                    <div class="flexslider">
                        <ul class="slides">
                            <li>
                                <div class="overlay"></div>
                                <img src="images/vente.jpg" alt="">
                                <div class="slider-caption visible-md visible-lg">
                                    <h2>Une plateforme de vente en ligne</h2>
                                    <p>pour l'échange d'objets sur le plateau</p>
                                    <a href="#objetsvente" class="slider-btn">Aller aux annonces !</a>
                                </div>
                            </li>
                            <li>
                                <div class="overlay"></div>
                                <img src="images/trouvé.jpg" alt="">
                                <div class="slider-caption visible-md visible-lg">
                                    <h2>Un centre de recensement</h2>
                                    <p>pour tous les objets perdus et trouvés</p>
                                    <a href="#objetstrouve" class="slider-btn">Aller aux annonces !</a>
                                </div>
                            </li>
                        </ul>
                    </div> 
                </div> 
            </div> 
            <div class="site-header">
                <div class="main-header">
                    <div class="container">
                        <div id="menu-wrapper">
                            <div class="row">
                                <div class="logo-wrapper col-md-2 col-sm-2">
                                    <h1>
                                        <a href="#">Leboncoin</a>
                                    </h1>
                                </div> <!-- /.logo-wrapper -->
                                <div class="col-md-10 col-sm-10 main-menu text-right">
                                    <div class="toggle-menu visible-sm visible-xs"><i class="fa fa-bars"></i></div>
                                    <ul class="menu-first">
                                        <li class="active"><a href="#">Accueil</a></li>
                                        <li><a href="#objetsvente">Objets à vendre</a></li>
                                        <li><a href="#objetstrouve">Objets trouvés</a></li> 
                                        <li><a href="#contact">Contact</a></li>   
                                        <li><a href="index.php?page=membre" class="external" target="_parent" rel="nofollow"><?php $res = est_connecte(); echo $res; ?></a></li> 
                                    </ul>                                    
                                </div> 
                            </div> 
                        </div>                        
                    </div> 
                </div> 
            </div>
        </div> 


        <div class="content-section" id="objetsvente">
            <div class="hidden-xs"><br/><br/><br/><br/><br/></div>
            <div class="container">
                <div class="row">
                    <div class="heading-section col-md-12 text-center">
                        <h2> <a href="index.php?page=objetsvente">Objets à vendre</h2>
                        <p>Vous trouverez ici tous les objets en vente sur le plateau</a></p>
                    </div> 
                </div>
                <?php
                printQuatreDernières($dbh,1);
                ?>
            </div>
        </div> 



        <div class="content-section" id="objetstrouve">
            <div class="hidden-xs"><br/><br/><br/><br/><br/></div>
            <div class="container">
                <div class="row">
                    <div class="heading-section col-md-12 text-center">
                        <h2><a href="index.php?page=objetstrouve">Objets trouvés</h2>
                        <p>Ici sont centralisées toutes les annonces d'objets perdus ou trouvés sur le plateau</a></p>
                    </div>
                </div> 
                <?php
                // il faudrait rechercher pour $statut = 3 ou = 2
                printQuatreDernières($dbh,2);
                ?>
            </div> 
        </div> 


        <div class="content-section" id="contact">
            
            <div class="hidden-xs"><br/><br/><br/><br/><br/></div>
            <div class="container">
                <div class="row">
                    <div class="heading-section col-md-12 text-center">
                        <h2>Contact</h2>
                        <p>Envoyez nous un message</p>
                    </div> 
                </div> 
                <div class="row">
                    <div class="col-md-7 col-sm-6 text-center">
                        <p>Ce site web a été conçu dans le cadre du Modal Web par Tristan Ricoul et Benoît Sauty. Il est libre d'utilisation
                            et si vous avez des remarques à nous faire parvenir n'hésitez pas à utiliser le formulaire pour nous envoyer un mail.
                        </p>
                        <ul class="contact-info">
                            <li>Téléphone: 060102030405</li>
                            <li>Email: <a href="mailto:leboncoinmodalweb@hotmail.com">leboncoinmodalweb@hotmail.com</a></li>
                            <li>Addresse: Ecole Polytechnique, 91120 Palaiseau</li>
                        </ul>
                        <br><br>
                    </div> 
                    <div class="col-md-5 col-sm-6">
                        <div class="contact-form">
                            <form method="post" action="index.php?todo=sendmail" name="contactform" id="contactform">
                                <p>
                                    <input name="name" type="text" id="name" required placeholder="Nom">
                                </p>
                                <p>
                                    <input name="email" type="email" id="email" required placeholder="Email"> 
                                </p>
                                <p>
                                    <input name="subject" type="text" id="subject" required placeholder="Sujet"> 
                                </p>
                                <p>
                                    <textarea name="comments" id="comments" required placeholder="Message"></textarea>    
                                </p>
                                <input type="submit" class="mainBtn" id="submit" value="Envoyer message">
                            </form>
                        </div> 
                    </div>
                </div> 
            </div> 
        </div> 