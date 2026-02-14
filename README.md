<div style="
    margin: 2rem auto;
    padding: 1.5rem 2rem;
    border: 1px solid #e0e0e0;
    border-radius: 12px;
    text-align: center;
">
  <h1 style="
      font-size: 2rem;
      font-weight: 700;
      margin-bottom: 0.5rem;
      letter-spacing: 0.5px;
  ">
    Todo List Application ✒️
  </h1>
  <p style="
      font-size: 0.95rem;
      color: #666666;
  ">
    Simple, lightweight task manager
  </p>
</div>


<div style="
    display: flex;
    flex-direction: column;
    gap: 0.3rem;
    ">

<details 
  style="
    border:1px solid #ccc;
    border-radius:8px;
  "
>
  <summary 
    style="
      list-style:none;
      padding:1rem;
      cursor:pointer;
      width:100%;
    "
  >
    <b>Overview</b>
  </summary>

<div style="padding: 0 2rem 2rem;">

  ### Description
  A RESTful Todo API built with Laravel 12, featuring user authentication via Laravel Sanctum and a clean, repository-based architecture. The application provides complete CRUD operations for todo items with advanced features like filtering, search, statistics, and task completion tracking. The entire development environment runs in Docker containers via Laravel Sail for consistent, portable development.

  ### Technologies Used

  **Backend Framework & Core**
  - PHP 8.2+ (currently 8.5.2)
  - Laravel Framework 12.0
  - Laravel Sanctum 4.0 (API Authentication)

  **Database & ORM**
  - MySQL 8.4
  - Eloquent ORM
  - Database migrations & seeders

  **Development Tools**
  - Laravel Sail 1.53 (Docker development environment)
  - Adminer (Web-based database management)

  **Testing & Quality**
  - Pest Laravel

  **DevOps & Infrastructure**
  - Docker & Docker Compose

  ### Project Structure
  ```
  app/
  ├── Features/
  │   ├── Auth/
  │   │   └── Controllers/AuthController.php
  │   └── Todo/
  │       ├── Models/Todo.php
  │       ├── Repositories/TodoRepository.php
  │       ├── Exceptions/
  │       │   ├── TodoNotFoundException.php
  │       │   ├── TodoCreateException.php
  │       │   ├── TodoUpdateException.php
  │       │   └── TodoDeleteException.php
  │       └── Resources/
  │           └── (API Resources)
  docker-compose.yml
  vendor/laravel/sail/
  ```

  **Architecture Pattern**: Feature-based organization may feel like overhead at first, but as the project grows and becomes more complex, it makes navigation significantly easier

  ### Docker Services

  **Application Container (sail-8.5/app)**
  - PHP 8.5 runtime
  - Laravel application server
  - Exposed ports: 80 (HTTP)

  **MySQL 8.4**
  - Primary database service
  - Exposed port: 3306

  **Adminer**
  - Web-based database management UI
  - Exposed port: 8082
  </div>
</details>

<details 
  style="
    border:1px solid #ccc;
    border-radius:8px;
  "
>
  <summary 
    style="
      list-style:none;
      padding:1rem;
      cursor:pointer;
      width:100%;
    "
  >
  <b>Setup</b>
</summary>


<div style="padding: 0 2rem 2rem;">

  ### Installation

  A Laravel-based TODO list application with Docker support via Laravel Sail.

  ## Prerequisites

  - Git
  - Docker Desktop
  - WSL 2 (for Windows users)
  - Composer

  ## Setup Instructions

  ### 1. Clone the Repository

  ```bash
  git clone <repository-url>
  cd todo-list-application
  ```

  ### 2. Install Dependencies

  Open your terminal (CMD, Git Bash, or your preferred terminal) in the project folder and run:

  ```bash
  composer install
  ```

  ### 3. Configure Environment

  Create a `.env` file from the example:

  ```bash
  # Windows (CMD)
  copy .env.example .env

  # Linux/Mac/Git Bash
  cp .env.example .env
  ```

  ### 4. Generate Application Key

  ```bash
  php artisan key:generate
  ```

  ### 5. Configure Database

  Open the `.env` file and update the database variables if needed, especially fill the password:

  ```env
  DB_CONNECTION=mysql
  DB_HOST=mysql
  DB_PORT=3306
  DB_DATABASE=todo_list_application
  DB_USERNAME=sail
  DB_PASSWORD=password
  ```

  ### 6. Start Docker Environment

  1. Start Docker Desktop
  2. Open WSL command line as administrator
  3. Navigate to your project folder from the Linux environment:

  ```bash
  cd /mnt/c/Users/Adam/Desktop/todo-list-application
  ```

  *(Adjust the path to match your project location)*

  ### 7. Configure Sail Alias (Optional)

  To simplify commands, create an alias:

  ```bash
  alias sail='sh $([ -f sail ] && echo sail || echo vendor/bin/sail)'
  ```

  Now you can use `sail` instead of `./vendor/bin/sail`.

  ### 8. Start the Application

  ```bash
  sail up -d
  ```

  ### 9. Run Database Migrations

  ```bash
  sail artisan migrate
  ```

  This will create the `todo_list_application` database and run all migrations.

  ### 10. Access the Database (Optional)

  **Via Adminer:**
  - URL: http://localhost:8082/
  - System: MySQL
  - Server: mysql
  - Username: sail
  - Password: password
  - Database: todo_list_application

  Alternatively, you can use your IDE's database integration tools.

  ### 11. Test the API

  Import the included Postman collection and:
  1. Register a new user
  2. Test the available endpoints

  ## Troubleshooting

  - Ensure Docker Desktop is running before executing `sail up` and you have enabled WSL in docker Settings->Resources->WSL integration
  - Make sure ports 80, 3306, and 8082 are not in use by other applications
  - If migrations fail, verify your database credentials in `.env`
  </div>

