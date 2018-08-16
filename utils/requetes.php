<!-- Cette page regroupe toutes les requêtes sql pour les deux objets (utilisateurs et objets) et la fonction de connection
à la base de donnée-->



<?php


class Database {
    public static function connect() {
        $dsn = 'mysql:dbname=leboncoin;host=127.0.0.1';
        $user = 'root';
        $password = '';
        $dbh = null;
        try {
            $dbh = new PDO($dsn, $user, $password,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            $dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        } catch (PDOException $e) {
            echo 'Connexion échouée : ' . $e->getMessage();
            exit(0);
        }
        return $dbh;
    }
}

class Utilisateur {
    public $login;
    public $mdp;
    public $mail;
    //statut = 0 si admin, 1 si membre normal et 2 si demande d'être admin mais pas encore accepté
    public $statut;
   
    public static function getUtilisateur($dbh,$login){
        $query = "SELECT * FROM users WHERE login=?";
        $sth = $dbh->prepare($query);
        $sth->setFetchMode(PDO::FETCH_CLASS, 'Utilisateur');
        $sth->execute(array($login));
        $user = $sth->fetch();
        return $user;
    }
    
    public static function insererUtilisateur($dbh,$login,$mdp,$mail,$statut){
        if (Utilisateur::getUtilisateur($dbh,$login)!= NULL){
            echo 'Ce login est deja utilise. Veuillez choisir un autre login.';
        }
        else{
            $sth = $dbh->prepare("INSERT INTO users (`login`, `mdp`, `mail`, `statut`) VALUES(?,?,?,?)");
            $pass = passhash($mdp);
            $sth->execute(array($login,$pass,$mail,$statut));
        }
    }
    
    public static function changeMdp($dbh,$login,$mdp){
        $query = "UPDATE users SET mdp=? WHERE login=?;";
        $sth = $dbh->prepare($query);
        $sth->execute(array(passhash($mdp),$login));
    }
    
    public static function supprimerUtilisateur($dbh,$login){
        $query = "DELETE FROM users WHERE login=?;";
        $sth = $dbh->prepare($query);
        $sth->execute(array($login));
    }
    
    public static function testerMdp($dbh,$user,$pass){
        $b=false;
        if ($user == false){
            $b = false;
        }
        else{
            $b = (passhash($pass)==($user->mdp));
        }
        return $b;
    }
    
    
    public static function statutAdmin($dbh,$login){
        $query = "UPDATE users SET statut = 0 WHERE login=?";
        $sth = $dbh->prepare($query);
        $sth->execute(array($login));
    }

    //permet d'obtenir les gens s'étant inscrits et voulant être administrateur
    public static function demandeAdmin($dbh){
        $query = "SELECT * FROM users WHERE statut = 2";
        $sth = $dbh->prepare($query);
        $sth->execute();
        $user = $sth -> fetchAll();
        return $user;
    }

    //recupere le statut d'une personne qui s'est connectée
    public static function recupererStatut($dbh,$login){
        $query = "SELECT statut FROM users WHERE login = ?";
        $sth = $dbh->prepare($query);
        $sth->execute(array($login));
        $user = $sth -> fetch();
        return $user["statut"];
    }
    
    public static function recupererMail($dbh,$login){
        $query = "SELECT mail FROM users WHERE login = ?";
        $sth = $dbh->prepare($query);
        $sth->execute(array($login));
        $user = $sth -> fetch();
        return $user["mail"];
    }
}   

$dbh = null;


Class Objet{
    //l'id sera auto-incrémenté et permet à deux annonces d'avoir le même nom
    public $id;
    public $nom;
    public $description;
    public $prix;
    public $lieu;
    //pour le statut 1=à vendre, 2=trouvé, 3=perdu
    public $statut;
    public $categorie;
    public $img1;
    public $img2;
    public $vendeur;
    public $date;
    
    
    public static function creerObjet($dbh,$nom,$description,$prix,$lieu,$statut,$categorie,$img1,$img2,$vendeur,$date){
        $query = "INSERT INTO objets (nom,description,prix,lieu,statut,categorie,img1,img2, vendeur,date) VALUES(?,?,?,?,?,?,?,?,?,?)";
        $sth = $dbh->prepare($query);
        $sth -> execute(array($nom,$description,$prix,$lieu,$statut,$categorie,$img1,$img2,$vendeur,$date));
    }
    
    public static function recupererId($dbh,$statut){
        $query = "SELECT id FROM objets WHERE statut=?";
        $sth = $dbh->prepare($query);
        $sth -> execute(array($statut));
        $type = $sth -> fetch();
        return $type["id"];
    }
    
    // récupère toutes les annonces filtrées par ordre décroissant d'id
    public static function recupererAnnonces($dbh,$requete){
        $query = "SELECT * FROM objets ".$requete."ORDER BY id DESC";
        $sth = $dbh->prepare($query);
        $sth -> execute();
        return $sth; // Il vaudrait mieux renvoyer après avoir fait fetch();
    }
    
    public static function recupererAnnoncesVendeur($dbh,$vendeur){
        $query = "SELECT * FROM objets WHERE vendeur=? ORDER BY id DESC";
        $sth = $dbh->prepare($query);
        $sth -> execute(array($vendeur));
        $objets = $sth -> fetchAll();
        return $objets;
    }
    
    // récupère toute les quatre dernières annonces par ordre décroissant d'id
    public static function recupererQuatreDerniers($dbh,$statut){
        $query = "SELECT * FROM objets WHERE statut=? ORDER BY id DESC LIMIT 4";
        $sth = $dbh->prepare($query);
        $sth -> execute(array($statut));
        return $sth; // Il vaudrait mieux renvoyer après avoir fait fetch();
    }
    
    // renvoie l'objet associé à l'id (sous la forme de la Class Objet)
    public static function recupererdepuisId($dbh,$id){
        $query = "SELECT * FROM objets WHERE id=?";
        $sth = $dbh->prepare($query);
        $sth -> execute(array($id));
        $objet = $sth -> fetch();
        return $objet;
    }
    
    public static function recupererObjetCat($dbh,$statut,$categorie){
    $identifiant = Objet::recupererId($dbh, $statut);
    $query = "SELECT * FROM objets WHERE id=? AND categorie=?";
    $sth = $dbh->prepare($query);
    $sth->execute(array($identifiant),$categorie);
    $user = $sth -> fetchAll();
    return $user;
    }
        
    //éventuellement si il nous reste du temps, mais vraiment pas très utile
    public static function recupererObjetLieu($dbh,$lieu){
    $query = "SELECT * FROM objets WHERE lieu =?";
    $sth = $dbh->prepare($query);
    $sth->execute(array($lieu));
    $user = $sth -> fetchAll();
    return $user;
    }
    
    public static function supprimerObjet($dbh,$id){
        $objet = Objet::recupererdepuisId($dbh,$id);
        if ($objet['img1'] != ""){
        $dossier = dirname($objet['img1']);
        deleteDirectory($dossier);}
        $query = "DELETE FROM objets WHERE id=?;";
        $sth = $dbh->prepare($query);
        $sth->execute(array($id));
    }
    
    public static function supprimerAnnoncesUtilisateur($dbh,$login){
        $sth = Objet::recupererAnnoncesVendeur($dbh, $login);
        foreach($sth as $objet){
            Objet::supprimerObjet($dbh, $objet['id']);
        }
    }
}
?>