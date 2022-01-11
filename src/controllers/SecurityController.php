<?php


require_once 'AppController.php';


require_once __DIR__ . '/../models/User.php';
require_once(__DIR__ . '/../repository/UserRepository.php');
require_once __DIR__ . '/../helpers/LoginMenager.php';

class SecurityController extends AppController
{

    public function login()
    {

        LoginMenager::redirectIfLoggedIn();
        if (!$this->isPost())
            return $this->render('login');

        if (($_POST['login']) === "")
            return $this->render('login', ['title' => 'Strona główna', 'styles' => ['loggedOutStyle', 'style']]);

        if ($_POST['password'] === "")
            return $this->render('login', ['title' => 'Strona główna', 'styles' => ['loggedOutStyle', 'style']]);



        $userRepository = new UserRepository();
        $user = $userRepository->getUser($_POST['login'], $_POST['password']);

        if (!$user)
            return $this->render('login', ['title' => 'Strona główna', 'styles' => ['loggedOutStyle', 'style']]);


        $_SESSION['user'] = $user->getUsername();

        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/");

    }

    public function logout()
    {
        session_destroy();

        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/");

    }


    public function registerBG() {

        $this->ifPost();

        die("AAAAAAAAAA");
/*        $Name = $_POST['Name'];
        $Surname = $_POST['Surname'];
        $Email = $_POST['Email'];
        $Username = $_POST['Username'];
        $Password = $_POST['Password'];

        //GroupID === 2 -> student, 1 for teachers
        $user = new Users(0,1, $Name, md5(md5($Surname)), $Email, $Username, $Password);

        $this->userRepository->register($user);

        return $this->render('login', ['messages' => ["Successfully registered!<br/> Now you can login"]]);*/

    }

}