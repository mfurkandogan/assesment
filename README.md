## Step 1: Create env file 

```
$ cp .env.example .env
```

## Step 2: Change db config

DB_CONNECTION=mysql
DB_HOST=10.5.0.2
DB_PORT=3306
DB_DATABASE=ideasoft
DB_USERNAME=root
DB_PASSWORD=123456

## Step 3: Step up a database seeders

Run this command to docker up

```
$ docker-compose up -d
```
## Step 4: Final Step
Finally, run this command to create db tables and import demo data:

```
$ docker exec -it ideasoftassesment php artisan migrate --seed
```

