<!-- Ce fichier recense les formulaires des différentes pages web--->

<?php

function print_form_connexion(){
    echo<<<END
    
<form class="form-horizontal col-sm-offset-1" action="index.php?page=membre&todo=register" method=post>
    <div class="col-sm-5 boxed">
    <fieldset>
  <div class="form-group">
    <label for="login" class="col-sm-4 control-label">Login *</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" id="login" required placeholder="Login" required name=login>
    </div>
  </div>
        <div class="form-group">
    <label for="mdp1" class="col-sm-4 control-label">Mot de passe *</label>
    <div class="col-sm-8">
      <input type="password" class="form-control" id="mdp1" required placeholder="Mot de passe" required name=mdp>
    </div>
        </div>
        <div class="form-group">
    <label for="mdp2" class="col-sm-4 control-label">Confirmer le mot de passe *</label>
    <div class="col-sm-8">
      <input type="password" class="form-control" id="mdp2" required placeholder="Confirmation mot de passe"  required  name=mdp2>
    </div>
  </div>
  <div class="form-group">
    <label for="email" class="col-sm-4 control-label">Email *</label>
    <div class="col-sm-8">
        <input type="email" class="form-control" id="email" required placeholder="Votre e-mail" required  name=mail>
    </div>
  </div>
     <div class="form-group">
    <label for="statut" class="col-sm-4 control-label">Devenir administrateur ?</label>
    <div class="col-sm-8">
        <p><br></p>
        <input type="radio" name="admin" value="oui" id="oui" /> 
        <label for="oui">Oui</label>
        <input type="radio" name="admin" value="non" id="non" checked="checked"/> 
        <label for="non">Non</label>
    </div>
  </div>
  <div class="g-recaptcha col-sm-offset-2 col-sm-9" data-sitekey="6LeH-T8UAAAAAFe4_Ad55bN1WcpFVKfOH-TYBD3q" style="overflow:auto;"></div>
  <div class="form-group">
    <div class="col-sm-offset-4 col-sm-6">
      <button type="submit" class="btn btn-default">S'inscrire</button>
    </div>
  </div>
  </fieldset>
  </div>
</form>    
    
  <form class="form-horizontal col-sm-offset-1" action="index.php?page=membre&todo=logIn" method="post">
   <div class=" col-sm-5 boxed"> 
   <fieldset>
  <div class="form-group">
    <label for="login" class="col-sm-4 control-label">Login</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" id="login" required placeholder="Login" name=login>
    </div>
  </div>
  <div class="form-group">
    <label for="mdp" class="col-sm-4 control-label">Mot de passe</label>
    <div class="col-sm-8">
      <input type="password" class="form-control" id="mdp" required placeholder="Mot de passe" name=mdp>
    </div>
  </div>
  <div class="form-group">
    <label for="cookies" class="col-sm-4 control-label">Rester connecté ?</label>
    <div class="col-sm-8">
        <input type="radio" name="cookies" value="ouicookies" id="oui" /> 
        <label for="ouicookies">Oui</label>
        <input type="radio" name="cookies" value="noncookies" id="non" checked="checked"/> 
        <label for="noncookies">Non</label>
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-4 col-sm-6">
      <button type="submit" class="btn btn-default">Se connecter</button>
    </div>
  </div>
       </fieldset>
</div>
</form>
    
    
<div class = "col-sm-5  ">
<div class = "article">   
    <div class="msg"> Pensez à vous connecter pour pouvoir poster vos annonces et contacter 
        les vendeurs. Si vous n'avez pas de compte créez en un ! C'est gratuit et
        ça prend 5 secondes. Si vous demandez à être administrateur, votre demande 
        sera examinée par les administrateurs du site.</div>
</div>
</div>
  
END;
}

