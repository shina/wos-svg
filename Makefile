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
	docker exec -it wos-svg /app/artisan octane:reload
	docker exec -it wos-svg /app/artisan storage:link

update: down up migrate optimize
