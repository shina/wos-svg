up:
	docker compose -f docker-compose.prod.yml up

migrate:
	docker exec -it wos-svg /app/artisan migrate
