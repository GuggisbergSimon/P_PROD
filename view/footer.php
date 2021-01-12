        <footer>
            <!-- footer -->
            <div class="footer">

                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
                <p>Killian Good, Anthony Höhn, Julien Cartier, Simon Guggisberg, Adrian Barreira © <?php echo date("Y"); ?> @ Ecole technique des métiers de Lausanne</p>
            </div>
        </footer>
        <script>
            function toggleBurger() {
                var x = document.getElementById("myTopnav");
                if (x.className === "topnav") {
                    x.className += " responsive";
                } else {
                    x.className = "topnav";
                }
            }
        </script>
    </body>
</html>