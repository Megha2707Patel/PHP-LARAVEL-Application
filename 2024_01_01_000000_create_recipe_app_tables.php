<?php
// ============================================================
// MIGRATION 1: Add extra fields to users table
// File: database/migrations/xxxx_add_fields_to_users_table.php
// ============================================================
// Schema::table('users', function (Blueprint $table) {
//     $table->string('username')->unique()->after('name');
//     $table->text('bio')->nullable()->after('email');
//     $table->string('avatar')->nullable()->after('bio');
//     $table->boolean('is_admin')->default(false)->after('avatar');
// });

// ============================================================
// MIGRATION 2: Create ingredients table
// File: database/migrations/xxxx_create_ingredients_table.php
// ============================================================
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // --- users extra fields ---
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->unique()->nullable()->after('name');
            $table->text('bio')->nullable()->after('email');
            $table->string('avatar')->nullable()->after('bio');
            $table->boolean('is_admin')->default(false)->after('avatar');
        });

        // --- ingredients ---
        Schema::create('ingredients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category')->nullable(); // e.g. Dairy, Meat, Vegetable
            $table->timestamps();
        });

        // --- recipes ---
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('description');
            $table->longText('instructions');
            $table->string('image')->nullable();
            $table->unsignedInteger('prep_time')->default(0);  // minutes
            $table->unsignedInteger('cook_time')->default(0);  // minutes
            $table->unsignedInteger('servings')->default(4);
            $table->enum('difficulty', ['easy', 'medium', 'hard'])->default('medium');
            $table->string('category')->nullable(); // e.g. Breakfast, Dinner, Dessert
            $table->timestamps();
        });

        // --- recipe_ingredient pivot ---
        Schema::create('recipe_ingredient', function (Blueprint $table) {
            $table->id();
            $table->foreignId('recipe_id')->constrained()->cascadeOnDelete();
            $table->foreignId('ingredient_id')->constrained()->cascadeOnDelete();
            $table->string('quantity')->nullable();  // e.g. "2", "1/2"
            $table->string('unit')->nullable();       // e.g. "cups", "tbsp"
            $table->timestamps();
        });

        // --- comments ---
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('recipe_id')->constrained()->cascadeOnDelete();
            $table->text('body');
            $table->timestamps();
        });

        // --- likes ---
        Schema::create('likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('recipe_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['user_id', 'recipe_id']); // one like per user per recipe
        });

        // --- bookmarks ---
        Schema::create('bookmarks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('recipe_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['user_id', 'recipe_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookmarks');
        Schema::dropIfExists('likes');
        Schema::dropIfExists('comments');
        Schema::dropIfExists('recipe_ingredient');
        Schema::dropIfExists('recipes');
        Schema::dropIfExists('ingredients');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['username', 'bio', 'avatar', 'is_admin']);
        });
    }
};
