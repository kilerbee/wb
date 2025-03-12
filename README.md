# Articles and tags

The solution is wrapped in Docker with common commands in Makefile. You can run it this way:

Setup the project
```bash
make install
```

Start containers 
```bash
make up
```
Execute migrations
```bash
make migrate
```

After that the app is ready to use.

At the end
```bash
make down
```

## API

After the application is started you can visit `http://localhost:8080/api/doc.json` to see API schema.

### Tags

#### Create a tag

Request:

```http request
POST /api/tags HTTP/1.1

{
    "name": "New tag"
}
```

Response:

```text
HTTP/1.1 201 Created

{
    "id": 5,
    "name": "New tag"
}
```

#### Update a tag

Request:

```http request
POST /api/tags/5 HTTP/1.1

{
    "name": "Updated new tag"
}
```

Response:

```text
HTTP/1.1 200 OK

{
    "id": 5,
    "name": "Updated new tag"
}
```

#### List all tags (additional)

Request:

```http request
GET /api/tags HTTP/1.1
```

Response:

```text
HTTP/1.1 200 OK

{
    "tags": [
        ...
        {
            "id": 5,
            "name": "Updated new tag"
        }
    ]
}
```

### Articles

#### Create an article

Request:

```http request
POST /api/articles HTTP/1.1

{
    "name": "New article",
    "tags": [
        1,
        3,
        4,
        5
    ]
}
```
Response:

```text
HTTP/1.1 201 Created

{
    "id": 9,
    "name": "New article",
    "tags": [
        {
            "id": 1,
            "name": "updated"
        },
        {
            "id": 3,
            "name": "new"
        },
        {
            "id": 4,
            "name": "one more"
        },
        {
            "id": 5,
            "name": "Updated new tag"
        }
    ]
}
```

#### Update an article

Request:

```http request
POST /api/articles/9 HTTP/1.1

{
    "name": "Updatd new article",
    "tags": [
        4,
        5
    ]
}
```

Response:

```text
HTTP/1.1 200 OK

{
    "id": 9,
    "name": "Updatd new article",
    "tags": [
        {
            "id": 4,
            "name": "one more"
        },
        {
            "id": 5,
            "name": "Updated new tag"
        }
    ]
}
```

#### List all articles

Request without filter:

```http request
GET /api/articles HTTP/1.1
```

Response:

```text
HTTP/1.1 200 OK

{
    "articles": [
        {
            "id": 3,
            "name": "Updated test article",
            "tags": [
                {
                    "id": 1,
                    "name": "updated"
                },
                {
                    "id": 3,
                    "name": "new"
                }
            ]
        },
        {
            "id": 4,
            "name": "Another test article",
            "tags": [
                {
                    "id": 1,
                    "name": "updated"
                },
                {
                    "id": 2,
                    "name": "Test"
                }
            ]
        },
        {
            "id": 5,
            "name": "Another test article",
            "tags": []
        },
        {
            "id": 8,
            "name": "New article",
            "tags": [
                {
                    "id": 1,
                    "name": "updated"
                },
                {
                    "id": 3,
                    "name": "new"
                },
                {
                    "id": 4,
                    "name": "one more"
                }
            ]
        },
        {
            "id": 9,
            "name": "Updatd new article",
            "tags": [
                {
                    "id": 4,
                    "name": "one more"
                },
                {
                    "id": 5,
                    "name": "Updated new tag"
                }
            ]
        }
    ]
}
```

Request with filter (`/api/articles?tags[]=1&tags[]=3`):

```http request
GET /api/articles?tags%5B%5D=1&tags%5B%5D=3 HTTP/1.1
```
Response:

```text
HTTP/1.1 200 OK

{
    "articles": [
        {
            "id": 8,
            "name": "New article",
            "tags": [
                {
                    "id": 1,
                    "name": "updated"
                },
                {
                    "id": 3,
                    "name": "new"
                },
                {
                    "id": 4,
                    "name": "one more"
                }
            ]
        },
        {
            "id": 3,
            "name": "Updated test article",
            "tags": [
                {
                    "id": 1,
                    "name": "updated"
                },
                {
                    "id": 3,
                    "name": "new"
                }
            ]
        }
    ]
}
```
