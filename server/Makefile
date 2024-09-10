default: env prepare up key-generate migrate
	@echo "--> Your environment is ready to use! Access http://localhost:8081/api/ and enjoy it!"

.PHONY: env
env:
	@echo "--> Copying .env.example to .env file"
	@cp .env.example .env

.PHONY: prepare
prepare:
	@echo "--> Installing Composer dependencies..."
	@sh ./bin/prepare.sh

.PHONY: up
up:
	@echo "--> Starting all Docker containers..."
	@./vendor/bin/sail up -d

.PHONY: key-generate
key-generate:
	@echo "--> Generating new laravel key..."
	@./vendor/bin/sail art key:generate

.PHONY: migrate
migrate:
	@echo "--> run sail art migrate command..."
	@sleep 10
	@./vendor/bin/sail art migrate:fresh --seed

.PHONY: test
test:
	@echo "--> running laravel tests..."
	@./vendor/bin/sail art config:cache
	@./vendor/bin/sail art test
