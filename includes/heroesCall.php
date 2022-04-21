<?php
    $heroesData = [];

    foreach($heroesIds as $id)
    {
        $url = 'http://gateway.marvel.com/v1/public/characters/' . $id . '?ts=' . $time . '&apikey=' .$apiKeyPublic. '&hash='.$hash;
        $static = 'http://gateway.marvel.com/v1/public/characters/'. $id;
        $call = apiCall($url, $static);
        $data = $call->data->results[0];
        $heroesData[] = $data;
    }