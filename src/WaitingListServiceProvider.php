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

        try {
            //code...

            $checkEmail = WaitingList::where('email', $email)->exists();

            if($checkEmail){

                $getEmail = WaitingList::where('email', $email)->first();

                return "Vous êtes déjà inscrit dans la file d'attente. Votre position : #".$getEmail->position;

            } else {

                $countPosition = 0;
                $countEmail = WaitingList::count();

                if($countEmail === 0) {
                    $countPosition++;
                } else {

                    $lastRecordHightPosition = WaitingList::orderBy('position', 'desc')->first();
                    $countPosition = $lastRecordHightPosition->position + 1;
                    
                }
        
                $createFileAttente = WaitingList::create([
                    'email' => $email,
                    'position' => $countPosition,
                    'status' => 0
                ]);

                return "Félicitations, vous êtes maintenant inscrit à la liste d'attente. Votre position : #".$countPosition;

            }

        } catch (\Throwable $th) {
            //throw $th;
            return $th;
        }

    }

    public static function passerEnCompteActif($email) {

        try {
            //code...

            // Récupérer l'utilisateur en fonction de l'email
            $utilisateur = WaitingList::where('email', $email)->where('status', 0)->first();

            if ($utilisateur) {
                // // Décrémenter toutes les positions sauf la position 0
                WaitingList::where('position', '>', 0)->decrement('position');

                $utilisateur->update([
                    'position' => 0,
                    'status' => 1
                ]);

                $getAllPositionZero = WaitingList::where('position', 0)
                ->where('status', 0)
                ->update([
                    'status' => 1
                ]);

                return "L'adresse email ".$email." est maintenant considéré comme actif.";

            } else {

                return "L'adresse email ".$email." n'existe pas ou à déjà été activé.";

            }

        } catch (\Throwable $th) {
            //throw $th;
            return $th;
        }

    }

    public static function getWaitingList() {
        try {
            //code...
            $countWL = WaitingList::where('position', '>', 0)->where('status', 0)->count();
            return $countWL;
        } catch (\Throwable $th) {
            //throw $th;
            return $th;
        }
    }

    public static function getActifAccount() {
        try {
            //code...
            $countActifWL = WaitingList::where('position', 0)->where('status', 1)->count();
            return $countActifWL;
        } catch (\Throwable $th) {
            //throw $th;
            return $th;
        }
    }

}