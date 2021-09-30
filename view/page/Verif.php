<h1 class="mt-3 text-center" >Vérification</h1>

<?php
//Affiche le résultat si le lien est validé ou non.
if($_SESSION['statusLink'] == 1){
?>
<div class="alert alert-success" role="alert">
  <h4 class="alert-heading">Bien joué!</h4>
  <p>Ton adresse mail est validée. Tu as maintenant accès à la page pour commander des plats !</p>
</div>
<?php
}
else{
?>
<div class="alert alert-danger" role="alert">
  <h4 class="alert-heading">Oups</h4>
  <p>Ton lien a expiré. Veuillez vous connecter, aller sur "Mon compte", puis cliquez sur le bouton pour vérifier à nouveau votre adresse mail.</p>
</div>
<?php
}
?>