<?php
include __DIR__ . '/Asset/Header.php';

require __DIR__ . '/donnees.php';
require __DIR__ . '/connexion.php';
require __DIR__ . '/function.php';





$requete = $pdo->query(
    'SELECT Id_quete, Nom, Etat, exclamation FROM quetes'
);

$quetes = $requete->fetchAll();
echo '<pre>';
var_dump($quetes);
echo '</pre>';





$total = count($quetes);
$quetesrestantes = compterQuetesRestantes($quetes);
$quetesterminee = $total - $quetesrestantes;

?>


<main>
    <h1>
        Journal de quêtes :
    </h1>

    <h2>

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
    </h2>
    <h2>

    </h2>
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

    <ul>
        <!-- <br> -->
        <?php foreach ($quetes as $quete):
            // echo "En cours";
            // if ($quete['exclamation'] == false) {
            //     $quetesrestantes++;
            // }
            // if ($quete['exclamation'] == true) {
            //     $quetesterminee++;
            // } ?>
            <br>
            <li>
                <h3>
                    <?php
                    echo $quete['Nom'];
                    ?>
                </h3>
                <p>
                    <?php
                    echo $quete['Etat'];
                    ?>
                </p>
                <span>
                    <?php
                    if ($quete['exclamation'] === 1) {
                        echo "Terminée";
                    } else {
                        echo "En cours";
                    }
                    ?>
                </span>
            </li>
        <?php endforeach; ?>
    </ul>
</main>

<?php
include __DIR__ . '/Asset/Footer.php';
?>