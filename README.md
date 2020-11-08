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
![Diagram](http://www.plantuml.com/plantuml/png/FOyz3i8m38LtdyBgL0Okm80A6mDI9RY0Yor0JPj_SNsSf33vlU_PUSeG4uMK5mC-InRi9g5LcPcvGuheWIdHH56Zeiv5zSx6z0mITtM79rWjwm8vX_rflA1xkHOfsRAF3RC4xFzH0_0mDZDsij3RL5uLG7bhVzH-NuQw9hQhDWhGyfzHLu_nWBVhVOH1LjQVVG40)
