
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
                                </div> <!-- /.logo-wrapper -->
                                <div class="col-md-10 col-sm-10 main-menu text-right">
                                    <div class="toggle-menu visible-sm visible-xs"><i class="fa fa-bars"></i></div>
                                    <ul class="menu-first">
                                        <li><a href="index.php">Accueil</a></li>
                                        <li><a href="index.php#objetsvente">Objets à vendre</a></li>
                                        <li class="active"><a href="#">Objets trouvés</a></li> 
                                        <li><a href="index.php#contact">Contact</a></li>
                                        <li><a href="index.php?page=membre" class="external" target="_parent" rel="nofollow"><?php $res = est_connecte(); echo $res; ?></a></li> 
                                    </ul>                                    
                                </div> 
                            </div> 
                        </div>                       
                    </div>
                </div>
            </div>
            
            
            
            
        <div class="content-section" id="objetstrouve">
            <div class="container">
                <div class="hiden-md-down">
                <p><br/><br/><br/><br/></p>
                </div>
                <div class="row">
                    <div class="heading-section col-md-12 text-center">
                        <p><br><br/></p>
                        <h2>Objets trouvés</h2>
                    </div>
                </div>
                <?php printFiltrageTrouve();
                ?>
                <?php
                    $requete = "WHERE statut=2 ";
                    printAnnonces($dbh,2,$requete);
                ?>
                <div class="row">
                    <div class="heading-section col-md-12 text-center">
                        <h2>Objets perdus</h2>
                    </div> 
                </div> 
                <?php
                    $requete = "WHERE statut=3 ";
                    printAnnonces($dbh,3,$requete);
                ?>
            </div> 
        </div> 