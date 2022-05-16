install:
	chmod 777 mysql && chmod 777 logs && chmod 777 www/logs
start:
	bash start.sh .
migrate:
	docker exec -it kc_test_php_1 php console.php
