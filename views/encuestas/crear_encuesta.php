<?php include 'app/views/layouts/header.php'; ?>
<div class="container mt-5">
    <h1>Crear Nueva Encuesta</h1>
    <form id="form-crear-encuesta" action="/encuestas/encuestas/crear" method="POST">
        <div class="mb-3">
            <label for="titulo" class="form-label">Título de la Encuesta</label>
            <input type="text" class="form-control" name="titulo" required>
        </div>
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" name="descripcion"></textarea>
        </div>

        <h3>Preguntas</h3>
        <div id="preguntas-container"></div>
        <button type="button" class="btn btn-secondary mt-2" id="btn-add-pregunta">Agregar Pregunta</button>
        <button type="submit" class="btn btn-primary mt-2">Guardar Encuesta</button>
    </form>
</div>

<script>
$(document).ready(function() {
    let preguntaCounter = 0;
    $('#btn-add-pregunta').click(function() {
        preguntaCounter++;
        const newPregunta = `
            <div class="input-group mb-3">
                <span class="input-group-text">${preguntaCounter}.</span>
                <input type="text" class="form-control" name="preguntas[]" placeholder="Escribe tu pregunta aquí..." required>
            </div>
        `;
        $('#preguntas-container').append(newPregunta);
    });

    $('#form-crear-encuesta').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                alert('Encuesta creada con éxito!');
                window.location.href = '/encuestas/encuestas/index';
            },
            error: function() {
                alert('Hubo un error al crear la encuesta.');
            }
        });
    });
});
</script>
<?php include 'app/views/layouts/footer.php'; ?>