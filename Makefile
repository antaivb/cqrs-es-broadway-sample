DEBIAN_JESSIE_SOURCES_MIRROR?=
DOCKER_REGISTRY?=localhost:5000
MAIN_NAMESPACE?=$(shell git symbolic-ref --short HEAD | sed -e 's/\//-/g;s/_/-/g')
NAMESPACE:=$(shell echo $(MAIN_NAMESPACE) | sed -e 's/\//-/g;s/_/-/g')
TAG?=$(shell git describe --tags --always --match="v*" 2> /dev/null || cat $(CURDIR)/.version 2> /dev/null || echo v0)
PROJECT?=app/app
IMAGE=$(DOCKER_REGISTRY)/$(PROJECT)
IMAGE_TAG=$(IMAGE):$(TAG)
MAIN_BRANCH ?= master
ENVIRONMENT?=staging
COMPONENTS ?= api:$(TAG) \
			  mysql:5.7 \
              redis:5.0-alpine


# Local development
local:
	docker start app-mysql-development
	symfony server:start

local-stop:
	docker stop app-mysql-development
