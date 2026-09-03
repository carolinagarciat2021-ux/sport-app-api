# Documentación de la API - Sport-App (`sport-app-api`)

## Descripción General
La API REST de **Sport-App** es una interfaz de servicios web desarrollada en PHP para gestionar la comunicación entre el sistema frontend y la base de datos relacional `venta_ropa_deportiva` en MySQL Workbench. Su finalidad principal es permitir la consulta y creación de productos del catálogo de ropa deportiva, garantizando validaciones de datos y respuestas estructuradas en formato JSON con códigos de estado HTTP estandarizados.

---

## Listado de Endpoints / Servicios Web

### 1. Consultar el Catálogo de Productos
Permite obtener el listado completo de todos los productos registrados en el sistema.

* **Método HTTP:** `GET`
* **Ruta / URL:** `http://localhost/sport-app-api/productos.php`
* **Parámetros / Body:** Ninguno (`none`).
* **Respuesta de ejemplo (`200 OK`):**
```json
[
  {
    "id_producto": 1,
    "nombre": "Camiseta Deportiva Transpirable",
    "precio": 85000.00
  },
  {
    "id_producto": 2,
    "nombre": "Zapatillas Running Hombre",
    "precio": 210000.00
  }
]

2. Registrar un Nuevo Producto
Permite agregar un nuevo artículo al catálogo de productos de la tienda.

Método HTTP: POST

Ruta / URL: http://localhost/sport-app-api/productos.php

Headers: Content-Type: application/json

Cuerpo de la Petición (Body - raw JSON):

{
  "nombre": "Chaqueta Cortavientos Impermeable",
  "precio": 145000
}

Respuesta de ejemplo (201 Created):

{
  "estado": "éxito",
  "mensaje": "Producto creado correctamente."
}


Validaciones y Manejo de Errores HTTP
La API incluye validaciones básicas para garantizar la integridad de los datos ingresados:

Campos obligatorios incompletos (400 Bad Request):

Ocurre cuando se envía una petición POST sin incluir alguno de los campos requeridos (nombre o precio).

Respuesta JSON:

{
  "estado": "error",
  "mensaje": "Campos obligatorios incompletos (nombre y precio son requeridos)."
}
Formato o valor de dato inválido (400 Bad Request):

Ocurre si el precio enviado es menor o igual a cero, o si contiene caracteres no numéricos.

Respuesta JSON:

{
  "estado": "error",
  "mensaje": "El precio debe ser un valor numérico mayor a 0."
}