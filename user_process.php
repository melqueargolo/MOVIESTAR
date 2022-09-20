<?php 

require_once "Models/User.php";
require_once "Models/Message.php";
require_once "Dao/UserDAO.php";
require_once "db.php";
require_once "globals.php";

$message = new Message($BASE_URL); 
$userDao = new UserDAO($conn, $BASE_URL);

//resgata o type do formulario
$type = filter_input(INPUT_POST,"type");

//atualizar usuario
if ($type === "update") {

    //resgatar dados do usuario
    $userData= $userDao->verifyToken();

    //receber dados do post
    $name     = filter_input(INPUT_POST,'name');
    $lastname = filter_input(INPUT_POST,'lastname');
    $email    = filter_input(INPUT_POST,'email');
    $bio      = filter_input(INPUT_POST,'bio');

    //criar novo usuario
    $user = new User();

    //preencher dados do usuario
    $userData->name     = $name;
    $userData->lastname = $lastname;
    $userData->email    = $email;
    $userData->bio      = $bio;

    //upload da imagem
    if (isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])) {
        
        $image      = $_FILES["image"];
        $imageTypes = ["image/jpeg", "image/jpg", "image/png"];
        $jpgArray   = ["image/jpeg", "image/jpg"];

        //checa o tipo da imagem
        if (in_array($image["type"], $imageTypes)) {
            
            //checa se jpg
            if (in_array($image["type"], $jpgArray)) {
                $imageFile = imagecreatefromjpeg($image["tmp_name"]);

            }else { //imagem é png
                $imageFile = imagecreatefrompng($image["tmp_name"]);
            }

            $imageName = $user->imageGenerateName();

            imagejpeg($imageFile,"./Img/Users/".$imageName, 100); 

            $userData->image = $imageName;

        }else{
            $message->setMessage("tipo invalido de imagem, insira jpg ou png", "error", "back");
        }

    }

    $userDao->update($userData);

}else if($type ==="changePassword"){
    $password        = filter_input(INPUT_POST,"password");
    $confirmPassword = filter_input(INPUT_POST,"confirmPassword");
    $id              = filter_input(INPUT_POST,"id");

    //verifica se as senhas são iguais
    if ($password === $confirmPassword) {
        //criar novo usuario
    $user = new User();

    $finalPassword = $user->generatePassword($password);

    $user->password = $finalPassword;
    $user->id       = $id;

    $userDao->changePassword($user);

    } else {
        $message->setMessage("as senhas não conferem!","error","back");
    }
    




}else {
    $message->setMessage("Informações invalidas!","error","index.php");
}

