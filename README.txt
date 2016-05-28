Repository : https://github.com/kevinboussard/IMIE-JOBEET-SYMFONY

2 types d'installations :

* Order des fichiers d'installation des fichiers .cmd du projet Jobeet :

	- composer-update.cmd

	- install.cmd


* Installation standard du projet Jobeet :

	* Se positionner dans le dossier du projet qui vient d'être cloner ou télécharger.

	* Lancer une invite de commande et executer les commandes suivantes

		* composer update

		* php app/console doctrine:schema:create

		* php app/console doctrine:schema:update --force

		* php app/console doctrine:fixtures:load --no-interaction

		* php app/console jbt:jobeet:users admin admin

		* php app/console assets:install

		* php app/console cache:clear

		* php app/console cache:clear --env=prod

		* php app/console server:run
