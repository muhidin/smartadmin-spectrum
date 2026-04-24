#!/bin/bash

# SmartAdmin Spectrum Version Consistency Checker
# Author: Muhidin Saimin
# Description: Check version consistency across all theme files

set -e

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Theme information
THEME_NAME="SmartAdmin Spectrum"
THEME_DIR="/var/www/html/rgi/wordpress/wp-content/themes/smartadmin-spectrum"

# Files to check
FILES=(
    "style.css:Version:"
    "readme.txt:Stable tag:"
    "functions.php:Version"
    "package.json:version"
)

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

# Function to extract version from file
extract_version() {
    local file=$1
    local pattern=$2
    
    if [ ! -f "$file" ]; then
        echo "FILE_NOT_FOUND"
        return
    fi
    
    case $pattern in
        "Version:")
            version=$(grep "^Version:" "$file" | head -1 | cut -d' ' -f2)
            ;;
        "Stable tag:")
            version=$(grep "^Stable tag:" "$file" | head -1 | cut -d' ' -f3)
            ;;
        "Version")
            version=$(grep -o '"version":\s*"[^"]*"' "$file" 2>/dev/null | head -1 | cut -d'"' -f4)
            ;;
        "version")
            version=$(grep -o '"version":\s*"[^"]*"' "$file" 2>/dev/null | head -1 | cut -d'"' -f4)
            ;;
        *)
            version="UNKNOWN_PATTERN"
            ;;
    esac
    
    echo "$version"
}

# Function to check version consistency
check_consistency() {
    local inconsistent=0
    local versions=()
    local file_names=()
    
    print_status "Checking version consistency across theme files..."
    echo ""
    
    # Check each file
    for file_info in "${FILES[@]}"; do
        IFS=':' read -r file pattern <<< "$file_info"
        local file_path="$THEME_DIR/$file"
        
        if [ -f "$file_path" ]; then
            local version=$(extract_version "$file_path" "$pattern")
            
            if [ "$version" = "FILE_NOT_FOUND" ]; then
                print_error "$file: File not found"
                inconsistent=1
            elif [ "$version" = "UNKNOWN_PATTERN" ]; then
                print_error "$file: Unknown pattern '$pattern'"
                inconsistent=1
            elif [ -z "$version" ]; then
                print_warning "$file: No version found with pattern '$pattern'"
            else
                versions+=("$version")
                file_names+=("$file")
                echo -e "  $file: ${GREEN}$version${NC}"
            fi
        else
            print_warning "$file: File not found (optional file)"
        fi
    done
    
    echo ""
    
    # Check if all versions are the same
    if [ ${#versions[@]} -gt 1 ]; then
        local first_version="${versions[0]}"
        local all_same=true
        
        for version in "${versions[@]}"; do
            if [ "$version" != "$first_version" ]; then
                all_same=false
                break
            fi
        done
        
        if [ "$all_same" = true ]; then
            print_success "All versions are consistent: $first_version"
            return 0
        else
            print_error "Version inconsistency detected!"
            echo ""
            print_status "Version summary:"
            for i in "${!file_names[@]}"; do
                echo "  ${file_names[i]}: ${versions[i]}"
            done
            return 1
        fi
    elif [ ${#versions[@]} -eq 1 ]; then
        print_success "Single version found: ${versions[0]}"
        return 0
    else
        print_warning "No versions found to compare"
        return 0
    fi
}

# Function to show detailed version info
show_detailed_info() {
    print_status "Detailed version information..."
    echo ""
    
    for file_info in "${FILES[@]}"; do
        IFS=':' read -r file pattern <<< "$file_info"
        local file_path="$THEME_DIR/$file"
        
        echo "=== $file ==="
        if [ -f "$file_path" ]; then
            echo "Path: $file_path"
            echo "Pattern: $pattern"
            
            local version=$(extract_version "$file_path" "$pattern")
            echo "Version: $version"
            
            # Show file size and modification time
            local size=$(du -h "$file_path" | cut -f1)
            local mtime=$(stat -c %y "$file_path" 2>/dev/null || stat -f %Sm "$file_path" 2>/dev/null)
            echo "Size: $size"
            echo "Modified: $mtime"
        else
            echo "Path: $file_path"
            echo "Status: File not found"
        fi
        echo ""
    done
}

# Function to search for version strings
search_version_strings() {
    print_status "Searching for all version-like strings..."
    echo ""
    
    # Common version patterns
    local patterns=(
        "Version:"
        "Stable tag:"
        "version"
        "v[0-9]\+\.[0-9]\+\.[0-9]\+"
        "[0-9]\+\.[0-9]\+\.[0-9]\+"
    )
    
    for pattern in "${patterns[@]}"; do
        echo "--- Pattern: $pattern ---"
        find "$THEME_DIR" -type f -name "*.php" -o -name "*.css" -o -name "*.txt" -o -name "*.js" -o -name "*.json" | while read file; do
            if grep -q "$pattern" "$file" 2>/dev/null; then
                echo "  $file:"
                grep "$pattern" "$file" | head -3 | sed 's/^/    /'
                echo ""
            fi
        done
    done
}

# Function to show help
show_help() {
    echo "SmartAdmin Spectrum Version Consistency Checker"
    echo ""
    echo "Usage: $0 [OPTIONS]"
    echo ""
    echo "Options:"
    echo "  -h, --help          Show this help message"
    echo "  -d, --detailed     Show detailed version information"
    echo "  -s, --search       Search for all version strings"
    echo "  -q, --quiet        Quiet mode (only show errors)"
    echo ""
    echo "Examples:"
    echo "  $0                 # Check version consistency"
    echo "  $0 --detailed      # Show detailed information"
    echo "  $0 --search        # Search for version strings"
    echo ""
}

# Main execution
main() {
    local detailed=false
    local search=false
    local quiet=false
    
    # Parse arguments
    while [[ $# -gt 0 ]]; do
        case $1 in
            -h|--help)
                show_help
                exit 0
                ;;
            -d|--detailed)
                detailed=true
                shift
                ;;
            -s|--search)
                search=true
                shift
                ;;
            -q|--quiet)
                quiet=true
                shift
                ;;
            -*)
                print_error "Unknown option: $1"
                show_help
                exit 1
                ;;
            *)
                print_error "Unknown argument: $1"
                show_help
                exit 1
                ;;
        esac
    done
    
    # Change to theme directory
    if [ ! -d "$THEME_DIR" ]; then
        print_error "Theme directory not found: $THEME_DIR"
        exit 1
    fi
    
    if [ "$quiet" = false ]; then
        print_status "Checking $THEME_NAME version consistency..."
    fi
    
    # Handle different modes
    if [ "$search" = true ]; then
        search_version_strings
        exit 0
    fi
    
    if [ "$detailed" = true ]; then
        show_detailed_info
        exit 0
    fi
    
    # Default consistency check
    if check_consistency; then
        if [ "$quiet" = false ]; then
            print_success "Version consistency check passed!"
        fi
        exit 0
    else
        print_error "Version consistency check failed!"
        exit 1
    fi
}

# Run main function
main "$@"
