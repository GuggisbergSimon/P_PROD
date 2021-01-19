<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.2/jspdf.min.js"></script>

<div class="container">
    <div class="my-4">
        <div class="mb-4">
            <h3 class="my-0">Récapitulatif des menus du jour</h3>
            <div class="ligne ligne-admin"></div>
        </div>
        <div class="text-center mb-4">
            <button onclick="doCapture();" type="button" class="btn btn-primary btn-lg"><i class="fas fa-download"></i> Télécharger le récapitulatif</button>
        </div>
        <div id="menuRecap" class="p-5">
            <div class="textAccueil textAccueil-admin mb-4 p-5">
                <h1 class="text-center mb-3">Tranche de 11h</h1>
                <div class="d-flex justify-content-around flex-wrap">
                    <div class="text-center my-1">
                        <p class="mb-0">Menu n°1</p>
                        <h3 class="py-0">Hamburger végétarien</h3>
                        <h1 class="display-1">4x</h1>
                    </div>
                    <div class="text-center my-1">
                        <p class="mb-0">Menu n°2</p>
                        <h3 class="py-0">Falafele végétarienne</h3>
                        <h1 class="display-1">4x</h1>
                    </div>
                </div>
            </div>
            <div class="textAccueil textAccueil-admin mb-4 p-5">
                <h1 class="text-center mb-3">Tranche de 12h</h1>
                <div class="d-flex justify-content-around flex-wrap">
                    <div class="text-center my-1">
                        <p class="mb-0">Menu n°1</p>
                        <h3 class="py-0">Hamburger végétarien</h3>
                        <h1 class="display-1">4x</h1>
                    </div>
                    <div class="text-center my-1">
                        <p class="mb-0">Menu n°2</p>
                        <h3 class="py-0">Falafele végétarienne</h3>
                        <h1 class="display-1">4x</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function doCapture() {
            html2canvas(document.getElementById("menuRecap")).then(function (canvas) {
                var pdfData = canvas.toDataURL('image/png')
                var doc = new jsPDF()
                doc.addImage(pdfData,'PNG')
                doc.save("recap.pdf")
            });
    }
</script>