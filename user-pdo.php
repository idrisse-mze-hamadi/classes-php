<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="">
        <title>classes</title>
    </head>

    <?php

    class UserPDO
    {
        // Attribut
        private $id;
        public $login;
        public $email;
        public $fname;
        public $lname;
        public $bdd;
        public $users;

        //Méthodes
        public function __construct() {
            session_start();
            $this->bdd = new PDO('mysql:host=localhost;dbname=classes;charset=utf8', 'root', '');
            $slct = "SELECT * FROM utilisateurs";
            $req = $this->bdd->prepare($slct);
            $req->execute();
            $this->users = $req->fetchAll();
        }

        public function register ($login, $password, $email, $fname, $lname) {

            foreach($this->users as $user)
            {
                if($login == $user[1])
                {
                    echo "login indisponible";
                }

                elseif($login != $user[1])
                {
                    $ins = "INSERT INTO utilisateurs(login, password, email, firstname, lastname) VALUES (:login, :password, :email, :firstname, :lastname)";
                    $rins = $this->bdd->prepare($ins);
                    $exin = $rins->execute(['login' => $login, 'password' => $password, 'email' => $email, 'firstname' => $fname, 'lastname' => $lname]);
                    return "
                    <table style='text-align:center'>
                        <theader>
                            <th>login</th>
                            <th>password</th>
                            <th>email</th>
                            <th>firstname</th>
                            <th>lastname</th>
                        </theader>
                        <tbody>
                            <td> $login </td>
                            <td> $password </td>
                            <td> $email </td>
                            <td> $fname </td>
                            <td> $lname </td>
                        </tbody>
                    </table>";    
                }
            }
            

        }

        public function connect ($login, $password) {

            foreach($this->users as $user)
            {
                if($login == $user[1] && $password = $user[2])
                {
                    $_SESSION["login"] = $login;
                    
                    $this->login = $login;
                    $this->email = $user[3];
                    $this->fname = $user[4];
                    $this->lname = $user[5];
                    echo "vous êtes connecté à ".$this->login;
                }
            }
        }

        public function disconnect () {
            session_destroy();
            echo "vous êtes déconnecté";
        }

        public function delete () {
            $login = $this->login;
            $dlt = "DELETE FROM utilisateurs WHERE login = '$login'";
            $rdlt = $this->bdd->prepare($dlt);
            $rdlt->execute([$login]);
            session_destroy();
            return $login." est supprimé";
        }

        public function update($login, $password, $email, $fname, $lname) {
            if(isset($_SESSION["login"]))
            {
                $loginn = $this->login;
                $data = ['login' => $login, 'password' => $password, 'email' => $email, 'firstname' => $fname, 'lastname' => $lname, 'loginn' => $loginn];
                $updt = "UPDATE utilisateurs SET login = :login, password = :password, email = :email, firstname = :firstname, lastname = :lastname WHERE login = :loginn";
                $rupdt = $this->bdd->prepare($updt);
                $rupdt->execute($data);
                return "Mis a jour avec succès";
            }
        }

        public function isConnected () {
            return isset($_SESSION["login"]);
        }

        public function getAllInfos () {
            return "
            <table style='text-align:center'>
                <theader>
                    <th>login</th>
                    <th>email</th>
                    <th>firstname</th>
                    <th>lastname</th>
                </theader>
                <tbody>
                    <td> $this->login </td>
                    <td> $this->email </td>
                    <td> $this->fname </td>
                    <td> $this->lname </td>
                </tbody>
            </table>";
        }

        public function getLogin() {
            return $this->login;
        }

        public function getEmail() {
            return $this->email;
        }

        public function getFirstname() {
            return $this->fname;
        }

        public function getLastname() {
            return $this->lname;
        }
    }

    $user = new UserPDO();

    //echo $user->register("paulo", "x", "x", "paulo", "pastis");
    echo $user->connect("paulo", "pastis");
    //echo $user->delete();
    //echo $user->update("", "", "", "","");
    //echo $user->isConnected();
    //echo $user->getAllInfos();
    //echo $user->getLogin();
    //echo $user->getEmail();
    //echo $user->getFirstname();
    //echo $user->getLastname();
    ?>



</html>