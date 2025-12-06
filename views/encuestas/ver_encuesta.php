<?php include 'app/views/layouts/header.php'; ?>
<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h1 class="card-title"><?php echo htmlspecialchars($infoEncuesta['titulo']); ?></h1>
                </div>
                <div class="card-body">
                    <p class="card-text"><?php echo htmlspecialchars($infoEncuesta['descripcion']); ?></p>
                    
                    <?php if ($yaRespondio): ?>
                        <div class="alert alert-info" role="alert">
                            Ya has respondido a esta encuesta. Puedes ver los <a href="/encuestas/encuestas/resultados/<?php echo $infoEncuesta['id']; ?>">resultados aquí</a>.
                        </div>
                    <?php else: ?>
                        <form id="form-responder-encuesta">
                            <input type="hidden" name="encuesta_id" value="<?php echo $infoEncuesta['id']; ?>">
                            <?php foreach ($infoEncuesta['preguntas'] as $pregunta): ?>
                                <div class="mb-4">
                                    <p><strong><?php echo htmlspecialchars($pregunta['texto_pregunta']); ?></strong></p>
                                    <div>
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="respuesta_<?php echo $pregunta['id']; ?>" id="pregunta_<?php echo $pregunta['id']; ?>_valor_<?php echo $i; ?>" value="<?php echo $i; ?>" required>
                                                <label class="form-check-label" for="pregunta_<?php echo $pregunta['id']; ?>_valor_<?php echo $i; ?>"><?php echo $i; ?></label>
                                            </div>
                                        <?php endfor; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <button type="submit" class="btn btn-success">Enviar Respuestas</button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
$(document).ready(function() {
    $('#form-responder-encuesta').submit(function(e) {
        e.preventDefault();

        const formData = $(this).serialize();

        $.ajax({
            url: '/encuestas/responder',
            type: 'POST',
            data: formData,
            success: function(response) {
                alert('Respuestas enviadas con éxito!');
                window.location.href = '/encuestas/encuestas/index';
            },
            error: function(xhr, status, error) {
                alert('Hubo un error al enviar las respuestas. Por favor, inténtelo de nuevo.');
                console.error(error);
            }
        });
    });
});
</script>
<?php include 'app/views/layouts/footer.php'; ?>