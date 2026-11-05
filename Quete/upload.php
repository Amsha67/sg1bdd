<?php

require_once __DIR__ . '/securite.php';

$message = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verifierFormulaire();

    try {
        $fichier = $_FILES['document'] ?? null;

        if (
            !is_array($fichier)
            || !isset($fichier['error'])
            || !is_int($fichier['error'])
        ) {
            throw new RuntimeException(
                'Aucun fichier valide n’a été reçu.'
            );
        }

        if ($fichier['error'] === UPLOAD_ERR_NO_FILE) {
            throw new RuntimeException(
                'Choisissez un fichier avant de valider.'
            );
        }

        if (
            $fichier['error'] === UPLOAD_ERR_INI_SIZE
            || $fichier['error'] === UPLOAD_ERR_FORM_SIZE
        ) {
            throw new RuntimeException(
                'Le fichier dépasse la taille autorisée.'
            );
        }

        if ($fichier['error'] !== UPLOAD_ERR_OK) {
            throw new RuntimeException(
                'L’envoi du fichier a échoué.'
            );
        }

        if (
            !isset($fichier['name'], $fichier['tmp_name'])
            || !is_string($fichier['name'])
            || !is_string($fichier['tmp_name'])
        ) {
            throw new RuntimeException(
                'Les informations du fichier sont invalides.'
            );
        }

        $cheminTemporaire = $fichier['tmp_name'];

        if (!is_uploaded_file($cheminTemporaire)) {
            throw new RuntimeException(
                'Le fichier ne provient pas d’un envoi autorisé.'
            );
        }

        // Mesurer le fichier reçu côté serveur.
        $taille = filesize($cheminTemporaire);

        if ($taille === false || $taille > 102400) {
            throw new RuntimeException(
                'Le fichier ne doit pas dépasser 100 Ko.'
            );
        }

        if ($taille === 0) {
            throw new RuntimeException(
                'Le fichier est vide.'
            );
        }

        $extension = strtolower(
            pathinfo($fichier['name'], PATHINFO_EXTENSION)
        );

        if ($extension !== 'txt') {
            throw new RuntimeException(
                'Seuls les fichiers avec l’extension .txt sont acceptés.'
            );
        }

        // Détecter le type à partir du contenu réel.
        $detecteur = new finfo(FILEINFO_MIME_TYPE);
        $mime = $detecteur->file($cheminTemporaire);

        if ($mime !== 'text/plain') {
            throw new RuntimeException(
                'Le contenu doit être reconnu comme du texte brut.'
            );
        }

        require __DIR__ . '/stockage.php';

        // Ne pas réutiliser le nom fourni par le navigateur.
        $nomStockage = bin2hex(random_bytes(16)) . '.txt';

        $destination = $dossierUploads . '/' . $nomStockage;

        if (!move_uploaded_file($cheminTemporaire, $destination)) {
            throw new RuntimeException(
                'Le fichier n’a pas pu être enregistré.'
            );
        }

        $message = 'Le fichier texte a bien été enregistré.';
    } catch (RuntimeException $erreur) {
        $message = $erreur->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Envoyer un fichier texte</title>
</head>

<body>
    <h1>Envoyer un fichier texte</h1>

    <p>
        Format accepté : .txt.
        Taille maximale : 100 Ko.
        Les fichiers vides sont refusés.
    </p>

    <?php if ($message !== null): ?>
        <p role="status">
            <?= htmlspecialchars(
                $message,
                ENT_QUOTES,
                'UTF-8'
            ) ?>
        </p>
    <?php endif; ?>

    <form action="upload.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="csrf" value="<?= htmlspecialchars(
            $_SESSION['csrf'],
            ENT_QUOTES,
            'UTF-8'
        ) ?>">

        <label for="document">Fichier texte</label>

        <input type="file" id="document" name="document" accept=".txt,text/plain">

        <button type="submit">Envoyer</button>
    </form>

    <a href="index.php">Retour au journal</a>
</body>

</html>