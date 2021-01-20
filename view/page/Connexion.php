<h1 class="mt-3 text-center" >Connexion</h1>

<div class="container">

  <?php
  if (array_key_exists('loginError', $_SESSION) && $_SESSION['loginError']) {
  ?>
        <div class="alert alert-danger mt-5">Nom d'utilisateur ou mot de passe erroné</div>
  <?php
  }
  $_SESSION['loginError'] = false;
  ?>

  <form action="index.php?controller=home&action=Connexion" class="my-5" method="post">
      <div class="form-group">
        <label for="NomUser">Nom d'utilisateur</label>
        <input type="text" class="form-control" id="NomUser" aria-describedby="AideNomUser" name="username" value="<?php if (isset($_POST['username'])) { echo htmlspecialchars($_POST['username']); } ?>">
        <small id="AideNomUser" class="form-text text-muted">Votre nom d'utilisateur ne sera pas partagé.</small>
      </div>
      <div class="form-group mb-4">
        <label for="MotDePasse">Mot de passe</label>
        <input type="password" class="form-control" id="MotDePasse" name="password">
      </div>
      <button type="submit" name="submitBtn" class="btn btn-primary">Connexion</button>
      <a href="index.php?controller=home&action=Register" class="ml-2" style="text-decoration: none;">Pas encore inscrit ?</a>
  </form>
</div>