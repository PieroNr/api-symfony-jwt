# api-symfony-jwt

## First run
At first run you must :
- Start docker : `docker-compose up -d`
- Go to the symfony container : `docker-compose exec symfony bash`
  - Install the vendors : `composer install`
  - Run the migrations : `symfony console doctrine:migrations:migrate`
  - Run the fixtures : `symfony console doctrine:fixtures:load`
  - Create the keys for the jwt : `symfony console lexik:jwt:generate-keypair`

## Next run
You just have to run `docker-compose up -d`

## Dev url
Your application run at `http://localhost:8000`
Phpmyadmin run at : `http://localhost:8080`

## Api
You must set the header `Accept : application/json` in all the requests !
Base url : `http://localhost:8000/api/`

### Routes : 
#### Public
**Login : `/login_check`**

Method : POST  
Body : 
```
{
  "username": "admin@admin.com",
  "password": "password"
}
```
Headers : `Content-Type : application/json`  

**Register : `/register`**

Method : POST  
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

#### Protected

**List all posts : `/posts`**

Method : GET

**Create a post : `/posts`**   

Method : POST       
Body :                             
```                                
{
  "title": "Hello world",
  "content": "Lorem ipsum sit dolores"
}
```                                
Headers :                          
`Content-Type : application/json`  

**Get a post : `/posts/{id}`**                

Method : GET   

**Delete a post : `/posts/{id}`**
