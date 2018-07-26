# Solution
## Explanation
```
Challenge that I did: 
  challenge number 1.
  
Libraries: 
  Klein (Router)
  PHP-DI (Dependency Injection)
  Doctrine (ORM and Migrations)

Code Flows:
  src/App/Route/ProductPost.php --> goes to middlewares
  Middlewares -->
     Auth -> Product POST Body Validate -> Product Create -> Render
     
Endpoint:
    POST http://localhost:8000/v1/products
    body:          
    {
      "sku": "LES-123-s-green",
      "name": "Cotton t-shirt, S, green",
      "price": {
        "value": 170.87,
        "currency": "CNY"
      }
    }
```
  
## Requirement
1. docker & docker-compose to run mysql server
2. PHP 7 & composer

## Run server
```
./run.sh
```

## Run Test
``` 
./test.sh
```
 
