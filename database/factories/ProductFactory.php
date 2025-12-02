<?php
namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        $names = [
            'Americano Bold',
            'Caramel Latte',
            'Hazelnut Cappuccino',
            'Mocha Delight',
            'Cold Brew Classic',
            'Vanilla Sweet Cream',
            'Irish Cream Latte',
            'Flat White',
            'Matcha Latte',
            'Brown Sugar Latte',
            'Cookies & Cream Frappe',
            'Signature Chocolate',
            'Peppermint Mocha',
            'Spanish Latte',
            'Tiramisu Latte',
            'Honey Oat Latte',
            'Berry Hibiscus Tea',
            'Lemon Earl Grey Tea',
            'Mango Yakult Fizz',
            'Strawberry Sweet Tea',
            'Caramel Macchiato',
            'Hazelnut Latte',
            'Iced Americano',
            'Iced Caramel Latte',
            'Iced Mocha',
            'Iced Matcha Latte',
            'Chocolate Frappe',
            'Vanilla Frappe',
            'Strawberry Frappe',
            'Mocha Frappe',
        ];


        $name = $this->faker->unique()->randomElement($names);

        if (str_contains($name, 'Tea')) {
            $categoryName = 'Tea';
        } elseif (str_contains($name, 'Frappe') || str_contains($name, 'FIZZ') || str_contains($name, 'Fizz')) {
            $categoryName = 'Frappe';
        } else {
            $categoryName = 'Coffee';
        }

        $category = Category::where('name', $categoryName)->inRandomOrder()->first()
            ?? Category::inRandomOrder()->first();

        $basePrice = $this->faker->numberBetween(6, 10);
        $price     = $basePrice * 5000;

        return [
            'category_id' => $category->id,
            'name'        => $name,
            'description' => 'Delicious '.$name.' from our coffee shop menu.',
            'price'       => $price,
        ];
    }
}
