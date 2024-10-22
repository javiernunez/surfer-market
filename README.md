
<h1 align="center">
🍎🥕 Fruits and Vegetables
</h1>

<p align="center">
    <img src="https://img.shields.io/badge/PHP-8.2-darkred" alt="PHP 8.2"/>
    <img src="https://img.shields.io/badge/Symfony-7.1-orange" alt="Symfony 7.1"/>
</p>




## 🚂 Running the project

1. Build docker image
   ```bash
   docker build -t surfer-market .
   ```
2. Run and expose the container's port 80 in hots 8000
   ```bash
   docker run -d -p 8000:80 -v $(pwd):/app surfer-market
   ```
3. Run doctrine migrations to have SQLITE db generated. Can be done inside the container or from host machine
   ```bash
   php bin/console  doctrine:migrations:migrate
   ```



## 👣 Routing

This solution is implementing 3 routes:

- `POST /food` to create food elements from the `request.json` provided

- `GET /food` to find food in the storage

   Example: http://localhost:8000/food

- `GET /food/search` that search for items accepting arguments 'type', 'name' and 'quantityInGrams'
   
   Example: http://localhost:8000/food/search?quantityInGrams=90000

   Expected Result:

   ```json
   [
    {
        "id": 3,
        "name": "Melons",
        "grams": 120000,
        "type": "fruit"
    },
    {
        "id": 5,
        "name": "Bananas",
        "grams": 100000,
        "type": "fruit"
    }
   ]
   ```

The data will use SQLITE storage.

## 🧪 Running tests

To run the tests you just need to run:

```bash 
$ vendor/bin/phpunit
```

Expected Results:

<img width="885" alt="Screenshot 2024-10-22 at 21 19 44" src="https://github.com/user-attachments/assets/bf476a8b-c51a-4692-8d74-d5a1ac7a7d30">


