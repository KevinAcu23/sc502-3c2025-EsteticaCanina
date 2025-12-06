<?php include 'app/views/layouts/header.php'; ?>
<div class="container mt-5">
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Opciones</h5>
                    <div class="list-group">
                        <a href="/encuestas/encuestas/crear"
                            class="list-group-item list-group-item-action bg-success text-white">
                            <i class="fas fa-plus-circle"></i> Nueva Encuesta
                        </a>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="card mb-4">
                <div class="card-header">
                    <h2>Mis Encuestas Creadas</h2>
                </div>
                <div class="card-body">
                    <?php if (!empty($misEncuestas)): ?>
                        <div class="list-group">
                            <?php foreach ($misEncuestas as $encuesta): ?>
                                <a href="/encuestas/encuestas/resultados/<?php echo $encuesta['id']; ?>"
                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                    <?php echo htmlspecialchars($encuesta['titulo']); ?>
                                    <span class="badge bg-primary rounded-pill">Ver Resultados</span>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info">
                            Todavía no has creado ninguna encuesta.
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h2>Encuestas Disponibles para Responder</h2>
                </div>
                <div class="card-body">
                    <?php if (!empty($todasLasEncuestas)): ?>
                        <div class="list-group">
                            <?php foreach ($todasLasEncuestas as $encuesta): ?>
                                <?php if ($encuesta['id_creador'] != $_SESSION['user_id']): ?>
                                    <a href="/encuestas/encuestas/ver/<?php echo $encuesta['id']; ?>"
                                        class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                        <?php echo htmlspecialchars($encuesta['titulo']); ?>
                                        <span class="badge bg-success rounded-pill">Responder</span>
                                    </a>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info">
                            No hay encuestas disponibles para responder en este momento.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'app/views/layouts/footer.php'; ?>