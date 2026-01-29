# litchpress — WordPress Theme

A custom, minimalist WordPress theme by **Mike Lindner** for [mikelindner.com.au](https://mikelindner.com.au).

| Meta             | Value                                      |
|------------------|--------------------------------------------|
| **Theme Name**   | litchpress                                 |
| **Version**      | 0.03                                       |
| **Author**       | Mike Lindner                               |
| **Author URI**   | http://mikelindner.com.au                  |
| **License**      | "Screw You Hippy"                          |
| **Text Domain**  | litchpress                                 |

---

## Part 1 — Technical Documentation

### 1.1 Directory Structure

```
litchpress/
├── header.php                # Site header, <head>, navigation
├── footer.php                # Footer & wp_footer() hook
├── index.php                 # Main blog/archive template
├── index.php.noblock         # Backup/alternative index without excerpt truncation
├── single.php                # Single-post template
├── page.php                  # Generic page template (title commented out)
├── page-nodate.php           # Page template without date display
├── page-cooking.php          # Custom page template for "cooking" category (4-col grid)
├── sidebar.php               # Sidebar with categories, archives, Leanpub embed
├── template-page-full-width.php  # Full-width page template (no sidebar)
│
├── style.css                 # Main theme stylesheet + WP theme header
├── screenshot.png            # Theme preview (2516×1348 RGBA PNG)
│
├── css/                      # Bootstrap 4.0.0 CSS (full + grid + reboot)
│   ├── bootstrap.css / .min.css
│   ├── bootstrap-grid.css / .min.css
│   └── bootstrap-reboot.css / .min.css
│
├── js/                       # Bootstrap 4.0.0 JS bundle
│   ├── bootstrap.bundle.js / .min.js
│   └── bootstrap.js / .min.js
│
├── fonts/                    # Self-hosted "Play" font (Google Fonts alternative)
│   ├── Play-Bold.ttf, Play-Regular.ttf
│   └── play-v9-latin-* (EOT, SVG, TTF, WOFF, WOFF2)
│
├── fontawesome/              # Font Awesome 5.3.1 (Free)
│   ├── css/all.css
│   ├── webfonts/
│   └── (less, scss, sprites, svgs, metadata)
│
├── vendor/                   # Composer dependencies (dev: wordpress-stubs)
├── composer.json / .lock
│
├── deploy                    # rsync deployment script to production server
├── files                     # Quick-reference list of theme files
├── litchpress.code-workspace # VS Code workspace config
└── .vscode/settings.json     # Editor settings (Intelephense, PHP path)
```

---

### 1.2 Core Template Files

| File                          | Purpose                                                                                                                                       |
|-------------------------------|-----------------------------------------------------------------------------------------------------------------------------------------------|
| **header.php**                | Outputs `<!DOCTYPE html>`, `<head>` with meta tags (Open Graph, favicon), loads Bootstrap CSS, theme stylesheet, renders jumbotron header with external navigation links. |
| **footer.php**                | Copyright notice, credits, calls `wp_footer()` for plugin scripts.                                                                            |
| **index.php**                 | Main archive/blog listing. Defines `POST_SIZE` constant (700 chars). Extracts first image from post content via regex. Truncates excerpts, appends "Read more…" links. Renders posts in a 2-column Bootstrap grid (`col-lg-6`). |
| **index.php.noblock**         | Simpler backup version of `index.php` without custom truncation logic — uses native `the_content()`.                                          |
| **single.php**                | Displays a single post with full content, date, in a 2-column grid (though typically one post shown).                                         |
| **page.php**                  | Generic page template. Title output is commented out; shows full-width content (`col-lg-12`). Date display commented out.                     |
| **page-nodate.php**           | Variant of `page.php` with title commented out and no date — clean content-only layout.                                                       |
| **page-cooking.php**          | 4-column grid layout (`col-lg-4`) intended for recipe/category pages. Contains debug text `"yeah yeah yeah"` (to be removed).                 |
| **sidebar.php**               | Lists categories (`wp_list_cats`) and archives (`wp_get_archives`). Embeds Leanpub book widget via `<iframe>`.                                |
| **template-page-full-width.php** | Registered page template ("Full width page"). Calls `get_template_part('loop', 'page')` — **note: `loop-page.php` does not exist** (bug).    |

---

### 1.3 Stylesheet — `style.css`

The stylesheet serves two roles:
1. **WordPress theme header** (required metadata block).
2. **Custom styles** layered on top of Bootstrap.

#### Key Style Declarations

| Selector / Rule                     | Description                                                                 |
|-------------------------------------|-----------------------------------------------------------------------------|
| `@import url(…Play…)`               | Loads **Play** font from Google Fonts (400 & 700 weights).                  |
| `@font-face { font-family: "Play" }` | Declares local Play font; `src` is commented out (currently unused).         |
| `body`                              | Dark background (`#444`), `greenyellow` text, Play font stack.               |
| `a`                                 | Inherits Play font, `greenyellow` color.                                     |
| `#ttr_header`                       | Full-width header with red top border, right-aligned text, cover background image from remote URL. |
| `#ttr_footer`                       | Full-width footer, red top border, centered text.                            |
| `#ttr_sidebar`                      | Red left border (1 px).                                                      |
| `pre`                               | Courier New monospace, `greenyellow` with `!important`.                      |
| `.page-template-template-page-full-width` | Full-width override for content/sidebar (100 % width, no float). **Truncated `clear: b`** — CSS syntax error. |
| `img`                               | Responsive images (`max-width: 100%; height: auto`).                         |

---

### 1.4 Frameworks & Libraries

#### 1.4.1 Bootstrap 4.0.0

- **Location:** `css/` and `js/`
- **Files included:**
  - `bootstrap.css` / `.min.css` — full framework
  - `bootstrap-grid.css` — grid-only (unused in current templates)
  - `bootstrap-reboot.css` — CSS reset (unused directly)
  - `bootstrap.bundle.js` — includes Popper.js for dropdowns/tooltips
  - `bootstrap.js` — standalone (without Popper)
- **Loading:** `header.php` links `bootstrap.css` via `get_stylesheet_directory_uri()`.
- **JS loading:** Currently **commented out** in `header.php` — Bootstrap JS is **not loaded**, so no dropdowns, modals, or collapse.

##### Bootstrap Grid Usage

Templates use Bootstrap 4's 12-column grid system:

| Template         | Desktop (`col-lg-*`) | Tablet (`col-md-*`) | Phone (`col-sm-*` / `col-xs-*`) |
|------------------|----------------------|---------------------|---------------------------------|
| index.php        | 6 (2-col)            | 6                   | 6 / 12                          |
| single.php       | 6                    | 6                   | 6 / 12                          |
| page.php         | 12 (full)            | 12                  | 12 / 12                         |
| page-cooking.php | 4 (3-col)            | 4                   | 6 / 12                          |
| sidebar.php      | 2                    | 2                   | 4 / 12                          |

> **Note:** `col-xs-*` is Bootstrap 3 syntax; Bootstrap 4 uses `col-*` (extra-small is the default). Classes like `col-xs-12` are **ignored** in Bootstrap 4.

#### 1.4.2 Font Awesome 5.3.1 (Free)

- **Location:** `fontawesome/`
- **Contents:** CSS (`all.css`, `brands.css`, etc.), webfonts, SCSS/LESS source, SVG sprites.
- **Usage:** **Not loaded anywhere in templates** — available but inactive.

---

### 1.5 Fonts

| Font      | Source                           | Formats Available                             |
|-----------|----------------------------------|-----------------------------------------------|
| **Play**  | Google Fonts (remote `@import`)  | WOFF2, WOFF, TTF, EOT, SVG (self-hosted too)  |

- The theme imports Play from Google Fonts **and** ships local copies in `fonts/`.
- The local `@font-face` declaration is commented out, so only the Google Fonts import is active.
- Fallback stack: `'Play', Fallback, sans-serif` — `Fallback` is not a valid font name (typo/placeholder).

---

### 1.6 Images & Assets

| Asset                | Location / URL                                                                 | Purpose                              |
|----------------------|--------------------------------------------------------------------------------|--------------------------------------|
| **screenshot.png**   | Theme root                                                                     | WordPress theme preview (2516×1348)  |
| **Header background**| `https://mikelindner.com.au/wp-content/uploads/2025/04/1354689436.jpg`         | Jumbotron background (remote)        |
| **OG image**         | `http://mikelindner.com.au/wp-content/uploads/2025/04/me_pop-art-25.jpeg`      | Open Graph preview                   |
| **Favicon**          | `http://mikelindner.com.au/wp-content/uploads/2025/04/me_pop-art-25.png`       | Browser tab icon                     |
| **Apple touch icon** | Same as favicon                                                                | iOS home-screen icon                 |

All image URLs are **hardcoded absolute URLs** to the production server.

---

### 1.7 Custom PHP Functions (`index.php`)

#### `get_first_image_from_post($post_content)`

Extracts the first `<img src="…">` URL from post HTML using regex:

```php
$pattern = '/<img.*?src=["\'](.*?)["\']/i';
```

Returns the URL string or `false` if no image found.

#### `custom_truncate_content($content, $limit)`

1. Strips all HTML except `<a>` and `<video>`.
2. Truncates to `$limit` characters.
3. Trims trailing punctuation.
4. Appends "… Read more…" link if truncated.
5. Passes result through `the_content` filter.

---

### 1.8 Sidebar Widgets

`sidebar.php` is **not widget-ready** (no `dynamic_sidebar()` call). It outputs:

1. **Categories** via deprecated `wp_list_cats()` (should be `wp_list_categories()`).
2. **Archives** via `wp_get_archives()`.
3. **Leanpub embed** — hardcoded iframe for "CloudBook".

---

### 1.9 Deployment

The `deploy` script uses `rsync` to sync the theme to a remote server:

```bash
rsync -ruv --delete ~/source/litchpress/* kzs9j6@dominus:/var/www/html/wp-content/themes/litchpress
```

- `-r` recursive, `-u` update (skip newer), `-v` verbose
- `--delete` removes files on destination not in source

---

### 1.10 Development Setup

- **Composer:** `composer.json` requires `php-stubs/wordpress-stubs` (dev) for IDE autocompletion of WP functions.
- **VS Code:** `.vscode/settings.json` configures Intelephense to include stubs and sets `php.executablePath`.

---

## Part 2 — Suggestions, Bugs & Fixes

### 2.1 Bugs

| # | File                            | Issue                                                                                                       | Severity |
|---|---------------------------------|-------------------------------------------------------------------------------------------------------------|----------|
| 1 | `style.css`                     | `.page-template-template-page-full-width` rule has truncated `clear: b` — should be `clear: both;`.          | High     |
| 2 | `template-page-full-width.php`  | Calls `get_template_part('loop', 'page')` but `loop-page.php` **does not exist** — outputs nothing.          | High     |
| 3 | `sidebar.php`                   | Uses deprecated `wp_list_cats()` — replaced by `wp_list_categories()` since WP 2.1.                          | Medium   |
| 4 | `page-cooking.php`              | Contains debug string `"yeah yeah yeah"` in output.                                                          | Low      |
| 5 | `header.php`                    | Bootstrap JS `<script>` tag is commented out — interactive components (dropdowns, collapse) won't work.       | Medium   |
| 6 | `style.css`                     | Font fallback `'Play', Fallback, sans-serif` — `Fallback` is not a real font; should be a generic family.     | Low      |
| 7 | All templates                   | Uses Bootstrap 3 class `col-xs-*` which is **ignored** in Bootstrap 4 (use `col-*` instead).                  | Medium   |
| 8 | `header.php`                    | Missing `wp_head()` call — theme/plugin styles and scripts won't load properly.                              | High     |
| 9 | `header.php`                    | Hardcoded absolute URLs for CSS, images, favicon — breaks local/dev environments.                            | Medium   |
| 10| `style.css`                     | Local `@font-face` for Play has empty `src` (commented out) — no fallback if Google Fonts blocked.           | Low      |

---

### 2.2 Suggested Fixes

```php
// Bug #1 — style.css: Fix truncated CSS
.page-template-template-page-full-width .content,
.page-template-template-page-full-width .sidebar {
    width: 100%;
    float: none;
    clear: both;  /* was: clear: b */
}
```

```php
// Bug #2 — template-page-full-width.php: Replace missing template part
// Option A: Create loop-page.php with standard page loop
// Option B: Inline the loop:
<?php get_header(); ?>
<div id="ttr_main" class="row">
    <div id="ttr_content" class="col-12">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <h1><?php the_title(); ?></h1>
            <?php the_content(); ?>
        <?php endwhile; endif; ?>
    </div>
</div>
<?php get_footer(); ?>
```

```php
// Bug #3 — sidebar.php: Replace deprecated function
// Before:
<?php wp_list_cats('sort_column=namonthly'); ?>
// After:
<?php wp_list_categories(['orderby' => 'name']); ?>
```

```php
// Bug #4 — page-cooking.php: Remove debug text
<p><?php the_content(__('(more...)')); ?></p>
// Remove: yeah yeah yeah
```

```html
<!-- Bug #5 — header.php: Uncomment Bootstrap JS (before </body> ideally) -->
<script src="<?php echo get_stylesheet_directory_uri() . '/js/bootstrap.bundle.min.js'; ?>"></script>
```

```php
// Bug #8 — header.php: Add wp_head() before </head>
<?php wp_head(); ?>
</head>
```

```php
// Bug #9 — header.php: Use dynamic URLs
<link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>">
<link rel="icon" href="<?php echo get_stylesheet_directory_uri(); ?>/images/favicon.png">
```

---

### 2.3 Enhancements

| Category            | Recommendation                                                                                                                                       |
|---------------------|------------------------------------------------------------------------------------------------------------------------------------------------------|
| **Theme Functions** | Create `functions.php` to: enqueue scripts/styles properly, register sidebars, add theme support (menus, thumbnails, title-tag).                     |
| **Navigation**      | Replace hardcoded header links with `wp_nav_menu()` for admin-editable menus.                                                                        |
| **Sidebar**         | Register a widget area with `register_sidebar()` so widgets can be managed in WP admin.                                                              |
| **Featured Images** | Use `the_post_thumbnail()` instead of regex extraction — more reliable and admin-friendly.                                                           |
| **Excerpts**        | Use `the_excerpt()` or `wp_trim_words()` instead of custom truncation for cleaner code.                                                              |
| **Security**        | Escape all output: `esc_html()`, `esc_url()`, `esc_attr()` — especially dynamic URLs.                                                                |
| **Accessibility**   | Add `alt` attributes to all images, ARIA labels to navigation, skip-to-content link.                                                                 |
| **Performance**     | Load Bootstrap and Font Awesome from CDN or enqueue minified versions; consider removing unused grid/reboot CSS.                                      |
| **Font Awesome**    | Either load `fontawesome/css/all.min.css` in header or remove the directory to reduce theme size.                                                    |
| **Local Fonts**     | Enable local Play font as fallback: uncomment `@font-face` src and point to `fonts/Play-Regular.ttf`.                                                |
| **Responsive**      | Test and fix Bootstrap 4 grid classes (`col-*` instead of `col-xs-*`).                                                                               |
| **Code Cleanup**    | Remove `index.php.noblock`, commented code, and debug strings before production.                                                                     |
| **Child Theme**     | If extending, create a child theme to preserve customizations across updates.                                                                        |

---

### 2.4 Quick-Start Checklist

- [ ] Fix `clear: both;` in `style.css`
- [ ] Create `loop-page.php` or fix `template-page-full-width.php`
- [ ] Replace `wp_list_cats()` with `wp_list_categories()`
- [ ] Remove debug text from `page-cooking.php`
- [ ] Add `<?php wp_head(); ?>` before `</head>`
- [ ] Uncomment/add Bootstrap JS before `</body>`
- [ ] Replace hardcoded URLs with `get_stylesheet_directory_uri()`
- [ ] Create `functions.php` for proper asset enqueuing
- [ ] Replace `col-xs-*` with `col-*`

---

## License

Custom license: "Screw You Hippy" — consult author for usage terms.

## Author

**Mike Lindner**  
[mikelindner.com.au](https://mikelindner.com.au) · [GitHub](https://github.com/MikeLindner/litchpress)
