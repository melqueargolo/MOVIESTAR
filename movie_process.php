<?php 

require_once "Models/Movie.php";
require_once "Models/Message.php";
require_once "Dao/UserDAO.php";
require_once "Dao/MovieDAO.php";
require_once "db.php";
require_once "globals.php";

$message  = new Message($BASE_URL); 
$userDao  = new UserDAO($conn, $BASE_URL);
$movieDAO = new MovieDAO($conn, $BASE_URL);

//resgata o type do formulario
$type = filter_input(INPUT_POST,"type");

//resgatar dados do usuario
$userData= $userDao->verifyToken();


if ($type === "create") {

    //recebe os dados do input
    $title       = filter_input(INPUT_POST,"title");
    $description = filter_input(INPUT_POST,"description");
    $trailer     = filter_input(INPUT_POST,"trailer");
    $category    = filter_input(INPUT_POST,"category");
    $length      = filter_input(INPUT_POST,"length");

    $movie = new Movie();

    //validação minima de dados
    if (!empty($title) && !empty($description) && !empty($category)) {
        
        $movie->title       = $title;
        $movie->description = $description;
        $movie->trailer     = $trailer;
        $movie->category    = $category;
        $movie->length      = $length;
        $movie->user_id     = $userData->id;

        //upload da filme
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
                
                //gera o nome da imagem
                $imageName = $movie->imageGenerateName();
    
                imagejpeg($imageFile,"./Img/Movies/".$imageName, 100); 
    
                $movie->image = $imageName;

            }else {
                $message->setMessage("tipo invalido de imagem, insira jpg ou png", "error", "back");
            }

        }
        
        $movieDAO->create($movie);

    } else {
        $message->setMessage("Você precisa adicionar pelo menos: titulo, descrição e categoria.","error","back");
    }
    

    

} else {
    $message->setMessage("Informações invalidas!","error","index.php");
}
