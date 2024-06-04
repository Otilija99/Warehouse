<?php

require __DIR__ . '/vendor/autoload.php';

use Warehouse\Controllers\UserController;
use Warehouse\Controllers\ProductController;

session_start();

$userController = new UserController();
$productController = new ProductController();

echo "Welcome to the Warehouse Management \n";
echo "Please enter your access code: ";
$access_code = trim(fgets(STDIN));

$user = $userController->authenticate($access_code);
if (!$user) {
    echo "Invalid access code.\n";
    exit;
}

$_SESSION['user'] = $user;
$user = $_SESSION['user']['username'];

while (true) {
    echo "\nMenu:\n";
    echo "1. List Products\n";
    echo "2. Create Product\n";
    echo "3. Update Product\n";
    echo "4. Delete Product\n";
    echo "5. Exit\n";
    echo "Select an option: ";

    $option = trim(fgets(STDIN));

    switch ($option) {
        case '1':
            $products = $productController->getAllProducts();
            echo "\nProducts:\n";
            foreach ($products as $product) {
                echo "ID: " . $product['id'] . " | Name: " . $product['name'] . " | Amount: " . $product['amount'] . "\n";
                echo "History:\n";
                foreach ($product['history'] as $history) {
                    echo " - " . $history['timestamp'] . ": " . $history['action'] . " by " . $history['user'] . " (Amount: " . ($history['amount'] ?? 'N/A') . ")\n";
                }
            }
            break;
        case '2':
            echo "Enter product name: ";
            $name = trim(fgets(STDIN));
            echo "Enter product amount: ";
            $amount = trim(fgets(STDIN));
            $productController->createProduct($name, $amount, $user);
            echo "Product created successfully.\n";
            break;
        case '3':
            echo "Enter product ID: ";
            $id = trim(fgets(STDIN));
            echo "Enter new amount: ";
            $amount = trim(fgets(STDIN));
            $productController->updateProductAmount($id, $amount, $user);
            echo "Product updated successfully.\n";
            break;
        case '4':
            echo "Enter product ID: ";
            $id = trim(fgets(STDIN));
            $productController->deleteProduct($id, $user);
            echo "Product deleted successfully.\n";
            break;
        case '5':
            echo "Goodbye!\n";
            exit;
        default:
            echo "Invalid option. Please try again.\n";
    }
}
