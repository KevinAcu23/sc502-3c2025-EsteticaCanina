const formatearNumero = (n) => {
  return Number.isInteger(n) ? n : n.toFixed(2);
};

const actualizarTotal = () => {
  let total = 0;
  document.querySelectorAll("#carrito-body tr").forEach(fila => {
    const precioSpan = fila.querySelector(".precio");
    const cantidadInput = fila.querySelector(".cantidad");
    const subtotalSpan = fila.querySelector(".subtotal");

    if (!precioSpan || !cantidadInput || !subtotalSpan) return;

    const precio = parseFloat(precioSpan.textContent);
    let cantidad = parseInt(cantidadInput.value) || 1;
    if (cantidad <= 0) cantidad = 1;

    const subtotal = precio * cantidad;
    subtotalSpan.textContent = formatearNumero(subtotal);
    total += subtotal;
  });

  const totalSpan = document.getElementById("total");
  if (totalSpan) {
    totalSpan.textContent = "₡" + formatearNumero(total);
  }
};

document.addEventListener('DOMContentLoaded', function () {
  // Actualizar total cuando cambie la cantidad
  document.querySelectorAll(".cantidad").forEach(input => {
    input.addEventListener("change", () => {
      if (input.value <= 0) input.value = 1;
      actualizarTotal();
    });
  });

  // Eliminar producto del carrito con SweetAlert
  document.querySelectorAll(".eliminar").forEach(btn => {
    btn.addEventListener("click", e => {
      const fila = e.target.closest("tr");
      if (!fila) return;

      const productoId = fila.dataset.productoId;

      Swal.fire({
        title: '¿Quitar este producto?',
        text: 'Se eliminará del carrito.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'No, volver',
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d'
      }).then((result) => {
        if (!result.isConfirmed) return;

        const formData = new FormData();
        formData.append('producto_id', productoId);
        formData.append('ajax', '1');

        fetch('?url=carrito/eliminar', {
          method: 'POST',
          body: formData,
          credentials: 'same-origin'
        })
        .then(res => res.json())
        .then(data => {
          if (data.success) {
            fila.remove();
            actualizarTotal();

            Swal.fire({
              icon: 'success',
              title: 'Producto eliminado',
              text: data.message || 'Se eliminó del carrito.',
              confirmButtonColor: '#4b2e83'
            });
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: data.message || 'No se pudo eliminar el producto del carrito.',
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

  // Confirmación al finalizar compra
  const formFinalizar = document.getElementById('form-finalizar');
  if (formFinalizar) {
    formFinalizar.addEventListener('submit', function (e) {
      e.preventDefault();

      const filas = document.querySelectorAll('#carrito-body tr');
      if (!filas.length) {
        Swal.fire({
          icon: 'info',
          title: 'Carrito vacío',
          text: 'No tienes productos en el carrito.',
          confirmButtonColor: '#4b2e83'
        });
        return;
      }

      Swal.fire({
        title: '¿Confirmar compra?',
        text: 'Se generará tu factura con los productos del carrito.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sí, realizar compra',
        cancelButtonText: 'No, aún no',
        confirmButtonColor: '#4b2e83',
        cancelButtonColor: '#6c757d'
      }).then((result) => {
        if (result.isConfirmed) {
          formFinalizar.submit();
        }
      });
    });
  }

  // Calcula total al cargar
  actualizarTotal();
});
