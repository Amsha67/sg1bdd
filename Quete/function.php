<?






if ($exclamation === true) {
    echo "Terminée";
} else {
    echo "En cours";
}
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
echo "En cours 1";
$quetesrestantes = compterQuetesRestantes($quetes);
$quetesterminee = $total - $quetesrestantes;



include __DIR__ . '/Asset/Header.php';

echo "En cours";

?>