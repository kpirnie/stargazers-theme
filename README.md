# Stargazers WordPress Theme

A dark, astronomy-themed WordPress theme built with Tailwind CSS, featuring a blue/gray color scheme inspired by space and the cosmos.

## Features

- **Dark Theme**: Deep space-inspired dark color palette
- **Custom Colors**: Uses blue/gray colors (#0e3759, #185e98, #77aad4) from the Stargazers logo
- **Typography**: 
  - Orbitron font for headings
  - Raleway font for body content
- **Tailwind CSS**: Modern utility-first CSS framework
- **Responsive Design**: Mobile-friendly and fully responsive
- **Partials Architecture**: 
  - Separate page and post content partials
  - Header menu partial
  - Footer menu partial
- **Two Menu Locations**: Primary header menu and footer menu
- **Yoast Breadcrumbs Support**: Built-in styling for Yoast SEO breadcrumbs
- **Standard WordPress Features**: 
  - Featured images
  - Comments
  - Custom menus
  - Widget areas ready

## Installation

1. Upload the `stargazers-theme` folder to `/wp-content/themes/`
2. Navigate to the theme directory in your terminal:
   ```bash
   cd wp-content/themes/stargazers-theme
   ```
3. Install dependencies:
   ```bash
   npm install
   ```
4. Build the Tailwind CSS:
   ```bash
   npm run build
   ```
5. Activate the theme in WordPress Admin under Appearance → Themes

## Development

### Building CSS

**Production build** (minified):
```bash
npm run build
```

**Development mode** (watch for changes):
```bash
npm run watch
```

### Customization

#### Colors

The theme uses custom astronomy colors defined in `tailwind.config.js`:
- `astro-dark`: #0e3759 (Deep space blue)
- `astro-mid`: #185e98 (Medium cosmic blue)
- `astro-light`: #77aad4 (Light nebula blue)

You can use these in your custom CSS with Tailwind classes like:
- `bg-astro-dark`
- `text-astro-mid`
- `border-astro-light`

#### Fonts

- **Headings**: Orbitron (Google Fonts)
- **Body**: Raleway (Google Fonts)

#### Menus

The theme supports two menu locations:
1. **Primary Menu**: Main navigation in the header
2. **Footer Menu**: Navigation links in the footer

Configure these in WordPress Admin under Appearance → Menus.

## Template Structure

```
stargazers-theme/
├── assets/
│   ├── css/
│   │   ├── input.css (Tailwind source)
│   │   └── main.css (compiled output)
│   └── js/
│       └── main.js
├── template-parts/
│   ├── content-page.php (page content partial)
│   ├── content-post.php (post content partial)
│   ├── content-none.php (no content found)
│   ├── footer.php (footer partial)
│   ├── menu-header.php (header menu partial)
│   ├── menu-footer.php (footer menu partial)
│   └── pagination.php
├── functions.php
├── header.php
├── footer.php
├── index.php
├── single.php
├── page.php
├── archive.php
├── search.php
├── 404.php
├── comments.php
├── searchform.php
├── style.css
└── tailwind.config.js
```

## Browser Support

- Modern browsers (Chrome, Firefox, Safari, Edge)
- Mobile browsers (iOS Safari, Chrome Mobile)

## License

GNU General Public License v2 or later

## Credits

- Theme Developer: Kevin Pirnie
- Tailwind CSS: https://tailwindcss.com
- Fonts: Google Fonts (Orbitron & Raleway)

## Support

For issues or questions about this theme, please contact the developer.
