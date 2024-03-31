up:
	docker compose -f docker-compose.prod.yml up -d

down:
	docker compose -f docker-compose.prod.yml down

migrate:
	docker exec -it wos-svg /app/artisan migrate
