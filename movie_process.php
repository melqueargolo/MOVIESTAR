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
    
}elseif ($type === "delete") {
    $id = filter_input(INPUT_POST, "id");

    $movie = $movieDAO->findById($id);

   
    if ($movie) {
        //verifica se o filme e do usuario
        if ($movie->user_id === $userData->id) {
            $movieDAO->destroy($movie->id);

        } else {

            $message->setMessage("Informações inválidas!", "error", "index.php");
    
          }
    
        } else {
    
          $message->setMessage("Informações inválidas!", "error", "index.php");
    
        }
    
} elseif($type === "update") { 
    
    
    // Receber os dados dos inputs
    $title       = filter_input(INPUT_POST, "title");
    $description = filter_input(INPUT_POST, "description");
    $trailer     = filter_input(INPUT_POST, "trailer");
    $category    = filter_input(INPUT_POST, "category");
    $length      = filter_input(INPUT_POST, "length");
    $id          = filter_input(INPUT_POST, "id");

    $movieData = $movieDAO->findById($id);

    // Verifica se encontrou o filme
    if($movieData) {

        // Verificar se o filme é do usuário
        if($movieData->user_id === $userData->id) {

        // Validação mínima de dados
        if(!empty($title) && !empty($description) && !empty($category)) {

            // Edição do filme
            $movieData->title       = $title;
            $movieData->description = $description;
            $movieData->trailer     = $trailer;
            $movieData->category    = $category;
            $movieData->length      = $length;

            // Upload de imagem do filme
            if(isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])) {

            $image = $_FILES["image"];
            $imageTypes = ["image/jpeg", "image/jpg", "image/png"];
            $jpgArray = ["image/jpeg", "image/jpg"];

            // Checando tipo da imagem
            if(in_array($image["type"], $imageTypes)) {

                // Checa se imagem é jpg
                if(in_array($image["type"], $jpgArray)) {
                $imageFile = imagecreatefromjpeg($image["tmp_name"]);
                } else {
                $imageFile = imagecreatefrompng($image["tmp_name"]);
                }

                // Gerando o nome da imagem
                $movie = new Movie();

                $imageName = $movie->imageGenerateName();

                imagejpeg($imageFile, "./Img/Movies/" . $imageName, 100);

                $movieData->image = $imageName;

            } else {

                $message->setMessage("Tipo inválido de imagem, insira png ou jpg!", "error", "back");

             }

            }

            $movieDAO->update($movieData);

        } else {

            $message->setMessage("Você precisa adicionar pelo menos: título, descrição e categoria!", "error", "back");

        }

        } else {

        $message->setMessage("Informações inválidas!", "error", "index.php");

        }

    } else {

        $message->setMessage("Informações inválidas!", "error", "index.php");

    }
    
    } else {

    $message->setMessage("Informações inválidas!", "error", "index.php");

    }


