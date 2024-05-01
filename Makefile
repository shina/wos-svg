up:
	docker compose -f docker-compose.prod.yml up -d

down:
	docker compose -f docker-compose.prod.yml down

migrate:
	docker exec -it wos-svg /app/artisan migrate --force

prune:
	docker system prune --all --force --volumes

build:
	./sail test
	docker compose -f docker-compose.prod.yml build
	docker save -o wos-svg.tar wos-svg-wos-svg
	scp wos-svg.tar root@svg.servegame.com:/root/wos-svg
	rm wos-svg.tar

load:
	docker load -i wos-svg.tar

backup:
	cp database/database.sqlite /root/db.bkp

gitpull:
	git pull

optimize:
	docker exec -it wos-svg /app/artisan optimize
	docker exec -it wos-svg /app/artisan data:cache-structures
	docker exec -it wos-svg /app/artisan octane:reload
	docker exec -it wos-svg /app/artisan storage:link

update: backup gitpull load up migrate optimize
