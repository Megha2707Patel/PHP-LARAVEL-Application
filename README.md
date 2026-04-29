# 🍽️ Recipe Sharing Application
### Built with Laravel 11, Alpine.js, and Tailwind CSS

---

## Tech Stack

| Layer | Technology |
|-------|-----------|
| Backend Framework | Laravel 11 |
| Frontend JS | Alpine.js 3.x |
| CSS Framework | Tailwind CSS 3.x |
| Database | MySQL 8.x |
| Auth Scaffolding | Laravel Breeze |
| Email | Laravel Mailables (SMTP / Mailtrap) |
| Template Engine | Blade |
| Package Manager | Composer + NPM |

---

## 📁 Project Structure

```
recipe-app/
├── app/
│   ├── Console/Commands/
│   │   └── CreateAdminUser.php          # Task 2: Custom artisan command
│   ├── Events/
│   │   └── UserRegistered.php           # Task 4: Event fired on registration
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AdminUserController.php  # Task 5-8: Admin user CRUD
│   │   │   ├── AdminRecipeController.php
│   │   │   ├── RecipeController.php     # Task 14-16: Recipe CRUD
│   │   │   ├── RecipeBookmarkController.php  # Task 19
│   │   │   ├── RecipeLikeController.php      # Task 20
│   │   │   └── RecipeCommentController.php   # Task 21
│   │   └── Middleware/
│   │       └── AdminMiddleware.php
│   ├── Listeners/
│   │   └── SendWelcomeEmail.php          # Task 4: Listener sends email
│   ├── Mail/
│   │   └── WelcomeMail.php              # Task 4: Mailable class
│   ├── Models/
│   │   ├── User.php
│   │   ├── Recipe.php
│   │   ├── Ingredient.php
│   │   ├── RecipeIngredient.php
│   │   ├── Comment.php
│   │   ├── Like.php
│   │   └── Bookmark.php
│   └── Policies/
│       ├── UserPolicy.php               # Task 6: Gates & Policies
│       └── RecipePolicy.php
├── database/
│   ├── migrations/
│   │   ├── 2024_01_01_add_fields_to_users_table.php
│   │   ├── 2024_01_02_create_ingredients_table.php
│   │   ├── 2024_01_03_create_recipes_table.php
│   │   ├── 2024_01_04_create_recipe_ingredient_table.php
│   │   ├── 2024_01_05_create_comments_table.php
│   │   ├── 2024_01_06_create_likes_table.php
│   │   └── 2024_01_07_create_bookmarks_table.php
│   ├── factories/
│   │   └── RecipeFactory.php
│   └── seeders/
│       ├── DatabaseSeeder.php
│       └── IngredientSeeder.php
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   │   └── app.blade.php            # Main layout
│   │   ├── components/
│   │   │   ├── recipe-card.blade.php
│   │   │   └── delete-confirm-modal.blade.php
│   │   ├── auth/                        # Breeze auth views (customized)
│   │   ├── recipes/
│   │   │   ├── index.blade.php          # Public grid (Task 17-18)
│   │   │   ├── show.blade.php           # Single recipe
│   │   │   ├── create.blade.php
│   │   │   ├── edit.blade.php
│   │   │   └── dashboard.blade.php      # Task 14
│   │   ├── profile/
│   │   │   └── show.blade.php           # Task 10
│   │   ├── admin/
│   │   │   ├── users/
│   │   │   │   ├── index.blade.php
│   │   │   │   ├── edit.blade.php
│   │   │   │   └── show.blade.php
│   │   │   └── recipes/
│   │   │       └── index.blade.php
│   │   └── emails/
│   │       └── welcome.blade.php
│   ├── css/
│   │   └── app.css
│   └── js/
│       └── app.js
└── routes/
    ├── web.php
    └── api.php
```

---

## 🚀 Installation & Setup

### 1. Requirements
- PHP >= 8.2
- Composer
- Node.js >= 18 + NPM
- MySQL 8.x
- Laravel CLI (optional)

### 2. Create New Laravel Project
```bash
composer create-project laravel/laravel recipe-app
cd recipe-app
```

### 3. Install Laravel Breeze (Auth Scaffolding)
```bash
composer require laravel/breeze --dev
php artisan breeze:install blade
```

### 4. Install Frontend Dependencies
```bash
npm install
npm install alpinejs @alpinejs/focus
npm run dev   # for development
npm run build # for production
```

### 5. Install Additional Packages
```bash
# Tailwind (included with Breeze, but confirm)
npm install -D tailwindcss postcss autoprefixer

# Image handling (for recipe photos)
composer require intervention/image-laravel
```

### 6. Configure Environment
```bash
cp .env.example .env
php artisan key:generate
```


### 7. Run Migrations & Seeders
```bash
php artisan migrate
php artisan db:seed
```

### 8. Create Admin User
```bash
php artisan make:admin
# Follow the prompts: name, email, password
```

### 9. Create Storage Link (for uploaded images)
```bash
php artisan storage:link
```

### 10. Start the Dev Server
```bash
php artisan serve
# Visit http://localhost:8000
```

---

## 📋 Feature Summary by Task

| Task | Feature |
|------|---------|
| 1 | Customize registration (username, bio) |
| 2 | `php artisan make:admin` command |
| 3 | Extra registration fields |
| 4 | Welcome email on register (event/listener) |
| 5 | Admin user routes + AdminMiddleware |
| 6 | Gates & Policies (UserPolicy, RecipePolicy) |
| 7 | User CRUD logic |
| 8 | Admin user views |
| 9 | Alpine.js delete confirmation modal |
| 10 | User profile page |
| 11 | Ingredients table + seeder |
| 12 | Recipes table migration |
| 13 | Recipe ↔ Ingredient pivot table |
| 14 | Recipe dashboard (my recipes) |
| 15 | Recipe create form |
| 16 | Recipe update form |
| 17 | Public recipe grid |
| 18 | AJAX search + single recipe page |
| 19 | Bookmark toggle (AJAX) |
| 20 | Like toggle (AJAX) |
| 21 | Comment system |

---

## 🔐 Roles

- **Guest**: Browse and search recipes
- **User**: Create, edit, delete own recipes; like, bookmark, comment
- **Admin**: Full access to all users and recipes via admin backend
