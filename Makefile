build:
	$(MAKE) prepare-dev
	$(MAKE) analyze
	$(MAKE) tests
it:
	$(MAKE) prepare-dev
	$(MAKE) analyze

tests: vendor
	$(MAKE) prepare-test
	vendor/bin/simple-phpunit

analyze: vendor
	yarn audit
	composer valid
	php bin/console doctrine:schema:valid
	php vendor/bin/phpcs

prepare-dev: bin
	composer install --no-progress --no-suggest --prefer-dist
	php bin/console cache:clear --env=dev
	php bin/console doctrine:database:drop --if-exists -f --env=dev
	php bin/console doctrine:database:create --env=dev
	php bin/console doctrine:schema:update -f --env=dev
	php bin/console doctrine:fixtures:load -n --env=dev

prepare-test: bin
	yarn install
	yarn run dev
	composer install --no-progress --no-suggest --prefer-dist
	php bin/console cache:clear --env=test
	php bin/console doctrine:database:drop --if-exists -f --env=test
	php bin/console doctrine:database:create --env=test
	php bin/console doctrine:schema:update -f --env=test
	php bin/console doctrine:fixtures:load -n --env=test