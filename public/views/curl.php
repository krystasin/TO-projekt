<?php
require_once 'simple_html_dom.php';
require_once __DIR__ . '/../../src/models/Kolejka.php';
require_once __DIR__ . '/../../src/models/Mecz.php';
require_once __DIR__ . '/../../src/models/Druzyna.php';

$url = 'https://regiowyniki.pl/kalendarz/Pilka_Nozna/2021/2022/Malopolskie/Liga_okregowa/Wadowice/';
$url = 'https://regiowyniki.pl/kalendarz/Pilka_Nozna/2021/2022/Malopolskie/Liga_okregowa/Krakow_I/';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
$response = curl_exec($ch);
curl_close($ch);
$html = new simple_html_dom();
$html->load($response);



foreach ($html->find('.matcheslist') as $kolejka) {

    echo  $header = $kolejka->find('.panel-heading', 0)->plaintext . "<br/>";
    //echo  $header = $kolejka->find('.panel-heading', 0)->getAttribute('id');
    foreach ($kolejka->find('.panel-collapse', 0)->find('li') as $li) {
         echo $r1 = $li->first_child();

    }


}