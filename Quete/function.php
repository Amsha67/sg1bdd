<?


function compterQuetesRestantes(array $quetes): int
{
    $quetesrestantes = 0;
    foreach ($quetes as $quete):

        if ($quete['exclamation'] === 0) {
            $quetesrestantes++;

        }
        if ($quete['exclamation'] === 1) {
            $quetesterminee++;
        }

    endforeach;
    return $quetesrestantes;
}







?>