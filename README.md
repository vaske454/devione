# Word Game Web Application

This is a simple web application for playing a word game. The user can enter a word, and the application will score it based on certain rules.

## Prerequisites

Before getting started, make sure you have the following installed:

- [Docker](https://docs.docker.com/engine/install/)
- [DDEV](https://ddev.readthedocs.io/en/stable/#installation)

## Get started

1. Clone this repository to your computer by running the following command:
```
git clone git@github.com:vaske454/devione.git
```
2. Navigate to the project's root directory and initiate it by running
```
ddev start
```
3. Install all required Composer dependencies:

```
ddev composer install
```
4. Then, generate a key for your application by running this command:
```
ddev exec "php artisan key:generate"
```
5. Execute Laravel migrations to create the database:
```
ddev artisan migrate
```

6. To install the necessary dependencies, run:

```bash
npm install
```

## Usage

To run the application in development mode, use:

```bash
npm run dev
```
This command will start the development server. You can then access the application in your web browser.
