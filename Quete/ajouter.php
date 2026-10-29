<?php

require __DIR__ . '/connexion.php';


$quete = $_POST['quete'] ?? '';
$etat = $_POST['etat'] ?? '';

$quete = trim($quete);
$etat = trim($etat);



if (!is_string($quete) || !is_string($etat)) {
    exit('Données invalides.');
}


if ($quete === '')
    exit('Lenomestobligatoire.');
if (!in_array($etat, ['finie', 'encours',], true)) {
    exit('La priorité est invalide.');
}

$requete = $pdo->prepare(
    'INSERT INTO quetes (Nom, Etat)
     VALUES (:quete, :etat)'
);

$requete->execute([
    'quete' => $quete,
    'etat' => $etat,
]);

header('Location: index.php', true, 303);
exit;
