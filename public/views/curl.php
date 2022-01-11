<?php

$ch = curl_init();
$url = 'https://regiowyniki.pl/kalendarz/Pilka_Nozna/2021/2022/Malopolskie/Liga_okregowa/Wadowice/';
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
$response = curl_exec($ch);
curl_close($ch);



echo $response;

