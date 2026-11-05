<?php

require_once __DIR__ . '/securite.php';
require_once __DIR__ . '/connexion.php';
require_once __DIR__ . '/function.php';

// 1. Lire le filtre transmis dans l’URL.
$etat = $_GET['etat'] ?? 'toutes';

// 2. Définir les filtres acceptés.
$etatsAutorises = ['toutes', 'demarre', 'fini'];

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

// 6. Commencer l’affichage seulement maintenant.
include __DIR__ . '/Asset/Header.php';

?>



<main>
    <h1>
        Journal de quêtes :
    </h1>

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
    <a h></a>
    <h2>Ajouter une Quête</h2>
    <form action="ajouter.php" method="post">
        <label for="quete">Nom de la quête</label>
        <input id="quete" name="quete" required maxlength="150">

        <label for="etat">Etat</label>
        <select id="etat" name="etat">
            <option value="finie">Finie</option>
            <option value="encours">En cours</option>

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

</main>

<?php
include __DIR__ . '/Asset/Footer.php';
?>