#!/usr/bin/env bash

# Portal Development Manager - Complete serve:dev wrapper
# All functionality now integrated into serve:dev commands

set -e

PORTAL_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
ARTISAN="$PORTAL_DIR/artisan"

# Check if artisan exists
artisan_exists() {
    [ -f "$ARTISAN" ]
}

# Show help
show_help() {
    echo "========================================"
    echo "  Portal Development Manager"
    echo "========================================"
    echo ""
    echo "Complete wrapper for artisan serve:dev commands"
    echo "All scripts integrated into serve:dev ecosystem"
    echo ""
    echo "Usage: $(basename "$0") [command]"
    echo ""
    echo "Development Commands:"
    echo "  start       Start development (serve:dev)"
    echo "  stop        Stop development (serve:dev:stop)"
    echo "  status      Check status (serve:dev:status)"
    echo "  health      Health check (serve:dev:health)"
    echo "  service     Manage systemd service (serve:dev:service)"
    echo "  vite        Start Vite server (serve:dev:vite)"
    echo "  help        Show this help"
    echo ""
    echo "Advanced Options:"
    echo "  start --service      Install as systemd service"
    echo "  start --health       Enable health check"
    echo "  health --fix         Auto-fix servers"
    echo "  service install      Install systemd service"
    echo "  service status       Check service status"
    echo ""
    echo "Artisan Commands:"
    echo "  [any artisan command]  Pass through to artisan"
    echo ""
    echo "Examples:"
    echo "  $(basename "$0") start                 # Start development"
    echo "  $(basename "$0") start --service       # Install as service"
    echo "  $(basename "$0") status                # Check status"
    echo "  $(basename "$0") health --fix          # Health check + fix"
    echo "  $(basename "$0") service install       # Install service"
    echo "  $(basename "$0") migrate               # Run migrations"
    echo ""
    echo "Development URLs:"
    echo "  Portal: http://localhost:8000"
    echo "  Vite:   http://localhost:5173"
}

# Main logic
if [ $# -eq 0 ]; then
    show_help
    exit 0
fi

# Check command
CMD="$1"
shift

# Ensure artisan exists
if ! artisan_exists; then
    echo "❌ artisan not found at: $ARTISAN"
    echo "   Please check Laravel installation"
    exit 1
fi

case "$CMD" in
    start)
        echo "🚀 Starting development..."
        php "$ARTISAN" serve:dev "$@"
        ;;
    stop)
        echo "🛑 Stopping development..."
        php "$ARTISAN" serve:dev:stop "$@"
        ;;
    status)
        php "$ARTISAN" serve:dev:status "$@"
        ;;
    health)
        echo "🩺 Health check..."
        php "$ARTISAN" serve:dev:health "$@"
        ;;
    service)
        echo "🔧 Service management..."
        php "$ARTISAN" serve:dev:service "$@"
        ;;
    vite)
        echo "⚡ Starting Vite..."
        # Check if serve:dev:vite exists, otherwise use npm
        if php "$ARTISAN" list 2>/dev/null | grep -q "serve:dev:vite"; then
            php "$ARTISAN" serve:dev:vite "$@"
        else
            cd "$PORTAL_DIR" && npm run dev
        fi
        ;;
    help|--help|-h)
        show_help
        ;;
    *)
        # Pass through to artisan
        php "$ARTISAN" "$CMD" "$@"
        ;;
esac