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

//$html = file_get_html('https://regiowyniki.pl/kalendarz/Pilka_Nozna/2021/2022/Malopolskie/Liga_okregowa/Krakow_I/');
$html = new simple_html_dom();
$html->load($response);


$kolejki_array = $html->find('#leagueroundsaccordion', 0);

//var_dump($kolejki_array->find('div[class="panel panel-default matcheslist"]'), 0);


foreach ($html->find('.matcheslist') as $item) {

    echo  $header = $item->find('.panel-heading', 0);
    echo  $header = $item->find('.panel-heading', 0)->getAttribute('id');
    foreach ($item->find('.panel-collapse', 0)->find('li') as $li) {
        // echo $li->first_child();
    }


}



