<?php

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
echo "En cours";

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
    <ul>


        <br>
        <?php foreach ($quetes as $quete):
            echo "En cours";
            if ($quete['exclamation'] == false) {
                $quetesrestantes++;
            }
            if ($quete['exclamation'] == true) {
                $quetesterminee++;
            }




            ?>
            <br>


            <li>
                <h3>
                    <?php
                    echo $quete['Nom'];
                    ?>
                    <p>
                        <?php
                        echo $quete['Etat'];
                        ?>
                    </p>
                    <span>
                        <?php
                        echo $quete['exclamation'];
                        ?>
                    </span>
                </h3>
            </li>
        <?php endforeach; ?>
    </ul>

</main>

<?php

include __DIR__ . '/Asset/Footer.php';
?>