<?php 

class Review{
    
    public $id;
    public $rating;
    public $user_id;
    public $movie_id;





}

interface RevewDAOInterface{

    public function buildReview($data);
    public function create(Review $review);
    public function getMoviesReview($id);
    public function hassAlreadyReviwed($id, $userId);
    public function getRating($id);
    


}