#!/bin/bash

# Learning Management System - Docker Deployment Script
# Author: Learning Dev Team
# Description: Automated Docker deployment for LMS

set -e

echo "🚀 Learning Management System - Docker Deployment"
echo "=================================================="

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Functions
log_info() {
    echo -e "${BLUE}[INFO]${NC} $1"
}

log_success() {
    echo -e "${GREEN}[SUCCESS]${NC} $1"
}

log_warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

log_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

# Check if Docker is installed
check_docker() {
    log_info "Checking Docker installation..."
    if ! command -v docker &> /dev/null; then
        log_error "Docker is not installed. Please install Docker first."
        exit 1
    fi
    
    if ! command -v docker-compose &> /dev/null; then
        log_error "Docker Compose is not installed. Please install Docker Compose first."
        exit 1
    fi
    
    log_success "Docker and Docker Compose are installed"
}

# Create environment file
create_env() {
    log_info "Setting up environment file..."
    
    if [ ! -f .env ]; then
        if [ -f .env.example ]; then
            cp .env.example .env
            log_success "Copied .env.example to .env"
        else
            log_warning ".env.example not found, creating basic .env file"
            cat > .env << EOL
APP_NAME="Learning Management System"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=http://localhost:8000

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=learning_dev
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_password

BROADCAST_DRIVER=log
CACHE_DRIVER=redis
FILESYSTEM_DISK=local
QUEUE_CONNECTION=redis
SESSION_DRIVER=redis
SESSION_LIFETIME=120

REDIS_HOST=redis
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="\${APP_NAME}"
EOL
        fi
        
        # Generate application key
        log_info "Generating application key..."
        docker run --rm -v $(pwd):/app -w /app php:8.2-cli php -r "echo 'base64:'.base64_encode(random_bytes(32)).PHP_EOL;" > .key.tmp
        APP_KEY=$(cat .key.tmp)
        rm .key.tmp
        sed -i "s/APP_KEY=.*/APP_KEY=$APP_KEY/" .env
        log_success "Application key generated"
    else
        log_success "Environment file already exists"
    fi
}

# Build and start containers
deploy_containers() {
    log_info "Building Docker containers..."
    docker-compose build --no-cache
    
    log_info "Starting containers..."
    docker-compose up -d
    
    log_success "Containers started successfully"
}

# Install dependencies and setup Laravel
setup_laravel() {
    log_info "Installing Composer dependencies..."
    docker-compose exec app composer install --optimize-autoloader --no-dev
    
    # Fix permissions before any file operations
    log_info "Setting up proper directories and permissions..."
    docker-compose exec app mkdir -p /var/www/storage/logs
    docker-compose exec app mkdir -p /var/www/storage/framework/cache
    docker-compose exec app mkdir -p /var/www/storage/framework/sessions
    docker-compose exec app mkdir -p /var/www/storage/framework/views
    docker-compose exec app mkdir -p /var/www/storage/app/public
    docker-compose exec app chown -R www-data:www-data /var/www/storage
    docker-compose exec app chown -R www-data:www-data /var/www/bootstrap/cache
    docker-compose exec app chmod -R 775 /var/www/storage
    docker-compose exec app chmod -R 775 /var/www/bootstrap/cache
    
    log_info "Installing NPM dependencies and building assets..."
    docker-compose exec app npm install
    docker-compose exec app npm run build
    
    # Clear all caches before migrations
    log_info "Clearing application caches..."
    docker-compose exec app php artisan config:clear
    docker-compose exec app php artisan cache:clear
    docker-compose exec app php artisan route:clear
    docker-compose exec app php artisan view:clear
    
    log_info "Running database migrations (including cache table)..."
    docker-compose exec app php artisan migrate --force
    
    log_info "Seeding database..."
    docker-compose exec app php artisan db:seed --force
    
    log_info "Creating storage symlink..."
    docker-compose exec app php artisan storage:link
    
    # Wait a moment before final optimization
    sleep 2
    
    log_info "Optimizing Laravel for production..."
    docker-compose exec app php artisan config:cache
    docker-compose exec app php artisan route:cache
    docker-compose exec app php artisan view:cache
    
    log_success "Laravel setup completed"
}

# Set proper permissions
set_permissions() {
    log_info "Setting proper permissions..."
    docker-compose exec app chown -R www-data:www-data /var/www/storage
    docker-compose exec app chown -R www-data:www-data /var/www/bootstrap/cache
    docker-compose exec app chmod -R 775 /var/www/storage
    docker-compose exec app chmod -R 775 /var/www/bootstrap/cache
    log_success "Permissions set successfully"
}

# Health check
health_check() {
    log_info "Performing health check..."
    
    # Wait for services to be ready
    sleep 10
    
    # Check if app is responding
    if curl -f http://localhost:8000 > /dev/null 2>&1; then
        log_success "Application is responding on http://localhost:8000"
    else
        log_warning "Application might not be ready yet. Please check logs with: docker-compose logs app"
    fi
    
    # Check database connection
    if docker-compose exec app php artisan migrate:status > /dev/null 2>&1; then
        log_success "Database connection is working"
    else
        log_warning "Database connection issues detected"
    fi
}

# Show service URLs
show_urls() {
    echo ""
    echo "🎉 Deployment completed successfully!"
    echo "=================================="
    echo ""
    echo "📱 Service URLs:"
    echo "• Main Application: http://localhost:8000"
    echo "• phpMyAdmin: http://localhost:8080"
    echo "• Redis Commander: http://localhost:8081"
    echo ""
    echo "🔐 Default Login Credentials:"
    echo "• Admin: admin@admin.com / password"
    echo "• User: john@example.com / password"
    echo ""
    echo "🛠️ Useful Commands:"
    echo "• View logs: docker-compose logs -f app"
    echo "• Stop services: docker-compose down"
    echo "• Restart services: docker-compose restart"
    echo "• Access app container: docker-compose exec app bash"
    echo ""
}

# Cleanup function
cleanup() {
    log_info "Cleaning up temporary files..."
    rm -f .key.tmp
}

# Main deployment process
main() {
    echo "Starting deployment process..."
    echo ""
    
    # Trap to ensure cleanup on exit
    trap cleanup EXIT
    
    check_docker
    create_env
    deploy_containers
    setup_laravel
    set_permissions
    health_check
    show_urls
}

# Command line options
case "${1}" in
    "deploy")
        main
        ;;
    "stop")
        log_info "Stopping all containers..."
        docker-compose down
        log_success "All containers stopped"
        ;;
    "restart")
        log_info "Restarting all containers..."
        docker-compose restart
        log_success "All containers restarted"
        ;;
    "logs")
        docker-compose logs -f
        ;;
    "clean")
        log_warning "This will remove all containers and volumes. Are you sure? (y/N)"
        read -r response
        if [[ "$response" =~ ^[Yy]$ ]]; then
            docker-compose down -v --rmi all
            log_success "Cleanup completed"
        else
            log_info "Cleanup cancelled"
        fi
        ;;
    *)
        echo "Usage: $0 {deploy|stop|restart|logs|clean}"
        echo ""
        echo "Commands:"
        echo "  deploy  - Deploy the application"
        echo "  stop    - Stop all containers"
        echo "  restart - Restart all containers"
        echo "  logs    - Show container logs"
        echo "  clean   - Remove all containers and volumes"
        exit 1
        ;;
esac 