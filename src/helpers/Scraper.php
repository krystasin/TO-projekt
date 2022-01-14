<?php

require_once __DIR__ . '/../lib/simple_html_dom.php';
require_once __DIR__ . '/../models/Klub.php';
require_once __DIR__ . '/../models/Kolejka.php';
require_once __DIR__ . '/../../Database.php';

define('MY_BASE_URL', 'https://regiowyniki.pl/kalendarz/Pilka_Nozna/2021/2022/');

class Scraper
{
    protected $database;
    protected $html;
    protected $ch;

    public function __destruct()
    {
        curl_close($this->ch);
    }


    public function __construct()
    {
        $this->ch = curl_init();
        curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, TRUE);
        $this->html = new simple_html_dom();
        $this->init(null);
    }

    private function init(?string $url)
    {
        curl_setopt($this->ch, CURLOPT_URL, $url);
        $response = curl_exec($this->ch);
        $this->html->load($response);
    }

    //done
    public function getWojewodztwa(): array
    {
        $this->init('https://regiowyniki.pl/kalendarz/Pilka_Nozna/2021/2022/');
        $woj = [];
        $mapa = $this->html->find('.poland', 0);

        foreach ($mapa->children() as $li)
            $woj[trim($li->find('a', 0)->plaintext)] = explode('/', $li->find('a', 0)->getAttribute('href'))[5];

        return $woj;
    }


    // 1.start pobiera jak narazie nazwy i adresy lig -> z których pobierze sie najbliższe mecze
    public function getLeaguesLinks($wojewodztwo): array
    {
        $str = MY_BASE_URL . $wojewodztwo;
        $this->init($str);

        $poziomRozgrywek = $this->html->find('#sidebar', 0)->children(1)->children(4);
        $ligi = [];

        foreach ($poziomRozgrywek->children() as $item) {
            $liga = $item->find('a', 0);
            $liga_nazwa = $liga->plaintext;
            $liga_href = explode('/', $liga->getAttribute('href'));
            $ligi[$liga_nazwa] = [
                'nazwa' => $liga_nazwa,
                'href' => $liga_href[5] . "/" . $liga_href[6]
            ];
        }
        return $ligi;
    }

    // 2.start pobiera wszystkie liki
    public function getAllLocalLeaguesLinks(): array
    {
        $wszystkieLigi = [];
        $poziomRozgrywek = $this->html->find('#sidebar', 0)->children(1)->children(4);

        //foreach po 1 poziomie
        foreach ($poziomRozgrywek->children() as $item) {
            $LIG = $item->find('a', 0);
            $LIG_nazwa = $LIG->plaintext;

            $podligi = $item->find('ul', 0);
            foreach ($podligi->children() as $p) {
                $p_a = $p->find('a', 0);
                $p_nazwa = $p_a->plaintext;
                $p_href = explode("/", $p_a->getAttribute('href'));
                $wszystkieLigi[$p_nazwa] = [
                    'nazwa' => $p_nazwa,
                    'href' => $p_href[5] . "/" . $p_href[6] . "/" . $p_href[7],
                    'liga' => $LIG_nazwa,
                    'liga_href' => $p_href[5] . '/' . $p_href[6]
                ];
            }
        }
        return $wszystkieLigi;
    }

    // 3. todo FETCH
    public function getClubsData($tmp)
    {
        //todo filtrowanie klubów
        $links = $tmp;
        $kluby = [];

        foreach ($links as $link) {
            $str = MY_BASE_URL . $link['href'];
            $this->init($str);


            $kluby = [];
            echo $str."<br>";
            if( $lii = $this->html->find('#tabletotal', 0)) {
            $li = $lii->find('ul', 0)->firstchild();

                while ($li = $li->next_sibling()) {
                    $row = $li->first_child();


                    $d1 = $row->first_child();
                    $pozycja = $d1->first_child()->plaintext;
                    $nazwa = $d1->find('a', 1)->plaintext;

                    $pkt = $row->children(1)->plaintext;
                    $mecze = $row->children(2)->plaintext;
                    $wygrane = $row->children(3)->plaintext;
                    $remisy = $row->children(4)->plaintext;
                    $przegrane = $row->children(5)->plaintext;


                    $bramki = $row->children(6)->plaintext;
                    $bramkiZdobyte = explode(':', $bramki)[0];
                    $bramkiStracne = explode(':', $bramki)[1];


                    $forma = $row->children(7);
                    $forma_zapis = [];
                    foreach ($forma->children() as $f)
                        if ($f->plaintext !== '?') {
                            array_push($forma_zapis, $f->plaintext);
                        }
                    //todo stworz nowy klub i dodajj do tablicy
                    $klub = new Klub($nazwa, $pozycja, $pkt, $mecze, $wygrane, $remisy, $przegrane, $bramkiZdobyte, $bramkiStracne, $forma_zapis);
                    array_push($kluby, $klub);
                }

            }

        }

        return $kluby;
    }


    public function getAllMatchdays(): array
    {
        $kolejki = [];
        foreach ($this->html->find('.matcheslist') as $ko) {
            $kolejka = new Kolejka();
            $tmp = explode(' ', $ko->find('.panel-heading', 0)->plaintext);

            $kolejka->setNr(intval(explode('.', $tmp[4])[0], 10));
            $kolejka->setPoczatek($tmp[8] . ' ' . $tmp[9]);
            $kolejka->setKoniec($tmp[11] . ' ' . $tmp[12]);

            foreach ($ko->find('.panel-collapse', 0)->find('li') as $li) {
                $mecz = [];
                $c1 = $li->first_child()->firstchild();
                $data = $c1->first_child()->first_child();
                $godzina = trim(substr($data->next_sibling()->innertext, 0, -1));
                $mecz['godzina'] = $godzina;

                foreach ($this->getDateFrom($data->plaintext) as $k => $v)
                    $mecz[$k] = $v;
                foreach ($this->getTeamsAndScore($c1) as $k => $v)
                    $mecz[$k] = $v;

                $kolejka->addMecz($mecz);
            }
            array_push($kolejki, $kolejka);
        }
        return $kolejki;
    }


    public function getAllTeams(): array
    {
        $druzyny = [];
        $t = $this->html->find('.matcheslist')[0];
        foreach ($t->find('.panel-collapse', 0)->find('li') as $li) {
            $c1 = $li->first_child()->firstchild();
            $c2 = $c1->next_sibling()->firstchild()->children(1)->firstchild();
            array_push($druzyny, trim($c2->children(0)->plaintext));
            array_push($druzyny, trim($c2->children(2)->plaintext));
        }

        return $druzyny;
    }


    private function getTeamsAndScore($c1)
    {

        $c2 = $c1->next_sibling()->firstchild()->children(1)->firstchild();
        $team_1 = $c2->children(0)->plaintext;
        $team_2 = $c2->children(2)->plaintext;
        $wynik = $c2->children(1);

        $team_1_wynik = $wynik->children(0)->firstchild()->plaintext;
        $team_2_wynik = $wynik->children(1)->firstchild()->plaintext;

        return array('gospodarz' => $team_1, 'gosc' => $team_2, 'gospodarz_wynik' => $team_1_wynik, 'gosc_wynik' => $team_2_wynik);
    }

    private function getDateFrom($data)
    {

        $dzien = explode(' ', $data)[1];
        $miesiac_name = explode(' ', $data)[2];
        $miesiac = trim(explode('/', $data)[1]);


        return array('dzien' => $dzien, 'miesiac_name' => $miesiac_name, 'miesiac' => $miesiac);
    }


}

