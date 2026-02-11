<p align="center">
  <h1 align="center" style="color: #FF2D20; font-size: 48px; font-weight: bold;">
    📝 Todo List Application
  </h1>
</p>

<details>
<summary><b>SETUP</b></summary>

### Prerequisites

- Docker & Docker Compose
- Git

### Installation

1. **Clone the repository**
```bash
git clone 
cd todo-list-application
```

2. **Copy environment file**
```bash
cp .env.example .env
```

3. **Start Docker containers**
```bash
./vendor/bin/sail up -d
```

4. **Install dependencies**
```bash
./vendor/bin/sail composer install
```

5. **Generate application key**
```bash
./vendor/bin/sail artisan key:generate
```

6. **Run migrations**
```bash
./vendor/bin/sail artisan migrate
```

7. **Access the application**
- Application: http://localhost
- Adminer (Database): http://localhost:8082

</details>