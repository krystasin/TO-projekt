<?php

require_once 'DataRepository.php';

require_once __DIR__ . '/../models/User.php';

class UserRepository extends DataRepository
{
    private function getUserData( $con, int $id) :?User{
        // natural join public.accountTypes aT on uD.accountTypeId = aT.id
        //     $stmt = $this->database->connect()->prepare(
        $stmt = $con->prepare(
            'SELECT * FROM public.usersdata 
                    WHERE id = :id');

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if($stmt == null){
            //todo log dla administratora
            return null;
        }

        return new User(
            $result['username'],
            $result['email'],
            $result['accountTypeID']
        );
    }


    public function getUser( string $login, string $password): ?User
    {

        $con = $this->database->setConnection();
        $stmt = $con->prepare('SELECT id FROM public.users WHERE login = :login AND password = :password');
        $stmt->bindParam(':login', $login, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_COLUMN);


        if ($stmt->rowCount() != 1) {            return null;        }

        $id = $result[0];

        return $this->getUserData($con, $id);

    }



}