function print_form_objetvente(){
    echo <<<END
	<form enctype="multipart/form-data" method="post" class="form-horizontal col-sm-offset-1" action="index.php?page=membre&todo=objetvendre" name="formulaire" id="formulaire">
            <div class="col-sm-5 boxed">
                <div class="titlebox">Déposez ici votre annonce !</div><br/>
                <fieldset>
                <div class="form-group col-sm-12">
                <div class="col-sm-offset-1">
		<input type="text" class="form-control" required placeholder="Titre de l'annonce" name="titre"  />
                </div>
                </div>
                <div class="form-group col-sm-12">
                <div class="col-sm-offset-1">
			<select name="categorie" id="category" class="form-control">
				<option value="0">Choisissez une cat&eacute;gorie</option>
				<option value='1' id='cat1' > VEHICULES</option>
				<option value='2' id='cat2' > IMMOBILIER</option>
				<option value='3' id='cat3' > MULTIMEDIA</option>
				<option value='4' id='cat4' >MOBILIER </option>
				<option value='5' id='cat5' > LOISIRS </option>
				<option value='6' id='cat6' > MATERIEL PROFESSIONNEL </option>
				<option value='7' id='cat7' > SERVICES ET AUTRES </option>
			</select>
                </div>
                </div> 
                <div class="form-group col-sm-12">
                <div class="col-sm-offset-1">
		<input type="number" class="form-control" required placeholder="Prix en euros" name="prix"  />
                </div>
                </div>
                <div class="form-group col-sm-12">
                <div class="col-sm-offset-1">
		<input type="text" class="form-control" required placeholder="Localisation" name="lieu"  />
                </div>
                </div>
                <div class="form-group col-sm-12">
                <div class="col-sm-offset-1">
		<textarea name="description" class="form-control" placeholder="Donnez ici une description rapide et précise de l'objet à vendre. Ne laissez aucun champ vide et mettez au moins une photo." required rows="4"></textarea>
                </div>    
                </div>
                <div class="form-group">
                  <label for="img1" class="col-sm-3 control-label">Photo n°1 </label>
                <div class="col-sm-8">
                    <input type="file" class="form-control" required name="img1" id="image1">
                </div>
                </div>
                <div class="form-group">
                <label for="img1" class="col-sm-3 control-label">Photo n°2 </label>
                <div class="col-sm-8">
                    <input type="file" class="form-control" name="img2" id="image2">
                </div>
                </div
                <div class="form-group">
                <div class ="col-sm-offset-3 col-sm-5">
                <button type="submit" class="btn btn-default">Déposer l'annonce</button>
                </div>
            </div>
                </fieldset>
            </div>
        </form>
END;
}

function print_form_objettrouve(){
    echo<<<END
        <form enctype="multipart/form-data" method="post" class="form-horizontal col-sm-offset-1" action="index.php?page=membre&todo=objettrouve" name="formulaire" id="formulaire">
            <div class="col-sm-5 boxed">
                <div class="titlebox">Décrivez ici l'objet trouvé !</div><br/>
                <fieldset>
                <div class="form-group col-sm-12">
                <div class="col-sm-offset-1">
		<input type="text" class="form-control" required placeholder="Titre de l'annonce" name="titre"  />
                </div>
                </div>
                <div class="form-group col-sm-12">
                <div class="col-sm-offset-1">
		<input type="text" class="form-control" required placeholder="Localisation" name="lieu"  />
                </div>
                </div>
                <div class="form-group col-sm-12">
                <div class="col-sm-offset-1">
		<textarea name="description" class="form-control" placeholder="Donnez ici une description rapide et précise de l'objet trouvé. Ne laissez aucun champ vide et mettez au moins une photo." required rows="4"></textarea>
                </div>    
                </div>
                <div class="form-group">
                <label for="img1" class="col-sm-3 control-label">Photo n°1 </label>
                <div class="col-sm-8">
                    <input type="file" class="form-control" required name="img1" id="image1">
                </div>
                </div>
                <div class="form-group">
                <label for="img1" class="col-sm-3 control-label">Photo n°2 </label>
                <div class="col-sm-8">
                    <input type="file" class="form-control" name="img2" id="image2">
                </div>
                </div>
                <div class="form-group">
                <div class ="col-sm-offset-3 col-sm-5">
                <button type="submit" class="btn btn-default">Déposer l'annonce</button>
                </div>
                </div>
                </fieldset>
            </div>
        </form>
END;
}

