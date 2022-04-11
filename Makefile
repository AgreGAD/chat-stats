all: demo

deps:
	composer install

ecs-fix:
	./vendor/bin/ecs check --fix src/ tests/

ecs-check:
	./vendor/bin/ecs check src/ tests/

test:
	./vendor/bin/phpunit

docker-build:
	docker build -t agregad/chat-stats .

docker-deploy:
	docker push agregad/chat-stats

info:
	./bin/console info

info-short:
	./bin/console info --short

run-cases:
	@echo ""
	@echo "Examples: "
	@echo ""
	@echo docker run --rm -it --entrypoint=bin/console agregad/chat-stats calc http://195.140.147.119:8080/?case=a
	@./bin/console calc http://195.140.147.119:8080/?case=a
	@echo docker run --rm -it --entrypoint=bin/console agregad/chat-stats calc http://195.140.147.119:8080/?case=b
	@./bin/console calc http://195.140.147.119:8080/?case=b

fulltest: ecs-check test

demo: info fulltest run-cases info-short
