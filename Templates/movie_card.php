<?php

  if(empty($movie->image)) {
    $movie->image = "movie_cover.jpg";
  }
?>

<div class="card movie-card">
  <div class="card-img-top" style="background-image: url('Img/Movies/<?= $movie->image ?>')"></div>

  <div class="card-body">
    <p class="card-rating">
      <i class="fas fa-star"></i>
      <span class="rating">9</span> <!--<?= $movie->rating ?> -->
    </p>
    <h5 class="card-title">
      <a href="movie.php?id=<?= $movie->id ?>"><?= $movie->title ?></a>
    </h5>
    <a href="movie.php?id=<?= $movie->id ?>" class="btn btn-primary rate-btn">Avaliar</a>
    <a href="movie.php?id=<?= $movie->id ?>" class="btn btn-primary card-btn">Conhecer</a>
  </div>
</div>