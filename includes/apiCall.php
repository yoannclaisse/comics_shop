<!-- FUNCTION TO CALL API -->
<?php
// function for call api transfort to json and creat cache
function apiCall($url, $md5)
{
    // hashage + nom du fichier
    $fileName = md5($md5);
    // chemin du fichier
    $filePath = './cache/' . $fileName;

    $fileExists = file_exists($filePath);

    if($fileExists)
    {
        $fileTime = filemtime($filePath);
        $time = time();

        if($fileTime < $time - 60 * 24)
        {
            unlink($filePath);
            $fileExists = false;
        }
    }

    if($fileExists)
    {
        $result = file_get_contents($filePath);
    }
    else
    {
        $curl = curl_init();                                    // Crée la requête
        curl_setopt($curl, CURLOPT_URL, $url);                  // Défini l'URL
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);       // Renvoyer le resultat au lieu de l'afficher
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);       // suit les redirections

        $result = curl_exec($curl);                             // Éxecuter la requête
        curl_close($curl);                                      // Fermer cURL

        file_put_contents($filePath, $result);
    }

    $result = json_decode($result);
    return $result;
}

$apiKeyPublic = 'b55e445a168db7fa6b78a10c6a0bd709';
$apiKeyPrivate = 'd0b0d03fa1fa05644e3e500a7157d0e2de342735';
$time = time();
$hash = md5($time.$apiKeyPrivate.$apiKeyPublic);

$heroesIds = 
    [
        1009282,
        1009368,
        1009664,
        1009351,
        1009220,
        1009189,
        1011054,
        1009187,
        1009155,
        1009652,
        1009268,
        1009718,
        1009262,
        1009257,
        1010925,
        1009592,
    ];





