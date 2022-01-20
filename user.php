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

    class User
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
            $this->bdd = mysqli_connect("localhost", "root", "", "classes");
            $req = mysqli_query($this->bdd, "SELECT * FROM utilisateurs");
            $this->users = mysqli_fetch_all($req);
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
                    $ruser = mysqli_query($this->bdd, "INSERT INTO utilisateurs(login, password, email, firstname, lastname) VALUES ('$login', '$password', '$email', '$fname', '$lname')");
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
                    /*$_SESSION["password"] = $password;*/

                    /*$this->id = $user[0];*/
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
            $dlt = mysqli_query($this->bdd, "DELETE FROM utilisateurs WHERE login = '$login'");
            session_destroy();
            $this->login = NULL;
            return $login." est supprimé";
        }

        public function update($login, $password, $email, $fname, $lname) {
            if(isset($_SESSION["login"]))
            {
                $loginn = $_SESSION["login"];
                $updt = mysqli_query($this->bdd, "UPDATE utilisateurs SET login='$login', password='$password', email='$email', firstname='$fname', lastname='$lname' WHERE login = '$loginn'");
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

    $user = new User();

    //echo $user->register("idrisse", "x", "x", "mze", "idrisse");
    echo $user->connect("kz", "gon");
    /*echo $user->delete();*/
    /*echo $user->update("", "", "", "","");*/
    //echo $user->isConnected();//
    //echo $user->getAllInfos();//
    //echo $user->getLogin();//
    //echo $user->getEmail();
    //echo $user->getFirstname();
    //echo $user->getLastname();
    ?>



</html>