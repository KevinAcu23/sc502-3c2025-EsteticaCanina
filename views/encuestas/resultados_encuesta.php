<?php include 'app/views/layouts/header.php'; ?>
<div class="container mt-5 mb-3">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h1 class="card-title"><?php echo htmlspecialchars($resultados['encuesta']['titulo']); ?></h1>
                    <p class="card-text text-muted"><?php echo htmlspecialchars($resultados['encuesta']['descripcion']); ?></p>
                </div>
                <div class="card-body">
                    <?php if (isset($esCreador) && $esCreador): ?>
                        <div class="mb-4">
                            <?php if (!$haSidoRespondida): ?>
                                <a href="/encuestas/encuestas/eliminar/<?php echo $resultados['encuesta']['id']; ?>" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que quieres eliminar esta encuesta?');">
                                    <i class="fas fa-trash-alt"></i> Eliminar Encuesta
                                </a>
                            <?php else: ?>
                                <button class="btn btn-danger disabled" disabled>
                                    <i class="fas fa-ban"></i> No se puede eliminar (ya ha sido respondida)
                                </button>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <?php if (empty($resultados['preguntas_con_resultados'])): ?>
                        <div class="alert alert-warning">Esta encuesta aún no tiene resultados.</div>
                    <?php else: ?>
                        <?php foreach ($resultados['preguntas_con_resultados'] as $pregunta): ?>
                            <div class="mb-4">
                                <h5><?php echo htmlspecialchars($pregunta['texto_pregunta']); ?></h5>
                                <p class="text-muted">Total de respuestas: <?php echo $pregunta['total_respuestas']; ?></p>

                                <?php 
                                    // Resultados
                                    $valores = array_column($pregunta['resultados'], 'valor_respuesta');
                                    $totales = array_column($pregunta['resultados'], 'total');
                                    $resultadosCombinados = array_combine($valores, $totales);
                                ?>
                                
                                <div class="progress-container">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <?php
                                            $total = $resultadosCombinados[$i] ?? 0;
                                            $porcentaje = $pregunta['total_respuestas'] > 0 ? ($total / $pregunta['total_respuestas']) * 100 : 0;
                                        ?>
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="me-2" style="width: 20px;">
                                                <?php echo $i; ?>
                                            </div>
                                            <div class="progress flex-grow-1">
                                                <div class="progress-bar" role="progressbar" style="width: <?php echo $porcentaje; ?>%;">
                                                    <?php echo round($porcentaje, 1); ?>% (<?php echo $total; ?>)
                                                </div>
                                            </div>
                                        </div>
                                    <?php endfor; ?>
                                </div>
                            </div>
                            <hr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'app/views/layouts/footer.php'; ?>