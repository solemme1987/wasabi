# ADK Dockerized Wordpress

Set up a local Linux/Apache/Mysql/PHP/Wordpress environment using the WordPress official Docker image.

```
Apache: 2.4
MySQL: 5.7
PHP: 7.2
Wordpress: 5.4.x
WP-CLI
```

Start a new project with the included `adk` theme, or migrate an existing repository to docker.

__You should not be tracking commits intended for another project on this repo.__

## Getting Started

If you're starting a new project, or migrating an existing project, make sure you remove the `.git` folder and initialize git for **your new repo**.

### Initialize Repo & Version Control:

```bash
$ rm -rf .git
$ git init
```

## Remote environments

Make sure at least one environment is configured on /web/code/config/remote.site.yml

An example with a _dev_ environment would look like this:

```
# File: remote.site.yml
dev:
  host: adkalpha.com
  user: alpha
  root: /var/www/vhosts/adkalpha.com/staging/alpha-site
  alias: alpha-site
```

#### `wp-config.php`

Wordpress will use the connection values defined in the `docker-compose.yml` file. If you need to define some WordPress setting in the `wp-config.php` file add it in a new line below the `WORDPRESS_CONFIG_EXTRA` environment variable like this:

```
- WORDPRESS_CONFIG_EXTRA=
    define('WP_HOME', 'http://localhost:8000/');
    define('WP_SITEURL', 'http://localhost:8000/');
```

## Database Management

Bash scripts to manage the database of this docker set up are included in the `/commands` directory. Run the following commands from the root directory of the repo.

#### Sync

```
sh commands/sync-db.sh <ENVIRONMENT NAME>
```

Import a remote database into your docker mysql instance (local database) from an environment defined in the `remote.site.yml` file. Taking the previous file example the command to sync from the `dev` environment would be:

```
sh commands/sync-db.sh dev
```

#### Import (requires SQL Dump)

```
bash commands/import-db.sh <PATH TO YOUR SQL DUMP>
```

Keep your large database dump files outside of this repo for security reasons and also in order to minimize the build time for Docker.

#### Backup:

```
bash commands/backup-db.sh
```

Create a **time-stamped backup** of your *current database*.

This should create a new time-stamped backup on the `mysql/mounted/backups` folder.

#### MYSQL error logs:

These can be viewed inside the **mysql/mounted/logs/** folder.


## Start the Docker Containers

Before you try to start the containers, make sure that all your settings steps are done.

```
git clone the repo
cd <Your cloned folder>
docker-compose up --build
```

 If you are using a mac, ensure you are sharing the project folder in the Docker sharing tab under preferences.

 If you go to **http://localhost:8000/** you should see a **phpinfo** index.

## Wordpress Installation

- `web/code/wp-content`

The Wordpress core files and install are configured in the `Dockerfile` inside the web folder. Add the site theme, plugins, uploads, etc to the `wp-content` directory.

### Installing a new local site

For new sites, plugins and uploads folders are ignored from the repo to avoid being tracked. If you need to setup a new site you can run the command

`sh commands/wp-init.sh`

This command will install a default Wordpress site, remove default unused plugin and themes and set the `adk` theme as active. It will show an output like this:

```
Admin password: <RANDOM PASSWORD VALUE>
Success: WordPress installed successfully.
...
```

The WordPress admin credentials then would be:

```
Username: theadkgroup
Password: <RANDOM PASSWORD VALUE>
```
### Installing from a remote site

There are three bash script commands that allow to sync a website from an environmet defined on `remotes.sites.yml`. These commands are:

__To sync the database__

```
sh commands/sync-db.sh <ENVIRONMENT NAME>
```

__To sync the plugins folder__

```
sh commands/sync-plugins.sh <ENVIRONMENT NAME>
```

__To sync the uploads folder__
```
sh commands/sync-uploads.sh <ENVIRONMENT NAME>
```

Note: If an <ENVIRONMENT NAME> is not passed, the default `dev` will be used. 
Taking the previous remote sites file example to install the site from the `dev` environment you would have run these three commands:
```
sh commands/sync-db.sh dev
sh commands/sync-plugins.sh dev
sh commands/sync-uploads.sh dev
```

## Wordpress Theme

The `adk` starter theme has been included in this repo. If you are migrating an existing project, __please remove this theme__.  Otherwise, please read the theme's Readme to begin a new project.

[ADK Theme Readme](https://bitbucket.org/adkgroup/dockerized-wordpress/src/master/web/code/wp-content/themes/adk/README.md)
