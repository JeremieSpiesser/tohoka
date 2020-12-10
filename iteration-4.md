# Rapport d'itération  
*Ce rapport est à fournir pour chaque équipe au moment du changement d'itération.*

## Composition de l'équipe 
*Remplir ce tableau avec la composition de l'équipe et les rôles.*

|  &nbsp;                 | Itération précédente     |
| -------------           |-------------             |
| **Product Owner**       | *Louis*                  |
| **Scrum Master**        | *Tony*                   |

## Bilan de l'itération précédente  
### Évènements 
*Quels sont les évènements qui ont marqué l'itération précédente? Répertoriez ici les évènements qui ont eu un impact sur ce qui était prévu à l'itération précédente.*
> L'un des événements centraux de la vie associative de l'école, la campagne pour les élections du BdE, a débuté en plein milieu de ce sprint. Les deux tiers des membres de notre équipe 
  > de projet a pris part à l'organisation active de cet événement, ce qui a de fait impacté leur disponibilité.
>
> De plus, quelques partiels nous ont déjà été donnés cette semaine. De nombreux autres examens se profilent pour la semaine prochaine ainsi que des projets qui nous ont été demandés. Cette quantité de travail 
> nous a obligé à diminuer le temps que nous consacrions à cette matière afin de l'équilibrer avec celui des autres disciplines.

### Taux de complétion de l'itération  
*Quel est le nombre d'éléments terminés par rapport au nombre total d'éléments prévu pour l'itération?*
> 6 terminés / 8 prévues = 75%

### Liste des User Stories terminées
*Quelles sont les User Stories qui ont été validées par le PO à la fin de l'itération ?*
> - Rajouter des questions à base d'images *(quasiment terminée, problème avec la base de données du serveur alors que fonctionnel en local)*
> - Rajouter des questions à base de son *(idem)*
> - Réparer les quizzs
> - Mode responsive
> - Protéger un salon par mot de passe
> - Commencer une partie à plusieurs
> - Terminer une partie à plusieurs
> - Ajouter un timer sur les quizzs

## Rétrospective de l'itération précédente
  
### Bilans des retours et des précédentes actions 
*Quels sont les retours faits par l'équipe pendant la rétrospective? Quelles sont les actions qui ont apporté quelque chose ou non?*
> La priorisation des US réalisée en début de sprint était bien faite, de sorte que le produit obtenu à la fin de l'itération contient toutes les features
> les plus utiles pour les utilisateurs et les plus rentables en termes de business value. Par contre, si la priorisation était réussie, les dernières US étaient vraiment conséquentes, presque trop ambitieuses.

### Axes d'améliorations 
*Quels sont les axes d'améliorations pour les personnes qui ont tenu les rôles de PO, SM et Dev sur la précédente itération?*
> Nous avons rencontré au cours de ce sprint la même difficulté qu'au cours des premières itérations : l'évaluation correcte de la complexité. En  effet, nous avons cette fois encore sous-évalué les difficultés de certaines user stories, 
> déséquilibrant la répartition entre les membres de l'équipe de développement. Ce point serait donc à améliorer pour les projets futures.



## Bilan du projet  
### Avancement  
*Où en est votre projet à la fin de la quatrième et dernière itération ?*
> A l'issue de ce sprint, toutes les fonctionnalités indispensables à une utilisation agréable de notre site sont en place. Pour rappel, nous avions choisi pour projet de réaliser un site de création et de jeu de quizz similaire à [Kahoot](https://kahoot.com).
>
> En effet, aujourd'hui notre site [Tohoka](https://tohoka.tk) est bien disponible en ligne. Des simples visiteurs peuvent jouer à des quizzs publics, mais le plus intéressant concerne les utilisateurs qui auront décidé de s'inscrire et de se connecter.
> Ces utilisateurs connectés peuvent créer des quizz très divers : QCM/Vrai-Faux/QCU/..., nombre de questions et réponses libre, ... Quizzs qu'ils peuvent évidemment modifier et supprimer s'ils le veulent. Ils peuvent par la suite
> jouer à tout quizz dont il obtiennent le numéro de la partie, y compris les leurs. A l'issue d'une partie, le joueur obtient son score.
>
> Nous avons également créé la possibilité de jouer à plusieurs. En générant le numéro de salle pour lancer la partie, si le lanceur connecté partage le numéro avec des gens même non connectés, ces personnes pourront se joindre à la partie.
>
> Un petit bonus a été développé pour agrémenter le jeu. Nous sommes conscients qu'il faut éviter de développer des fonctionnalités non demandées par le PO, mais dans la mesure où pour ce projet ce PO faisait partie intégrante de l'équipe de dev, nous avons persévéré.
> Il est important de préciser que nous nous le sommes permis car cela ne nous demandait pas davantage de travail (il s'agissait en quelques sorte d'une phase de test pour vérifier le bon échange de données par le websocket).
> Ce petit bonus est un chat de discussion. Les utilisateurs mêmes non connectés peuvent rejoindre une salle de discussion pour échanger avec leurs concurrents lors d'une partie, par exemple.

