document.addEventListener("DOMContentLoaded", function () {
        document.getElementById('fileInput').addEventListener('change', function() {
              // Aquí puedes añadir la lógica para manejar los archivos seleccionados
        console.log(this.files);
    });
});
