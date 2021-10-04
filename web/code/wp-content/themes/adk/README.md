## ADK Theme Overview

Read this documentation to learn about the theme architecture and development workflow.

### Table of Contents

1. Local Development
2. Wordpress Architecture
3. SCSS & Assets
4. Development & Build Tooling
5. Installation & Getting Started

### 1.0 Local Development

Docker is the preferred local development environment.  `docker-compose.yml` contains the necessary containers to get started.

- WP Install
- php
- mysql
- phpMyAdmin

Visit `localhost:8000` to access the site.

Visit `localhost:8888` to access phpMyAdmin

### 2.0 Theme structure `wp-content/themes/adk`

__All dev frond end work should be done in `adk/src`__

* /fonts
* /img
* /js
	* /helpers
	* /components
    * /component.js
	* /pages
		* page.js
* /pages
	* /components
    * /component.php
	* /partials
    * /header.php
    * /nav.php
    * /footer.php
	* templates.php
* /scss
	* /components
	* /generic
	* /objects
	* /settings
	* /tools
	* /utilities
	* main.scss

__Custom theme development `adk/inc`__

* /acf
	* /json-sync ---------> `ACF groups get saved here. One json file per group`
		* field_group.json
    * index.php --------> `ACF related functions`
* /api
* /post-types ----------> `Register custom post types by adding theme in here. One per json file`
	* post_type.json
* /taxonomies ----------> `Register custom taxonomies by adding theme in here. One per json file`
	* taxonomy.json
* assemble.php ---------> `Contains functions that put template parts together to form pages`
* custom.php -----------> `Add your custom functions here`
* enqueue.php ----------> `Register/Enqueue your external custom style/scripts here`
* images.php -----------> `Register your custom image sizes here`
* unit.php -------------> `Contains functions that register your custom post types and taxonomies and menus`
* modify.php -------------> `Functions that modify default WP installation`
* utils.php ------------> `Built-in Helper functions`

### 2.1 Custom Post Types and Taxonomies
* Each custom post type should be defined using a json file and saved in the `adk/inc/post-type/` folder.
* Follow the format on the example text file located on the same folder.
* Custom taxonomies are defined similar to post types but saved on the `adk/inc/taxonomies/` folder.
* An example text file is also included for custom taxonomies.
* The name given to the json file will be the name used to register the custom post type or taxonomy. Names should not contain spaces and
words should be separated by an underscore (_)
* For more information visit [WP Post Types](https://codex.wordpress.org/Post_Types) and [WP Taxonomies](https://codex.wordpress.org/Taxonomies)

### 2.2 Advance Custom Fields
* The theme comes with json-sync support which automatically saves custom fields groups that are added/updated/deleted through the wordpress admin.
* ACF fields should be added locally on you admin panel, committed to the repo, and deployed to server.
* Once the json files have been added/updated/deleted and pushed to the sever, the field groups must be synced in the remote WP admin so the changes can be integrated in the DB.
* Field groups can be synced from the ACF admin edit screen.

### 2.3 Routing

- WP theme files to manage the site routes.
- Instead of rendering HTML with PHP in WP template files, call the `assemble_template()` function and pass in a corresponding template in `/src/pages`.

### 2.4 Template Naming Convention

Files should be named using `camelCase` convention.  For example, a custom post type of `product`:

`adk/taxonomy-product.php` should call:

- `src/pages/productCategories.php`
- `src/js/pages/productCategories.js`
- `src/scss/pages/_productCategories.scss`

### 2.5 Functions & Includes

- PHP functions are located in `functions.php` and should `require()` files in `/inc`.
- Make sure to properly enqueue files in `enqueue.php`

### 3.0 SCSS

The theme uses the IOTA CSS framework and BEM for naming convention. SCSS files should be imported into `src/scss/style.scss`.

### 3.1 Fonts & Assets

- Add fonts to `src/fonts`.
- Add static assets to `src/img`.

### 4.0 Development & Build Tooling

Webpack (v4) is used for build tooling:
- HMR for SCSS files
- Reload for JS and HTML/PHP
- dev server
- pre-process files
- create an optimized production build

By default, the theme enqueues files from the `/dist` directory in `inc/enqueue.php`.

> Start the webpack dev server and build the `/dist` directory

```bash
$ cd wp-content/themes/adk
$ npm run dev
```

> Build the `/dist` directory for production (filled with the optimized code & assets).

```bash
$ cd wp-content/themes/adk
$ npm run build
```

When linking to assets, use the `$theme_dir_uri` (defined in `functions.php`) variable as it will link to the appropriate path.

### 4.1 Updating from old webpack config
When updating an old webpack config please make sure you are doing it on a feature branch.
Once is confirmed that everything is working as expected, merge back into dev.

1. Copy and replace the entire `theme/config` folder 
2. Open the `env.config.js` found in the config folder and update the `THEME_NAME` property to the projects theme folder name
3. Merge the following files ensuring no conflicts or duplicated properties/rules are present. New file settings should have priority over existing ones.
  * .babelrc
  * .eslintrc
  * .stylelintrc
4. Merge devDpendencies found in `package.json`. Newer package versions should have priority.
5. Copy and replace the npm scripts found in `package.json`
6. Open up the PHP file `theme/inc/enqueue.php` and update the following:
```bash
$styleCSS = asset_file_name('style.css');
```
to
```bash
$styleCSS = asset_file_name('global.css');
```
7. Delete the `node_modules` folder and `package-lock.json` file
8. Run `npm i` and then `npm run dev`

### 5.0 Installation & Getting Started

```bash
$ cd wp-content/themes/adk
$ npm install
$ npm run dev
```

- Rename any instances of `adk` to your new theme name.
