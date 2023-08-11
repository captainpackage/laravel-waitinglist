<?php

namespace Warshaen\LaravelWaitinglist;

use Illuminate\Support\ServiceProvider;
use Warshaen\LaravelWaitinglist\models\WaitingList;

class WaitingListServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Enregistrer des liaisons, des services, des configurations, etc.
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Charger les routes, les vues, les migrations, etc.
        $this->loadMigrationsFrom(__DIR__."/database/migrations");
        $this->publishes([
            __DIR__.'/database/migrations' => database_path('migrations'),
        ], 'waitinglist-migrations');
    }

    public static function ajouterEnFileDAttente($email) {
        dump("Ajout dans la file : ".$email);
    }

    public static function passerEnCompteActif($email) {
        dump("Retirer de la file et passer en compte actif : ".$email);
    }

}