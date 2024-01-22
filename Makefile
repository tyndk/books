DOCKER_COMPOSE = docker-compose
DOCKER_EXEC = $(DOCKER_COMPOSE) exec

init:
	$(DOCKER_COMPOSE) up -d --build
	$(DOCKER_EXEC) php composer install

up:
	$(DOCKER_COMPOSE) up -d
	$(DOCKER_EXEC) php yii migrate --interactive=0
down:
	$(DOCKER_COMPOSE) down