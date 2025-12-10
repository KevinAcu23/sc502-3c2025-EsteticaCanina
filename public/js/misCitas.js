document.addEventListener('DOMContentLoaded', function () {
  const botones = document.querySelectorAll('.btn-cancelar-cita');

  botones.forEach(btn => {
    btn.addEventListener('click', function () {
      const citaId  = this.dataset.citaId;
      const cardRow = document.getElementById('cita-row-' + citaId) || this.closest('.cita-card');

      Swal.fire({
        title: '¿Cancelar esta cita?',
        text: 'Esta acción no se puede deshacer.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, cancelar',
        cancelButtonText: 'No, volver',
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d'
      }).then((result) => {
        if (!result.isConfirmed) return;

        const formData = new FormData();
        formData.append('cita_id', citaId);
        formData.append('ajax', '1');

        fetch('?url=citas/cancelar', {
          method: 'POST',
          body: formData,
          credentials: 'same-origin'
        })
        .then(res => res.json())
        .then(data => {
          if (data.success) {
            if (cardRow) {
              cardRow.remove();
            }
            Swal.fire({
              icon: 'success',
              title: 'Cita cancelada',
              text: data.message || 'La cita se canceló correctamente.'
            });
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: data.message || 'No se pudo cancelar la cita. Intenta de nuevo.'
            });
          }
        })
        .catch(() => {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Ocurrió un problema al cancelar la cita.'
          });
        });
      });
    });
  });
});
