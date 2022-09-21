<?php 
    require_once "Templates/header.php";
    require_once "Dao/UserDAO.php";
    require_once "Models/User.php";

    $user = new User();

    $userDao = new UserDAO($conn,$BASE_URL);

    $userData = $userDao->verifyToken(true);

    $fullName = $user->getFullName($userData);

    if ($userData->image == "") {
        $userData->image = "user.png";
    }

?>
   
    <div id="main-container" class="container-fluid" class="container-fluid edit-profile-page">
       <div class="col-md-12">
        <form action="<?php $BASE_URL ?>user_process.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="type" value="update">
            <div class="row">
                <div class="col-md-4">
                    <h1><?= $fullName ?></h1>
                    <p class="page-description">Altere seus dados no formulario abaixo</p>
                    <div class="form-group">
                        <label for="name">Nome:</label>
                        <input type="text" class="form-control" id="name" name="name"placeholder="Digite seu nome" value="<?=$userData->name ?>">
                    </div>
                    <div class="form-group">
                        <label for="lastname">Sobrenome:</label>
                        <input type="text" class="form-control" id="lastname" name="lastname"placeholder="Digite seu sobrenome" value="<?=$userData->lastname ?>">
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="text" readonly class="form-control disabled" id="email" name="email"placeholder="Digite seu email" value="<?=$userData->email ?>">
                    </div>
                    <input type="submit" class="btn card-btn" value="Alterar">
                    
                    
                </div>
                <div class="col-md-4">
                    <div id="profile-image-container" style="background-image: url('Img/Users/<?= $userData->image ?>')"></div>
                    <div class="form-group">
                        <label for="image">Foto:</label>
                        <input type="file" class="form-control-file" name="image"> 
                    </div>
                    <div class="form-group">
                        <label for="bio">Sobre você:</label>
                    <textarea class="form-control" name="bio" id="bio"  rows="5" placeholder="Conte-nos quem você é, o que faz e onde trabalha..."><?=$userData->bio ?></textarea>
                    </div>
                </div>
            </div>
        </form>
        <div class="row" id="change-password-container">
            <div class="col-md-4">
                <h2>Alterar a senha:</h2>
                <p page-description>Digite a nova senha e confirme para sua alterar senha:</p>
                <form action="<?php $BASE_URL ?>user_process.php" method="POST">
                    <input type="hidden" name="type" value="changePassword">
                    <div class="form-group">
                        <label for="password">Senha:</label>
                        <input type="password" class="form-control" id="password" name="password"placeholder="Digite sua nova senha" >
                    </div>
                    <div class="form-group">
                        <label for="confirmPassword">Confirmação de senha:</label>
                        <input type="password" class="form-control" id="confirmPassword" name="confirmPassword"placeholder="Confirme sua nova senha" >
                    </div>
                    <input type="submit" class="btn card-btn" value="Alterar Senha">
                </form>
            </div>
        </div>
       </div>
    </div>

    
<?php 
    require_once "Templates/footer.php";
?>