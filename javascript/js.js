async function fetchUsers() {
    try {
        const response = await fetch('clientes/clientesById.php?id=1'); // URL del archivo PHP
        if (!response.ok) {
            throw new Error('Error en la respuesta del servidor');
        }
        let data = []
        data.push(await response.json()) ; // Convertir respuesta a JSON
        console.log(data); // Ver los datos en la consola

        // Llenar la tabla con los datos
        const tableBody = document.querySelector('#usersTable tbody');
        tableBody.innerHTML = ''; // Limpiar cualquier contenido previo

        data.forEach(user => {
            const row = `
                <tr>
                    <td>${user.ID}</td>
                    <td>${user.Nombre}</td>
                    <td>${user.Apellido}</td>
                </tr>
            `;
            tableBody.innerHTML += row; // Insertar fila en la tabla
        });
    } catch (error) {
        console.error('Error:', error);
    }
}

// Llamar a la función al cargar la página
fetchUsers();