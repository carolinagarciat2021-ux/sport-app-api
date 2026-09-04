# Documentación de la API - Sport-App (`sport-app-api`)

## Descripción General
La API REST de **Sport-App** es una interfaz de servicios web desarrollada en PHP para gestionar la comunicación entre la aplicación y la base de datos relacional MySQL. Permite realizar operaciones CRUD (Create, Read, Update, Delete) sobre el catálogo de ropa deportiva, garantizando respuestas estructuradas en formato JSON y códigos de estado HTTP estandarizados.

---

## Listado de Endpoints / Servicios Web

### 1. Consultar Todos los Productos
Permite obtener el listado completo de productos registrados en el sistema.

* **Método HTTP:** `GET`
* **Ruta / URL:** `{{base_url}}/productos.php`
* **Parámetros / Body:** Ninguno (`none`).
* **Respuesta de ejemplo (`200 OK`):**
```json
[
  {
    "id": "1",
    "nombre": "Sudadera Entrenamiento",
    "precio": "70000"
  },
  {
    "id": "3",
    "nombre": "Sudadera Entrenamiento",
    "precio": "65000"
  }
]
```
### 2. Consultar Producto por ID
Obtiene la información detallada de un producto específico mediante su parámetro identificador.

Método HTTP: GET

Ruta / URL: {{base_url}}/productos.php?id=8

Parámetros / Body: Ninguno (none).

Respuesta de ejemplo (200 OK):

```json
{
  "id": 8,
  "nombre": "Camiseta Deportiva",
  "precio": 45000
}
```
### 3. Registrar un Nuevo Producto
Permite agregar un nuevo artículo al catálogo de ropa deportiva.

Método HTTP: POST

Ruta / URL: {{base_url}}/productos.php

Headers: Content-Type: application/json

Cuerpo de la Petición (Body - raw JSON):

```json
{
  "nombre": "Chaqueta Cortavientos Impermeable",
  "precio": 85000
}
```
Respuesta de ejemplo (201 Created):

```json
{
  "estado": "éxito",
  "mensaje": "Producto creado exitosamente.",
  "id": 11
}
```
### 4. Actualizar un Producto
Modifica los datos de un producto existente especificando su ID en la URL.

Método HTTP: PUT

Ruta / URL: {{base_url}}/productos.php?id=10

Headers: Content-Type: application/json

Cuerpo de la Petición (Body - raw JSON):

```json
{
  "nombre": "Camiseta Seleccion Colombia Oficial",
  "precio": 110000
}
```
Respuesta de ejemplo (200 OK):

```json
{
  "estado": "éxito",
  "mensaje": "Producto actualizado exitosamente."
}
```
### 5. Eliminar un Producto
Remueve un producto del catálogo pasando su ID por parámetro de URL.

Método HTTP: DELETE

Ruta / URL: {{base_url}}/productos.php?id=6

Parámetros / Body: Ninguno (none).

Respuesta de ejemplo (200 OK):

```json
{
  "estado": "éxito",
  "mensaje": "Producto eliminado exitosamente."
}
```
Validaciones y Manejo de Errores HTTP
Campos obligatorios incompletos (400 Bad Request): Ocurre cuando se envía una petición POST o PUT omitiendo campos requeridos.

```json
{
  "estado": "error",
  "mensaje": "Campos obligatorios incompletos (nombre y precio son requeridos)."
}
```
Precio inválido (400 Bad Request): Ocurre si el precio enviado es menor o igual a cero o no numérico.

```json
{
  "estado": "error",
  "mensaje": "El precio debe ser un valor numérico mayor a 0."
}
```