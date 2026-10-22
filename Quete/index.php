<?php
require __DIR__ . '/donnees.php';

if ($exclamation === true) {
    echo "Terminée";
} else {
    echo "En cours";
}



$total = count($quetes);
function compterQuetesRestantes(array $quetes): int
{
    $quetesrestantes = 0;
    foreach ($quetes as $quete):

        if ($quete['exclamation'] == false) {
            $quetesrestantes++;
        }
        if ($quete['exclamation'] == true) {
            $quetesterminee++;
        }

    endforeach;
    return $quetesrestantes;
}

$quetesrestantes = compterQuetesRestantes($quetes);
$quetesterminee = $total - $quetesrestantes;



include __DIR__ . '/Asset/Header.php';
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