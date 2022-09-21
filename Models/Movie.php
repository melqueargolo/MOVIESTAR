<?php 

class movie
{
    public $id;
    public $title;
    public $description;
    public $image;
    public $trailer;
    public $category;
    public $length;
    public $users_id;
  

    public function imageGenerateName(){
        return bin2hex(60) . "jpg";
    }

    
}


interface MovieDAOInterface {

    public function buildMovie($data);
    public function findAll();
    public function getLatestMovies();
    public function getMoviesByCategory($category);
    public function getMoviesByUserId($id);
    public function findById($id);
    public function findByTitle($title);
    public function create(Movie $movie);
    public function update(Movie $movie);
    public function destroy($id);

}