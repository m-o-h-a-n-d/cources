<?php  


namespace App\Providers;

use App\Providers\ServiceProvider;
use Core\Database;
use Core\Model;

class DatabaseServiceProvider extends ServiceProvider
{
   public function register(): void
{
    $dbConfig = $this->config->get('database');

    if ($dbConfig) {
        $db = new Database($dbConfig);

        $this->container->instance(Database::class, $db);
    }
}

public function boot(): void
{
    /** @var Database $db */
    $db = $this->container->make(Database::class);

    Model::setConnection($db->connection());
}
}