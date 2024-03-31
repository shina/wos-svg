up:
	docker compose -f docker-compose.prod.yml up -d

down:
	docker compose -f docker-compose.prod.yml down

migrate:
	docker exec -it wos-svg /app/artisan migrate

prune:
	docker system prune --all --force --volumes

optimize:
	docker exec -it wos-svg /app/artisan optimize

update: down up migrate optimize
