<form action="index.php?controller=home&action=Register" class="my-5" method="post">
    <div class="container">
    <?php

if(array_key_exists('registerError', $_SESSION) && $_SESSION['registerError']){
echo '								
  <div class="text-danger mb-5">
  <h4>' .

      "nom d'utilisateur ou mot de passe erroné"
      .
  '</h4>
</div>';

$_SESSION['registerError'] = false;
}

?>
       <div class="form-group">
       <label for="NomUser">Nom d'utilisateur</label>
       <input type="text" class="form-control" id="NomUser" aria-describedby="AideNomUser" name="username">
       <small id="AideNomUser" class="form-text text-muted">Votre nom d'utilisateur ne sera pas partagé.</small>
     </div>
     <div class="form-group">
       <label for="MotDePasse">Mot de passe</label>
       <input type="password" class="form-control" id="MotDePasse" name="password">
     </div>
     <button type="submit" class="btn btn-primary">Inscription</button>
    </div>
    <input type="hidden" id="loginCheck" name="register" value="1">
</form>



<?php
if(array_key_exists('username', $_SESSION)){
    echo $_SESSION['username'];
}
?>