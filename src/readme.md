# Sample Api based on Laravel's Lumen micro-framework

## How to

### Prerequisite
  - Docker for windows or mac

### Start

```
docker-composer up -d
```

### Migrate

```
docker-compose exec php php artisan migrate
```

### Seed

```
docker-compose exec php php artisan db:seed
```

### Test

```
docker-compose exec php vendor/bin/phpunit
```

## Documentation

### API

**Get Jobs: Returns a list of jobs ( default 10 jobs returned)**

```
Method: GET
URL: http://localhost:8080/api/jobs

Params:
- page (int) example ?page=1

Header:
Authorization: Bearer {TOKEN}
```

**Get Job: Returns a job for the requested job ID**

```
Method: GET
URL: http://localhost:8080/api/jobs/{:id}

Header:
Authorization: Bearer {TOKEN}
```

**Create Job**

```
Method: POST
URL: http://localhost:8080/api/jobs

Params:
- title (string) 
- description (string)
- location (string)

Header:
Authorization: Bearer {TOKEN}
```

**Update Job**

```
Method: PUT
URL: http://localhost:8080/api/jobs/{:id}

Params:
- title (string) 
- description (string)
- location (string)

Header:
Authorization: Bearer {TOKEN}
```

**Delete Job**

```
Method: DELETE
URL: http://localhost:8080/api/jobs/{:id}

Header:
Authorization: Bearer {TOKEN}
```
