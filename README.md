# Project Management App

Aplikasi manajemen proyek internal berbasis web yang dibangun dengan Laravel 12. Sistem ini memungkinkan tim untuk mengelola proyek, tugas, dan anggota tim dengan kontrol akses berbasis peran.

## Fitur Utama

- Autentikasi (login, register, logout)
- Authorization berbasis role (admin/member) dan kepemilikan
- Manajemen proyek (CRUD)
- Manajemen tugas dalam proyek (CRUD)
- Sistem member per proyek
- Filter & pencarian proyek dan tugas

## Cara Instalasi

### Prasyarat
- PHP >= 8.2
- Composer
- MySQL
- Node.js & NPM

### Langkah Instalasi

1. Clone repository
```bash
   git clone https://github.com/fillahalwy/project-management-app.git
   cd project-management-app
```

2. Install dependencies
```bash
   composer install
   npm install
```

3. Konfigurasi environment
```bash
   cp .env.example .env
   php artisan key:generate
```

4. Atur konfigurasi database di file `.env`
```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=project_management
   DB_USERNAME=root
   DB_PASSWORD=
```

5. Jalankan migration dan seeder
```bash
   php artisan migrate --seed
```

6. Build assets
```bash
   npm run build
```

## Cara Menjalankan
```bash
php artisan serve
```

Buka browser dan akses `http://localhost:8000`

### Akun Default (dari Seeder)

| Role   | Email                  | Password |
|--------|------------------------|----------|
| Admin  | atmin@mail.com         | password |
| Member | member1@mail.com       | password |
| Member | member2@mail.com       | password |

## Arsitektur Aplikasi

Aplikasi ini mengikuti pola arsitektur **MVC (Model-View-Controller)** bawaan Laravel.
```
app/
├── Http/
│   ├── Controllers/     # Menangani request dan response
│   ├── Requests/        # Form validation (StoreProjectRequest, dll)
│   └── Middleware/      # Filter request
├── Models/              # Eloquent ORM (Project, Task, User)
└── Policies/            # Authorization rules (ProjectPolicy, TaskPolicy)

database/
├── migrations/          # Skema database
└── seeders/             # Data awal

resources/views/
├── layouts/             # Master layout
├── components/          # Reusable Blade components (badge, input-error, dll)
├── projects/            # Views untuk project (index, show, create, edit)
└── tasks/               # Views untuk task (create, edit)
```

### Relasi Database

- `User` has many `Project` (sebagai owner)
- `Project` has many `Task`
- `Project` ↔ `User` many-to-many (via tabel `project_members`)
- `Task` belongs to `User` (sebagai assignee, nullable)