function print_form_objetperdu(){
    echo<<<END
        <form enctype="multipart/form-data" method="post" class="form-horizontal col-sm-offset-1" action="index.php?page=membre&todo=objetperdu" name="formulaire" id="formulaire">
            <div class="col-sm-5 boxed">
                <div class="titlebox">Décrivez ici l'objet perdu !</div><br/>
                <fieldset>
                <div class="form-group col-sm-12">
                <div class="col-sm-offset-1">
		<input type="text" class="form-control" required placeholder="Nom de l'objet" name="titre"  />
                </div>
                </div>
                <div class="form-group col-sm-12">
                <div class="col-sm-offset-1">
		<input type="text" class="form-control" required placeholder="Localisation" name="lieu"  />
                </div>
                </div>
                <div class="form-group col-sm-12">
                <div class="col-sm-offset-1">
		<textarea name="description" class="form-control" placeholder="Donnez ici une description rapide et précise de l'objet perdu. Ne laissez aucun champ vide." required rows="4"></textarea>
                </div>    
                </div>
                <div class="form-group">
                <div class ="col-sm-offset-3 col-sm-5">
                <button type="submit" class="btn btn-default">Déposer l'annonce</button>
                </div>
            </div>
                </fieldset>
            </div>
        </form>
END;
}

function print_form_annonce(){
    echo <<<END
    <div class="col-sm-offset-1">
    <div class="col-sm-5 boxed">
<form method="post" action="index.php?page=membre" name="formulaire">
    
    <div class="titlebox"> Que souhaitez vous faire ?</div><br/>
    <fieldset>
    
    <div class="col-sm-offset-2">
    <div class="form-group col-sm-10">
    <div>
    <input type="submit" class="form-control" value="Vendre un objet" placeholder="Vendre un objet" name="annonces" />
    <br />
    </div>
    <div>
    <input type="submit" class="form-control" value="Déclarer un objet trouvé" name="annonces" />
    <br />
    </div>
    <div>
    <input type="submit" class="form-control" value="Déclarer la perte d'un objet" name="annonces" />
    <br/>
    </div>   
    </fieldset>
</form>
    </div>
    </div>
    </div>
END;
}

function print_form_changemdp(){
    echo <<<END
    <form method="post" class="form-horizontal" action="index.php?page=membre&todo=passchange" name="formulaire" id="formulaire">
            
        <div class="col-sm-5 boxed">
                <fieldset>
                <br />
                <div class="form-group">
    <label for="login" class="col-sm-3 control-label">Login</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" id="login" placeholder="login" required name=login>
    </div></div>
               <div class="form-group">
    <label for="mdp" class="col-sm-3 control-label">Ancien mot de passe</label>
    <div class="col-sm-8">
      <input type="password" class="form-control" id="mdp" placeholder ="Ancien mot de passe" required name=mdp>
    </div></div>
                <div class="form-group">
    <label for="mdp1" class="col-sm-3 control-label">Nouveau mot de passe</label>
    <div class="col-sm-8">
      <input type="password" class="form-control" id="mdp1" required placeholder="Nouveau mot de passe" name=mdp1>
    </div></div>
                <div class="form-group">
    <label for="mdp2" class="col-sm-3 control-label">Confirmez mot de passe</label>
    <div class="col-sm-8">
      <input type="password" class="form-control" id="mdp2" placeholder="Confirmation mot de passe"  required name=mdp2>
    </div></div>
            <div class="form-group">
                <div class ="col-sm-offset-3 col-sm-5">
                <button type="submit" class="btn btn-default">Changer mon mot de passe</button>
                </div>
            </div>
                </fieldset>
    
</div>        
        </form>
END;
}

