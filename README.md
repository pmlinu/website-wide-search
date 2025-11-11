# Laravel Website-Wide Search System

A professional search system using **Laravel 11** with **SOLID principles**.

## Features

- **Unified Search** - Search across Blog Posts, Products, Pages, and FAQs
- **Laravel Scout** - Automatic search indexing
- **Smart Ranking** - Relevance-based with recency bonus
- **Queue-based Indexing** - Async updates with Redis
- **Search Analytics** - Complete logging and statistics
- **SOLID Architecture** - Clean, maintainable code
- **FormRequest Validation** - Separated validation logic
- **Docker Ready** - Complete containerization

## Technology Stack

- **Laravel 11.x** - Latest framework
- **PHP 8.2-8.4** - Modern PHP
- **PostgreSQL 15** - Database
- **Redis 7** - Cache & Queue
- **Laravel Scout** - Search indexing
- **Laravel Sanctum** - API authentication
- **Docker** - Containerization

## Installation on New Machine

### Prerequisites

Make sure you have installed:
- **Docker** - [Install Docker](https://docs.docker.com/get-docker/)
- **Docker Compose** - Usually comes with Docker Desktop
- **Git** - [Install Git](https://git-scm.com/downloads)

### Step 1: Clone the Repository

```bash
# Clone the repository
git clone <your-repository-url>
cd website-wide-search
```

### Step 2: Quick Setup (Recommended)

```bash
# Make setup script executable and run it
chmod +x setup.sh
./setup.sh
```

The script will automatically:
- Create `.env` file
- Start Docker containers
- Install dependencies
- Generate application key
- Run migrations
- Seed sample data
- Import search indexes

**Done! Skip to "Verify Installation" below.**

### Step 3: Manual Setup (Alternative)

If the automated script doesn't work, follow these steps:

```bash
# 1. Create environment file
cp .env.example .env

# 2. Start Docker containers
docker-compose up -d

# Wait for containers to be ready (30 seconds)
sleep 30

# 3. Install Composer dependencies
docker-compose exec app composer install

# 4. Generate Laravel application key
docker-compose exec app php artisan key:generate

# 5. Run database migrations
docker-compose exec app php artisan migrate

# 6. Seed sample data
docker-compose exec app php artisan db:seed

# 7. Import search indexes
docker-compose exec app php artisan scout:import "App\Models\BlogPost"
docker-compose exec app php artisan scout:import "App\Models\Product"
docker-compose exec app php artisan scout:import "App\Models\Page"
docker-compose exec app php artisan scout:import "App\Models\Faq"
```

### Verify Installation

Test the API is working:

```bash
# Health check
curl "http://localhost:8000/api/health"

# Search test
curl "http://localhost:8000/api/search?q=laravel"
```

You should see JSON responses. If yes, installation is successful! ✅

## API Endpoints

### Public

```bash
# Search
GET /api/search?q={query}&per_page={10}&page={1}

# Suggestions
GET /api/search/suggestions?q={query}&limit={5}

# Health check
GET /api/health
```

### Admin (Requires Authentication)

```bash
# Rebuild index
POST /api/search/rebuild-index
Authorization: Bearer {token}

# Top searches
GET /api/search/logs/top?limit={10}
Authorization: Bearer {token}

# Recent searches
GET /api/search/logs/recent?limit={20}
Authorization: Bearer {token}

# Statistics
GET /api/search/logs/statistics
Authorization: Bearer {token}
```

## Default Credentials

- **Admin**: admin@example.com / password
- **User**: user@example.com / password

## Get Admin Token

```bash
docker-compose exec app php artisan tinker
```

Then in tinker:
```php
$user = App\Models\User::where('email', 'admin@example.com')->first();
$token = $user->createToken('admin-token')->plainTextToken;
echo $token;
exit
```

## SOLID Principles Implementation

### Single Responsibility Principle
Each class has one clear purpose:
- `SearchService` - Orchestrates search
- `SearchRanker` - Ranks results
- `SearchLogger` - Logs queries
- `IndexManager` - Manages indexes
- `FormRequests` - Validates input

### Open/Closed Principle
Extend via interfaces without modifying code:
```php
// Easy to add new ranking algorithms
class MLSearchRanker implements SearchRankerInterface { }
```

### Liskov Substitution Principle
Any implementation can replace another via interfaces.

### Interface Segregation Principle
Small, focused interfaces:
- `SearchServiceInterface`
- `SearchRankerInterface`
- `SearchLoggerInterface`

### Dependency Inversion Principle
Depend on abstractions (interfaces):
```php
public function __construct(
    SearchServiceInterface $searchService,
    SearchRankerInterface $ranker,
    SearchLoggerInterface $logger
) {}
```

## Project Structure

```
app/
├── Contracts/              # Interfaces (SOLID)
├── Http/
│   ├── Controllers/Api/    # API controllers
│   ├── Middleware/         # Admin middleware
│   └── Requests/           # FormRequest validation
├── Models/                 # Eloquent models with Scout
├── Providers/              # Service providers (DI)
└── Services/
    ├── SearchService.php   # Main orchestrator
    └── Search/             # SOLID components
        ├── SearchRanker.php
        ├── SearchLogger.php
        └── IndexManager.php
```

## Sample Data

After seeding:
- 10 Blog Posts
- 12 Products
- 8 Pages
- 14 FAQs
- 2 Users

## Troubleshooting

### Port 8000 Already in Use

Edit `docker-compose.yml` and change nginx ports:
```yaml
ports:
  - "8001:80"  # Change 8000 to 8001
```

### Search Returns No Results

Re-import search indexes:
```bash
docker-compose exec app php artisan scout:import "App\Models\BlogPost"
docker-compose exec app php artisan scout:import "App\Models\Product"
docker-compose exec app php artisan scout:import "App\Models\Page"
docker-compose exec app php artisan scout:import "App\Models\Faq"
```

### Database Connection Error

```bash
# Restart database
docker-compose restart db

# Wait and retry
sleep 10
docker-compose exec app php artisan migrate
```

### Permission Errors

```bash
docker-compose exec app chmod -R 775 storage bootstrap/cache
docker-compose exec app chown -R www-data:www-data storage bootstrap/cache
```

## Common Commands

```bash
# View logs
docker-compose logs -f app

# Restart services
docker-compose restart

# Stop all containers
docker-compose down

# Stop and remove volumes
docker-compose down -v

# Clear Laravel cache
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan route:clear

# Access database
docker-compose exec db psql -U postgres laravel_search

# Run artisan commands
docker-compose exec app php artisan [command]
```

## Testing with Postman

Import `postman_collection.json` for ready-to-use API requests.

## Docker Services

- `app` - PHP 8.2-FPM
- `nginx` - Web server (port 8000)
- `db` - PostgreSQL 15
- `redis` - Cache & queue
- `queue` - Auto queue worker

## Requirements Met

✅ Multi-content search (4 types)  
✅ Laravel Scout integration  
✅ Partial/fuzzy matching  
✅ Relevance ranking  
✅ Pagination  
✅ Automatic indexing  
✅ Queue-based sync  
✅ Search logging  
✅ Admin analytics  
✅ Docker containerization  
✅ SOLID principles  
✅ FormRequest validation  

## License

MIT License

---

**Built with Laravel 11, following SOLID principles and modern best practices.**

## Laravel Scheduler

The application uses Laravel's task scheduler for periodic maintenance:

### Scheduled Tasks

- **Clean old search logs**: Runs weekly (Sundays at 3 AM), removes logs older than 6 months
- **Rebuild indexes** (optional): Example task for daily index maintenance

### Running the Scheduler

#### Option 1: Manual (for testing)

```bash
# Run scheduled tasks manually
docker compose exec app php artisan schedule:run

# List all scheduled tasks
docker compose exec app php artisan schedule:list
```

#### Option 2: Docker Scheduler Service (Production)

Add to `docker-compose.yml`:

```yaml
  scheduler:
    build:
      context: .
      dockerfile: Dockerfile
    container_name: laravel_search_scheduler
    restart: unless-stopped
    working_dir: /var/www
    volumes:
      - ./:/var/www
    networks:
      - laravel_search
    depends_on:
      - db
      - redis
    command: php artisan schedule:work
    environment:
      - DB_HOST=db
      - REDIS_HOST=redis
```

Then start it:

```bash
docker compose up -d scheduler
```

#### Option 3: Cron (Production Server)

```bash
# Add to crontab
* * * * * cd /path-to-project && php artisan schedule:run >> /dev/null 2>&1
```

### Viewing Scheduled Tasks

```bash
docker compose exec app php artisan schedule:list
```

Output:
```
  0 3 * * 0  php artisan schedule:run ...... Next Due: 2 days from now
  └─ clean-old-search-logs ................ Clean old search logs
```