### Améliorations possibles dans des itérations futures  
*Lister ici les fonctionnalités définies par le PO comme features qu'il aurait pu être intéressant de développer dans des sprint futurs.*
> - Une US que nous avions identifiée comme peu rentable niveau business value était la vérification de l'incription par envoi d'un mail de confirmation. Associé à cette fonctionnalité, il serait utile que l'utilisateur connecté puisse moodifier ses informations personnelles grâce à une page Profil.
> - Avec plus de sprints, nous pourrions essayer d'améliorer le bonus, en liant une salle de discussion à une salle de jeu.
> - Une fonctionnalité avait été implémentée lors de l'un des premiers sprints puis partiellement modifiée au cours des suivants : lors de la validation du quizz lors d'une partie seul, le joueur obtenait les corrections et réponses attendues à chacune des questions. Initialement traitée en javascript,
> la validation des réponses est désormais gérée par php, et nous avons abandonné lors de cette migration (jugée nécessaire pour les questions affichées une par une) la partie "correction" développée. A terme, il serait utile à l'utilisateur d'obtenir à nouveau ces corrections afin de savoir où s'améliorer
> et de comprendre le calcul de son score.
> - Le Kahoot dont nous nous servons de modèle calcule le score à chaque question en fonction de la justesse de la réponse, mais aussi de la rapidité d'envoi par rapport aux autres joueurs. Nous n'avons pas jugé prioritaire d'introduire cette fonctionnalité, mais elle aurait pu l'être dans un sprint suivant.

### Méthode Agile 
*Faites un bilan du fonctionnement de gestion de projet en méthode Agile que vous avez dû suivre.*
> Novices en la matière, de nombreuses difficultés ont été rencontrées au cours de la gestion de projet. Les principales ont été l'équilibrage des US, et la gestion du temps au sein de sprints.
> Tout au long des quatre sprints, nous avons petit à petit appris à mieux raffiner nos US, mieux les définir et mieux les prioriser. En revanche, la mauvaise connaissance des technologies que nous avions choisies nous a amenés à fortement sous-évaluer la complexité de certaines fonctionnalités. Ceci a de facto entraîné des déséquilibres 
> dans la répartition du travail et du retard dans l'implémentation de certaines US (justifiant les reports à certains sprints). Cette faiblesse devrait s'atténuer à force de réalisation de projets, car cela nous permettra d'apprendre à mieux évaluer nos capacités et à mieux gérer notre temps.
>
> Nous avons essayé, au cours de ces quatre sprints, d'alterner les rôles (PO et SM, faisant tous partie de l'équipe de dev par les besoins de la matière). De la sorte, nous avons pu chacun notre tour nous pencher sur les problématiques de ces rôles (priorisation et définition des besoins, facilitation des échanges, ...). Il est regrettable
> que l'essentiel du projet se soit déroulé à distance, ce qui nous a privé de véritables étapes du déroulé Agile (daily, rétrospectives, ... cérémonies effectuées mais sans les véritables interactions que  nous aurions dû pouvoir expérimenter).

### Satisfaction du résultat obtenu
*Remplir le tableau sachant que :D est une satisfaction pleine et entière en le résultat obtenu. Mettre le nombre de votes dans chacune des cases.*


|          	| :( 	| :&#124; 	| :) 	| :D 	|
|:--------:	|:----:	|:----:	    |:----:	|:----:	|
| Equipe 7 	|  *0* 	|  *0* 	    |  *0* 	|  *6* 	|

 
 
