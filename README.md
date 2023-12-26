# Larablog - Laravel 10 CRUD Blog with Service Repository Pattern

Larablog is a simple CRUD blog application built with Laravel 10, incorporating the Service Repository pattern for efficient data handling. This project provides basic functionalities for managing blog posts, including creation, editing, trashing, restoring, and permanent deletion.

## Features

- **Create:** Easily add new blog posts.
- **Read:** View and explore blog posts with detailed information.
- **Update:** Edit and update existing blog posts seamlessly.
- **Delete:** Move posts to trash, restore from trash, or permanently delete them.
- **List:** Display a list of published blog posts.
- **Search:** Search for specific posts based on title or category.
- **Pagination:** Navigate through blog posts with a paginated interface.

## Technologies Used

- Laravel 10
- MySQL

## Installation

1. Clone the repository: `git clone https://github.com/shofistwn/larablog.git`
2. Navigate to the project directory: `cd larablog`
3. Install dependencies: `composer install`
4. Create a copy of the `.env` file: `cp .env.example .env`
5. Generate the application key: `php artisan key:generate`
6. Set up your database in the `.env` file.
7. Run migrations: `php artisan migrate`
8. Start the development server: `php artisan serve`

## Configuration

- If you need to customize any configuration settings, refer to the `.env` file for options such as database connection details and application settings.

## Usage

- Access the Larablog application by visiting `http://localhost:8000` in your web browser.
- Explore the CRUD functionalities for managing your blog posts.

## Template Credits

This project uses the [Stisla](https://github.com/stisla/stisla) Bootstrap template for the user interface.

## Credits

Larablog is developed by [Shofi Setiawan](https://github.com/shofistwn). Feel free to contribute or report issues.

## License

This project is open-source and available under the [MIT License](LICENSE).
