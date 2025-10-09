# 🚀 Portfolify

A modern, feature-rich portfolio and blog management system built with **Laravel 12**, **Filament v4**, and **Tailwind CSS v4**.

![Laravel](https://img.shields.io/badge/Laravel-12.31.1-red.svg)
![Filament](https://img.shields.io/badge/Filament-v4-orange.svg)
![PHP](https://img.shields.io/badge/PHP-8.3+-blue.svg)
![Tailwind CSS](https://img.shields.io/badge/Tailwind%20CSS-v4-38bdf8.svg)

## ✨ Features

### 🏠 Frontend Features
- **Modern Responsive Design** - Mobile-first approach with Tailwind CSS v4
- **Blog System** - Full-featured blog with categories, tags, and comments
- **Portfolio Showcase** - Interactive portfolio section with project galleries
- **Dark Mode Support** - Seamless light/dark theme switching
- **SEO Optimized** - XML sitemap, RSS feeds, meta tags, and structured data
- **Comments System** - Nested comments with moderation capabilities
- **Search Functionality** - Advanced search across posts and portfolios
- **Reading Time Estimation** - Automatic reading time calculation for blog posts

### 🔧 Admin Panel (Filament v4)
- **Dashboard Analytics** - Quick stats and insights
- **Content Management** - CRUD operations for posts, portfolios, pages
- **User Management** - Role-based access control
- **Category Management** - Organize content with hierarchical categories
- **Comment Moderation** - Approve, reject, and manage user comments
- **Media Library** - File upload and management with Curator
- **Settings Management** - Configurable site settings with DB Config
- **Quick Actions Widget** - Fast access to common tasks

### 🎨 Technical Features
- **Laravel 12** - Latest Laravel framework with modern PHP practices
- **Filament v4** - Modern admin panel with Server-Driven UI
- **Livewire v3** - Dynamic frontend interactions without page refreshes
- **Tailwind CSS v4** - Utility-first CSS framework with modern features
- **Pest Testing** - Comprehensive test suite with Pest v4
- **Database Optimization** - Efficient queries with eager loading
- **View Tracking** - Post view counting and analytics
- **Image Optimization** - Automatic image processing and optimization

## 🛠️ Tech Stack

- **Backend**: Laravel 12.31.1, PHP 8.3+
- **Admin Panel**: Filament v4
- **Frontend**: Livewire v3, Tailwind CSS v4, Alpine.js
- **Database**: MySQL/PostgreSQL/SQLite
- **Testing**: Pest v4, PHPUnit
- **Code Quality**: Laravel Pint, PHPStan
- **Media**: Curator (Image management)
- **Comments**: Built-in nested comment system
- **Settings**: DB Config for dynamic settings

## 📋 Requirements

- **PHP**: 8.3 or higher
- **Composer**: Latest version
- **Node.js**: 18+ with npm/bun
- **Database**: MySQL 8.0+, PostgreSQL 13+, or SQLite
- **Web Server**: Apache/Nginx with URL rewriting

## 🚀 Installation & Setup

### 1. Clone the Repository

```bash
git clone <repository-url>
cd portfolify
```

### 2. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies (choose one)
npm install
# OR
bun install
```

### 3. Environment Configuration

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Database Setup

Configure your database in `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=portfolify
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

Run migrations and seeders:

```bash
# Run migrations
php artisan migrate

# Seed the database (optional)
php artisan db:seed
```

### 5. Storage & Permissions

```bash
# Create storage link
php artisan storage:link

# Set permissions (Linux/macOS)
chmod -R 755 storage bootstrap/cache
```

### 6. Build Assets

```bash
# Development build
npm run dev
# OR
bun run dev

# Production build
npm run build
# OR
bun run build
```

### 7. Create Admin User

```bash
# Create your first admin user
php artisan make:filament-user
```

## 🔧 Development Commands

```bash
# Start development server
php artisan serve

# Watch for file changes
npm run dev
# OR
bun run dev

# Run tests
php artisan test
# OR
./vendor/bin/pest

# Code formatting
./vendor/bin/pint

# Clear caches
php artisan optimize:clear

# Queue worker (if using queues)
php artisan queue:work
```

## 📁 Project Structure

```
├── app/
│   ├── Filament/           # Filament admin resources
│   │   ├── Admin/
│   │   │   ├── Pages/      # Settings pages
│   │   │   ├── Resources/  # CRUD resources
│   │   │   └── Widgets/    # Dashboard widgets
│   ├── Http/
│   │   └── Controllers/    # Frontend controllers
│   ├── Models/             # Eloquent models
│   └── Settings/           # DB Config settings
├── resources/
│   ├── views/
│   │   ├── frontend/       # Public website views
│   │   └── filament/       # Custom Filament views
│   ├── css/                # Stylesheets
│   └── js/                 # JavaScript files
├── database/
│   ├── migrations/         # Database migrations
│   ├── seeders/           # Database seeders
│   └── factories/         # Model factories
└── tests/                 # Test files
```

## � SEO Features

### Sitemap Generation
Portfolify includes comprehensive sitemap functionality using Spatie Sitemap. The sitemap is automatically generated and served at `/sitemap.xml`.

**Sitemap URL:**
- XML Sitemap: `https://your-domain.com/sitemap.xml`

**What's included:**
- Homepage and static pages (About, Contact)
- Blog index and published posts
- Active blog categories with posts
- Portfolio index and published items
- Automatic cache management (24-hour TTL)
- Auto-refreshes when content is updated

### RSS Feed
Full-featured RSS feed for blog content:

**RSS URLs:**
- RSS Feed: `https://your-domain.com/rss.xml`
- Alternative: `https://your-domain.com/feed`

**RSS Features:**
- Last 20 published blog posts (configurable)
- Full content including excerpts
- Author and category information
- Proper RSS 2.0 format with namespaces
- Automatic cache management (1-hour TTL)

### Configuration
Both sitemap and RSS can be configured in `config/blog.php`:

```php
'sitemap' => [
    'enabled' => env('BLOG_SITEMAP_ENABLED', true),
    'cache_ttl' => env('BLOG_SITEMAP_CACHE_TTL', 86400), // 24 hours
    'include_images' => env('BLOG_SITEMAP_INCLUDE_IMAGES', true),
],

'rss' => [
    'enabled' => env('BLOG_RSS_ENABLED', true),
    'posts_count' => env('BLOG_RSS_POSTS_COUNT', 20),
    'cache_ttl' => env('BLOG_RSS_CACHE_TTL', 3600), // 1 hour
    'include_content' => env('BLOG_RSS_INCLUDE_CONTENT', true),
],
```

### Environment Variables
Add these to your `.env` file to customize SEO features:

```env
# Sitemap Configuration
BLOG_SITEMAP_ENABLED=true
BLOG_SITEMAP_CACHE_TTL=86400
BLOG_SITEMAP_INCLUDE_IMAGES=true

# RSS Configuration
BLOG_RSS_ENABLED=true
BLOG_RSS_POSTS_COUNT=20
BLOG_RSS_CACHE_TTL=3600
BLOG_RSS_INCLUDE_CONTENT=true
```

### Automatic Cache Management
The system automatically clears sitemap and RSS caches when:
- Blog posts are created, updated, or deleted
- Portfolio items are modified
- Blog categories are changed
- Content publication status changes

### robots.txt
The included `public/robots.txt` file automatically references your sitemap:

```txt
User-agent: *
Disallow:

# Sitemap
Sitemap: /sitemap.xml
```

## �🔐 Admin Panel Access

Once installed, access the admin panel at:

```
http://your-domain.com/admin
```

Use the credentials created during the `make:filament-user` command.

## 🎨 Customization

### Themes & Styling
- Modify `resources/css/app.css` for global styles
- Customize Filament theme in `resources/css/filament/admin/theme.css`
- Tailwind configuration in `tailwind.config.js`

### Settings
- Configure blog settings at `/admin/blog-settings`
- Manage general settings at `/admin/general-settings`
- All settings are stored in database for easy management

### Adding Content
1. **Blog Posts**: Create posts with rich content, categories, and featured images
2. **Portfolio Items**: Showcase projects with galleries and descriptions
3. **Pages**: Create static pages for about, contact, etc.
4. **Categories**: Organize content with hierarchical categories

## 🧪 Testing

```bash
# Run all tests
php artisan test

# Run specific test suite
php artisan test --testsuite=Feature

# Run with coverage
php artisan test --coverage
```

## 🐛 Troubleshooting

### Common Issues

1. **Permission Errors**: Ensure `storage/` and `bootstrap/cache/` are writable
2. **Asset Issues**: Run `npm run build` and `php artisan storage:link`
3. **Database Errors**: Check database connection and run `php artisan migrate`
4. **Cache Issues**: Run `php artisan optimize:clear`

### Getting Help

- Check Laravel documentation: https://laravel.com/docs
- Filament documentation: https://filamentphp.com/docs
- Create an issue for bugs or feature requests

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

---

Built with ❤️ using Laravel, Filament, and modern web technologies.
