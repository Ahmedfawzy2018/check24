
# 1. Start the container
Download and launch the container. Especially the download process may take a while if your internet connection is slower.
```bash
❯ docker-compose up -d
```

Run `docker ps` to find out the name of your php container. It should look like this for docker >= 4.1 `s2-coding-challenge-php-1` (docker < 4.1 `s2-coding-challenge_php_1`) (name of the folder + php + number of instance) then you can open a bash into your container using:
```bash
❯ docker ps
CONTAINER ID   IMAGE                       COMMAND                  CREATED              STATUS                        PORTS                                                        NAMES
f47293b013a9   s2-coding-challenge_nginx   "/docker-entrypoint.…"   About a minute ago   Up About a minute             0.0.0.0:80->80/tcp, :::80->80/tcp                            s2-coding-challenge-nginx-1
5f308739b6eb   s2-coding-challenge_php     "docker-php-entrypoi…"   About a minute ago   Up About a minute             9000/tcp                                                     s2-coding-challenge-php-1
df0c8329609f   mysql/mysql-server:latest   "/entrypoint.sh mysq…"   About a minute ago   Up About a minute (healthy)   0.0.0.0:3306->3306/tcp, :::3306->3306/tcp, 33060-33061/tcp   s2-coding-challenge-mysql-1
```
then you can enter the php container (/bin/ash is not a type. It is alpines shell)
```bash
❯ docker exec -it s2-coding-challenge-php-1 /bin/ash
```


# In the container: Initialization
```bash
❯ composer install
❯ bin/console doctrine:schema:update --force
❯ bin/console doctrine:fixtures:load -n
❯ yarn install
❯ yarn encore dev
```

# Frontend build
Whenever you have made changes in the frontend and thus also after your initialization, you need to run the build process for this
```bash
❯ yarn encore dev
```

# Congratulations !
You have successfully set up your coding challange DEV environment. You can now access the application in your browser
```bash
http://localhost
```
The application code can be found in the `src` folder. \
\
You can access the DB by typing following into your local shell
```bash
❯ docker exec -it s2-coding-challenge-mysql-1 /bin/bash
❯ mysql -u user -ppassword
```

# Troubleshooting

## docker container are not starting
please shutdown all other projects in docker to avoid using port 80 and 3306. You can run `docker ps` to identify other running containers. Easiest way is to stop then via UI

#### Already used port 3306 for mysql
when you can't temporary stop the container, or you have a mysql running directly on your machine, please change the port in the following files
- In file:`./docker-compose.yml`
    - Uncomment the lines 14, 17 and 18
    - Change the port 3306 to 3307 in lines 16 and 26
- In file: `./.env`
    - Change the port 3306 to 3307 in line 34 (DATABASE_URL)
- Run `docker-compose up -d` to update the container settings
