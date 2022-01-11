<?php


require_once 'AppController.php';
require_once __DIR__ . '/../helpers/LoginMenager.php';
require_once __DIR__ . '/../repository/DataRepository.php';
require_once __DIR__ . '/../parsers/DataProvider.php';

class DefaultController extends AppController
{

    private $datarepo;
    private DataProvider $dataProvider;

    public function __construct()
    {
        parent::__construct();
        $this->datarepo = new DataRepository();
    }


    public function index()
    {
        if (LoginMenager::isLoggedIn())
            $this->stronaGlowna();
        else
            $this->login();

    }


    public function login()    {
        $this->render('login', ['title' => 'Strona główna']);
    }

    public function register()    {
        $this->render('register', ['title' => 'Rejestracja']);

    }

    public function stronaGlowna()    {
        $this->render('stronaGlowna', ['title' => 'Rejestracja']);

    }

    public function scrape()    {

        $this->render('scrape', ['title' => 'scrape']);
    }

    public function curl()    {
        $this->render('curl', ['title' => 'scrape']);

    }


}