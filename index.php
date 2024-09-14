<?php
include "connectdb.php"
?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Biosina</title>
    <link rel="stylesheet" href="style.css">
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
      crossorigin="anonymous"
    />
  </head>
  <body class= "bg-dark" >
    <h1 class="text-center text-white">Formulario de Información</h1>
    <main>
      <div class="container mt-5 bg-light p-5 rounded ms-md-4 me-md-4 ">
        <div id="alert" class="alert d-none" role="alert"></div>
      
        <form id="infoForm">
          <div class="mb-3">
            <label for="nombre" class="form-label fw-bold">Nombre completo</label>
            <input
              type="text"
              class="form-control"
              id="nombre"
              placeholder="Ingrese su nombre completo"
              required
            />
          </div>
          <div class="mb-3">
            <label for="edad" class="form-label fw-bold">Edad</label>
            <input
              type="number"
              class="form-control"
              id="edad"
              placeholder="Ingrese su edad"
              min="18"
              max="60"
              required
            />
          </div>
          <fieldset class="mb-3" id="fieldset">
            <label for="sexo" class="form-label fw-bold">Sexo</label>
            <div>
              <input
                type="radio"
                id="masculino"
                name="sexo"
                value="Masculino"
                checked
              />
              <label for="masculino" class="form-label">Masculino</label>
            </div>
            <div>
              <input type="radio" id="femenino" name="sexo" value="Femenino" />
              <label for="femenino" class="form-label">Femenino</label>
            </div>
          </fieldset>
          <div class="mb-3">
            <label for="fechaNacimiento" class="form-label fw-bold"
              >Fecha de nacimiento</label
            >
            <input
              type="date"
              class="form-control"
              id="fechaNacimiento"
              required
            />
          </div>
          <div class="mb-3">
            <label for="correo" class="form-label fw-bold">Correo electrónico</label>
            <input
              type="email"
              class="form-control"
              id="correo"
              placeholder="Ingrese su correo electrónico"
              required
            />
          </div>
          <button type="submit" class="btn btn-primary w-100">Enviar</button>
        </form>
      </div>
      <section class="container mt-5 bg-light p-5 rounded ms-md-4 me-md-4">
        <h2 class="text-center">Datos Agregados</h2>
        <table class="table table-striped mt-3">
          <thead>
            <tr>
              <th>Nombre Completo</th>
              <th>Correo Electrónico</th>
            </tr>
          </thead>
          <tbody id="dataTableBody">
            <!-- Aquí aparecen los datos -->
          </tbody>
        </table>
      </section>
    </main>

    <script>

      document.getElementById('infoForm').addEventListener('submit', function(event) {
        event.preventDefault(); 

        let formData = {
          nombre: document.getElementById('nombre').value,
          edad: document.getElementById('edad').value,
          sexo: document.querySelector('input[name="sexo"]:checked').value,
          fechaNacimiento: document.getElementById('fechaNacimiento').value,
          correo: document.getElementById('correo').value
        };
        console.log(formData)

        fetch('processinfo.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(formData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                console.log(data.message);
                let alertPopUp = document.getElementById('alert');
                alertPopUp.classList.remove('d-none');
                alertPopUp.classList.add('alert-success');
                alertPopUp.textContent = 'Datos enviados correctamente.';
                fetchAndDisplayData();
            } else {
              let alertPopUp = document.getElementById('alert');
              alertPopUp.classList.remove('d-none');
              alertPopUp.classList.add('alert-danger');
              alertPopUp.textContent = 'Error al enviar los datos, porfavor refresque la pagina';
            }
        })
        .catch(error => {
          let alertPopUp = document.getElementById('alert');
          alertPopUp.classList.remove('d-none');
          alertPopUp.classList.add('alert-danger');
          alertPopUp.textContent = 'Error al enviar los datos, porfavor refresque la pagina ';
        });
      });

      function fetchAndDisplayData() {
        fetch('getinfo.php')
          .then(response => response.json())
              .then(data => {
                console.log('Datos obtenidos:', data);
                if (data.status === 'success') {
                  const tableBody = document.getElementById('dataTableBody');
                  tableBody.innerHTML = '';
                  data.data.forEach(row => {
                      console.log('Fila:', row);
                      const rowElement = document.createElement('tr');
                      //Si no hay valor entonces N/A para que no marque undefined
                      rowElement.innerHTML = `<td>${row.name || 'N/A'}</td><td>${row.email || 'N/A'}</td>`;
                      tableBody.appendChild(rowElement);
                  });
                } else {
                  alert('Error al obtener los datos: ' + data.message);
                }
              })
              .catch(error => {
                  console.error('Error al obtener los datos:', error);
                  alert('Error al obtener los datos.');
              });
      }
    fetchAndDisplayData();   
    </script>

    <!-- DEPENDENCIES POPPER, BOOTSTRAP -->
    <script
      src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
      integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
