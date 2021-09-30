<script type="text/javascript" src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>

<div class="container">
    <div class="my-4">
        <div class="text-center">
            <button id="printRecap" type="button" class="btn btn-primary btn-lg"><i class="fas fa-download"></i>Télécharger le récapitulatif</button>
        </div>
        <div id="menuRecap" style="padding-bottom: 50;">
            <div class="p-5">
                <div class="mb-5 text-center">
                    <h1 class="my-0">Récapitulatif des menus végétariens du</h1>
                    <h1 class="my-0"><?= date("d/m/Y") ?></h1>
                </div>
                <div class="textAccueil textAccueil-admin mb-4 p-5">
                    <h1 class="text-center mb-3">Service de 11h</h1>
                    <div class="container">
                        <div class="row justify-content-around mb-3">
                        <?php
                        if(count($_SESSION['nbrOfMeal']) != 0){
                            for($a=0; $a < count($_SESSION['nbrOfMeal']); $a++){
                                if($a%2 == 0 && $a != 0){
                                    ?>
                                    </div>
                                    <div class="row justify-content-around">
                                    <?php
                                }
                            ?>
                                <div class="text-center my-1">
                                    <p class="mb-0">Menu n°<?= $a + 1 ?></p>
                                    <h3 class="py-0"><?= $_SESSION['nbrOfMeal'][$a]['meaName'] ?></h3>
                                    <h1 class="display-1">
                                        <?= $_SESSION['nbrOfMeal'][$a]['reserved11'] ?>x
                                    </h1>
                                    <?php
                                    for($b=0; $b < count($_SESSION['allReservation']); $b++){
                                        if($_SESSION['allReservation'][$b]['resHour'] == 11 && $_SESSION['allReservation'][$b]['meaName'] == $_SESSION['nbrOfMeal'][$a]['meaName']){
                                            echo("<h7>". $_SESSION['allReservation'][$b]['useFirstName'] ." ". $_SESSION['allReservation'][$b]['useLastName'] ."</h7>");
                                            echo("</br>");
                                        }
                                    }
                                    ?>
                                </div>
                            <?php
                            }
                        }
                        else{
                            ?>
                            <h3>Aucun plat n'a été commandé</h3>
                            <?php
                        }
                        ?>
                        </div>
                    </div>
                </div>
                <div class="textAccueil textAccueil-admin mb-4 p-5">
                    <h1 class="text-center mb-3">Service de 12h</h1>
                    <div class="container">
                        <div class="row justify-content-around mb-3">
                        <?php
                        if(count($_SESSION['nbrOfMeal']) != 0){
                            for($a=0; $a < count($_SESSION['nbrOfMeal']); $a++){
                                if($a%2 == 0 && $a != 0){
                                    ?>
                                    </div>
                                    <div class="row justify-content-around">
                                    <?php
                                }
                            ?>
                                <div class="text-center my-1">
                                    <p class="mb-0">Menu n°<?= $a + 1 ?></p>
                                    <h3 class="py-0"><?= $_SESSION['nbrOfMeal'][$a]['meaName'] ?></h3>
                                    <h1 class="display-1">
                                        <?= $_SESSION['nbrOfMeal'][$a]['reserved12'] ?>x
                                    </h1>
                                    <?php
                                    for($b=0; $b < count($_SESSION['allReservation']); $b++){
                                        if($_SESSION['allReservation'][$b]['resHour'] == 12 && $_SESSION['allReservation'][$b]['meaName'] == $_SESSION['nbrOfMeal'][$a]['meaName']){
                                            echo("<h7>". $_SESSION['allReservation'][$b]['useFirstName'] ." ". $_SESSION['allReservation'][$b]['useLastName'] ."</h7>");
                                            echo("</br>");
                                        }
                                    }
                                    ?>
                                </div>
                            <?php
                            }
                        }
                        else{
                            ?>
                            <h3>Aucun plat n'a été commandé</h3>
                            <?php
                        }
                        ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    //Permet de générer un PDF
    $('#printRecap').click(function () {
        var HTML_Width = $("#menuRecap").width();
        var HTML_Height = $("#menuRecap").height();
        var top_left_margin = 15;
        var PDF_Width = HTML_Width + (top_left_margin * 2);
        var PDF_Height = (PDF_Width * 1.5) + (top_left_margin * 2);
        var canvas_image_width = HTML_Width;
        var canvas_image_height = HTML_Height;

        var totalPDFPages = Math.ceil(HTML_Height / PDF_Height) - 1;

        html2canvas($("#menuRecap")[0]).then(function (canvas) {
            var imgData = canvas.toDataURL("image/jpeg", 1.0);
            var pdf = new jsPDF('p', 'pt', [PDF_Width, PDF_Height]);
            pdf.addImage(imgData, 'JPG', top_left_margin, top_left_margin, canvas_image_width, canvas_image_height);
            for (var i = 1; i <= totalPDFPages; i++) { 
                pdf.addPage(PDF_Width, PDF_Height);
                pdf.addImage(imgData, 'JPG', top_left_margin, -(PDF_Height*i)+(top_left_margin*4),canvas_image_width,canvas_image_height);
            }

            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0');
            var yyyy = today.getFullYear();

            today = dd + '-' + mm + '-' + yyyy;
            pdf.save("menu-recap-" + today + ".pdf");
        });
    });
</script>