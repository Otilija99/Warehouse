<?php

namespace Warehouse\Models;

use Warehouse\Utilities\FileStorage;

class Product {
    private $storage;

    public function __construct() {
        $this->storage = new FileStorage('data/products.json');
    }

    public function getAll() {
        return $this->storage->read();
    }

    public function create($name, $amount, $user) {
        $products = $this->storage->read();
        $products[] = [
            'id' => uniqid(),
            'name' => $name,
            'amount' => $amount,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'history' => [
                [
                    'timestamp' => date('Y-m-d H:i:s'),
                    'action' => 'created',
                    'user' => $user,
                    'amount' => $amount
                ]
            ]
        ];
        $this->storage->write($products);
    }

    public function updateAmount($id, $amount, $user) {
        $products = $this->storage->read();
        foreach ($products as &$product) {
            if ($product['id'] === $id) {
                $product['amount'] = $amount;
                $product['updated_at'] = date('Y-m-d H:i:s');
                $product['history'][] = [
                    'timestamp' => date('Y-m-d H:i:s'),
                    'action' => 'updated',
                    'user' => $user,
                    'amount' => $amount
                ];
            }
        }
        $this->storage->write($products);
    }

    public function delete($id, $user) {
        $products = $this->storage->read();
        foreach ($products as $key => $product) {
            if ($product['id'] === $id) {
                unset($products[$key]);
                break;
            }
        }
        $this->storage->write(array_values($products));
    }
}
