.PHONY: test-up
test-up:
	docker-compose -f docker-compose.test.yml up -d

.PHONY: test-down
test-down:
	docker-compose -f docker-compose.test.yml down
