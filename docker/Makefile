USER_ID := $(shell id -u ${USER})
LOCAL_IP_ADDRESS := $(shell ifconfig | sed -En 's/127.0.0.1//;s/.*inet (addr:)?(([0-9]*\.){3}[0-9]*).*/\2/p')
COMPOSE=USER=${USER} USER_ID=$(USER_ID) LOCAL_IP_ADDRESS=$(LOCAL_IP_ADDRESS) docker-compose -f docker-compose.development.yml

build:
	$(COMPOSE) stop
	$(COMPOSE) rm -fv
	$(COMPOSE) build
	$(COMPOSE) up -d
stop:
	$(COMPOSE) stop
rm:
	yes | $(COMPOSE) rm
ps:
	$(COMPOSE) ps

logs:
	$(COMPOSE) logs

.PHONY: clean build
