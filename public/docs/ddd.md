# Dictionnaire de données

## USER

|Champ|Type|Spécificités|Description|
|-|-|-|-|
|id|INT|PRIMARY KEY, NOT NULL, AUTO_INCREMENT, UNSIGNED|L'identifiant de l'utilisateur|
|avatar|VARCHAR(255)|NULL|L'avatar de l'utilisateur|
|firstname|VARCHAR(100)|NOT NULL|Le prénom de l'utilisateur|
|lastname|VARCHAR(100)|NOT NULL|Le nom de famille de l'utilisateur|
|username|VARCHAR(100)|NOT NULL|Le nom de l'utilisateur|
|companyname|VARCHAR(100)|NOT NULL|Le nom de l'entreprise (editeur)|
|description|TEXT|NULL|La description de l'utilisateur|
|siret|INT(14)|NULL|Le SIRET de l'entreprise (editeur)|
|password|VARCHAR(255)|NOT NULL|Le mot de passe de l'utilisateur|
|birthdate|DATETIME|NOT NULL|La date de naissance de l'utilisateur|
|email|VARCHAR(255)|NOT NULL|L'adresse mail de l'utilisateur|
|address|VARCHAR(255)|NULL|L'adresse postale de l'utilisateur (editeur)|
|phonenumber|INT(10)|NULL|Le numéro de téléphone de l'entreprise (editeur)|
|created_at|DATETIME|NOT NULL, DEFAULT CURRENT_TIMESTAMP|La date de création de l'utilisateur|
|updated_at|DATETIME|NULL|La date de la dernière mise à jour de l'utilisateur|

## ROLE

|Champ|Type|Spécificités|Description|
|-|-|-|-|
|id|INT|PRIMARY KEY, NOT NULL, AUTO_INCREMENT, UNSIGNED|L'identifiant du rôle|
|name|VARCHAR(20)|NOT NULL|Le nom du rôle|
|code|VARCHAR(60)|NOT NULL|Le code du rôle|

## POST

|Champ|Type|Spécificités|Description|
|-|-|-|-|
|id|INT|PRIMARY KEY, NOT NULL, AUTO_INCREMENT, UNSIGNED| L'identifiant du post (article/annonce)|
|title|VARCHAR(100)|NOT NULL|Titre du post|
|picture1|VARCHAR(255)|NULL|Image d'accompagnement du post (photo, dessin)|
|picture2|VARCHAR(255)|NULL|Image d'accompagnementdu post|
|picture3|VARCHAR(255)|NULL|Image d'accompagnement du post|
|description|LONGTEXT|NOT NULL|Paragraphe du post|
|created_at|DATETIME|NOT NULL, DEFAULT CURRENT_TIMESTAMP|La date de création du post|
|updated_at|DATETIME|NULL|La date de la dernière mise à jour du coup|


## GALLERYPOST

|Champ|Type|Spécificités|Description|
|-|-|-|-|
|id|INT|PRIMARY KEY, NOT NULL, AUTO_INCREMENT, UNSIGNED| L'identifiant de galerie |
|title|VARCHAR(100)|NOT NULL|Titre de la galerie|
|picture_1|VARCHAR(255)|NULL|Dessin/image/storyboard (...) de l'utilisateur|
|picture_2|VARCHAR(255)|NULL|Dessin/image/storyboard (...) de l'utilisateur|
|picture_3|VARCHAR(255)|NULL|Dessin/image/storyboard (...) de l'utilisateur|
|description|TEXT|NOT NULL|Paragraphe de la galerie|
|created_at|DATETIME|NOT NULL, DEFAULT CURRENT_TIMESTAMP|La date de création de la galerie|
|updated_at|DATETIME|NULL|La date de la dernière mise à jour de la galerie|

## COMMENT

|Champ|Type|Spécificités|Description|
|-|-|-|-|
|id|INT|PRIMARY KEY, NOT NULL, AUTO_INCREMENT, UNSIGNED|L'identifiant du commentaire|
|description|TEXT|NOT NULL|Paragraphe du commentaire|
|created_at|DATETIME|NOT NULL, DEFAULT CURRENT_TIMESTAMP|La date de création du commentaire|
|updated_at|DATETIME|NULL|La date de la dernière mise à jour du commentaire|

## JOB

|Champ|Type|Spécificités|Description|
|-|-|-|-|
|id|INT|PRIMARY KEY, NOT NULL, AUTO_INCREMENT, UNSIGNED|L'identifiant du job|
|name|VARCHAR(20)|NOT NULL|Nom du job|

## TAG

|Champ|Type|Spécificités|Description|
|-|-|-|-|
|id|INT|PRIMARY KEY, NOT NULL, AUTO_INCREMENT, UNSIGNED| L'identifiant du thème |
|name|VARCHAR(20)|NOT NULL|Nom du thème|

## STATUS

|Champ|Type|Spécificités|Description|
|-|-|-|-|
|id|INT|PRIMARY KEY, NOT NULL, AUTO_INCREMENT, UNSIGNED| L'identifiant du status |
|label|VARCHAR(20)|NOT NULL|Label du status|
|code|VARCHAR(20)|NOT NULL|Code du status|

## MESSAGE

|Champ|Type|Spécificités|Description|
|-|-|-|-|
|id|INT|PRIMARY KEY, NOT NULL, AUTO_INCREMENT, UNSIGNED|L'identifiant du message |
|content|TEXT|NOT NULL|Contenu du message|
|created_at|DATETIME|NOT NULL, DEFAULT CURRENT_TIMESTAMP|La date de création du message|
|email|VARCHAR(255)|NOT NULL|Texte du message inscrit dans le formulaire de contact|
|title|CARCHAR(100)|NOT NULL|Titre du message inscrit dans le formulaire de contact|