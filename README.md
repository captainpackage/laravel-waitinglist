Si vous lancez une application qui nécessite une file d'attente pour son lancement et que vous souhaitez quand même pouvoir récolter l'enregistrement de vos utilisateurs, vous pouvez utiliser ce package qui va vous permettre de créer une file d'attente et de la gérer facilement.

## Installation

Vous pouvez installer le package via composer:

```bash
composer require equativa/laravel-waitinglist
```

Ajoutez la classe au provider dans "config/app.php" : 
```php
'providers' => ServiceProvider::defaultProviders()->merge([
    /*
        * Package Service Providers...
        */
    equativa\LaravelWaitinglist\WaitingListServiceProvider::class,
```

Vous pouvez publier et lancer les migrations avec : 

```bash
php artisan vendor:publish --tag=waitinglist-migrations
php artisan migrate
```

## Usage

### Etape 1 : Importez la class WaitingListServiceProvider
Cette class contient l'ensemble des méthodes que vous pouvez utiliser pour la gestion de votre file d'attente.

```php 
use equativa\LaravelWaitinglist\WaitingListServiceProvider;
```

### Etape 2 : Ajoutez une adresse email à la file d'attente
Vous pouvez ajouter une adresse email grâce à la méthode "addEmailToQueue" en lui passant une adresse email : 

```php 
$addWList = WaitingListServiceProvider::addEmailToQueue($email);
return $addWList;
```

### Etape 3 : Activation d'un compte
Vous pouvez sortir une adresse email de la file d'attente grâce à la méthode "activateAccount", cela aura pour conséquence de changer la position de tous les autres dans la liste et pour chaque compte qui tombe en position zéro d'être également activé.

```php 
$activateWList = WaitingListServiceProvider::activateAccount($email);
return $activateWList;
```

### Etape 4 : Obtenir le nombre d'email dans la file d'attente
Vous pouvez obtenir le nombre d'email encore dans la file d'attente grâce à la méthode "countWaitingQueue" :

```php 
$gWList = WaitingListServiceProvider::countWaitingQueue();
return $gWList;
```

### Etape 5 : Obtenir le nombre d'email qui ne sont plus dans la file d'attente
Vous pouvez obtenir le nombre d'email qui ne sont plus dans la file d'attente grâce à la méthode "countActiveAccounts" :

```php 
$gActifAccount = WaitingListServiceProvider::countActiveAccounts();
return $gActifAccount;
```

## Supportez nous !

L'ensemble de nos projets open source sont portée par [Equativa](https://opensource.equativa.com). Vous pouvez nous supporter de plusieurs manières en participant à nos projets, en faisant un don, en créant un article ou tout autre forme de soutien sera fortement apprécier.

## Credits

- [Ludovic LEVENEUR (Yuchima)](https://github.com/llvnr)

## License

La License MIT. Regardez le fichier (LICENSE.md) pour plus d'informations.
