document.addEventListener('DOMContentLoaded', function () {
  // SweetAlerts globales desde PHP (crear / error / editar)
  if (window.mensajeExitoProductos) {
    Swal.fire({
      icon: 'success',
      title: 'Listo',
      html: window.mensajeExitoProductos,
      confirmButtonColor: '#4b2e83'
    });
  }

  if (window.errorProductos) {
    Swal.fire({
      icon: 'error',
      title: 'Ups...',
      html: window.errorProductos,
      confirmButtonColor: '#4b2e83'
    });
  }

  // Agregar al carrito (solo clientes)
  const botonesCarrito = document.querySelectorAll('.btn-agregar-carrito');
  botonesCarrito.forEach(btn => {
    btn.addEventListener('click', function () {
      const productoId = this.dataset.id;
      const nombre     = this.dataset.nombre || 'Producto';

      const formData = new FormData();
      formData.append('producto_id', productoId);
      formData.append('cantidad', 1);
      formData.append('ajax', '1');

      fetch('?url=carrito/agregar', {
        method: 'POST',
        body: formData,
        credentials: 'same-origin'
      })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          Swal.fire({
            icon: 'success',
            title: 'Agregado al carrito',
            text: nombre + ' se agregó a tu carrito.',
            confirmButtonColor: '#4b2e83'
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: data.message || 'No se pudo agregar el producto al carrito.',
            confirmButtonColor: '#4b2e83'
          });
        }
      })
      .catch(() => {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Ocurrió un problema al agregar al carrito.',
          confirmButtonColor: '#4b2e83'
        });
      });
    });
  });

  // Eliminar producto (admin, AJAX)
  const botonesEliminar = document.querySelectorAll('.btn-eliminar-producto');
  botonesEliminar.forEach(btn => {
    btn.addEventListener('click', function () {
      const id   = this.dataset.id;
      const card = this.closest('.producto-card');

      Swal.fire({
        title: '¿Eliminar este producto?',
        text: 'Esta acción no se puede deshacer.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'No, volver',
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d'
      }).then((result) => {
        if (!result.isConfirmed) return;

        const formData = new FormData();
        formData.append('producto_id', id);
        formData.append('ajax', '1');

        fetch('?url=productos/eliminar', {
          method: 'POST',
          body: formData
        })
        .then(res => res.json())
        .then(data => {
          if (data.success) {
            if (card) {
              card.remove();
            }
            Swal.fire({
              icon: 'success',
              title: 'Eliminado',
              text: data.message || 'El producto fue eliminado.',
              confirmButtonColor: '#4b2e83'
            });
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: data.message || 'No se pudo eliminar el producto.',
              confirmButtonColor: '#4b2e83'
            });
          }
        })
        .catch(() => {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Ocurrió un problema al eliminar el producto.',
            confirmButtonColor: '#4b2e83'
          });
        });
      });
    });
  });

  // Editar producto (admin)
  const botonesEditar = document.querySelectorAll('.btn-editar-producto');
  const modalEditar   = document.getElementById('modalEditarProducto');
  if (modalEditar) {
    const inputId          = document.getElementById('edit-id');
    const inputNombre      = document.getElementById('edit-nombre');
    const inputDescripcion = document.getElementById('edit-descripcion');
    const inputPrecio      = document.getElementById('edit-precio');

    const modalBs = new bootstrap.Modal(modalEditar);

    botonesEditar.forEach(btn => {
      btn.addEventListener('click', function () {
        inputId.value          = this.dataset.id;
        inputNombre.value      = this.dataset.nombre;
        inputDescripcion.value = this.dataset.descripcion;
        inputPrecio.value      = this.dataset.precio;

        modalBs.show();
      });
    });
  }
});
