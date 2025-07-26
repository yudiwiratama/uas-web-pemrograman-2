#!/bin/bash

# Quick fix script for current Docker deployment issues
# This fixes the current containers without full redeploy

set -e

echo "🔧 Docker Quick Fix - Repairing Current Deployment"
echo "=================================================="

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

log_info() {
    echo -e "${BLUE}[INFO]${NC} $1"
}

log_success() {
    echo -e "${GREEN}[SUCCESS]${NC} $1"
}

log_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

# Fix permissions in running container
fix_permissions() {
    log_info "Fixing storage permissions..."
    
    # Create directories if they don't exist
    docker-compose exec app mkdir -p /var/www/storage/logs
    docker-compose exec app mkdir -p /var/www/storage/framework/cache
    docker-compose exec app mkdir -p /var/www/storage/framework/sessions  
    docker-compose exec app mkdir -p /var/www/storage/framework/views
    docker-compose exec app mkdir -p /var/www/storage/app/public
    
    # Set correct ownership and permissions
    docker-compose exec app chown -R www-data:www-data /var/www/storage
    docker-compose exec app chown -R www-data:www-data /var/www/bootstrap/cache
    docker-compose exec app chmod -R 775 /var/www/storage
    docker-compose exec app chmod -R 775 /var/www/bootstrap/cache
    
    log_success "Permissions fixed"
}

# Run missing migrations
run_migrations() {
    log_info "Running missing migrations..."
    
    # Clear config first (safe to do)
    docker-compose exec app php artisan config:clear
    
    # Run migrations first (this will create cache table)
    docker-compose exec app php artisan migrate --force
    
    # Now safely clear other caches after cache table exists
    docker-compose exec app php artisan cache:clear
    docker-compose exec app php artisan route:clear
    docker-compose exec app php artisan view:clear
    
    log_success "Migrations completed"
}

# Restart problematic services
restart_services() {
    log_info "Restarting queue worker..."
    docker-compose restart queue
    
    log_info "Restarting main app..."
    docker-compose restart app
    
    log_success "Services restarted"
}

# Health check
health_check() {
    log_info "Performing health check..."
    
    sleep 5
    
    # Check app status
    if curl -f http://localhost:8000 > /dev/null 2>&1; then
        log_success "✅ Application is responding on http://localhost:8000"
    else
        log_error "❌ Application not responding"
        return 1
    fi
    
    # Check database
    if docker-compose exec app php artisan migrate:status > /dev/null 2>&1; then
        log_success "✅ Database connection working"
    else
        log_error "❌ Database connection issues"
        return 1
    fi
    
    return 0
}

# Main repair process
main() {
    log_info "Starting quick repair process..."
    echo ""
    
    fix_permissions
    run_migrations
    restart_services
    
    if health_check; then
        echo ""
        echo "🎉 Quick Fix Completed Successfully!"
        echo "=================================="
        echo ""
        echo "📱 Your application should now be working at:"
        echo "• Main App: http://localhost:8000"
        echo "• phpMyAdmin: http://localhost:8080"
        echo "• Redis Commander: http://localhost:8081"
    else
        echo ""
        echo "⚠️  Some issues remain. You may need full redeploy:"
        echo "   ./docker-deploy.sh clean"
        echo "   ./docker-deploy.sh deploy"
    fi
}

# Run the fix
main 