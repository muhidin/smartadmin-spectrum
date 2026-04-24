#!/bin/bash

# SmartAdmin Spectrum Version Update Script
# Author: Muhidin Saimin
# Description: Helper script for updating theme version across all files

set -e  # Exit on any error

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Theme information
THEME_NAME="SmartAdmin Spectrum"
THEME_DIR="/var/www/html/rgi/wordpress/wp-content/themes/smartadmin-spectrum"

# Files to update
FILES=(
    "style.css"
    "readme.txt"
)

# Backup directory
BACKUP_DIR="$THEME_DIR/backups"
TIMESTAMP=$(date +"%Y%m%d_%H%M%S")

# Function to print colored output
print_status() {
    echo -e "${BLUE}[INFO]${NC} $1"
}

print_success() {
    echo -e "${GREEN}[SUCCESS]${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

print_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

# Function to validate version format
validate_version() {
    local version=$1
    if [[ $version =~ ^[0-9]+\.[0-9]+\.[0-9]+$ ]]; then
        return 0
    else
        return 1
    fi
}

# Function to backup files
backup_files() {
    print_status "Creating backup..."
    
    if [ ! -d "$BACKUP_DIR" ]; then
        mkdir -p "$BACKUP_DIR"
    fi
    
    for file in "${FILES[@]}"; do
        if [ -f "$THEME_DIR/$file" ]; then
            cp "$THEME_DIR/$file" "$BACKUP_DIR/${file}.backup_$TIMESTAMP"
            print_success "Backed up: $file"
        fi
    done
    
    print_success "Backup completed in: $BACKUP_DIR"
}

# Function to update version in style.css
update_style_css() {
    local version=$1
    local file="$THEME_DIR/style.css"
    
    if [ ! -f "$file" ]; then
        print_error "style.css not found!"
        return 1
    fi
    
    # Update version line
    sed -i "s/^Version: .*/Version: $version/" "$file"
    print_success "Updated version in style.css: $version"
}

# Function to update version in readme.txt
update_readme_txt() {
    local version=$1
    local file="$THEME_DIR/readme.txt"
    
    if [ ! -f "$file" ]; then
        print_error "readme.txt not found!"
        return 1
    fi
    
    # Update stable tag line
    sed -i "s/^Stable tag: .*/Stable tag: $version/" "$file"
    print_success "Updated stable tag in readme.txt: $version"
}

# Function to check version consistency
check_consistency() {
    local expected_version=$1
    local inconsistent=0
    
    print_status "Checking version consistency..."
    
    # Check style.css
    if [ -f "$THEME_DIR/style.css" ]; then
        local css_version=$(grep "^Version:" "$THEME_DIR/style.css" | cut -d' ' -f2)
        if [ "$css_version" != "$expected_version" ]; then
            print_error "style.css version mismatch: $css_version (expected: $expected_version)"
            inconsistent=1
        else
            print_success "style.css version correct: $css_version"
        fi
    fi
    
    # Check readme.txt
    if [ -f "$THEME_DIR/readme.txt" ]; then
        local readme_version=$(grep "^Stable tag:" "$THEME_DIR/readme.txt" | cut -d' ' -f3)
        if [ "$readme_version" != "$expected_version" ]; then
            print_error "readme.txt stable tag mismatch: $readme_version (expected: $expected_version)"
            inconsistent=1
        else
            print_success "readme.txt stable tag correct: $readme_version"
        fi
    fi
    
    return $inconsistent
}

# Function to show current versions
show_current_versions() {
    print_status "Current versions in theme files:"
    
    if [ -f "$THEME_DIR/style.css" ]; then
        local css_version=$(grep "^Version:" "$THEME_DIR/style.css" | cut -d' ' -f2)
        echo -e "  style.css: ${GREEN}$css_version${NC}"
    fi
    
    if [ -f "$THEME_DIR/readme.txt" ]; then
        local readme_version=$(grep "^Stable tag:" "$THEME_DIR/readme.txt" | cut -d' ' -f3)
        echo -e "  readme.txt: ${GREEN}$readme_version${NC}"
    fi
}

# Function to create changelog entry
create_changelog_entry() {
    local version=$1
    local changelog_file="$THEME_DIR/readme.txt"
    
    if [ ! -f "$changelog_file" ]; then
        print_error "readme.txt not found!"
        return 1
    fi
    
    print_status "Creating changelog entry template..."
    
    # Find changelog section and add new entry
    local temp_file=$(mktemp)
    
    # Read file until changelog section
    awk '/^== Changelog ==$/ {print; print ""; print "= " $version " ="; print "* NEW: "; print "* IMPROVED: "; print "* FIXED: "; next} {print}' "$changelog_file" > "$temp_file"
    
    mv "$temp_file" "$changelog_file"
    print_success "Changelog entry template created. Please fill in the changes."
}

# Function to show help
show_help() {
    echo "SmartAdmin Spectrum Version Update Script"
    echo ""
    echo "Usage: $0 [OPTIONS] <VERSION>"
    echo ""
    echo "Options:"
    echo "  -h, --help          Show this help message"
    echo "  -c, --check         Check current version consistency"
    echo "  -s, --show          Show current versions"
    echo "  -b, --backup        Create backup only"
    echo "  -l, --changelog     Create changelog entry only"
    echo "  --no-backup         Skip backup creation"
    echo ""
    echo "Examples:"
    echo "  $0 1.1.4                    # Update to version 1.1.4"
    echo "  $0 --check                   # Check version consistency"
    echo "  $0 --show                    # Show current versions"
    echo "  $0 --backup                  # Create backup only"
    echo "  $0 1.1.4 --no-backup        # Update without backup"
    echo ""
    echo "Version format: MAJOR.MINOR.PATCH (e.g., 1.1.4)"
}

# Main execution
main() {
    local version=""
    local check_only=false
    local show_only=false
    local backup_only=false
    local changelog_only=false
    local no_backup=false
    
    # Parse arguments
    while [[ $# -gt 0 ]]; do
        case $1 in
            -h|--help)
                show_help
                exit 0
                ;;
            -c|--check)
                check_only=true
                shift
                ;;
            -s|--show)
                show_only=true
                shift
                ;;
            -b|--backup)
                backup_only=true
                shift
                ;;
            -l|--changelog)
                changelog_only=true
                shift
                ;;
            --no-backup)
                no_backup=true
                shift
                ;;
            -*)
                print_error "Unknown option: $1"
                show_help
                exit 1
                ;;
            *)
                if [ -z "$version" ]; then
                    version=$1
                else
                    print_error "Multiple versions specified"
                    exit 1
                fi
                shift
                ;;
        esac
    done
    
    # Change to theme directory
    if [ ! -d "$THEME_DIR" ]; then
        print_error "Theme directory not found: $THEME_DIR"
        exit 1
    fi
    
    cd "$THEME_DIR"
    
    # Handle different modes
    if [ "$check_only" = true ]; then
        show_current_versions
        if ! check_consistency; then
            print_error "Version consistency check failed!"
            exit 1
        else
            print_success "Version consistency check passed!"
            exit 0
        fi
    fi
    
    if [ "$show_only" = true ]; then
        show_current_versions
        exit 0
    fi
    
    if [ "$backup_only" = true ]; then
        backup_files
        exit 0
    fi
    
    if [ "$changelog_only" = true ]; then
        if [ -z "$version" ]; then
            print_error "Version required for changelog entry"
            exit 1
        fi
        create_changelog_entry "$version"
        exit 0
    fi
    
    # Version update mode
    if [ -z "$version" ]; then
        print_error "Version required for update"
        show_help
        exit 1
    fi
    
    # Validate version format
    if ! validate_version "$version"; then
        print_error "Invalid version format: $version"
        print_error "Expected format: MAJOR.MINOR.PATCH (e.g., 1.1.4)"
        exit 1
    fi
    
    print_status "Updating $THEME_NAME to version $version"
    
    # Show current versions
    show_current_versions
    
    # Create backup unless skipped
    if [ "$no_backup" = false ]; then
        backup_files
    fi
    
    # Update files
    update_style_css "$version"
    update_readme_txt "$version"
    
    # Check consistency
    if check_consistency "$version"; then
        print_success "Version update completed successfully!"
        print_success "All files updated to version: $version"
        
        # Ask about changelog
        echo ""
        read -p "Do you want to create a changelog entry? (y/N): " -n 1 -r
        echo ""
        if [[ $REPLY =~ ^[Yy]$ ]]; then
            create_changelog_entry "$version"
        fi
        
        print_success "Don't forget to:"
        echo "  1. Fill in the changelog entry"
        echo "  2. Test all theme features"
        echo "  3. Create update notes documentation"
        echo "  4. Submit to WordPress.org"
        
    else
        print_error "Version consistency check failed!"
        print_error "Please check the files manually"
        exit 1
    fi
}

# Run main function
main "$@"
