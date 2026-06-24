app test de gestion de una posible biblioteca universitaria

## Entorno local

1. Copia `.env.example` a `.env`.
2. Ajusta credenciales de base de datos en `.env`.

## Entorno de pruebas

1. Crea una base de datos de test (por defecto `biblioteca_test`).
2. Importa el esquema de pruebas desde `bd_test.sql`.
3. Opcional: copia `.env.testing.example` a `.env.testing` y ajusta credenciales.
4. Ejecuta pruebas con:

```bash
composer test
```

Notas:
- Durante PHPUnit, `APP_ENV` se fuerza a `test` en `tests/bootstrap.php`.
- `connection.php` usa `TEST_DB_*` cuando `APP_ENV=test`.
