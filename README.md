# Requirements
- Install Docker

# Usage
Run docker compose and build `docker-compose up --build -d` (only needed 1st time)
Next time you can just run `docker-compose up -d`

Docker compose will run 4 containers: `app`, `worker`, `db`, and `beanstalkd` container

### API

#### localhost:8000/index.php/email
* `POST` : Send Email
```
header:
Authorization: Basic a2V2aW46a2V2aW4=
```

```
body:
{
    "sendTo": "kevin@gmail.com",
    "message": "testing body email"
}
```

### Stopping
- To stop run `docker-compose stop`
- To stop and remove container `docker-compose down`

# Logs
- To see logs and errors, run `docker-compose logs -f`


# Diagram
![Diagram](http://www.plantuml.com/plantuml/png/FOyz3i8m38LtdyBgL0Okm80A6mDI9RY0Wor0JPj_SNsS53hv-VjU8db8cM8kiuLGf0XsHcXHPYVka186OCfaAAcgwLnJxrtApoXfrpfiO76i1V8U-zDuGV_ogrBoSnyN9udORse5yB2kC7OoqzistX90_Mj_n011nx-yZWhOR8jkxGqUy7QzZp38mdhG5m00)
