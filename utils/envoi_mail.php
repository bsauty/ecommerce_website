<?php
//email : leboncoinmodalweb@hotmail.com
//password : modal2017


function envoi_mail($to, $from, $objet, $msg){
$mail = $to; // Déclaration de l'adresse de destination.
if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) // On filtre les serveurs qui rencontrent des bogues.
{
    $passage_ligne = "\r\n";
}
else
{
    $passage_ligne = "\n";
}
//=====Déclaration des messages au format texte et au format HTML.
if($msg=="new_registration"){
    $message_html = "
<!DOCTYPE html>
<html>
<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' /> 
<title>Email accueil HTML</title>
<body style='margin: 0px 0px 0px 0px; padding: 0px 0px 0px 0px; font-family: Trebuchet MS, Arial, Verdana, sans-serif;'>
 

<table width='100%' height='100%' cellpadding='0' style='padding: 20px 0px 20px 0px' background='images/background.jpg' >
    <tr align='center'>
        <td>

            <table style='width:580px; height:108px;' background='images/white.jpg' border='0'>
            <tr>
                <td valign='top' style='width:456px;'>
                    <h1 style='font-size:22px; color:#ec523f;margin-left:20px; margin-top:26px;'>Inscription sur Leboncoin</h1>
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
                    <p>Félicitation, vous êtes inscrits sur Leboncoin, la plateforme de recensement des objets à vendre/perdus/trouvés sur le plateau de Saclay. Vous pouvez désormais déposer vos annonces et envoyer des messages aux autres utilisateurs si vous êtes intéressé par leurs annonces.</p>
                </td>
                <td>
                    <a href='localhost/leboncoin/' target='_blank'><img src='images/mac.jpg' width='230' height='189' style='border:none;margin-left:0px;' /></a>
                </td>
            </tr>
            </table>
            

            <table cellpadding='0' cellspacing='0' width='580' background='images/white.jpg' style='padding:30px 0px 40px 0px;'>
            <tr>
                <td>
                    <a href='localhost/leboncoin/' target='_blank'><img src='images/mac2.jpg' width='250' height='170' style='border:none;margin-left:70px;' /></a>
                </td>
                <td valign='top' style='color:#808080; font-size:11px; padding:0px 18px 0px 19px; text-align:justify; line-height:25px;'>
                    <p>Par sécurité nous vous avons demandé d'inscrire un mot de passe de plus de 6 caractères, dont au moins une majuscule, une miscule et un chiffre. Pour vous aidez à protéger vos données, nous vous incitons fortement à ne pas utiliser le même mot de passe pour plusieurs sites web et nous vous recommandons de le changer au moins une fois par an. </p>
                </td>
            </tr>
            </table>
           

            <table style='width:580px; height:148px;' width='580' cellpadding='0' cellspacing='0' background='images/white.jpg' style='padding:0px 0px 0px 0px;'>
            <tr>
                <td>
                    <a href='localhost/leboncoin/' style='display : block; width : 80%;color: white;text-align: center;background-color: #ec523f;padding: 12px 20px;border-radius: 4px;text-transform: uppercase;font-weight: 700;margin-left: 40px;border:none;'target='_blank' >Retrouvez nous surleboncoin</a>
                </td>
            </tr>
            </table>
         
</body>
</html>
\n";
}
else{
$message_html = $msg;
}
//==========
 
//=====Création de la boundary
$boundary = "-----=".md5(rand());
//==========
 
//=====Définition du sujet.
$sujet = $objet;
//=========
 
//=====Création du header de l'e-mail.
$header = "From: \"Annonce leboncoin\"<".$from.">".$passage_ligne;
$header.= "Reply-to: \"Annonce leboncoin\" <".$from.">".$passage_ligne;
$header.= "MIME-Version: 1.0".$passage_ligne;
$header.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
//==========

//=====Création du message.
$message = $passage_ligne."--".$boundary.$passage_ligne;
//=====Ajout du message au format HTML
$message.= "Content-Type: text/html; charset=\"ISO-8859-1\"".$passage_ligne;
$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
$message.= $passage_ligne.$message_html.$passage_ligne;
//==========
$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
//==========
 
//=====Envoi de l'e-mail.
@mail($mail, utf8_decode($sujet),utf8_decode($message),$header);
//==========

}



