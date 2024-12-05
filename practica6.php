
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Horas de Empleados</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #e8f5e9;
            color: #333;
        }
        .container {
            max-width: 1000px;
            margin: auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border: 2px solid #adebe4;
        }
        h1, h2 {
            text-align: center;
            color: #75e6f5;
        }
        form table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }
        form table th, form table td {
            padding: 8px;
            border: 1px solid #b2dfdb;
        }
        form table th {
            background-color: #ae85f0;
            font-weight: bold;
            color: black;
        }
        input, button {
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #b2dfdb;
            font-size: 16px;
            width: 100%; 
            box-sizing: border-box;
        }
        .boton-container {
            display: flex;
            justify-content: space-between; 
            gap: 10px; 
            flex-wrap: wrap; 
        }
        button {
            background-color: #81c784;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 19%; }
        
        button:hover {
            background-color: #eab2f1;
        }
        .table-responsive {
            overflow-x: auto; }
            width: 100%;
            -webkit-overflow-scrolling: touch;
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            min-width: 600px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #b2dfdb;
            text-align: center;
            font-size: 14px;
        }
        th {
            background-color: #ca5ad4;
            color: white;
        }
        #reiniciar-semana {
            background-color: #e9a9e0;
            margin-top: 20px;
        }
        #reiniciar-semana:hover {
            background-color: #fdaddc;
        }

       
        @media (max-width: 768px) {
            h1, h2 {
                font-size: 20px;
            }
            .container {
                padding: 10px;
            }
            th, td, input, button {
                font-size: 12px;
                padding: 5px;
            }
            .boton-container {
                flex-direction: column;
            }
        }
        @media (max-width: 480px) {
            table {
                min-width: 400px;
            }
            input, button {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Registro de Horas de Empleados</h1>
        <form id="registro-form">
            <table>
                <tr>
                    <th>Nombre</th>
                    <td><input type="text" id="nombre" placeholder="Nombre del empleado" required></td>
                </tr>
                <tr>
                    <th>Lunes</th>
                    <td><input type="number" id="lunes" placeholder="Horas trabajadas" min="0" required></td>
                </tr>
                <tr>
                    <th>Martes</th>
                    <td><input type="number" id="martes" placeholder="Horas trabajadas" min="0" required></td>
                </tr>
                <tr>
                    <th>Miércoles</th>
                    <td><input type="number" id="miercoles" placeholder="Horas trabajadas" min="0" required></td>
                </tr>
                <tr>
                    <th>Jueves</th>
                    <td><input type="number" id="jueves" placeholder="Horas trabajadas" min="0" required></td>
                </tr>
                <tr>
                    <th>Viernes</th>
                    <td><input type="number" id="viernes" placeholder="Horas trabajadas" min="0" required></td>
                </tr>
                <tr>
                    <th>Sábado</th>
                    <td><input type="number" id="sabado" placeholder="Horas trabajadas" min="0"></td>
                </tr>
                <tr>
                    <th>Domingo</th>
                    <td><input type="number" id="domingo" placeholder="Horas trabajadas" min="0"></td>
                </tr>
            </table>
            <div class="boton-container">
                <button type="submit">Registrar Horas</button>
                <button type="button" onclick="darDeAlta()">Dar de Alta</button>
                <button type="button" onclick="bajaEmpleado()">Dar de Baja</button>
                <button type="button" onclick="modificarEmpleado()">Modificar</button>
                <button type="button" onclick="consultarEmpleado()">Consultar</button>
                <button type="button" onclick="verInformes()">Ver Informes</button>
            </div>
        </form>

        <h2>Registro de Horas</h2>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Lunes</th>
                        <th>Martes</th>
                        <th>Miércoles</th>
                        <th>Jueves</th>
                        <th>Viernes</th>
                        <th>Sábado</th>
                        <th>Domingo</th>
                        <th>Total a Pagar (MXN)</th>
                    </tr>
                </thead>
                <tbody id="registros-lista"></tbody>
            </table>
        </div>
        <button id="reiniciar-semana">Reiniciar Semana</button>
    </div>

    <script>
        
        const form = document.getElementById('registro-form');
        const registrosLista = document.getElementById('registros-lista');
        const reiniciarSemanaBtn = document.getElementById('reiniciar-semana');
        let registros = [];
        const salarioMinimoPorHora = 27.57;

        form.addEventListener('submit', function(event) {
            event.preventDefault();
            const nombre = document.getElementById('nombre').value;
            const horas = {
                lunes: parseInt(document.getElementById('lunes').value),
                martes: parseInt(document.getElementById('martes').value),
                miercoles: parseInt(document.getElementById('miercoles').value),
                jueves: parseInt(document.getElementById('jueves').value),
                viernes: parseInt(document.getElementById('viernes').value),
                sabado: parseInt(document.getElementById('sabado').value) || 0,
                domingo: parseInt(document.getElementById('domingo').value) || 0,
            };

            const registro = { id: Date.now(), nombre, horas };
            registros.push(registro);
            mostrarRegistros();
            form.reset();
        });

        function mostrarRegistros() {
            registrosLista.innerHTML = '';
            registros.forEach(registro => {
                const totalHoras = Object.values(registro.horas).reduce((a, b) => a + b, 0);
                const totalPaga = totalHoras * salarioMinimoPorHora;

                const tr = document.createElement('tr');
                tr.innerHTML = 
                    <td>${registro.nombre}</td>
                    <td>${registro.horas.lunes}</td>
                    <td>${registro.horas.martes}</td>
                    <td>${registro.horas.miercoles}</td>
                    <td>${registro.horas.jueves}</td>
                    <td>${registro.horas.viernes}</td>
                    <td>${registro.horas.sabado}</td>
                    <td>${registro.horas.domingo}</td>
                    <td>$${totalPaga.toFixed(1)}</td>
                ;
                registrosLista.appendChild(tr);
            });
        }

        reiniciarSemanaBtn.addEventListener('click', function() {
            registros = [];
            mostrarRegistros();
            alert("Los registros de horas se han reiniciado.");
        });

        function darDeAlta() {
            const nombre = prompt('Ingrese el nombre del empleado para dar de alta:');
            if (nombre) {
                alert('Empleado ' + nombre + ' dado de alta.');
                
            }
        }

        function bajaEmpleado() {
            const nombre = prompt('Ingrese el nombre del empleado para dar de baja:');
            const index = registros.findIndex(registro => registro.nombre.toLowerCase() === nombre.toLowerCase());
            if (index !== -1) {
                registros.splice(index, 1);
                mostrarRegistros();
                alert('Empleado ' + nombre + ' dado de baja.');
            } else {
                alert('Empleado no encontrado.');
            }
        }

        function modificarEmpleado() {
            const nombre = prompt('Ingrese el nombre del empleado a modificar:');
            const index = registros.findIndex(registro => registro.nombre.toLowerCase() === nombre.toLowerCase());
            if (index !== -1) {
                const nuevoNombre = prompt('Ingrese el nuevo nombre para ' + nombre + ':', registros[index].nombre);
                registros[index].nombre = nuevoNombre;
                mostrarRegistros();
                alert('Empleado ' + nombre + ' modificado a ' + nuevoNombre);
            } else {
                alert('Empleado no encontrado.');
            }
        }

        function consultarEmpleado() {
            const nombre = prompt('Ingrese el nombre del empleado para consultar:');
            const registro = registros.find(registro => registro.nombre.toLowerCase() === nombre.toLowerCase());
            if (registro) {
                alert('Empleado: ' + registro.nombre + '\n' +
                    'Lunes: ' + registro.horas.lunes + '\n' +
                    'Martes: ' + registro.horas.martes + '\n' +
                    'Miércoles: ' + registro.horas.miercoles + '\n' +
                    'Jueves: ' + registro.horas.jueves + '\n' +
                    'Viernes: ' + registro.horas.viernes + '\n' +
                    'Sábado: ' + registro.horas.sabado + '\n' +
                    'Domingo: ' + registro.horas.domingo);
            } else {
                alert('Empleado no encontrado.');
            }
        }

        function verInformes() {
            const totalHoras = registros.reduce((acc, registro) => {
                return acc + Object.values(registro.horas).reduce((a, b) => a + b, 0);
            }, 0);
            const totalPago = totalHoras * salarioMinimoPorHora;
            alert('Informe General:\nTotal de horas trabajadas: ' + totalHoras + '\nTotal a pagar: $' + totalPago.toFixed(2));
        }
    </script>
</body>






























































































































































































































































































</html>  