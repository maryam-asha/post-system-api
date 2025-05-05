Laravel Blog Post API
This is a Laravel-based RESTful API for managing blog posts. It provides endpoints to create, read, update, and delete posts, with support for fields like title, slug, body, publication status, tags, and keywords. The API uses Laravel's Eloquent ORM, resource controllers, and validation to ensure robust and secure operations.
Table of Contents

Features
Prerequisites
Installation
Configuration
Database Schema
API Endpoints
Validation Rules
Testing
Troubleshooting
Contributing
License

Features

CRUD Operations: Create, read, update, and delete blog posts.
Pagination: Retrieve posts with pagination (5 posts per page).
JSON Responses: All endpoints return JSON with status, data, and messages.
Validation: Robust input validation using Laravel Form Requests.
JSON Tags: Store and retrieve tags as a JSON array.
Resource Transformation: Use PostResource for consistent API responses.
Implicit Model Binding: Automatically resolve Post models from route parameters.

Prerequisites

PHP >= 8.0
Composer
MySQL 5.7+ (or another compatible database)
Laravel 8.x or later
Postman (for testing API endpoints)
Git

Installation

Clone the Repository:
git clone <repository-url>
cd <repository-directory>


Install Dependencies:
composer install


Copy Environment File:
cp .env.example .env


Generate Application Key:
php artisan key:generate


Configure Environment:

Open .env and set your database credentials:DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_blog
DB_USERNAME=root
DB_PASSWORD=




Run Migrations:
php artisan migrate


Start the Development Server:
php artisan serve

The API will be available at http://localhost:8000.


Method
Endpoint
Description
Request Body/Example



GET
/
List posts (paginated)
None


GET
/{post}
Show a single post
None


POST
/
Create a new post
See Create Post Example


PUT
/{post}
Update an existing post
See Update Post Example


DELETE
/{post}
Delete a post
None

