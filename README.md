# Koriym.Restbucks

This project is a sample implementation of the Restbucks application described in the book [REST in Practice](http://shop.oreilly.com/product/9780596805838.do) by Jim Webber, Savas Parastatidis and Ian Robinson.

## What's RESTbucks ?

RESTbucks is about ordering and paying for coffee and food.
Read the article.

 * [How to **GET** a Cup of Coffee](http://www.infoq.com/articles/webber-rest-workflow)
 * [1杯のコーヒーを得る方法](http://www.infoq.com/jp/articles/webber-rest-workflow)

### GET Ready ?

Install

    $ git clone https://github.com/koriym/Koriym.Restbucks.git
    $ cd Koriym.Restbucks
    $ composer install
  
Warm up

    $ cd bootstrap
    $ cd php api.php 
    SUMMARY
        api.php -- CLI Router
    
    USAGE
        api.php <method> <resource URI path with query>
    
    DESCRIPTION
        Available methods are [get|post|put|patch|delete|options].
        
    $ php api.php options /order
    code: 200
    header:
    allow: get, post, put, delete
    body:


Story 1: As a customer, I want to order a coffee so that Restbucks can prepare my drink


    $ php api.php post '/order?drink=latte'
    code: 201
    header:
    body:
    {
        "drink": "latte",
        "cost": 2.5,
        "id": "1758",
        "_links": {
            "self": {
                "href": "/order?drink=latte"
            },
            "payment": {
                "href": "/payment?id=1758"
            }
        }
    }

Story 2: As a customer. I want to be able to change my drink to suite my taste

    $ php api.php put '/order?id=1758&addition=shot
    code: 100
    header:
    body:
    {
        "drink": "latte",
        "cost": 2.5,
        "id": "1758",
        "addition": "shot",
        "_links": {
            "self": {
                "href": "/order?id=1758&addition=shot"
            },
            "payment": {
                "href": "/payment?id=1758"
            }
        }
    }

Story 3: As a customer. I want to be able to pay my bill to receive my drink

    $ php api.php put '/payment?id=1758&card_no=12345678&expires=09082015&name=bear&amount=1'
    code: 200
    header:
    body:
    {
        "drink": "latte",
        "cost": 2.5,
        "id": "1758",
        "addition": "shot",
        "card_no": "12345678",
        "expires": "09082015",
        "name": "bear",
        "amount": "1",
        "_links": {
            "self": {
                "href": "/payment?id=1758&card_no=12345678&expires=09082015&name=bear&amount=1"
            }
        }
    }

TBC to "As a barista scenario"
