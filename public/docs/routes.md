# Routes

## Routes accessibles visiteurs
| URL | Méthode HTTP | Controller | Méthode | Titre | Contenu | Commentaire |
|--|--|--|--|--|--|--|
|`/`|GET|PostController|home|O'Stan|Articles conseils, side bar + lien pour la connexion/inscription|--|
| `/mentions-legales/` | GET | MainController | legalMentions | Mentions Légales | Paragraphes sur les mentions légales | - |
|`/concept/`|GET|MainController|concept|Le concept du site|présentation du concept du site - présentation des createurs du site - les points primordiaux dans son utilisation|--|
|`/contact/`|POST|MainController|contact|Contact|Page pour nous contacter|Formulaire de contact|
|`/plan-du-site/`|GET|MainController|sitemap|Plan du site|lien vers les différentes catégories|assez réduit car peu de fonctionnalités ouvertes au visiteur => lien vers page de connexion ?|
|`/advice-post/{id}/`|GET|PostController|AdviceShow|Détail article conseil| Un article en entier|--|
|`/connexion/`|POST|Backend\SecurityController|login|Connexion|Se connecter|redirection vers `/annonces/`  |
|`/inscription/`|POST|Backend\RegisterController|signup|Inscription|S'inscrire|redirection vers `/profil/` |


## Routes accessibles utilisateurs
| URL | Méthode HTTP | Controller | Méthode | Titre | Contenu | Commentaire |
|--|--|--|--|--|--|--|
|`/deconnexion/`|POST|Backend\SecurityController|logout|Déconnexion|Se déconnecter|redirection vers `/`|
|`/profil/{id}/`|GET|UserController|profile|Profil|Mon profil|page dédié à l'utilisateur (page de son profil) / son "métier", sa gallery, ... |
|`/profil/edit/{id}`|GET|UserController|profile|Profil|Mon profil - édition|page pour mise à jour de son profil / formulaire|
|`/`|POST|PostController|home||Liste des annonces|Page d'accueil de l'utilisateur une fois connecté|
|`/annonce/edit/{id}/`|POST|PostController|adEdit|Editer une annonce|Editer son annonce|Formulaire pour éditer une annonce |
|`/annonce/delete/{id}/`|POST|PostController|adDelete|Supprimer une annonce|Editer son annonce|Formulaire pour éditer une annonce |
|`/annonce/new/`|POST|PostController|adNew||Nouvelle annonce|Formulaire création annonce|
|`/profil/{id}/`|GET|UserController|profileShow|Profil utilisateur|Le profil "public" d'un utilisateur| accessible uniquement par les utilisateurs connectés et actifs |
|`/tag/{id}/`|GET|TagController|tagShow|Page par theme|liste de toutes les annonces et pro liées à ce tag|--|



## Routes accessibles uniquement administrateur
| URL | Méthode HTTP | Controller | Méthode | Titre | Contenu | Commentaire |
|--|--|--|--|--|--|--|
|`/backend/tag/`|GET|Backend\TagController|tagList|Liste des tags|Liste de tous les tags|--|
|`/backend/tag/edit/{id}/`|POST|Backend\TagController|tagEdit|Edition du tag|Formulaire d'édition d'un tag|Formulaire pour modifier un tag (son titre par exemple)|
|`/backend/tag/new/`|POST|Backend\TagController|tagNew|Création d'un tag|Formulaire création d'un tag|Formulaire |
|`/backend/tag/delete/{id}`|POST|Backend\TagController|tagDelete|Suppression d'un tag|Formulaire suppression d'un tag|Formulaire |
|`/backend/user/`|GET|Backend\UserController|userList|Liste de tous les utilisateurs|leur nom, leur rôle, la date de création du profil ? |--|
|`/backend/user/{id}/`|GET|Backend\UserController|userDetail|Consultation du profil d'un utilisateur|Avec notamment son role, son email|--|
|`/backend/user/block/{id}/`|GET|Backend\UserController|userBlock|Bloquer un user |--|
|`/backend/user/edit/{id}/`|POST|Backend\UserController|userEdit|Editer profil d'un utilisateur|Page pour éditer un profil|changer son role par exemple, formulaire|
|`/backend/user/delete/{id}/`|POST|Backend\UserController|userDelete|Supprimer profil d'un utilisateur|Page pour supprimer un profil|changer son role par exemple, formulaire|
|`/backend/`|GET|Backend\PostController|adList|Liste de toutes les annonces| le titre, le créateur de l'annonce, la date de création et le nombre de réponse|--|
|`/backend/annonce/{id}/`|GET|Backend\PostController|adDetail|Consultation d'une annonce d'un utilisateur|le titre, le contenu, le créateur de l'annonce, la date de création et toutes les réponses|--|
|`/backend/annonce/edit/{id}/`|POST|Backend\PostController|adEdit|Edition d'une annonce|Page pour éditer une annonce|pour modifier une annonce avec par exemple, un message en rouge "mention supprimée, ne respecte pas la charte"|
|`/backend/annonce/block/{id}/`|GET|Backend\PostController|annonceBlock|Bloquer une annonce |--|
|`/backend/annonce/delete/{id}/`|POST|Backend\PostController|adDelete|Suppression d'une annonce|Page pour supprimer une annonce|pour modifier une annonce avec par exemple, un message en rouge "mention supprimée, ne respecte pas la charte"|
|`/backend/comment/block/{id}/`|GET|Backend\CommentController|commentBlock|Bloquer un commentaire |--|
|`/backend/comment/delete/{id}/`|GET|Backend\CommentController|commentDelete|Suppression commentaire utilisateur|Suppression d'un commentaire utilisateur |--|
|`/backend/advice-post/`|GET|Backend\PostController|advicepostList|Liste de tous les articles| le titre, le détail, la date de création et de modification|--|
|`/backend/advice-post/new/`|POST|Backend\PostController|advicepostNew|Creation articles|Page creation d'article|formulaire de création d'article|
|`backend/advice-post/{id}/`|GET|Backend\PostController|advicePostShow|Détail d'un article| Un article en entier|--|
|`backend/advice-post/edit/{id}/`|POST|Backend\PostController|advicePostEdit|Edition d'un article|Edition d'un article|Formulaire|
|`backend/advice-post/delete/{id}/`|POST|Backend\PostController|advicePostDelete|Suppression d'un article|Suppression d'un article|Formulaire|