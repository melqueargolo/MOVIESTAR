<?php 

require_once "Models/User.php";
require_once "Models/Message.php";
require_once "Dao/UserDAO.php";
require_once "db.php";
require_once "globals.php";

$message = new Message($BASE_URL); //header("Location:".$_SERVER["HTTP_REFERER"])

$userDao = new UserDAO($conn, $BASE_URL);


//resgata o type do formulario
$type = filter_input(INPUT_POST,"type");

//verificação do tipo de formulario
if($type === "register"){
    $email           = filter_input(INPUT_POST,"email");
    $name            = filter_input(INPUT_POST,"name");
    $lastname        = filter_input(INPUT_POST,"lastname");
    $password        = filter_input(INPUT_POST,"password");
    $confirmpassword = filter_input(INPUT_POST,"confirmpassword");
   

    //verificação de dados minimos
    if($name && $lastname && $email && $password) {

       //verifica se as senhas batem
       if ($password === $confirmpassword) {
        
            //verifica se a senha e pequena
            //elseif (strlen($password) < 6) {
            //$message->setMessage("Senha menor que 6 digitos.","error","back");
            //    }

            //verifica se o email ja existe
            if ($userDao->findByEmail($email)=== false) {
               $user = new User();

               //token e senha
               $userToken     = $user->generateToken();
               $finalPassword = $user->generatePassword($password);

               $user->name     = $name;
               $user->lastname = $lastname;
               $user->email    = $email;
               $user->password = $finalPassword;
               $user->token    = $userToken;

               $auth = true;

               $userDao->create($user,$auth);
               
            }
            else {
                $message->setMessage("Usuario ja cadastrado.","error","back");
            }
        }
        //erro senha diferente
        else {
            $message->setMessage("As senhas não conferem.","error","back");
        }
    }
    //envia uma msg de erro, dados incompletos
    else {
       $message->setMessage("Por favor, preencha todos os campos.","error","back");
    }
    
}
elseif ($type === "login") {
    $email    = filter_input(INPUT_POST,"email");
    $password = filter_input(INPUT_POST,"password");

    //tenta autenticar usuario
    if ($userDao->authenticateUser($email,$password)) {
        $message->setMessage("Seja bem-vindo!","success","edit_profile.php");
    }
    
    //redireciona usuario caso autenticação invalida
    else {
        $message->setMessage("Usuario e/ou senha incorretos.","error","back");
    }
}
else {
    $message->setMessage("Informações invalidas.","error","index.php");
}
