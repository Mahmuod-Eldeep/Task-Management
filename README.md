# Task Management

This application is a task management API built using Laravel.

## Prerequisites

- PHP 8.0 or higher
- Composer
- MySQL
- Laravel CLI

## Setup Steps

1. Clone the repository:
   \`\`\`
   git clone https://github.com/Mahmuod-Eldeep/Task-Management
   cd Task-Management
   \`\`\`

2. Install dependencies:
   \`\`\`
   composer install
   \`\`\`

3. Create environment file:
   \`\`\`
   cp .env.example .env
   \`\`\`

4. Modify the \`.env\` file and add your database details:
   \`\`\`
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_database_username
   DB_PASSWORD=your_database_password
   \`\`\`

5. Generate application key:
   \`\`\`
   php artisan key:generate
   \`\`\`

6. Run migrations and seed initial data:
   \`\`\`
   php artisan migrate --seed
   \`\`\`

## Running the Application

To run the application locally, use the following command:

\`\`\`
php artisan serve
\`\`\`

The application will be available at \`http://localhost:8000\`.

## Basic Usage

- Register: \`POST /api/register\`
- Login: \`POST /api/login\`
- Create a new task: \`POST /api/tasks\`
- Get list of tasks: \`GET /api/tasks\`
- Update a task: \`PUT /api/tasks/{task_id}\`
- Add dependency to a task: \`POST /api/tasks/{task_id}/dependencies\`

Make sure to include the authentication token in the request header to access protected endpoints.

## Entity-Relationship Diagram (ERD)


Below is the Entity-Relationship Diagram for the Task Management System:


\`\`\`mermaid
erDiagram
    User ||--o{ Task : "is assigned to"
    User ||--o{ Role : "has"
    Task ||--o{ TaskDependency : "has"
    Task ||--o{ TaskDependency : "depends on"
    Task {
        int id PK
        string title
        text description
        int assignee_id FK
        date due_date
        enum status
        timestamp created_at
        timestamp updated_at
    }
    User {
        int id PK
        string name
        string email
        string password
        timestamp created_at
        timestamp updated_at
    }
    Role {
        int id PK
        string name
        timestamp created_at
        timestamp updated_at
    }
    TaskDependency {
        int id PK
        int task_id FK
        int dependency_id FK
        timestamp created_at
        timestamp updated_at
    }

\`\`\`





## Contributing

If you'd like to contribute to this project, please create a new branch and submit a pull request with your proposed changes.


