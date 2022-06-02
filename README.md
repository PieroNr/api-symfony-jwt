# api-symfony-jwt

## Installation

- `docker-compose up -d`
- `docker-compose exec symfony bash`
- `composer install`
- `symfony console doctrine:database:create`
- `symfony console doctrine:migrations:migrate`
- `symfony console doctrine:fixtures:load`
- `symfony console lexik:jwt:generate-keypair`


## Lien
- Serveur Symfony : `http://localhost:8000`
- Phpmyadmin : `http://localhost:8080`


### Routes : 

**Connexion : `/login_check`** ['POST']
 
Body : 
```
{
  "username": "admin@admin.com",
  "password": "admin"
}
```
Headers : `Content-Type : application/json`  



**Inscription : `/register`** ['POST']

Body :
```
{
  "username" : "username",
  "firstname" : "Test",
  "lastname" : "Test",
  "email" : "email@email.com",
  "password" : "password"	
}
```
Headers :
`Content-Type : application/json`



**Listes des posts : `/posts`** ['GET']

**Créer un post : `/posts`** ['POST']
 
Body :                             
```                                
{
  "title": "title of post",
  "content": "content of post"
}
```                                
Headers :                          
`Content-Type : application/json`  

**Voir un post : `/posts/{id}`** ['GET']

**Supprimer  un post : `/posts/{id}`** ['DELETE']

**Liste des users : `/users`** ['GET']
