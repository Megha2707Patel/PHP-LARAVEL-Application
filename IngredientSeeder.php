<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use Illuminate\Database\Seeder;

class IngredientSeeder extends Seeder
{
    public function run(): void
    {
        $ingredients = [
            // Dairy
            ['name' => 'Milk', 'category' => 'Dairy'],
            ['name' => 'Butter', 'category' => 'Dairy'],
            ['name' => 'Cheddar Cheese', 'category' => 'Dairy'],
            ['name' => 'Parmesan', 'category' => 'Dairy'],
            ['name' => 'Heavy Cream', 'category' => 'Dairy'],
            ['name' => 'Mozzarella', 'category' => 'Dairy'],
            ['name' => 'Yogurt', 'category' => 'Dairy'],

            // Proteins
            ['name' => 'Chicken Breast', 'category' => 'Meat'],
            ['name' => 'Ground Beef', 'category' => 'Meat'],
            ['name' => 'Bacon', 'category' => 'Meat'],
            ['name' => 'Salmon', 'category' => 'Seafood'],
            ['name' => 'Shrimp', 'category' => 'Seafood'],
            ['name' => 'Eggs', 'category' => 'Protein'],
            ['name' => 'Tofu', 'category' => 'Protein'],

            // Vegetables
            ['name' => 'Garlic', 'category' => 'Vegetable'],
            ['name' => 'Onion', 'category' => 'Vegetable'],
            ['name' => 'Tomatoes', 'category' => 'Vegetable'],
            ['name' => 'Spinach', 'category' => 'Vegetable'],
            ['name' => 'Bell Pepper', 'category' => 'Vegetable'],
            ['name' => 'Broccoli', 'category' => 'Vegetable'],
            ['name' => 'Mushrooms', 'category' => 'Vegetable'],
            ['name' => 'Carrots', 'category' => 'Vegetable'],
            ['name' => 'Potatoes', 'category' => 'Vegetable'],
            ['name' => 'Zucchini', 'category' => 'Vegetable'],

            // Pantry
            ['name' => 'Olive Oil', 'category' => 'Pantry'],
            ['name' => 'All-Purpose Flour', 'category' => 'Pantry'],
            ['name' => 'Sugar', 'category' => 'Pantry'],
            ['name' => 'Salt', 'category' => 'Pantry'],
            ['name' => 'Black Pepper', 'category' => 'Pantry'],
            ['name' => 'Pasta', 'category' => 'Pantry'],
            ['name' => 'Rice', 'category' => 'Pantry'],
            ['name' => 'Baking Powder', 'category' => 'Pantry'],
            ['name' => 'Soy Sauce', 'category' => 'Pantry'],
            ['name' => 'Honey', 'category' => 'Pantry'],

            // Herbs & Spices
            ['name' => 'Basil', 'category' => 'Herb'],
            ['name' => 'Oregano', 'category' => 'Herb'],
            ['name' => 'Paprika', 'category' => 'Spice'],
            ['name' => 'Cumin', 'category' => 'Spice'],
            ['name' => 'Cinnamon', 'category' => 'Spice'],
            ['name' => 'Thyme', 'category' => 'Herb'],
        ];

        foreach ($ingredients as $ingredient) {
            Ingredient::firstOrCreate(['name' => $ingredient['name']], $ingredient);
        }
    }
}
