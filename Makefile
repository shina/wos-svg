up:
	docker compose -f docker-compose.prod.yml up -d --build

down:
	docker compose -f docker-compose.prod.yml down

migrate:
	docker exec -it wos-svg /app/artisan migrate --force

prune:
	docker system prune --all --force --volumes

optimize:
	docker exec -it wos-svg /app/artisan optimize

octane:


update: down up migrate optimize
