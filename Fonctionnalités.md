# Fonctionnalités

Utilisateur : 
- [x] Connexion/déconnexion
- Créer un quizz
    - [x] Créer question
    - [ ] Choisir timer
    - [ ] Choisir type question(QCM, V/F, ...)
    - [ ] Rédiger réponses possibles + spécifier la bonne
    - [ ] Importation fichier .md/.txt décrivant le quizz (fin)
    
- [x] Modifier un quizz existant
- Lancer une partie
    - [ ] Générer code de la partie (pour inviter)
    - [ ] Afficher les pseudos des gens qui rejoignent la partie
    - [ ] Afficher question pendant le timer défini
    - [ ] Afficher les réponses possibles
    - [ ] Afficher réponse après timer
    - [ ] Calculer les points en fonction de la rapidité+justesse de la réponse
    - [ ] Générer et mettre à jour le classement à chaque question
    - [ ] Voir un récap des réponses / statistiques après une partie (+ historique enregistré)
    - [ ] Possibilité d'exporter les résultats

Invité : 
- [ ] Accès à l'accueil du site
- [ ] Création d'un compte
- [ ] Rejoindre une partie
    - [ ] Entrer le code d'une partie à rejoindre
    - [ ] Choisir son pseudo pour la partie
    - [ ] Choisir une réponse à chaque question affichée

**Fonctionnalités techniques**
- Chaque étape lors d'une partie apparaîtra différemment entre le lanceur (question, classement, réponses possibles) et les participants (timer, symbole des réponses possibles)
- Génération d'un code de partie non utilisé à l'instant du lancement (ou code associé automatique lors de la création d'un quizz ?)
- Stocker les questions/réponses dans une BDD