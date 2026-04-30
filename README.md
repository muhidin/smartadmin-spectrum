# SmartAdmin Spectrum WordPress Theme

A professional, accessible, and lightweight WordPress theme designed specifically for educational portals and Digital Office Specialist classes.

## Features

### Core Features
- **Multi-Level Menu System**: Support for up to 5-level menu hierarchy with full hover functionality
- **Dynamic Container Layout**: Box Container and Full Width layout options with responsive positioning
- **Enhanced Navigation**: Top, Bottom, and Footer menus with customizable positioning
- **Hero Slider**: 5 image slots with 4 transition effects (fade, slide, cube, flip)
- **Search Integration**: Inline search form with responsive design
- **Widget System**: Comprehensive widget support for content organization
- **Header Background**: Custom header background image support
- **WCAG 2.1 AA Compliance**: Accessibility features for inclusive design

### Menu System
- **Primary Menu**: Main navigation with submenu support
- **Top Menu**: Above header with left alignment options
- **Bottom Menu**: Below header with dynamic positioning
- **Footer Menu**: Footer navigation with contrasting colors
- **5-Level Depth**: Menu, Sub-menu, Sub-sub-menu, Sub-sub-sub-menu, Sub-sub-sub-sub-menu
- **Responsive Behavior**: Dynamic positioning based on container type

### Layout Options
- **Box Container**: Centered layout with fixed maximum width
- **Full Width**: Edge-to-edge layout with 10px padding for menus
- **Responsive Design**: Mobile-friendly navigation and content layout

### Customization
- **Theme Customizer**: Full integration with WordPress Customizer
- **Header Options**: Logo, text, or both display modes
- **Footer Settings**: Multiple layout options and custom text support
- **Color Scheme**: Professional blue and red accent colors

## Installation

1. Download the theme ZIP file
2. Navigate to **Appearance > Themes > Add New** in WordPress admin
3. Click **Upload Theme** and select the ZIP file
4. Activate the theme

## Configuration

### Menu Setup
1. Navigate to **Appearance > Menus**
2. Create menus for different locations:
   - Primary Menu (main navigation)
   - Top Menu (header top)
   - Bottom Menu (header bottom)
   - Footer Menu (footer area)
3. Assign menu locations in **Manage Locations**
4. Configure menu hierarchy with drag-and-drop

### Layout Settings
1. Navigate to **Appearance > Customize**
2. Select layout options:
   - Container type (Box/Full Width)
   - Header display settings
   - Footer layout options
3. Configure header background image if desired

### Hero Slider
1. Navigate to **Appearance > Customize > Hero Slider**
2. Upload up to 5 images
3. Select transition effect
4. Configure slider settings

## Theme Structure

```
smartadmin-spectrum/
|
|-- style.css                 # Main stylesheet
|-- functions.php             # Theme functions and setup
|-- header.php                # Header template
|-- footer.php                # Footer template
|-- index.php                 # Main template
|-- single.php                # Single post template
|-- page.php                  # Page template
|-- search.php                # Search results template
|-- 404.php                   # 404 error template
|
|-- js/
|   |-- swiper-init.js        # Slider and menu initialization
|
|-- images/
|   |-- logo.png              # Default logo
|   |-- logo2.png             # Alternative logo
|   |-- slider1.jpg           # Default slider image
|   |-- slider2.jpg           # Default slider image
|   |-- slider3.jpg           # Default slider image
|   |-- slider4.jpg           # Default slider image
|   |-- slider5.jpg           # Default slider image
|
|-- languages/
|   |-- smartadmin-spectrum.pot # Translation template
```

## Customization Guide

### Menu Styling
- **Top Menu**: Blue background with red hover effect
- **Bottom Menu**: Light gray background with blue hover
- **Footer Menu**: White background with blue borders and hover
- **Primary Menu**: Standard navigation with dropdown support

### Responsive Behavior
- **Desktop**: Full multi-level menu functionality
- **Tablet**: Optimized navigation spacing
- **Mobile**: Stacked menu layout with touch support

### Color Variables
The theme uses CSS custom properties for easy color customization:
```css
--primary-blue: #0056b3
--primary-red: #e63946
--dark-text: #333333
--light-bg: #f8f9fa
```

## Browser Support

- Chrome 90+
- Firefox 88+
- Safari 14+
- Edge 90+

## Requirements

- WordPress 6.0+
- PHP 7.4+
- Memory Limit: 64MB recommended

## License

This theme is licensed under the GNU General Public License v2 or later.

## Changelog

### Version 1.1.10
- Added 5-level menu depth support
- Implemented multi-level submenu positioning
- Enhanced hover functionality for all menu levels
- Added dynamic container-based menu positioning
- Improved footer menu styling and accessibility
- Fixed submenu clickability issues
- Optimized spacing between content elements
- Enhanced responsive menu behavior

### Version 1.1.9
- Enhanced accessibility features
- Improved widget system integration
- Fixed header background image display
- Updated translation readiness

## Support

For support and documentation:
- Visit: [Theme URI](https://muhidin.web.id/smartadmin-spectrum/)
- Author: [Muhidin Saimin](http://muhidin.web.id)

## Contributing

Contributions are welcome! Please follow these guidelines:
1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## Credits

- WordPress Core Team
- Swiper.js for slider functionality
- Font Awesome for icons (if used)
- All contributors and testers
