DOCKER_COMPOSE = docker-compose
DOCKER_EXEC = $(DOCKER_COMPOSE) exec

init:
	$(DOCKER_COMPOSE) up -d --build
	$(DOCKER_EXEC) php composer install
	$(DOCKER_EXEC) php init
	$(DOCKER_EXEC) php yii migrate --interactive=0

up:
	$(DOCKER_COMPOSE) up -d

down:
	$(DOCKER_COMPOSE) down