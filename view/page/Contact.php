<?php
  if (isset($mailSent)) {
    if ($mailSent) {
?>
      <!-- Modal for user feedback -->
      <div class="modal" tabindex="-1" role="dialog" id="messageSentModal">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Message envoyé</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>Le message a bien été envoyé.</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
            </div>
          </div>
        </div>
      </div>

      <script>
          $('#messageSentModal').modal('show');
      </script>
<?php
    }
  }
?>

<div class="container container-sm-fluid">

    <div class="imageContact text-center">
        <img class="img-fluid" src="resources/userContent/image_contact.jpg">
    </div>

    <div class="contactbarre <?php if ($_SESSION['adminRight']) { echo "contactbarre-admin text-white"; } ?>">
        <p>Contact</p>
    </div>

    <!-- carte google map-->
    <div class="map w-100">
        <div style="width: 100%">
            <iframe width="100%" height="300" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"
                src="https://maps.google.com/maps?width=100%25&amp;height=400&amp;hl=en&amp;q=Rue%20s%C3%A9beillon%2012+(ETML)&amp;t=&amp;z=15&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe>
            <a href="https://www.maps.ie/route-planner.htm"></a></div>
    </div>

    <h3>Adresse et numéro de téléphone</h3>
    <div class="ligne <?php if ($_SESSION['adminRight']) { echo "ligne-admin"; } ?>"></div>
    <div class="info">
        <p>
            Rue de Sébeillon 12 <br>
            Tél : 021 316 77 89<br>
            1004 Lausanne
        </p>
    </div>

    <?php /* ?>
    // désactivation du formulaire car, il n'était pas utilisé a de bonne fin (spam, messages inutils).
    <!-- formulaire de contact-->
    
    <h3>Formulaire de contact</h3>
    <div class="ligne <?php if ($_SESSION['adminRight']) { echo "ligne-admin"; } ?>"></div>

    <?php
    if (isset($contactError)) {
        if ($contactError) {
    ?>
            <div class="alert alert-danger mt-5">
                Veuillez remplir tous les champs.
            </div>
    <?php
        }
    }
    ?>

    <form action="index.php?controller=home&action=Contact" id="contact-form" class="formulaire" method="post">
        <div class="row mb-3">
            <label for="contactNom" class="form-label">Nom</label><br>
            <input type="text" class="form-control" id="contactNom" name="contactNom" value="<?php if (isset($_POST['contactNom'])) { echo htmlspecialchars($_POST['contactNom']); } ?>">
        </div>
        <div class="row mb-3">
            <label for="contactMsg" class="form-label">Message</label>
            <textarea class="form-control" id="contactMsg" rows="3" name="contactMsg"><?php if (isset($_POST['contactMsg'])) { echo htmlspecialchars($_POST['contactMsg']); } ?></textarea>

            <button class="btn btn-primary mt-3" name="submitBtn" type="submit">Envoyer</button>
        </div>

    </form>
  <?php  */ ?>
</div>