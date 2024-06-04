<?php

namespace Warehouse\Controllers;

use Warehouse\Models\Product;

class ProductController {
    private $productModel;

    public function __construct() {
        $this->productModel = new Product();
    }

    public function getAllProducts() {
        return $this->productModel->getAll();
    }

    public function createProduct($name, $amount, $user) {
        $this->productModel->create($name, $amount, $user);
    }

    public function updateProductAmount($id, $amount, $user) {
        $this->productModel->updateAmount($id, $amount, $user);
    }

    public function deleteProduct($id, $user) {
        $this->productModel->delete($id, $user);
    }
}

