# Como abrir a documentação da API

- run `php artisan l5-swagger:generate` para construir o JSON Swagger à partir das annotations;
- Um arquivo vai ser gerado em `/storage/api-docs/api-docs.json`;
- Então, navegue para `http://localhost:8081/api/documentation`.