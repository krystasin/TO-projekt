    <?php

class DataProvider
{
    private string $url;
    private $html;

    public function __construct(string $url)
    {
        $this->url = $url;
        $this->url = 'https://regiowyniki.pl/kalendarz/Pilka_Nozna/2021/2022/Malopolskie/Liga_okregowa/Krakow_I/';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $response = curl_exec($this->ch);

        $this->html = new simple_html_dom();
        $this->html->load($response);
    }


    public function getMatches(){

        foreach ($this->html->find('.matcheslist') as $item) {
            echo $header = $item->find('.panel-heading', 0);

            foreach ($item->find('.panel-collapse', 0)->find('li') as $li) {
                // echo $li->first_child();
            }
        }
    }





}