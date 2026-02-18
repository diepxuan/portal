#!/usr/bin/env bash

# Portal Development Manager - Strict serve:dev wrapper
# Bắt buộc dùng serve:dev để quản lý PHP server và Vite server

set -e

PORTAL_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
ARTISAN="$PORTAL_DIR/artisan"

# Check if artisan exists
artisan_exists() {
    [ -f "$ARTISAN" ]
}

# Check if composer exists
composer_exists() {
    command -v composer >/dev/null 2>&1
}

# Check if laravel-support package is installed
laravel_support_exists() {
    if artisan_exists; then
        php "$ARTISAN" list 2>/dev/null | grep -q "serve:dev"
    else
        false
    fi
}

# Install composer if missing
install_composer() {
    if ! composer_exists; then
        echo "📦 Installing Composer..."
        curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
        echo "✅ Composer installed"
    fi
}

# Install laravel-support package
install_laravel_support() {
    echo "📦 Installing laravel-support package..."
    
    # Check if package exists in composer.json
    if [ -f "$PORTAL_DIR/composer.json" ]; then
        if ! grep -q "diepxuan/laravel-support" "$PORTAL_DIR/composer.json"; then
            echo "➕ Adding laravel-support to composer.json..."
            composer require diepxuan/laravel-support --dev
        else
            echo "🔄 Updating laravel-support..."
            composer update diepxuan/laravel-support --dev
        fi
    else
        echo "❌ composer.json not found"
        return 1
    fi
    
    echo "✅ laravel-support installed/updated"
}

# Ensure serve:dev command is available
ensure_serve_dev() {
    echo "🔧 Ensuring serve:dev command..."
    
    if ! artisan_exists; then
        echo "❌ artisan not found at: $ARTISAN"
        echo "   Please check Laravel installation"
        exit 1
    fi
    
    if ! laravel_support_exists; then
        echo "⚠️ serve:dev command not found"
        
        # Install dependencies
        install_composer
        install_laravel_support
        
        # Verify installation
        if laravel_support_exists; then
            echo "✅ serve:dev command installed"
        else
            echo "❌ Failed to install serve:dev command"
            echo "   Please check composer installation manually"
            exit 1
        fi
    else
        echo "✅ serve:dev command available"
    fi
}

# Show help
show_help() {
    echo "========================================"
    echo "  Portal Development Manager"
    echo "========================================"
    echo ""
    echo "Strict wrapper for artisan serve:dev"
    echo "Bắt buộc dùng serve:dev để quản lý PHP server và Vite server"
    echo ""
    echo "Usage: $(basename "$0") [command]"
    echo ""
    echo "Development Commands:"
    echo "  start       Start development (serve:dev)"
    echo "  stop        Stop development (serve:dev:stop)"
    echo "  status      Check status (serve:dev:status)"
    echo "  vite        Start Vite server (serve:dev:vite)"
    echo "  help        Show this help"
    echo ""
    echo "Artisan Commands:"
    echo "  [any artisan command]  Pass through to artisan"
    echo ""
    echo "Examples:"
    echo "  $(basename "$0") start          # Start development"
    echo "  $(basename "$0") status         # Check status"
    echo "  $(basename "$0") migrate        # Run migrations"
    echo "  $(basename "$0") make:model Post # Generate model"
    echo ""
    echo "Development URLs:"
    echo "  Portal: http://localhost:8000"
    echo "  Vite:   http://localhost:5173"
    echo ""
    echo "⚠️  LƯU Ý: Bắt buộc dùng serve:dev, không có fallback mode"
}

# Main logic
if [ $# -eq 0 ]; then
    show_help
    exit 0
fi

# Check command
CMD="$1"
shift

# Ensure serve:dev is available for development commands
case "$CMD" in
    start|stop|status|vite)
        ensure_serve_dev
        ;;
esac

case "$CMD" in
    start)
        echo "🚀 Starting development with serve:dev..."
        php "$ARTISAN" serve:dev "$@"
        ;;
    stop)
        echo "🛑 Stopping development servers..."
        php "$ARTISAN" serve:dev:stop "$@"
        ;;
    status)
        php "$ARTISAN" serve:dev:status "$@"
        ;;
    vite)
        echo "⚡ Starting Vite server..."
        php "$ARTISAN" serve:dev:vite "$@"
        ;;
    help|--help|-h)
        show_help
        ;;
    *)
        # Try artisan if it exists
        if artisan_exists; then
            php "$ARTISAN" "$CMD" "$@"
        else
            echo "❌ Unknown command: $CMD"
            echo "   artisan not found at: $ARTISAN"
            show_help
            exit 1
        fi
        ;;
esac