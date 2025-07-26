#!/bin/bash

# Safe Docker fix script - handles missing cache table properly
# This version addresses the cache table issue specifically

set -e

echo "🔧 Docker Safe Fix - Handling Cache Table Issue"
echo "==============================================="

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

log_warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

# Fix permissions first
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

# Handle cache configuration and migrations
fix_cache_issue() {
    log_info "Fixing cache table issue..."
    
    # First, temporarily change cache driver to file to avoid database dependency
    log_info "Temporarily switching cache driver to file..."
    docker-compose exec app sed -i 's/CACHE_DRIVER=redis/CACHE_DRIVER=file/' /var/www/.env
    docker-compose exec app sed -i 's/CACHE_DRIVER=database/CACHE_DRIVER=file/' /var/www/.env
    
    # Clear config to reload new cache setting
    docker-compose exec app php artisan config:clear
    
    # Run all migrations to create missing tables
    log_info "Running migrations to create cache table..."
    docker-compose exec app php artisan migrate --force
    
    # Check if cache table now exists
    if docker-compose exec app php artisan tinker --execute="DB::table('cache')->count(); echo 'Cache table exists';" 2>/dev/null; then
        log_success "Cache table created successfully"
        
        # Switch back to redis cache if desired
        log_info "Switching cache driver back to redis..."
        docker-compose exec app sed -i 's/CACHE_DRIVER=file/CACHE_DRIVER=redis/' /var/www/.env
        docker-compose exec app php artisan config:clear
        
        # Now safely clear cache using redis
        docker-compose exec app php artisan cache:clear
        docker-compose exec app php artisan route:clear
        docker-compose exec app php artisan view:clear
        
        log_success "Cache configuration restored"
    else
        log_warning "Cache table creation failed, keeping file cache driver"
    fi
}

# Restart services
restart_services() {
    log_info "Restarting services..."
    
    # Restart queue worker (was crashing due to cache issues)
    docker-compose restart queue
    
    # Restart app to reload all configurations
    docker-compose restart app
    
    # Wait for services to start
    sleep 5
    
    log_success "Services restarted"
}

# Enhanced health check
health_check() {
    log_info "Performing comprehensive health check..."
    
    # Wait for services to stabilize
    sleep 10
    
    local health_score=0
    
    # Check app response
    if curl -f http://localhost:8000 > /dev/null 2>&1; then
        log_success "✅ Application responding on http://localhost:8000"
        ((health_score++))
    else
        log_error "❌ Application not responding"
    fi
    
    # Check database connection
    if docker-compose exec app php artisan migrate:status > /dev/null 2>&1; then
        log_success "✅ Database connection working"
        ((health_score++))
    else
        log_error "❌ Database connection issues"
    fi
    
    # Check cache functionality
    if docker-compose exec app php artisan tinker --execute="Cache::put('test', 'value', 60); echo Cache::get('test');" 2>/dev/null | grep -q "value"; then
        log_success "✅ Cache system working"
        ((health_score++))
    else
        log_warning "⚠️ Cache system issues (not critical)"
    fi
    
    # Check queue worker
    if docker-compose ps queue | grep -q "Up"; then
        log_success "✅ Queue worker running"
        ((health_score++))
    else
        log_error "❌ Queue worker issues"
    fi
    
    return $health_score
}

# Show detailed status
show_status() {
    echo ""
    echo "📊 Container Status:"
    docker-compose ps
    echo ""
    
    echo "🔗 Service URLs:"
    echo "• Main App: http://localhost:8000"
    echo "• phpMyAdmin: http://localhost:8080"  
    echo "• Redis Commander: http://localhost:8081"
    echo ""
    
    echo "🛠️ Useful Debug Commands:"
    echo "• Check logs: docker-compose logs -f app"
    echo "• Check queue: docker-compose logs -f queue"
    echo "• Access container: docker-compose exec app bash"
    echo ""
}

# Main repair process
main() {
    log_info "Starting safe repair process..."
    echo ""
    
    fix_permissions
    fix_cache_issue
    restart_services
    
    local health_result
    health_result=$(health_check)
    
    echo ""
    if [ "$health_result" -ge 3 ]; then
        echo "🎉 Safe Fix Completed Successfully!"
        echo "=================================="
        echo ""
        echo "Health Score: $health_result/4 - System is working well!"
        show_status
    elif [ "$health_result" -ge 2 ]; then
        echo "⚠️ Partially Fixed - Some Issues Remain"
        echo "========================================"
        echo ""
        echo "Health Score: $health_result/4 - Basic functionality working"
        show_status
        echo "Consider running full redeploy if issues persist:"
        echo "  ./docker-deploy.sh clean && ./docker-deploy.sh deploy"
    else
        echo "❌ Fix Failed - Major Issues Remain"
        echo "==================================="
        echo ""
        echo "Health Score: $health_result/4 - Requires full redeploy"
        show_status
        echo "Please run full redeploy:"
        echo "  ./docker-deploy.sh clean"
        echo "  ./docker-deploy.sh deploy"
    fi
}

# Run the safe fix
main 