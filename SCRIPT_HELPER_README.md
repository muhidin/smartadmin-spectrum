# SmartAdmin Spectrum Version Management Scripts

Collection of helper scripts to automate and simplify WordPress theme version management.

## 📋 Available Scripts

### 1. `update-version.sh` - Main Version Update Script
Automatically updates version numbers across all theme files.

**Usage:**
```bash
./update-version.sh [OPTIONS] <VERSION>
```

**Examples:**
```bash
# Update to version 1.1.4
./update-version.sh 1.1.4

# Update without backup
./update-version.sh 1.1.4 --no-backup

# Check current versions
./update-version.sh --show

# Check version consistency
./update-version.sh --check

# Create backup only
./update-version.sh --backup

# Create changelog entry only
./update-version.sh 1.1.4 --changelog
```

**Features:**
- ✅ Automatic backup creation
- ✅ Version format validation (MAJOR.MINOR.PATCH)
- ✅ Updates style.css and readme.txt
- ✅ Version consistency checking
- ✅ Changelog entry template
- ✅ Colored output for better visibility

### 2. `check-version.sh` - Version Consistency Checker
Checks version consistency across all theme files.

**Usage:**
```bash
./check-version.sh [OPTIONS]
```

**Examples:**
```bash
# Check version consistency
./check-version.sh

# Show detailed version information
./check-version.sh --detailed

# Search for all version strings
./check-version.sh --search

# Quiet mode (errors only)
./check-version.sh --quiet
```

**Features:**
- ✅ Checks multiple file types
- ✅ Detailed version information
- ✅ Version string search
- ✅ File metadata (size, modification time)
- ✅ Error reporting

### 3. `changelog-generator.sh` - Documentation Generator
Creates changelog entries, update notes, and release checklists.

**Usage:**
```bash
./changelog-generator.sh [OPTIONS] [VERSION]
```

**Examples:**
```bash
# Create all templates for v1.1.4
./changelog-generator.sh 1.1.4

# Create changelog entry only
./changelog-generator.sh --changelog 1.1.4

# Create update notes only
./changelog-generator.sh --update-notes 1.1.4

# Create release checklist only
./changelog-generator.sh --checklist 1.1.4
```

**Generated Files:**
- 📝 `CATATAN_UPDATE_V{VERSION}.md` - Update notes template
- 📋 `RELEASE_CHECKLIST_v{VERSION}.md` - Release checklist
- 📄 `readme.txt` - Changelog entry

## 🚀 Quick Start Guide

### First Time Setup

1. **Make scripts executable:**
```bash
chmod +x *.sh
```

2. **Check current versions:**
```bash
./check-version.sh --show
```

3. **Test version update:**
```bash
./update-version.sh --check
```

### Typical Workflow

1. **Before Release:**
```bash
# Check current version consistency
./check-version.sh

# Create documentation for new version
./changelog-generator.sh 1.1.4
```

2. **Version Update:**
```bash
# Update all files to new version
./update-version.sh 1.1.4
```

3. **After Update:**
```bash
# Verify consistency
./check-version.sh --check

# Fill in changelog details
# (Edit readme.txt manually)
```

## 📊 File Management

### Files Updated by Scripts

**`style.css`:**
```css
Version: 1.1.3  ← Updated automatically
```

**`readme.txt`:**
```text
Stable tag: 1.1.3  ← Updated automatically
== Changelog ==
= 1.1.3 =        ← Template added
* NEW: 
* IMPROVED: 
* FIXED: 
```

### Backup System

**Location:** `backups/` directory
**Format:** `{filename}.backup_{timestamp}`

**Example:**
```bash
backups/
├── style.css.backup_20260425_063000
├── readme.txt.backup_20260425_063000
└── ...
```

## 🔧 Advanced Usage

### Custom Version Patterns

The scripts can be customized for different version patterns:

**Edit `check-version.sh`:**
```bash
FILES=(
    "style.css:Version:"
    "readme.txt:Stable tag:"
    "package.json:version"      # Add npm package
    "composer.json:version"     # Add composer package
)
```

### Integration with Git

**Pre-commit hook example:**
```bash
#!/bin/sh
# .git/hooks/pre-commit
./check-version.sh --quiet || exit 1
```

**Git tagging workflow:**
```bash
# After version update
git add .
git commit -m "Release v1.1.4"
git tag -a v1.1.4 -m "Release v1.1.4"
git push origin v1.1.4
```

### CI/CD Integration

**GitHub Actions example:**
```yaml
name: Version Check
on: [push, pull_request]
jobs:
  check-version:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v2
      - name: Check version consistency
        run: ./check-version.sh
```

## 🛠️ Troubleshooting

### Common Issues

**1. Permission Denied:**
```bash
chmod +x *.sh
```

**2. Version Format Error:**
```
Expected format: MAJOR.MINOR.PATCH (e.g., 1.1.4)
```

**3. File Not Found:**
```bash
# Check if theme directory is correct
pwd  # Should be: /var/www/html/rgi/wordpress/wp-content/themes/smartadmin-spectrum
```

**4. Backup Directory Issues:**
```bash
# Create backup directory manually
mkdir -p backups
chmod 755 backups
```

### Debug Mode

**Enable verbose output:**
```bash
# Add to script beginning
set -x  # Debug mode
set +x  # Disable debug mode
```

**Check script syntax:**
```bash
bash -n script-name.sh
```

## 📋 Best Practices

### Version Numbering

**Semantic Versioning:**
- **Major (1.x.x)**: Breaking changes
- **Minor (x.1.x)**: New features
- **Patch (x.x.1)**: Bug fixes

**WordPress.org Guidelines:**
- Use semantic versioning
- Update changelog for every release
- Test thoroughly before release

### Documentation Workflow

1. **Before Release:**
   - Create update notes template
   - Fill in changelog details
   - Test all features

2. **Release Process:**
   - Update version numbers
   - Create backup
   - Verify consistency

3. **After Release:**
   - Submit to WordPress.org
   - Update documentation
   - Monitor feedback

### Safety Measures

**Always backup before major changes:**
```bash
./update-version.sh --backup
```

**Test on staging first:**
```bash
# Copy to staging environment
# Test version update
# Verify functionality
# Then update production
```

## 🎯 Tips & Tricks

### Speed Up Workflow

**Create aliases in `.bashrc`:**
```bash
alias theme-check='./check-version.sh'
alias theme-update='./update-version.sh'
alias theme-changelog='./changelog-generator.sh'
```

**Batch operations:**
```bash
# Check, backup, and update in one command
./check-version.sh && ./update-version.sh --backup && ./changelog-generator.sh
```

### Custom Templates

**Modify changelog templates:**
Edit the `changelog-generator.sh` file to customize templates for your specific needs.

**Add new file types:**
Update the `FILES` array in `check-version.sh` to include additional files.

---

## 📞 Support

**Issues & Questions:**
- Check script help: `./script-name.sh --help`
- Review this README for common solutions
- Contact theme developer for advanced issues

**Contributions:**
- Fork the theme repository
- Improve scripts with pull requests
- Share your customizations

---

**Happy version management! 🚀**
