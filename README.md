# crud-products-konecta
Crud maestro stock de productos en php 

# Base de datos

```sql
DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `reference` VARCHAR(255) NOT NULL,
  `price` INT NOT NULL,
  `weight` INT NOT NULL,
  `category` VARCHAR(255) NOT NULL,
  `stock` INT NOT NULL,
  `created_at` DATE NOT NULL,
  `last_selled_at` DATETIME NULL,

  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

# Configuración DB

Ir al archivo **config/config.php** y registrar las credenciales de la DB.

# Documentación API

1. Listar todos los productos:

URL: /product
Metodo: GET

2. Listar un producto

URL: /product/{id}
Metodo: GET

3. Crear un producto

URL: /product
Metodo: POST
Entrada:
```json
{
    "name": "Jabon Deluxe",
    "reference": "RF679898",
    "price": "3500",
    "weight": "2",
    "category": "Cuidado personal",
    "stock": "3000"
}
```

4. Modificar un producto

URL: /product/{id}
Metodo: PUT
Entrada:
```json
{
    "name": "Jabon Deluxe 2",
    "reference": "RF6798982",
    "price": "3400",
    "weight": "2",
    "category": "Cuidado personal",
    "stock": "2000"
}
```

5. Eliminar un producto

URL: /product/{id}
Metodo: DELETE

6. Realizar la venta de un producto

URL: /invoice
Metodo: POST
Entrada:
```json
{
    "product_id": 4
}
```
