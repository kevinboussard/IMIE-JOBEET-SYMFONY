composer update

php app/console doctrine:schema:create

php app/console doctrine:schema:update --force

php app/console doctrine:fixtures:load --no-interaction

php app/console jbt:jobeet:users admin admin

php app/console assets:install

php app/console cache:clear 

php app/console cache:clear --env=prod

php app/console server:run

exit

