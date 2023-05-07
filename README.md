# TO DO Vue.JS

## Descripción

Este proyecto es una aplicación web basada en Vue.js que te permite administrar tus tareas pendientes. Puedes crear nuevas tareas, marcarlas como completadas, editar su contenido y eliminarlas. Es una forma sencilla y eficiente de mantener un seguimiento de tus actividades diarias.

## Características

- Crear nuevas tareas
- Marcar tareas como completadas
- Editar el contenido de las tareas existentes
- Eliminar tareas de la lista

## Tecnologías utilizadas

- Vue.js
- HTML
- CSS
- PHP

## Instalación

1. Clona este repositorio en tu máquina local.
2. Abre el proyecto en tu editor de código favorito.
3. Abre una terminal en la carpeta raíz del proyecto.
4. Ejecuta el siguiente comando para instalar las dependencias:

   ```bash
   npm install
   ```

## Configuración de la base de datos

1. Primero, asegúrate de haber importado el archivo SQL incluido en el proyecto. El archivo SQL se encuentra en el directorio raiz y se llama `db.sql`.

2. Accede a tu sistema de gestión de bases de datos (por ejemplo, phpMyAdmin) y ejecuta la consulta del archivo `db.sql`.

## Configuración de servicios RESTFUL

1. Copia el archivo todo-vuejs.php en la carpeta htdocs de tu instalación de XAMPP. Puedes encontrar la carpeta htdocs en la ubicación donde instalaste XAMPP en tu máquina.

2. Inicia tu servidor web local (por ejemplo, XAMPP) y asegúrate de que esté en ejecución.

3. Accede a la siguiente URL en tu navegador web para verificar que todo esté funcionando correctamente:

```bash
   http://localhost/todo-vuejs.php
```

## Ejecutar el proyecto
```bash
   npm run dev
```