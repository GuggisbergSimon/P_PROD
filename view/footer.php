        <section id="footer" <?php if ($_SESSION['adminRight']) { echo "class='footer-admin'"; } ?>>
            <div class="container text-white p-3">
                <div class="row d-flex justify-content-around">
                    <div class="col-md-6 col-sm-12">
                        <h5>MENU</h5>
                        <ul class="list-unstyled quick-links">
                            <li><a class="text-white" href="index.php?controller=home&action=Accueil" style="text-decoration: none;"><i class="fa fa-angle-double-right"></i> Accueil</a></li>
                            <li><a class="text-white" href="index.php?controller=home&action=Contact" style="text-decoration: none;"><i class="fa fa-angle-double-right"></i> Contact</a></li>
                            <li><a class="text-white" href="index.php?controller=home&action=Apropos" style="text-decoration: none;"><i class="fa fa-angle-double-right"></i> À propos</a></li>
                        </ul>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <h5>DÉVELOPPEURS</h5>
                        <div class="row">
                            <div class="col">
                                <ul class="list-unstyled quick-links">
                                    <li>Kilian Good</li>
                                    <li>Anthony Höhn</li>
                                    <li>Julien Cartier</li>
                                </ul>
                            </div>
                            <div class="col">
                                <ul class="list-unstyled quick-links">
                                    <li>Simon Guggisberg</li>
                                    <li>Adrian Barreira</li>
                                    <li>Hugo Ducommun</li>
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-12 p-0 text-center">
                        <p class="m-0"><a class="text-white" href="https://www.etml.ch" target="_blank" style="font-family: 'ETML'; text-decoration: none !important;">ETML</a><span class="align-top"> © <?php echo date('Y'); ?> Tous droits réservés</span></p>
                    </div>
                </div>
            </div>
        </section>
    </body>
</html>