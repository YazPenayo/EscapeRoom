<script type="text/javascript" src="../assets/js/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="../assets/js/bootstrap.js"></script>
    <script type="text/javascript" src="../assets/js/custom.js"></script>
    <script>
        let timeLeft = 90;
        const timerElement = document.getElementById("timer");

        function updateTimer() {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            timerElement.textContent = `${String(minutes).padStart(2, "0")}:${String(seconds).padStart(2, "0")}`;
            
            if (timeLeft > 0) {
                timeLeft--;
            }
        }
        setInterval(updateTimer, 1000);
    </script>
    <!-- Agregar el siguiente script JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const messageElement = document.getElementById('message');

            // Si el mensaje existe (cuando se envía la respuesta)
            if (messageElement) {
                setTimeout(function() {
                    // Recargar la página para cargar la siguiente pregunta
                    location.reload();
                }, 3000); // Esperar 3 segundos antes de recargar
            }
        });
    </script>