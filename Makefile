# Makefile para gerenciar aplicação Laravel com Docker Compose

# Cores para output no terminal
RESET = \033[0m
GREEN = \033[32m
YELLOW = \033[33m
BLUE = \033[34m

# Variáveis
CONTAINER_APP = jrinvest_app
CONTAINER_NODE = jrinvest_node

.PHONY: help up down restart build bash logs ps artisan migrate migrate-fresh seed test npm-install npm-dev npm-build queue queue-listen queue-retry queue-failed

help: ## Exibe ajuda com os comandos disponíveis
	@echo "${BLUE}Uso:${RESET}"
	@echo "  make [comando]"
	@echo ""
	@echo "${BLUE}Comandos disponíveis:${RESET}"
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "  ${YELLOW}%-15s${RESET} %s\n", $$1, $$2}'

up: ## Inicia os containers da aplicação
	@echo "${GREEN}Iniciando os containers...${RESET}"
	docker compose up -d
	@echo "${GREEN}Aplicação disponível em: http://localhost:8000${RESET}"

down: ## Para e remove os containers da aplicação
	@echo "${GREEN}Parando os containers...${RESET}"
	docker compose down

restart: ## Reinicia os containers da aplicação
	@echo "${GREEN}Reiniciando os containers...${RESET}"
	docker compose restart

build: ## Reconstrói os containers da aplicação
	@echo "${GREEN}Reconstruindo os containers...${RESET}"
	docker compose build --no-cache
	docker compose up -d

bash: ## Acessa o shell do container da aplicação
	@echo "${GREEN}Acessando o shell do container...${RESET}"
	docker exec -it $(CONTAINER_APP) bash

logs: ## Exibe os logs da aplicação
	@echo "${GREEN}Exibindo logs...${RESET}"
	docker compose logs -f

ps: ## Lista os containers em execução
	@echo "${GREEN}Listando containers...${RESET}"
	docker compose ps

# Comandos Laravel Artisan
artisan: ## Executa um comando Artisan (uso: make artisan cmd="comando")
	@echo "${GREEN}Executando comando Artisan: $(cmd)${RESET}"
	docker exec -it $(CONTAINER_APP) php artisan $(cmd)

migrate: ## Executa as migrações do banco de dados
	@echo "${GREEN}Executando migrações...${RESET}"
	docker exec -it $(CONTAINER_APP) php artisan migrate

migrate-fresh: ## Recria o banco de dados e executa todas as migrações
	@echo "${GREEN}Recriando banco de dados e executando migrações...${RESET}"
	docker exec -it $(CONTAINER_APP) php artisan migrate:fresh

seed: ## Executa os seeders do banco de dados
	@echo "${GREEN}Executando seeders...${RESET}"
	docker exec -it $(CONTAINER_APP) php artisan db:seed

route-list: ## Lista todas as rotas da aplicação
	@echo "${GREEN}Listando rotas...${RESET}"
	docker exec -it $(CONTAINER_APP) php artisan route:list

cache-clear: ## Limpa todos os caches da aplicação
	@echo "${GREEN}Limpando caches...${RESET}"
	docker exec -it $(CONTAINER_APP) php artisan cache:clear
	docker exec -it $(CONTAINER_APP) php artisan config:clear
	docker exec -it $(CONTAINER_APP) php artisan route:clear
	docker exec -it $(CONTAINER_APP) php artisan view:clear

# Comandos para testes
test: ## Executa os testes da aplicação
	@echo "${GREEN}Executando testes...${RESET}"
	docker exec -it $(CONTAINER_APP) php artisan test

# Comandos para NPM
npm-install: ## Instala as dependências do NPM
	@echo "${GREEN}Instalando dependências do NPM...${RESET}"
	docker exec -it $(CONTAINER_NODE) npm install

npm-dev: ## Executa o script de desenvolvimento do NPM
	@echo "${GREEN}Executando npm run dev...${RESET}"
	docker exec -it $(CONTAINER_NODE) npm run dev

npm-build: ## Executa o script de build do NPM
	@echo "${GREEN}Executando npm run build...${RESET}"
	docker exec -it $(CONTAINER_NODE) npm run build

# Comandos para Composer
composer-install: ## Instala as dependências do Composer
	@echo "${GREEN}Instalando dependências do Composer...${RESET}"
	docker exec -it $(CONTAINER_APP) composer install

composer-update: ## Atualiza as dependências do Composer
	@echo "${GREEN}Atualizando dependências do Composer...${RESET}"
	docker exec -it $(CONTAINER_APP) composer update

# Comando para inicialização completa do projeto
init: up composer-install npm-install migrate ## Inicializa o projeto completo (containers, dependências e migrações)
	@echo "${GREEN}Projeto inicializado com sucesso!${RESET}"

# Comandos para filas
queue: ## Executa o worker de filas (uso: make queue [queue="high,default,low"])
	@echo "${GREEN}Iniciando worker de filas...${RESET}"
	@if test -n "$(queue)"; then \
		echo "${GREEN}Processando filas: $(queue)${RESET}"; \
		docker exec -it $(CONTAINER_APP) php artisan queue:work --queue=$(queue); \
	else \
		echo "${GREEN}Processando todas as filas${RESET}"; \
		docker exec -it $(CONTAINER_APP) php artisan queue:work; \
	fi

queue-listen: ## Executa o listener de filas (uso: make queue-listen [queue="high,default,low"])
	@echo "${GREEN}Iniciando listener de filas...${RESET}"
	@if test -n "$(queue)"; then \
		echo "${GREEN}Escutando filas: $(queue)${RESET}"; \
		docker exec -it $(CONTAINER_APP) php artisan queue:listen --queue=$(queue); \
	else \
		echo "${GREEN}Escutando todas as filas${RESET}"; \
		docker exec -it $(CONTAINER_APP) php artisan queue:listen; \
	fi

queue-retry: ## Tenta novamente jobs que falharam
	@echo "${GREEN}Tentando novamente jobs que falharam...${RESET}"
	docker exec -it $(CONTAINER_APP) php artisan queue:retry all

queue-failed: ## Lista jobs que falharam
	@echo "${GREEN}Listando jobs que falharam...${RESET}"
	docker exec -it $(CONTAINER_APP) php artisan queue:failed