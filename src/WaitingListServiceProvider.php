<?php

namespace WaitingList;

use Illuminate\Support\ServiceProvider;

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
    }

    public function ajouterEnFileDAttente($email) {
        dump("Ajout dans la file : ".$email);
    }

    public function passerEnCompteActif($email) {
        dump("Retirer de la file et passer en compte actif : ".$email);
    }

}