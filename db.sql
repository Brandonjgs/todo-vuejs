DROP DATABASE IF EXISTS todo_vuejs;

CREATE DATABASE todo_vuejs;

USE todo_vuejs;

CREATE TABLE todos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  description TEXT,
  created DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  task_status VARCHAR(50),
  status VARCHAR(50)
);

INSERT INTO todos (title, description, task_status, status)
VALUES
    ('Completar informe', 'Terminar el informe mensual de ventas', 'pending', '1'),
    ('Revisar correos', 'Revisar y responder los correos electrónicos', 'completed', '1'),
    ('Preparar presentación', 'Crear la presentación para la reunión de mañana', 'pending', '1'),
    ('Llamar a cliente', 'Contactar al cliente para programar una reunión', 'completed', '1'),
    ('Actualizar base de datos', 'Realizar actualización de la base de datos de clientes', 'pending', '1'),
    ('Investigar nuevos proveedores', 'Buscar y evaluar nuevos proveedores para productos', 'pending', '1'),
    ('Enviar facturas', 'Generar y enviar las facturas pendientes a los clientes', 'completed', '1'),
    ('Organizar archivos', 'Ordenar y archivar los documentos en las carpetas correspondientes', 'pending', '1'),
    ('Configurar reunión', 'Establecer fecha y hora para la reunión del equipo', 'pending', '1'),
    ('Crear informe de gastos', 'Generar informe detallado de gastos del mes', 'pending', '1'),
    ('Enviar propuesta', 'Elaborar y enviar propuesta comercial al cliente', 'completed', '1'),
    ('Realizar inventario', 'Contar y registrar el inventario de productos en el almacén', 'pending', '1'),
    ('Actualizar sitio web', 'Agregar nuevas funcionalidades al sitio web de la empresa', 'pending', '1'),
    ('Resolver incidencias', 'Atender y resolver las incidencias reportadas por los usuarios', 'pending', '1'),
    ('Planificar estrategia de marketing', 'Elaborar plan de marketing para el próximo trimestre', 'completed', '1');
