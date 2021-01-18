<div class="container container-sm-fluid">

    <div class="imageContact text-center">
        <img class="img-fluid" src="resources/userContent/image_contact.jpg">
    </div>

    <div class="contactbarre">
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
    <div class="ligne"></div>
    <div class="info">
        <p>
            Rue de Sébeillon 12 <br>
            Tél : 021 316 77 89<br>
            1004 Lausanne
        </p>
    </div>

    <?php
    if ($mailSent) {
        echo
        '
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <!-- Modal -->
        <div class="modal" tabindex="-1" role="dialog" id="myModal">
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
        </div>';
    }
    ?>


    <!-- formulaire de contact-->

    <h3>Formulaire de contact</h3>
    <div class="ligne">
    </div>

    <script> $('#myModal').modal('show');</script>

    <form action="index.php?controller=home&action=Contact" class="formulaire" method="post">
        <div class="row mb-3">
            <label for="contactNom" class="form-label">Nom</label><br>
            <input type="text" class="form-control" id="contactNom" name="contactNom">
        </div>
        <div class="row mb-3">
            <label for="contactMsg" class="form-label">Message</label>
            <textarea class="form-control" id="contactMsg" rows="3" name="contactMsg"></textarea>

            <button class="btn btn-primary mt-3" type="submit">Envoyer</button>
        </div>

    </form>

</div>