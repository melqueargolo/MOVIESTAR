<?php 

require_once "Models/Movie.php";
require_once "Models/Message.php";

//review DAO

class MovieDAO implements MovieDAOInterface
{

    private $conn;
    private $url;
    private $message;

    public function __construct(PDO $conn, $url)
    {
        $this->conn    = $conn;
        $this->url     = $url;
        $this->message = new message($url);
    }

    public function buildMovie($data){

        $movie = new Movie();

        $movie->id          = $data["id"];
        $movie->title       = $data["title"];
        $movie->description = $data["description"];
        $movie->image       = $data["image"];
        $movie->trailer     = $data["trailer"];
        $movie->category    = $data["category"];
        $movie->length      = $data["length"];
        $movie->user_id     = $data["user_id"];
        
        return $movie;
    }

    public function findAll(){


    }

    public function getLatestMovies(){
        $stmt = $this->conn->query("SELECT * FROM movies ORDER BY id DESC");
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $moviesArray = $stmt->fetchAll();

            foreach($moviesArray as $movie){
                $movie[] = $this->buildMovie($movie);
            };
        }

        return $movie;
    }

    public function getMoviesByCategory($category){
        $stmt = $this->conn->prepare("SELECT * FROM movies WHERE category = :category ORDER BY id DESC");

        $stmt->bindParam(":category", $category);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $moviesArray = $stmt->fetchAll();

            foreach($moviesArray as $movie){
                $movies[] = $this->buildMovie($movie);
            };
        }

        return $movies;
    }

    public function getMoviesByUserId($id){

    }

    public function findById($id){

    }

    public function findByTitle($title){

    }

    public function create(Movie $movie){

        $stmt = $this->conn->prepare("INSERT INTO movies(title, description, image, trailer, category, length, user_id)
        VALUES(:title, :description, :image, :trailer, :category, :length, :user_id)");

        $stmt->bindParam(":title", $movie->title);
        $stmt->bindParam(":description", $movie->description);
        $stmt->bindParam(":image", $movie->image);
        $stmt->bindParam(":trailer", $movie->trailer);
        $stmt->bindParam(":category", $movie->category);
        $stmt->bindParam(":length", $movie->length);
        $stmt->bindParam(":user_id", $movie->user_id);

        $stmt->execute();

        //mensssagem de filme adicionado com sucesso
        $this->message->setMessage("Filme adicionado com sucesso!","success","index.php");
    }

    public function update(Movie $movie){

    }

    public function destroy($id){

    }

}