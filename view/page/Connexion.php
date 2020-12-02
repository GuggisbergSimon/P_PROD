<form action="index.php?controller=home&action=Connexion" class="my-5" method="post">
    <div class="container">
       <div class="form-group">
       <label for="NomUser">Nom d'utilisateur</label>
       <input type="text" class="form-control" id="NomUser" aria-describedby="AideNomUser" name="username">
       <small id="AideNomUser" class="form-text text-muted">Votre nom d'utilisateur ne sera pas partagé.</small>
     </div>
     <div class="form-group">
       <label for="MotDePasse">Mot de passe</label>
       <input type="password" class="form-control" id="MotDePasse" name="password">
     </div>
     <div class="form-group form-check">
       <input type="checkbox" class="form-check-input" id="exampleCheck1">
       <label class="form-check-label" for="exampleCheck1">Rester connecté</label>
     </div>
     <button type="submit" class="btn btn-primary">Connexion</button>
    </div>
    <input type="hidden" id="loginCheck" name="login" value="1">
</form>



<?php
if(array_key_exists('username', $_POST)){
    echo $_SESSION['username'];
}
?>