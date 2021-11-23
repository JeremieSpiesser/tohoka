# Groupe n°4

## Réservé au cours

### Composition de l'équipe

| Nom                | Prénom            | Email                                      |
| -------------      | -------------     | -------------------------------            |
| *Goyard*           | *Louis*           | *goyard.louis@gmail.com*                   |
| *Sadler*           | *Alec*            | *alec.sadler@ensiie.fr*                    |
| *Germain*          | *Sophie*          | *sophie.germain@ensiie.fr*                 |
| *Ranini*           | *Tony*            | *nitorac.r@gmail.com*                      |
| *Spiesser*         | *Jérémie*         | *jeremie.spiesser@ensiie.fr*               |
| *Corredor Morales* | *Wendy Alejandra* | *wendyalejandra.corredormorales@ensiie.fr* |

### Sujet : Tohoka (Kahoot-like)
> Il s'agit de créer un site de mise à disposition de quizz qui puissent être joués à plusieurs en même temps. Dans l'original (https://kahoot.com), 
> lors d'une partie un classement est mis à jour à chaque question en fonction de la validité de la réponse donnée par le joueur et sa vitesse de réaction par rapport à ses concurrents. 
>
> Dans le Kahoot d'origine, il n'est pas utile de posséder un compte pour participer à une partie, mais s'authentifier permet d'accéder à l'interface de création d'une partie. 
> Les quizz créés peuvent prendre diverses formes, avec des questions de type QCM, QCU, Vrai/Faux, question avec une image, ...



## Mise en place du WebSocket

### Installation de l'environnement de dev

Vous aurez besoin de redis-server ainsi que PHPRedis (`sudo apt install redis-server php-redis`)

Ensuite, regardez le `.env.example` et mettez les nouveaux champs à jour dans votre `.env`, c'est à dire :
 * APP_URL: Doit être le site effectif, port compris (par exemple `http://localhost:8000`)
 * MIX_SOCKET_PORT: Le port du websocket (pour que le client JS se connecte au websocket serveur)
 * BROADCAST_DRIVER: Doit être `redis`
 * QUEUE_CONNECTION: Doit rester `sync` (Laravel gère lui même les tâches de broadcast)
 * REDIS_CLIENT: Doit être `phpredis` (autre client non supporté)
 * REDIS_PREFIX: Par commodité, on le laisse vide !
 * REDIS_HOST: Le domaine du serveur REDIS du point de vue Laravel
 * REDIS_PASSWORD: Le mot de passe du serveur REDIS du point de vue Laravel
 * REDIS_PORT: Le port du serveur REDIS du point de vue Laravel

Pour lancer le tout, il faut toujours faire plusieurs étapes :

 1. Faire un `composer install && npm install` 
 2. Toujours lancer `npm run dev` après avoir touché au JS dans `resources/js/` et au moins une fois si jamais fait
 3. Il faut démarrer `redis-server` si ce n'est pas fait
 4. Pour lancer le serveur, il faut lancer dans 2 consoles : `php artisan serve` et `npm run echo`

Vous pouvez contrôler la liaison Laravel-Websocket avec la commande `redis-cli monitor`
