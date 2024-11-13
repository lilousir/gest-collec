<?php

namespace App\Controllers\Api;

use CodeIgniter\Config\Services;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class Migration extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
public function getindex()
    {
        $token = $this->request->getHeaderLine('Authorization');
        $staticToken = getenv('ENV_TOKEN');
        if($token && $token == $staticToken){
        return $this->failUnauthorized('Token invalide');
    }
    $migration = Services::migrations();
    try {
        $migration->latest();

            return $this->respond(['message' => "Migration exécutées avec succès !"], 200);
        } catch (\Exception $e) {
            return $this->respond(['message' => "erreur lors de l'exécution des migrations : " . $e->getMessage()], 500);
     }
    }

}
