## Installation

1.  Clone this repo.

2. If you are working with Docker Desktop for Mac, ensure **you have enabled `VirtioFS` for your sharing implementation**. `VirtioFS` brings improved I/O performance for operations on bind mounts. Enabling VirtioFS will automatically enable Virtualization framework.

3. Create the file `./.docker/.env.nginx.local` using `./.docker/.env.nginx` as template. The value of the variable `NGINX_BACKEND_DOMAIN` is the `server_name` used in NGINX.

4. Go inside folder `./docker` and run `docker compose up -d` to start containers.

5. You should work inside the `php` container.

6. Inside the `php` container, run `composer install && php bin/console doctrine:migrations:migrate` to install dependencies from `/var/www/symfony` folder.

7. Use the following value for the DATABASE_URL environment variable:

```
DATABASE_URL=mysql://app_user:helloworld@db:3306/app_db?serverVersion=8.0.33
```

You could change the name, user and password of the database in the `env` file at the root of the project.

## Endpoints

|  Endpoint | Params  | Method  |
| ------------ | ------------ |
| /account-list  |  	client_id  | POST |
| /make-transaction  |  	id_from, id_to, amount, currency  | POST |
| /transactions-history  |  	account_id  | POST |

------------

## Example

|  Endpoint | Params  | Method  |
| ------------ | ------------ |
|  http://0.0.0.0:888/transactions-history |  account_id = MDI75ORX5PX <br> offset = 1 <br> limit = 2 |
|  http://0.0.0.0:888/account-list  |  client_id=1 |
|  http://0.0.0.0:888/make-transactiont  |  id_from = LPV38ZZW8LB <br> id_to = BLD14KPC6BF <br> amount = 10 <br> currency = EUR |

## Example

|  url | params  |
| ------------ | ------------ |
|  http://0.0.0.0:888/transactions-history |  account_id = MDI75ORX5PX <br> offset = 1 <br> limit = 2 |
|  http://0.0.0.0:888/account-list  |  client_id=1 |
|  http://0.0.0.0:888/make-transactiont  |  id_from = LPV38ZZW8LB <br> id_to = BLD14KPC6BF <br> amount = 10 <br> currency = EUR |

P.S. Make sure to run migration and make at least one transaction
