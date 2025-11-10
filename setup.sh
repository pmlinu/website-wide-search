#!/bin/bash

# Laravel Search System - Automated Setup Script
# This script automates the complete setup process

set -e

echo "=========================================="
echo "Laravel Search System - Setup Script"
echo "=========================================="
echo ""

# Colors for output
GREEN='\033[0;32m'
BLUE='\033[0;34m'
RED='\033[0;31m'
NC='\033[0m' # No Color

# Check if Docker is installed
if ! command -v docker &> /dev/null; then
    echo -e "${RED}Error: Docker is not installed${NC}"
    exit 1
fi

# Check if Docker Compose is installed (V2)
if ! docker compose version &> /dev/null; then
    echo -e "${RED}Error: Docker Compose is not installed${NC}"
    exit 1
fi

echo -e "${BLUE}Step 1/9: Creating environment file...${NC}"
if [ ! -f .env ]; then
    cp .env.example .env
    echo -e "${GREEN}✓ Environment file created${NC}"
else
    echo -e "${GREEN}✓ Environment file already exists${NC}"
fi

echo ""
echo -e "${BLUE}Step 2/9: Starting Docker containers...${NC}"
docker compose up -d
echo -e "${GREEN}✓ Docker containers started${NC}"

echo ""
echo -e "${BLUE}Step 3/9: Waiting for services to be ready...${NC}"
sleep 10
echo -e "${GREEN}✓ Services are ready${NC}"

echo ""
echo -e "${BLUE}Step 4/9: Installing Composer dependencies...${NC}"
docker compose exec -T app composer install --no-interaction --prefer-dist
echo -e "${GREEN}✓ Dependencies installed${NC}"

echo ""
echo -e "${BLUE}Step 5/9: Generating application key...${NC}"
docker compose exec -T app php artisan key:generate
echo -e "${GREEN}✓ Application key generated${NC}"

echo ""
echo -e "${BLUE}Step 6/9: Running database migrations...${NC}"
docker compose exec -T app php artisan migrate --force
echo -e "${GREEN}✓ Migrations completed${NC}"

echo ""
echo -e "${BLUE}Step 7/9: Seeding database with sample data...${NC}"
docker compose exec -T app php artisan db:seed --force
echo -e "${GREEN}✓ Database seeded${NC}"

echo ""
echo -e "${BLUE}Step 8/9: Importing search indexes...${NC}"
docker compose exec -T app php artisan scout:import "App\\Models\\BlogPost"
docker compose exec -T app php artisan scout:import "App\\Models\\Product"
docker compose exec -T app php artisan scout:import "App\\Models\\Page"
docker compose exec -T app php artisan scout:import "App\\Models\\Faq"
echo -e "${GREEN}✓ Search indexes imported${NC}"

echo ""
echo -e "${BLUE}Step 9/9: Testing API...${NC}"
sleep 2
RESPONSE=$(curl -s "http://localhost:8000/api/health")
if [[ $RESPONSE == *"ok"* ]]; then
    echo -e "${GREEN}✓ API is working!${NC}"
else
    echo -e "${RED}✗ API test failed${NC}"
fi

echo ""
echo "=========================================="
echo -e "${GREEN}Setup Complete!${NC}"
echo "=========================================="
echo ""
echo "Your Laravel Search System is ready!"
echo ""
echo "API URL: http://localhost:8000"
echo ""
echo -e "${BLUE}Quick Test:${NC}"
echo "curl \"http://localhost:8000/api/search?q=laravel\""
echo ""
echo -e "${BLUE}Default Credentials:${NC}"
echo "Admin: admin@example.com / password"
echo "User:  user@example.com / password"
echo ""
echo -e "${BLUE}Next Steps:${NC}"
echo "1. Import postman_collection.json into Postman"
echo "2. Get admin token: docker compose exec app php artisan tinker"
echo "3. Read README.md for full documentation"
echo ""
echo "To stop: docker compose down"
echo "To view logs: docker compose logs -f app"
echo ""

