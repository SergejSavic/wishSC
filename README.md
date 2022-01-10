![alt tag](https://sendcloud.com/wp-content/uploads/2017/02/New-Logo-mini.png)

# Sendcloud Wish Application

### Setting up application

To set up application on the server there are few steps that should be done:

- Step 1: Clone repository to desired location on server
    ```
    git clone git@gitlab.com:sendcloud/logeecom/wish.git
    ```
- Step 2: Give write privileges to www user for `./storage` and `./bootstrap/cache`
  folders. Run following command (`www-data` is used as www user):
    ```
    sudo chown -R www-data:www-data ./storage/ ./bootstrap/cache/
    ```
- Step 3: Create `.env` from one of the example .env files included in project and fill in
  configuration values.

|      Variable       |  Staging environment (connected to staging git branch)  |           Production (connected to master git branch)            |
|:-------------------:|:-------------------------------------------------------:|:----------------------------------------------------------------:|
|    *APPLICATION*    |                                                         |                                                                  |
|       APP_KEY       |       Logeecom will provide for each integration.       |          Logeecom will provide it for each integration.          |
|      APP_NAME       |                      SendcloudWish                      |                          SendcloudWish                           |
|       APP_ENV       |                         staging                         |                            production                            |
|      APP_DEBUG      |                          false                          |                              false                               |
|       APP_URL       | Sendcloud sets URL (e.g. https://wish.ws.sendcloud.com) | Sendcloud sets URL (e.g. https://wish.integration.sendcloud.com) |
|     ASSETS_URL      |     https://dev-wish.s3.eu-central-1.amazonaws.com/     |         https://prod-wish.s3.eu-central-1.amazonaws.com/         |
|     *DATABASE*      |                                                         |                                                                  |
|    DB_CONNECTION    |                          mysql                          |                              mysql                               |
|       DB_HOST       |             Sendcloud sets (database host)              |                  Sendcloud sets (database host)                  |
|       DB_PORT       |             Sendcloud sets (database port)              |                  Sendcloud sets (database port)                  |
|     DB_DATABASE     |             Sendcloud sets (database name)              |                  Sendcloud sets (database name)                  |
|     DB_USERNAME     |           Sendcloud sets (database username)            |                Sendcloud sets (database username)                |
|     DB_PASSWORD     |           Sendcloud sets (database password)            |                Sendcloud sets (database password)                |
|       *WISH*        |                                                         |                                                                  |
|    WISH_AUTH_URL    |           https://merchant.wish.com/v3/oauth            |                https://merchant.wish.com/v3/oauth                |
|    WISH_API_URL     |            https://merchant.wish.com/api/v3             |                 https://merchant.wish.com/api/v3                 |
| WISH_CLIENT_SECRET  |                        [secret]                         |                             [secret]                             |
|   WISH_CLIENT_ID    |                        [secret]                         |                             [secret]                             |
|     *SENDCLOUD*     |                                                         |                                                                  |
| SENDCLOUD_PANEL_URL |             https://panel.dev.sendcloud.sc/             |                   https://panel.sendcloud.sc/                    |      
|      *DOCKER*       |                                                         |                                                                  |
|    CONTAINER_APP    |     Container type need ( app / scheduler / queue )     |         Container type need ( app / scheduler / queue )          |
|   *FILE STORAGE*    |                                                         |                                                                  |
|  FILESYSTEM_DRIVER  |                           s3                            |                                s3                                |
|      *LOGGING*      |                                                         |                                                                  |
| SENTRY_LARAVEL_DSN  |                     Sendcloud sets                      |                          Sendcloud sets                          |
|       *OTHER*       |                                                         |                                                                  |
|    CACHE_DRIVER     |                          file                           |                               file                               |
|   SESSION_DRIVER    |                        database                         |                             database                             |
|  SESSION_LIFETIME   |                           120                           |                               120                                |
|     LOG_CHANNEL     |                    production_stack                     |                         production_stack                         |

### Build docker image (CI & CD)
After initial app setup it will be possible to build app docker image based on ./app.Dockerfile by executing:

```
docker build -t sendcloud/wish -f app.Dockerfile \
--build-arg SSH_KEY="$(cat ~/.ssh/id_rsa)" \
.
```

Building application docker image requires access to Sendcloud private repositories for integration core and middleware components. SSH_KEY build argument is used for this reason. Previous build command assumes standard git and ssh setup where ssh key is read from ~/.ssh/id_rsa file.

The web server image can be built in similar fashion.

```
docker build -t sendcloud/wish-nginx -f web.Dockerfile .
```

### Run docker image
The template for running docker environment is outlined in a .docker-compose file.

## Development (integration testing) docker setup

For development and integration testing purposes docker-compose.yml file is created that will build and run docker image automatically together with mysql
server image. To build and start all docker images required for wish app (php laravel app with apache server and mysql db) do following:

- Copy mysql.env.example file to mysq.env and setup same credentials and DB name as one in your .env file
- Set dev_stack for LOG_CHANNEL in .env file
- Run following command to build images and start application on localhost

 ```
export SSH_KEY="$(cat ~/.ssh/id_rsa)"; \
docker-compose build
```

Start ngrok with tls option

```
ngrok http 443
```

Replace APP_URL and ASSET_URL in docker-compose.yml with the ngrok https urls.

To start the app run:
```
docker-compose up -d
```

Important notice: Certificates in the ./certs directory are self-signed generated certificates used for development
purposes only.

## Running core unit tests
./vendor/bin/phpunit --configuration ./tests/phpunit.xml --testsuite Core
