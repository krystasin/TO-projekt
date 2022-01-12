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

$liga = [];


function getAllTeams($html)
{
    $druzyny = [];
    $t = $html->find('.matcheslist')[0];
    foreach ($t->find('.panel-collapse', 0)->find('li') as $li) {
        $c1 = $li->first_child()->firstchild();
        $c2 = $c1->next_sibling()->firstchild()->children(1)->firstchild();
        echo $c2 . "<br>";
        array_push($druzyny, trim($c2->children(0)->plaintext));
        array_push($druzyny, trim($c2->children(2)->plaintext));
    }
    var_dump($druzyny);
}
getAllTeams($html);

foreach ($html->find('.matcheslist') as $ko) {
    $kolejka = new Kolejka();
    $tmp = explode(' ', $ko->find('.panel-heading', 0)->plaintext);

    $kolejka->setNr(intval(explode('.', $tmp[4])[0], 10));
    $kolejka->setPoczatek($tmp[8] . " " . $tmp[9]);
    $kolejka->setKoniec($tmp[11] . " " . $tmp[12]);

    foreach ($ko->find('.panel-collapse', 0)->find('li') as $li) {
        $mecz = [];
        $c1 = $li->first_child()->firstchild();
        $data = $c1->first_child()->first_child();
        $godzina = trim(substr($data->next_sibling()->innertext, 0, -1));
        $mecz['godzina'] = $godzina;

        foreach (getDateFrom($data->plaintext) as $k => $v)
            $mecz[$k] = $v;
        foreach (getTeamsAndScore($c1) as $k => $v)
            $mecz[$k] = $v;

        $kolejka->addMecz($mecz);
    }
    array_push($liga, $kolejka);
}

function getTeamsAndScore($c1)
{

    $c2 = $c1->next_sibling()->firstchild()->children(1)->firstchild();
    $team_1 = $c2->children(0)->plaintext;
    $team_2 = $c2->children(2)->plaintext;
    $wynik = $c2->children(1);

    $team_1_wynik = $wynik->children(0)->firstchild()->plaintext;
    $team_2_wynik = $wynik->children(1)->firstchild()->plaintext;
    // echo "<br>>>team1: " . $team_1 . " : " . $team_1_wynik . "<br>";
    // echo ">>team2: " . $team_2 . " : " . $team_2_wynik . "<br>";
    return array('team_1' => $team_1, 'team_2' => $team_2, 'team_1_wynik' => $team_1_wynik, 'team_2_wynik' => $team_2_wynik);
}

function getDateFrom($data)
{

    $dzien = explode(" ", $data)[1];
    $miesiac_name = explode(" ", $data)[2];
    $miesiac = trim(explode("/", $data)[1]);


    return array('dzien' => $dzien, 'miesiac_name' => $miesiac_name, 'miesiac' => $miesiac);
}
