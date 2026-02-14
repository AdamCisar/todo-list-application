<p align="center">
  <h1 align="center" style="color: #FF2D20; font-size: 48px; font-weight: bold;">
    📝 Todo List Application
  </h1>
</p>

<details>
<summary><b>SETUP</b></summary>


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

</details>