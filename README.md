# epic.vn

## Require enviroiment
1. Docksal (https://docksal.io/)
2. Prepros (https://prepros.io/)
3. WP CLI (https://wp-cli.org/)
4. Composer (https://getcomposer.org/)

## Install project
1. Initialize the environment: `fin up`
2. Import database: `fin sqli path-to-database.sql`
3. Update option siteurl: `wp option update siteurl "my-local-site.example"`
4. Update option home: `wp option update home "my-local-site.example"`
5. Download and active Stage File Proxy plugin: `wp plugin install stage-file-proxy --activate`
6. Go to setting Stage File Proxy page: `/wp-admin/options-general.php?page=stage-file-proxy`
7. Add `Source Domain` is `http://www.exportkontrollforeningen.se/` and `Method` is `Redirect`
8. In the ROOT folder, create `wp-config-local.php` file with:
```
// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'default' );
/** MySQL database username */
define( 'DB_USER', 'user' );
/** MySQL database password */
define( 'DB_PASSWORD', 'user' );
/** MySQL hostname */
define( 'DB_HOST', 'db' );
/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );
/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );
```
## Install theme
1. In the THEME folder, run: `composer install`
2. Enable `FFW theme` on Appearance/themes page

## Deploy to pantheon env
1. `cd deploy`
2. run: `sh deploy-to-pantheon.sh`