function print_form_supprimercompte(){
    echo'<form method="post" class="form-horizontal" action="index.php?page=membre&todo=deleteaccount&token=';
    echo $_SESSION['token'];
    echo<<<END
        " name="formulaire" id="formulaire">
            
        <div class="col-sm-5 boxed">
                <fieldset>
                <br />
                <div class="form-group">
    <label for="login" class="col-sm-3 control-label">Login</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" id="login" placeholder ="login" required name=login>
    </div></div>
               <div class="form-group">
    <label for="mdp" class="col-sm-3 control-label">Mot de passe</label>
    <div class="col-sm-8">
      <input type="password" class="form-control" id="mdp" placeholder="Mot de passe" required name=mdp>
    </div></div>
            <div class="form-group">
                <div class ="col-sm-offset-3 col-sm-5">
                <button type="submit" class="btn btn-default">Supprimer mon compte</button>
                </div>
            </div>
                </fieldset>
    
</div>        
        </form>


END;

}

function print_form_admin($tab){
    echo <<< END
    
    <div class="col-sm-offset-1 col-sm-4 boxed">
    <div class="titlebox">Gestion des annonces</div><br/>
    <fieldset>
END;
    echo<<<END
        <table>
            <tr>
            <th>Demandeur</th>
            <th>Accepter la demande</th>
            </tr>
END;
    foreach ($tab as $value) {
        $a = $value["login"];
        echo '<tr><td>' . htmlspecialchars($a). '</td><td> <a href="index.php?page=membre&todo=admin&login=' . htmlspecialchars($a) . '&token='.$_SESSION['token'].'"><button type="button" class="btn btn-default" >Nommer administrateur</button></a></td></tr>';
    }
     echo <<< END
    
        </table>
    </fieldset>
  
</div>
END;
}

function print_form_gestioncompte(){
    echo <<<END
    <div class="col-sm-offset-1">
    <div class="col-sm-5 boxed">
<form method="post" action="index.php?page=membre" name="formulaire">
    
    <div class="titlebox"> Gestion du compte</div><br/>
    <fieldset>
    <div class="col-sm-offset-2">
    <div class="form-group col-sm-10">
    <div>
    <input type="submit" class="form-control" value="Changer mon mot de passe" placeholder="Vendre un objet" name="membre" />
    <br />
    </div>
    <div>
    <input type="submit" class="form-control" value="Supprimer mon compte" name="membre" />
    <br />
    </div>
    <div>
    <input type="submit" class="form-control" value="Gérer mes annonces" name="membre" />
    <br/>
    </div>
END;
    if(isset($_SESSION['statut']) && $_SESSION['statut'] == 0){
    echo<<<END
    <div>
    <input type="submit" class="form-control" value="Gérer la liste des admins" name="membre" />
    <br/>
    </div>  
END;
    }
    echo<<<END
    </fieldset>
</form>
    </div>
    </div>
    </div>
    
END;
}

function print_form_gestionannonces($tab){
    echo <<< END
    
    <div class="col-sm-offset-1 col-sm-5 boxed">
    <div class="titlebox">Gestion des annonces</div><br/>
    <fieldset>
END;
    echo<<<END
        <table>
            <tr>
            <th>Nom de l'annonce</th>
            <th>Voir l'annonce</th>
            <th>Supprimer l'annonce</th>
            </tr>
END;
    foreach ($tab as $value) {
        $a = $value["nom"];
        $id = $value["id"];
        echo '<tr><td>' . htmlspecialchars($a). "</td><td> <a href='index.php?page=annonce&affichage=" . $id . "'><button type='button' class='btn btn-default' >Aller à l'annonce</button></a></td><td> <a href='index.php?page=membre&todo=deleteannonce&id=" . $id . "&token=". $_SESSION['token']."'><button type='button' class='btn btn-default' >Supprimer</button></a></td></tr>";
    }
     echo <<< END
    
        </table>
    </fieldset>
  
</div>
END;
}

