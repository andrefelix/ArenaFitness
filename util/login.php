<?php

function randomSalt($len = 8) {
    $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789`~!@#$%^&*()-=_+';
    $l = strlen($chars) - 1;
    $str = '';

    for ($i = 0; $i < $len; ++$i) {
        $str .= $chars[rand(0, $l)];
    }

    return $str;
}

function create_hash($string, $hash_method = 'sha1', $salt_length = 8) {
    // generate random salt
    $salt = '5&nL*dF4';//randomSalt($salt_length);

    if (function_exists('hash') && in_array($hash_method, hash_algos())) {
        return hash($hash_method, $salt . $string);
    }

    return sha1($salt . $string);
}

/*
 * @param string $pass The user submitted password
 * @param string $hashed_pass The hashed password pulled from the database
 * @param string $salt The salt pulled from the database
 * @param string $hash_method The hashing method used to generate the hashed password
 */
function validateLogin($pass, $hashed_pass, $salt, $hash_method = 'sha1') {
    if (function_exists('hash') && in_array($hash_method, hash_algos())) {
        return ($hashed_pass == hash($hash_method, $salt . $pass));
    }

    return ($hashed_pass == sha1($salt . $pass));
}

/*
 * Required files
 */

if (!isset($appPath))
    require_once 'main.php';

require_once 'model/database.class.php';
require_once 'model/user.class.php';
require_once 'model/user_db.class.php';
require_once 'util/session.php';

function createUser() {
    $userArray['name'] = 'app';
    $userArray['password'] = create_hash('app');
    $userArray['salt'] = '5&nL*dF4';

    $user = new User($userArray);

    UserDB::addUser($user);
}

//createUser();


/*
 * Get POST and validate USER
 */

$message = '';

if ((isset($_POST['login']) && !empty($_POST['login'])) && 
    (isset($_POST['password']) && !empty($_POST['password']))) {
    
    $name = $_POST['login'];
    $password = $_POST['password'];
    $user = UserDB::getUser($name);

    if (isset($user)) {
        // $has_method is SHA1 by default
        //if (validateLogin($password, $user->getPassword(), $user->getSalt())) {
        if ($password == $user->getPassword()) {
            $_SESSION['userID'] = $name;
            initSession();
        } else {
            $message = 'Login ou senha inválido(s)';
            endSession($message);
        }

    } else {
        $message = 'Login ou Senha não encontrado(s)';
        endSession($message);
    }

} else {
    if (empty($_POST['login']) && empty($_POST['password']))
        $message = 'Por favor informe o usuário e a senha';
    else if (empty($_POST['password']))
        $message = 'Por favor informe a senha';
    else
        $message = 'Por favor informe o usuário';

    endSession($message);
}

?>