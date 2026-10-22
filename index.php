<?php
// $nom = "Quête de test";

// $etat = "Démarrée";

// $exclamation = false;

?>

<?php
if ($exclamation === true) {
    echo "Terminée";
} else {
    echo "En cours";
}
?>

<?php
$quetes = [
    [
        'id' => 1,
        'nom' => '1ere Quête',
        'etat' => 'Démarée',
        'exclamation' => true,
    ],
    [
        'id' => 2,
        'nom' => '2eme Quête',
        'etat' => 'Démarée',
        'exclamation' => true,

    ],
    [
        'id' => 3,
        'nom' => '3eme Quête',
        'etat' => 'Finie',
        'exclamation' => false,
    ],
    [
        'id' => 4,
        'nom' => '4eme Quête',
        'etat' => 'Finie',
        'exclamation' => true,
    ]
];

$quetesrestantes = 0;
$quetesterminee = $total - $quetesrestantes;



?>

<!DOCTYPE html>

<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SG1</title>
</head>

<body>
    <main>
        <h1>
            <?php
            // echo $nom, "/", $etat, "/", $exclamation;
            // echo $quete['etat'];
            
            ?>
            <br>
            <?php
            // echo $quete['nom'];
            ?>
        </h1>
        
        <h2>
            <?php
            $total = count($quetes);
            echo $total;

            ?>

        </h2>

        <ul>
            
        
        
        <br>
            <?php foreach ($quetes as $quete):

                if ($quete['exclamation'] == false) {
                    $quetesrestantes++;
                }

                echo $quetesrestantes;



                ?>
                <br>
                
               <?php foreach ($quetes as $quete):

                if ($quete['exclamation'] == true) {
                    $quetesterminee++;
                }

                echo $quetesterminee;
                ?>
                

                <li>
                    <h3>

                        <?php
                        echo $quete['nom'];
                        ?>
                        <p>
                            <?php
                            echo $quete['etat'];
                            ?>

                        </p>
                        <span><?php
                        echo $quete['exclamation'];
                        ?></span>
                    </h3>
                </li>
            <?php endforeach; ?>
        </ul>

    </main>
</body>

</html>