<?php

namespace Warehouse\Models;

use Warehouse\Utilities\FileStorage;

class User {
    private $storage;

    public function __construct() {
        $this->storage = new FileStorage('data/users.json');
    }

    public function authenticate($access_code) {
        $users = $this->storage->read();
        foreach ($users as $user) {
            if ($user['access_code'] === $access_code) {
                return $user;
            }
        }
        return false;
    }
}
