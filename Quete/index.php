<?php

require_once __DIR__ . '/securite.php';
require_once __DIR__ . '/connexion.php';
require_once __DIR__ . '/function.php';
echo '<pre>';
echo 'Version PHP : ' . PHP_VERSION . PHP_EOL;
echo 'php.ini chargé : ' . (php_ini_loaded_file() ?: 'Aucun') . PHP_EOL;
echo 'Dossier des extensions : ' . ini_get('extension_dir') . PHP_EOL;

echo 'fileinfo : '
    . (extension_loaded('fileinfo') ? 'activée' : 'non activée');

echo '</pre>';
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
         FROM quetes
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


// 6. Commencer l’affichage seulement maintenant.
include __DIR__ . '/Asset/Header.php';

?>



<main class="theme-<?= htmlspecialchars(
    $theme,
    ENT_QUOTES,
    'UTF-8'
) ?>">


    <h2>Préférence d’affichage</h2>

    <form action="preference.php" method="post">
        <input type="hidden" name="csrf" value="<?= htmlspecialchars(
            $_SESSION['csrf'],
            ENT_QUOTES,
            'UTF-8'
        ) ?>">

        <label for="theme">Thème</label>

        <select id="theme" name="theme">
            <option value="clair" <?= $theme === 'clair' ? 'selected' : '' ?>>
                Clair
            </option>

            <option value="sombre" <?= $theme === 'sombre' ? 'selected' : '' ?>>
                Sombre
            </option>
        </select>

        <button type="submit">Enregistrer le thème</button>
    </form>

    <h1>
        Journal de quêtes :
    </h1>
    <?php if (is_string($message)): ?>
        <p role="status">
            <?= htmlspecialchars(
                $message,
                ENT_QUOTES,
                'UTF-8'
            ) ?>
        </p>
    <?php endif; ?>

    <nav>
        <a href="index.php">Toutes les quêtes</a>
        <a href="index.php?etat=demarre">Quêtes en cours</a>
        <a href="index.php?etat=fini">Quêtes terminées</a>
    </nav>


    <ul>
        <li>
            <?php echo 'Quêtes en cours : ', $quetesrestantes, '  '; ?>
        </li>
        <li>
            <?php echo 'Quêtes finies : ', $quetesterminee, '  '; ?>
        </li>
        <li>
            <?php echo 'Total des quêtes : ', $total; ?>
        </li>

    </ul>
    <h2>Ajouter une quête</h2>

    <form action="ajouter.php" method="post">
        <input type="hidden" name="csrf" value="<?= htmlspecialchars(
            $_SESSION['csrf'],
            ENT_QUOTES,
            'UTF-8'
        ) ?>">
        <label for="quete">Nom de la quête</label>
        <input id="quete" name="quete" required maxlength="150">

        <label for="etat-quete">État</label>
        <select id="etat-quete" name="etat">
            <option value="En cours">En cours</option>
            <option value="Finie">Terminée</option>
        </select>

        <button type="submit">Ajouter</button>
    </form>


    <h2>Quêtes affichées</h2>

    <p>
        Dans cette sélection :
        <?= $total ?> quête(s),
        dont
        <?= $quetesrestantes ?> en cours
        et
        <?= $quetesterminee ?> terminée(s).
    </p>

    <?php if (empty($quetes)): ?>

        <p>Aucune quête ne correspond à ce filtre.</p>

    <?php else: ?>

        <ul>
            <?php foreach ($quetes as $quete): ?>
                <li>
                    <h3>
                        <?= htmlspecialchars(
                            $quete['Nom'],
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>
                    </h3>
                    <p>
                        <?= htmlspecialchars(
                            $quete['Etat'],
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>
                    </p>

                    <span>
                        <?= (int) $quete['exclamation'] === 1
                            ? 'Terminée'
                            : 'En cours' ?>
                    </span>
                </li>
            <?php endforeach; ?>
        </ul>

    <?php endif; ?>
    <h2>Export des quêtes</h2>

    <form action="exporter.php" method="post">
        <input type="hidden" name="csrf" value="<?= htmlspecialchars(
            $_SESSION['csrf'],
            ENT_QUOTES,
            'UTF-8'
        ) ?>">

        <button type="submit">Exporter les quêtes en JSON</button>
    </form>

    <p>
        <a href="lire-export.php">Consulter le dernier export</a>
    </p>
    <!DOCTYPE html>
    <html lang="fr">
    <p>
        <a href="upload.php">Envoyer un fichier texte</a>
    </p>


    </body>

    </html>

</main>

<?php
include __DIR__ . '/Asset/Footer.php';
?>

<style>
    main {
        padding: 1.5rem;
        min-height: 80vh;
    }

    .theme-clair {
        background-color: #ffffff;
        color: #202020;
    }

    .theme-sombre {
        background-color: #202020;
        color: #f5f5f5;
    }

    .theme-clair a {
        color: #174ea6;
    }

    .theme-sombre a {
        color: #a8c7fa;
    }
</style>