# DevMap - Where are the dev seeking for a job?

## Description

This is a web application that allows users to create a profile and share their location with other developers. Users can also view other
developers' profiles and locations. This only private data required is the user's email address. This email address is used to create a
unique user account, activate/deactivate your status (open to work or not) and is not shared with other users. It will be encrypted in the
database. Your location is shared with other users and is not encrypted. Only a zipcode is asked for and is used to display your location on
a map.

## Table of Contents

-   [stack](#stack)
-   [Installation](#installation)
-   [Usage](#usage)
-   [License](#license)
-   [Contribute](#contribute)
-   [Tests](#tests)
-   [Questions](#questions)

## Stack

### Front-end stack

-   Svelte
-   Sass
-   Mapbox
-   Leaflet
-   Json-server (for testing purposes)

### Back-end stack

-   Symfony
-   Doctrine
-   MySQL

## Installation

### Front-end install

```bash
cd front
npm install
```

### Back-end install

```bash
cd back-api
composer install
```

## Configuration

### Front-end config

```bash
cd front
cd src/config/config.js
```

### Back-end config

```bash
cd back-api
cd .env
# Configure your database connection
# Configure your mailer connection
```

```bash
# Create database
php bin/console doctrine:database:create

# Create tables
php bin/console doctrine:migrations:migrate

# Load fixtures
php bin/console doctrine:fixtures:load

# Start server
symfony serve
```

## Usage

### Front-end usage

```bash
cd front
npm run dev -- --open
```

### Back-end usage

```bash
cd back-api
symfony serve
```

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details.

## Contribute

Please read [CONTRIBUTING.md](CONTRIBUTING.md) for details on our code of conduct, and the process for submitting pull requests.

## Tests

## Questions

If you have any questions, please open an issue or contact [Anørak](https://discord.gg/JMWQyspS).
