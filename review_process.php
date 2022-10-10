<?php 

require_once "Models/Movie.php";
require_once "Models/Message.php";
require_once "Models/Review.php";
require_once "Dao/UserDAO.php";
require_once "Dao/MovieDAO.php";
require_once "Dao/ReviewDAO.php";
require_once "db.php";
require_once "globals.php";

$message   = new Message($BASE_URL); 
$userDao   = new UserDAO($conn, $BASE_URL);
$movieDao  = new MovieDAO($conn, $BASE_URL);
$reviewDao = new ReviewDAO($conn, $BASE_URL);

//recebendo o tipo do formulario 
$type = filter_input(INPUT_POST, "type");

//resgatar dados do usuario
$userData= $userDao->verifyToken();

if ($type == "create") {
    //recebendo os dados do post
    $rating   = filter_input(INPUT_POST, "rating");
    $review   = filter_input(INPUT_POST, "review");
    $movie_id = filter_input(INPUT_POST, "movie_id");
    $user_id  = $userData->id;

    $reviewObjetct = new Review();

    $movieData = $movieDao->findById($movie_id);

    $reviewObjetct->rating   = $rating;
    $reviewObjetct->review   = $review;
    $reviewObjetct->movie_id = $movie_id;
    $reviewObjetct->user_id  = $user_id;

    $reviewDao->create($reviewObjetct);



    if ($movieData) {

        //verificar dados minimos
        if (!empty($rating) && !empty($review) && !empty($movie_id)) {

        }else{
            $message->setMessage("Você precisa inserir a nota e o comentario!", "error", "back");
        }
        
    }else {
        $message->setMessage("Informações invalidas!", "error", "index.php");
    }

   

}else {
    $message->setMessage("Informações invalidas!", "error", "index.php");
}