</details>

<details 
  style="
    border:1px solid #ccc;
    border-radius:8px;
  "
>
  <summary 
    style="
      list-style:none;
      padding:1rem;
      cursor:pointer;
      width:100%;
    "
  ><b>Design Decisions & Trade-offs</b></summary>
<br>

<div style="padding: 0 2rem 2rem;">

  **Repository for todo model**
  - **Decision**: Implemented repository layer (`TodoRepository`) to extract database operations to single class
  - **Trade-off**: Model is already implementing repository so it might seems like overengeneering
  - **Benefit**: Database operations are handled in single class where we can add logic for complex queries /throw exceptions etc.

  **Custom Exception Handling**
  - **Decision**: Domain-specific exceptions (`TodoNotFoundException`, `TodoCreateException`, etc.)
  - **Trade-off**: More classes to maintain
  - **Benefit**: Clear, actionable and granular error handling and responses for API consumers

  **Manual Model Finding**
  - **Decision**: Avoided Route Model Binding, using manual `find()` in repository
  - **Trade-off**: More verbose code
  - **Benefit**: Better control over error handling, especially in cases where the model cannot be found. More flexible in the future.

  **Docker-based Development**
  - **Decision**: Laravel Sail for containerized environment
  - **Trade-off**: Docker overhead
  - **Benefit**: Eliminates "works on my machine" issues, includes all services (MySQL, Adminer) so its easier to deploy (environment consistency)
  </div>
</details>

<details 
  style="
    border:1px solid #ccc;
    border-radius:8px;
  "
>
  <summary 
    style="
      list-style:none;
      padding:1rem;
      cursor:pointer;
      width:100%;
    "
  ><b>Future Improvements</b></summary>
<br>

<div style="padding: 0 2rem 2rem;">

  **API Architecture**
  - Create `UserResource` for consistent user data serialization
  - `TodoResource` could be improved by allowing to return only the data needed for each endpoint
  - Implement API versioning (e.g., `/api/v1/todos`)

  **Code Organization**
  - Split `routes/api.php` into feature-specific route files (e.g., `routes/api/todos.php`, `routes/api/auth.php`)
  - Add IDE autocomplete support for custom `ResourceCollection` macro methods

  **Security & Performance**
  - Custom rate limiter for login route combining email + IP address (prevent credential stuffing)
  - Only for consideration - implement full-text search using MySQL full-text indexes or Laravel Scout instead of LIKE queries
  - Add caching for frequently accessed endpoints using Redis/Valkey

  **Developer Experience**
  - Integrate API documentation tool (e.g., Scribe, Apiary, or OpenAPI/Swagger)
  - Implement Sentry for database error tracking and query logging

  **Testing & Quality**
  - Increase test coverage
  - Implement CI/CD pipeline with automated testing (GitHub Actions/Gitlab CI/CD)

  </div>

</details>

<details 
  style="
    border:1px solid #ccc;
    border-radius:8px;
  "
>
  <summary 
    style="
      list-style:none;
      padding:1rem;
      cursor:pointer;
      width:100%;
    "
  ><b>API Documentation</b></summary>
<br>

<div style="padding: 0 2rem 2rem;">

  **Included in the project: `postman/collections/todo-list-application.postman_collection.json`**

  </div>

</details>
</div>