// affiche le formulaire d'envoi de mail pour une annonce
function print_form_mail($id){
    echo<<<END
    <form enctype="multipart/form-data" method="post" class="form-horizontal col-sm-offset-1" action="index.php?page=annonce&affichage=$id &todo=sendmail" name="formulaire" id="formulaire">
 
                <div class="titlebox">Vous pouvez envoyer un mail !</div><br/>
                <fieldset>
                <div class="form-group col-sm-12">
                <textarea name="content" class="form-control" placeholder="Ecrivez ici votre message à la personne qui a posté l'annonce. Il recevra votre adresse mail et pourra ainsi vous contacter mais n'hésitez pas à lui laisser votre numéro de téléphone pour plus de facilité." required rows="7"></textarea>   
                </div>
                <div class="form-group">
                <div class ="col-sm-offset-3 col-sm-5">
                <button type="submit" class="btn btn-default">Envoyer</button>
                </div>
            </div>
                </fieldset>
           
        </form>
        </div>
END;
}

// affiche la barre de recherche des objets à vendre
function printFiltrageVente()
{
?>
    <div class="row filtre">
        
        <div class="col-lg-6 col-xs-12">
        <div class="boxed-filtre">
            <div class="titlebox">Recherche par mot clé</div><br/>
            <div class="form-group">
                <input type="text" class="col-xs-offset-3 col-xs-6 "  name="motclef" id="barreRecherche" placeholder="Tapez un mot clé"><br/>
            </div>
        </div>
        </div>
        <div class="col-xs-12 col-lg-6" >
            <div class='boxed-filtre'>
            <div class="titlebox">Recherche par gamme de prix</div><br/>
            <div class="form-group">
                <div>
                    <span class="col-xs-2 text-center">De</span>
                    <input type="number" class="col-xs-3" name="prixmin" id="barrePrixMin"/>
                    <span class="col-xs-2 text-center">€    à</span>
                    <input type="number" class="col-xs-3" name="prixmax" id="barrePrixMax"/>
                    <span class="col-xs-2 text-center">€</span>
                    <br/>
                </div>
            </div>
            </div>
        </div>
    </div>
    <div class="row filtre">
        <div class="col-sm-12">
            <div class="boxed-filtre">
            <div class="titlebox">Recherche par catégories</div><br/>
            <div class="form-group">
                <input type="checkbox" class="categories" value="1" checked/> <label>Véhicules</label>
                <input type="checkbox" class="categories" value="2" checked/> <label>Immobilier</label>
                <input type="checkbox" class="categories" value="3" checked/> <label>Multimédia</label>
                <input type="checkbox" class="categories" value="4" checked/> <label>Mobilier</label>
                <input type="checkbox" class="categories" value="5" checked/> <label>Loisirs</label>
                <input type="checkbox" class="categories" value="6" checked/> <label>Matériel professionnel</label>
                <input type="checkbox" class="categories" value="7" checked/> <label>Services et autres</label>
            </div>
            </div>
        </div>
    </div>
    <div class="row titlebox boxed-nb" id="nbannonce"></div>
<?php   
}

// affiche la barre de recherche pour la page des objets trouvés
function printFiltrageTrouve()
{
?>
    
        
        <div class="row filtre">
        <div class="col-xs-12">
        <div class="boxed-filtre">
            <div class="titlebox">Recherche par mot clé</div><br/>
            <div class="form-group">
                <input type="text" class="col-xs-offset-3 col-xs-6 "  name="motclef" id="barreRecherche" placeholder="Tapez un mot clé"><br/>
            </div>
        </div>
        </div>
        </div>
        <div class="row titlebox boxed-nb" id="nbannonce"></div>
<?php
}