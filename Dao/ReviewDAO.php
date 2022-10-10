<?php 

require_once("Models/Review.php");
require_once("Models/Message.php");
require_once ("Dao/UserDAO.php");


class ReviewDAO implements RevewDAOInterface{

    private $conn;
    private $message;
    private $url;

    public function __construct(PDO $conn, $url)
    {
        $this->conn    = $conn;
        $this->url     = $url;
        $this->message = new message($url);
    }



    public function buildReview($data){

        $reviewObject = new Review();

        $reviewObject->id       = $data["id"];
        $reviewObject->rating   = $data["rating"];
        $reviewObject->review   = $data["review"];
        $reviewObject->user_id  = $data["user_id"];
        $reviewObject->movie_id = $data["movie_id"];

        return $reviewObject;
    }

    public function create(Review $review){

        $stmt = $this->conn->prepare("INSERT INTO reviews(rating, review, movie_id, user_id)
        VALUES(:rating, :review, :movie_id, :user_id)");

        $stmt->bindParam(":rating", $review->rating);
        $stmt->bindParam(":review", $review->description);
        $stmt->bindParam(":movie_id", $review->movie_id);
        $stmt->bindParam(":user_id", $review->user_id);
        

        $stmt->execute();

        //mensssagem de filme adicionado com sucesso
        $this->message->setMessage("review adicionado com sucesso!","success","index.php");

    }

    public function getMoviesReview($id){

    }

    public function hassAlreadyReviwed($id, $userId){

    }

    public function getRating($id){

    }



}