<?php
require 'openid.php'; // Utilise la bibliothèque LightOpenID (disponible gratuitement sur GitHub)

try {
    $openid = new LightOpenID('http://mondomaine.com/steam_login.php'); // Remplace par l'URL de ton site
    
    if(!$openid->mode) {
        $openid->identity = 'https://steamcommunity.com/openid';
        header('Location: ' . $openid->url());
    } elseif($openid->mode == 'cancel') {
        echo 'Connexion annulée.';
    } else {
        if($openid->validate()) {
            // L'utilisateur est connecté ! On récupère son SteamID64
            $id = basename($openid->identity);
            
            // Redirige vers ton interface GMod avec le SteamID validé
            header('Location: index.html?connected=true&steamid=' . $id);
            exit;
        } else {
            echo 'Échec de l\'authentification.';
        }
    }
} catch(ErrorException $e) {
    echo $e->getMessage();
}
?>
