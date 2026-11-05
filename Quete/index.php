<?php

require_once __DIR__ . '/securite.php';
require_once __DIR__ . '/connexion.php';
require_once __DIR__ . '/function.php';

// 1. Lire le filtre transmis dans l’URL.
$etat = $_GET['etat'] ?? 'toutes';

// 2. Définir les filtres acceptés.
$etatsAutorises = ['toutes', 'demarre', 'fini',];

// 3. Revenir à la liste complète si la valeur est inconnue.
if (!in_array($etat, $etatsAutorises, true)) {
    $etat = 'toutes';
}

// 4. Récupérer les quêtes correspondant au filtre.
if ($etat === 'toutes') {
    $requete = $pdo->query(
        'SELECT Id_quete, Nom, Etat, exclamation
         FROM quetes
         ORDER BY Id_quete DESC'
    );
} else {
    $valeurExclamation = ($etat === 'fini') ? 1 : 0;

    $requete = $pdo->prepare(
        'SELECT Id_quete, Nom, Etat, exclamation
         FROM quetes²
         WHERE exclamation = :exclamation
         ORDER BY Id_quete DESC'
    );

    $requete->bindValue(
        ':exclamation',
        $valeurExclamation,
        PDO::PARAM_INT
    );
    $requete->execute();
}

$quetes = $requete->fetchAll(PDO::FETCH_ASSOC);

// 5. Compter les quêtes présentes dans la liste affichée.
$total = count($quetes);
$quetesrestantes = compterQuetesRestantes($quetes);
$quetesterminee = $total - $quetesrestantes;
$message = $_SESSION['message'] ?? null;

unset($_SESSION['message']);

$theme = $_COOKIE['theme'] ?? 'clair';

if (!in_array($theme, ['clair', 'sombre'], true)) {
    $theme = 'clair';
}

require __DIR__ . '/vues/liste.php';

?>