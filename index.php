<?php declare(strict_types=1);

require_once "vendor/autoload.php";

final class Product
{
    public string $name;
    public int $price;

    public function __construct($name, $price)
    {
        $this->name = $name;
        $this->price = $price;
    }
}

final class Cart
{
    public array $products;

    public function getTotal(): int
    {
        return array_sum($this->products);
    }
}

$ruleEngine = new \App\RulesEngine([
    fn($fact) => count($fact->products) > 3,
    fn($fact) => $fact->getTotal() > 50,
    fn($fact) => !empty(array_filter($fact->products, fn($product) => $product->name === "Cheese")),
]);

$cart = new Cart();
$cart->products = [
    new Product("Cheese", 10),
    new Product("Chips", 25),
];

var_dump($ruleEngine->validateAny($cart));
