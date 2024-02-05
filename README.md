## Step 1: Create env file 

```
cp .env.example .env
```

## Step 2: Change db config

DB_CONNECTION=mysql<br>
DB_HOST=10.5.0.2<br>
DB_PORT=3306<br>
DB_DATABASE=ideasoft<br>
DB_USERNAME=root<br>
DB_PASSWORD=123456<br>

## Step 3: Step up a database seeders

Run this command to docker up

```
docker-compose up -d
```
## Step 4: Final Step
Finally, run this command to create db tables and import demo data:

```
docker exec -it ideasoftassesment php artisan migrate --seed
```


## NOTE : Endpoint Test Collection

Postman Collection (ideasoft_assesment.postman_collection.json) is in the main folder.
