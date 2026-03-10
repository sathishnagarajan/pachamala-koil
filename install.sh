#!/bin/bash
# =============================================================
# Pachaimalai Athireeswarar Temple — One-Click Installer
# Usage: bash install.sh
# Requires: WP-CLI, PHP, MySQL
# =============================================================

set -e

# ── CONFIG — edit before running ─────────────────────────────
DB_NAME="pachamala_koil"
DB_USER="root"
DB_PASS="@dm1n"
DB_HOST="localhost"

SITE_URL="http://localhost/pachamala-koil"
SITE_TITLE="Pachaimalai Athireeswarar Temple"
ADMIN_USER="admin"
ADMIN_PASS="admin@123"
ADMIN_EMAIL="admin@pachaimalaiathireeswarar.org"
# ─────────────────────────────────────────────────────────────

GREEN="\033[0;32m"
YELLOW="\033[1;33m"
RED="\033[0;31m"
NC="\033[0m"

info()    { echo -e "${GREEN}✔ $1${NC}"; }
warning() { echo -e "${YELLOW}⚠ $1${NC}"; }
error()   { echo -e "${RED}✖ $1${NC}"; exit 1; }

echo ""
echo "============================================="
echo " Pachaimalai Athireeswarar Temple Installer  "
echo "============================================="
echo ""

# Check WP-CLI
command -v wp >/dev/null 2>&1 || error "WP-CLI not found. Install from https://wp-cli.org"
info "WP-CLI found"

# Check if already installed
if wp core is-installed 2>/dev/null; then
    warning "WordPress is already installed. Skipping core install."
else
    # Download WordPress
    info "Downloading WordPress..."
    wp core download --skip-content

    # Create wp-config.php
    info "Creating wp-config.php..."
    wp config create \
        --dbname="$DB_NAME" \
        --dbuser="$DB_USER" \
        --dbpass="$DB_PASS" \
        --dbhost="$DB_HOST" \
        --dbcharset="utf8mb4" \
        --dbcollate="utf8mb4_unicode_ci" \
        --extra-php <<PHP
define('FS_METHOD', 'direct');
define('WP_DEBUG', false);
PHP

    # Create database
    info "Creating database..."
    wp db create || warning "Database may already exist, continuing..."

    # Install WordPress
    info "Installing WordPress..."
    wp core install \
        --url="$SITE_URL" \
        --title="$SITE_TITLE" \
        --admin_user="$ADMIN_USER" \
        --admin_password="$ADMIN_PASS" \
        --admin_email="$ADMIN_EMAIL" \
        --skip-email
fi

info "WordPress installed"

# Activate theme
info "Activating Pachamala Temple theme..."
wp theme activate pachamala-temple

# Set permalink structure
info "Setting permalink structure..."
wp rewrite structure '/%postname%/' --hard
wp rewrite flush --hard 2>/dev/null || true

# Site settings
info "Configuring site settings..."
wp option update blogname "$SITE_TITLE"
wp option update blogdescription "Official Website of Pachaimalai Athireeswarar Temple, Chennai"

# Import content (pages, menus, CPT data)
if [ -f "pachamala-export.xml" ]; then
    info "Importing content from pachamala-export.xml..."
    wp import pachamala-export.xml --authors=create 2>/dev/null || \
        warning "Import plugin not active. Install WordPress Importer plugin and import manually."
else
    warning "pachamala-export.xml not found. Skipping content import."
fi

# Set front page
HOME_ID=$(wp post list --post_type=page --name=home --field=ID --format=ids 2>/dev/null | head -1)
if [ -n "$HOME_ID" ]; then
    wp option update show_on_front 'page'
    wp option update page_on_front "$HOME_ID"
    info "Front page set (ID: $HOME_ID)"
fi

# Flush rewrite rules
wp rewrite flush 2>/dev/null || true

echo ""
echo "============================================="
info "Installation complete!"
echo ""
echo "  Site URL : $SITE_URL"
echo "  Admin    : $SITE_URL/wp-admin"
echo "  Username : $ADMIN_USER"
echo "  Password : $ADMIN_PASS"
echo ""
echo -e "${YELLOW}Next steps:${NC}"
echo "  1. Upload logo to: wp-content/themes/pachamala-temple/assets/images/logo/"
echo "  2. Upload audio to: wp-content/themes/pachamala-temple/assets/images/audio/"
echo "  3. Upload hero image: wp-content/themes/pachamala-temple/assets/images/temple-hero-bg.jpg"
echo "  4. Go to Appearance > Menus and assign menus to locations"
echo "  5. If import failed: go to Tools > Import > WordPress and upload pachamala-export.xml"
echo "============================================="
echo ""
