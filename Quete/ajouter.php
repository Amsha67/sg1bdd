<?php

$quete = $_POST['quete'] ?? '';
$etat = $_POST['etat'] ?? '';

if (!is_string($quete) || !is_string($etat)) {
    exit('Données invalides.');
}

$quete = trim($quete);

if ($quete === '')
    exit('Lenomestobligatoire.');
if (!in_array($etat, ['finie', 'encours',], true)) {
    exit('La priorité est invalide.');
}

echo 'Données reçues et valides.';
