document.addEventListener('DOMContentLoaded', function () {
  // Modal de agendar cita
  const modalCita = document.getElementById('modalCita');

  if (modalCita) {
    modalCita.addEventListener('show.bs.modal', function (event) {
      const button   = event.relatedTarget;
      if (!button) return;

      const servicio = button.getAttribute('data-servicio') || '';

      const campoServicio = modalCita.querySelector('#campoServicio');
      const tituloModal   = modalCita.querySelector('#modalCitaLabel');

      if (campoServicio) {
        campoServicio.value = servicio;
      }

      if (tituloModal) {
        tituloModal.textContent = 'Agendar cita - ' + servicio;
      }
    });
  }

  // SweetAlerts de éxito / error al crear cita
  if (window.mensajeExitoCita) {
    Swal.fire({
      icon: 'success',
      title: 'Cita creada',
      text: window.mensajeExitoCita
    });
  }

  if (window.errorCita) {
    Swal.fire({
      icon: 'error',
      title: 'Error',
      html: window.errorCita
    });
  }
});
