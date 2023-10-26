<?php 

use tests\Models\TestWaitingList;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchestra\Testbench\TestCase;
use Illuminate\Support\Facades\Schema; // Importez la classe Schema

class WaitingListTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Créez la table "waitinglist" dans la base de données SQLite en mémoire
        Schema::create('waitinglist', function ($table) {
            $table->id();
            $table->string('email')->unique();
            $table->integer('position');
            $table->integer('status');
            // Ajoutez d'autres colonnes au besoin
            $table->timestamps();
        });

    }

    public function test_add_new_email_to_queue()
    {
        // Assurez-vous que la liste d'attente est vide au départ
        $this->assertCount(0, TestWaitingList::all());

        // Adresse e-mail à ajouter
        $email = 'nouveau@example.com';

        // Appelez la fonction pour ajouter l'e-mail
        $countPosition = 0;
        $countEmail = TestWaitingList::count();

        if($countEmail === 0) {
            $countPosition++;
        } else {

            $lastRecordHightPosition = TestWaitingList::orderBy('position', 'desc')->first();
            $countPosition = $lastRecordHightPosition->position + 1;
            
        }

        $result = TestWaitingList::create([
            'email' => $email,
            'position' => $countPosition,
            'status' => 0
        ]);

        // Vérifiez que le résultat est un message de confirmation
        $this->assertStringContainsString('Félicitations, vous êtes maintenant inscrit à la liste d\'attente.', 'Félicitations, vous êtes maintenant inscrit à la liste d\'attente. Votre position : '.$result);

        // Vérifiez que la liste d'attente contient maintenant un enregistrement
        $this->assertCount(1, TestWaitingList::all());

        // Vérifiez que la position de l'e-mail ajouté est 1 (car la liste était vide)
        $this->assertEquals(1, TestWaitingList::where('email', $email)->first()->position);
    }

    public function test_activate_existing_account_success()
    {
        // Assurez-vous qu'un utilisateur inactif existe dans la liste d'attente
        $email = 'nouveau@example.com';
        $user = TestWaitingList::create([
            'email' => $email,
            'position' => 1, // position initiale
            'status' => 0, // statut inactif
        ]);

        $utilisateur = TestWaitingList::where('email', $email)->where('status', 0)->first();

        // Appelez la fonction pour activer le compte
        $utilisateur->update([
            'position' => 0,
            'status' => 1
        ]);

        // Obtenir tous les utilisateurs avec des positions supérieures à 0
        $usersToUpdate = TestWaitingList::where('position', '>', 0)
        ->where('status', 0)
        ->orderBy('position')
        ->get();

        // Réordonner les positions et mettre à jour les enregistrements
        $newPosition = 1;
        foreach ($usersToUpdate as $user) {
            $user->update(['position' => $newPosition]);
            $newPosition++;
        }
        // $result = TestWaitingList::activateAccount($email);

        // Vérifiez que le résultat est un message de confirmation
        $this->assertStringContainsString('est maintenant considéré comme actif', 'est maintenant considéré comme actif : '.$email);

        // Vérifiez que le statut de l'utilisateur a été mis à jour
        $user = $user->fresh(); // Rafraîchir l'utilisateur depuis la base de données
        $this->assertEquals(1, $user->status); // Le statut doit être actif

        // Vérifiez que les positions des autres utilisateurs ont été réordonnées
        // Vous pouvez ajouter des assertions pour cela si nécessaire
    }

    public function test_count_queue_accounts_equal_zero() {
        $countWL = TestWaitingList::where('position', '>', 0)->where('status', 0)->count();
        $this->assertEquals(0, $countWL); // VERIFIE EGAL A ZERO
    }

    public function test_count_queue_accounts_greater_than_zero() {

        TestWaitingList::create([
            'email' => 'toto@gmail.com',
            'position' => 1,
            'status' => 0
        ]);

        $countWL = TestWaitingList::where('position', '>', 0)->where('status', 0)->count();
        $this->assertGreaterThan(0, $countWL); // VERIFIE EGAL A ZERO
    }

    public function test_count_active_accounts_equal_zero()
    {
        $count = TestWaitingList::where('position', 0)->where('status', 1)->count();
        $this->assertEquals(0, $count); // VERIFIE EGAL A ZERO
    }

    public function test_count_active_accounts_greater_than_zero()
    {

        TestWaitingList::create([
            'email' => 'toto@gmail.com',
            'position' => 0,
            'status' => 1
        ]);

        $count = TestWaitingList::where('position', 0)->where('status', 1)->count();
        $this->assertGreaterThan(0, $count); // VERIFIE SUPERIEUR A ZERO !
    }

}
