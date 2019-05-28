# Sample Api based on Laravel's Lumen micro-framework

[![CircleCI](https://circleci.com/gh/sachitsac/lumen-sample-api.svg?style=svg)](https://circleci.com/gh/sachitsac/lumen-sample-api)

## How to

### Prerequisite
  - Docker for windows or mac
  - Postman or Curl

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

## Database config

```
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=lumenApi
DB_USERNAME=root
DB_PASSWORD=secr3t

external database port = 3307
```

## Initial seed

The database can be seeded with some dummy data including user data. Seed file contains users with all having the same password. The seed file also creates a default user with the credentials below:

```
email: user@example.com
password: secr3t12345
```

## Documentation

### API

**AUTH Endpoint**

This endpoint will authenticate a user provided they exist in the system and return a valid JWT token that can be used to request further jobs endpoints. This token is valid for 1 hour and will need to be renewed after that to make further requests.

Note: There is not refresh token / exchange token api implemented yet.

```
Method: POST
URL: http://localhost:8080/auth

Params:
- username (string) a valid email addreee * required
- password (string) * required

Returns:
{"token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJjb2RpbmctY2hhbGxlbmdlIiwic3ViIjoxLCJpYXQiOjE1NTYyODgwNjcsImV4cCI6MTU1NjI5MTY2N30.ra37lytHSIh65jhFYlcWyrr2QJzBbmQoPGQbB7z0brI"}
```

**Get Jobs: Returns a list of jobs ( default 10 jobs returned)**

```
Method: GET
URL: http://localhost:8080/api/jobs

Params:
- page (int) example ?page=1

Header:
Authorization: Bearer {TOKEN}

Returns:

Status = 200

{
    "current_page": 1,
    "data": [
        { ...
        },
        ...
    ],
    "first_page_url": "http://localhost:8080/api/jobs?page=1",
    "from": 1,
    "last_page": 5,
    "last_page_url": "http://localhost:8080/api/jobs?page=5",
    "next_page_url": "http://localhost:8080/api/jobs?page=2",
    "path": "http://localhost:8080/api/jobs",
    "per_page": 10,
    "prev_page_url": null,
    "to": 10,
    "total": 47
}
```

**Get Job: Returns a job for the requested job ID**

```
Method: GET
URL: http://localhost:8080/api/jobs/{:id}

Header:
Authorization: Bearer {TOKEN}

Returns:

Status = 200

{
    "id": 1,
    "title": "This is a title Updated",
    "description": "This is a description Updated",
    "location": "Melbourne East",
    "user_id": 1,
    "created_at": "2019-04-26 14:09:20",
    "updated_at": "2019-04-27 00:38:56"
}

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

Returns:

Status = 201

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
