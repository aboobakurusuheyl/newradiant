# New Radiant Sports Club - Academy Management System

A comprehensive football club website and academy management system built with Laravel 11 (REST API) and Vue 3 (Frontend SPA). Features a public homepage and a private Academy Portal for students, parents, and coaches.

## 🏆 About New Radiant Sports Club

New Radiant Sports Club is a premier football club from the Maldives, founded in 1979. The club has a rich history of success in Maldivian football, including multiple Dhivehi Premier League titles and FA Cup victories. Our academy program develops young talent and provides comprehensive training for all age groups.

## 🚀 Features

### Public Website

-   **Modern Homepage**: Real Madrid-inspired design with club information, news, and fixtures
-   **Club Information**: History, achievements, stadium details, and coaching staff
-   **News & Announcements**: Latest club updates and academy news
-   **Fixtures & Results**: Upcoming matches and recent results
-   **Academy Highlight**: Information about youth development programs

### Academy Portal (Private)

-   **Multi-Role System**: Admin, Coach, Student, and Parent access levels
-   **Student Management**: Complete CRUD operations for student profiles
-   **Enrollment System**: Multi-step enrollment with payment integration
-   **Payment Management**: Payment requests, receipt upload, and verification
-   **Schedule Management**: Training sessions and match scheduling
-   **Progress Tracking**: Coach ratings and student progress reports
-   **Parent Dashboard**: Comprehensive overview of children's status and payments

## 🛠️ Tech Stack

### Backend

-   **Laravel 11**: REST API framework
-   **Laravel Sanctum**: API authentication
-   **SQLite**: Database (easily configurable for MySQL/PostgreSQL)
-   **File Storage**: Receipt and document management

### Frontend

-   **Vue 3**: Progressive JavaScript framework
-   **Vite**: Build tool and development server
-   **TailwindCSS**: Utility-first CSS framework
-   **Vue Router**: Client-side routing
-   **Pinia**: State management
-   **Axios**: HTTP client

## 📋 Prerequisites

-   PHP 8.2 or higher
-   Composer
-   Node.js 18+ and npm/yarn
-   SQLite (or MySQL/PostgreSQL)

## 🚀 Installation

### 1. Clone the Repository

```bash
git clone <repository-url>
cd newradiant
```

### 2. Install Backend Dependencies

```bash
composer install
```

### 3. Install Frontend Dependencies

```bash
npm install
# or
yarn install
```

### 4. Environment Setup

```bash
cp .env.example .env
php artisan key:generate
```

### 5. Database Setup

```bash
# Run migrations
php artisan migrate

# Seed the database with sample data
php artisan db:seed
```

### 6. Storage Setup

```bash
php artisan storage:link
```

### 7. Build Frontend Assets

```bash
# Development
npm run dev

# Production
npm run build
```

### 8. Start the Application

```bash
# Start Laravel server
php artisan serve

# In another terminal, start Vite (for development)
npm run dev
```

The application will be available at `http://localhost:8000`

## 🔐 Demo Login Credentials

### Admin Account

-   **Email**: admin@newradiant.mv
-   **Password**: password
-   **Role**: Admin
-   **Access**: Full system access, student management, payment verification

### Coach Account

-   **Email**: coach@newradiant.mv
-   **Password**: password
-   **Role**: Coach
-   **Access**: Student management, schedule creation, progress tracking

### Parent Account

-   **Email**: parent@newradiant.mv
-   **Password**: password
-   **Role**: Parent
-   **Access**: Child enrollment, payment management, progress viewing

### Student Account

-   **Email**: student@newradiant.mv
-   **Password**: password
-   **Role**: Student
-   **Access**: View schedules, progress reports, academy news

## 🧪 Testing the Application

### 1. Public Website Testing

1. Visit `http://localhost:8000`
2. Browse the homepage sections
3. Check navigation menu functionality
4. View news and fixtures sections

### 2. Academy Portal Testing

#### Parent Workflow

1. Login with parent credentials
2. **Enroll a Child**:
    - Go to "Enroll New Child"
    - Fill out the 4-step enrollment form
    - Include payment details and upload receipt
    - Submit enrollment
3. **View Children**:
    - Check "My Children" page
    - View enrollment status and payment information
4. **Dashboard**:
    - Review children overview
    - Check payment status
    - View recent activity

#### Admin/Coach Workflow

1. Login with admin or coach credentials
2. **Student Management**:
    - View all students in "Students" section
    - Request payment for pending students
    - Approve students after payment verification
    - Assign coaches to approved students
3. **Payment Management**:
    - Review payment requests
    - Verify payment receipts
    - Track payment status

### 3. API Testing

Use tools like Postman or curl to test API endpoints:

```bash
# Get public news
curl http://localhost:8000/api/news

# Login (get token)
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@newradiant.mv","password":"password"}'

# Get students (with token)
curl http://localhost:8000/api/students \
  -H "Authorization: Bearer YOUR_TOKEN"
```

## 📁 Project Structure

```
newradiant/
├── app/
│   ├── Http/Controllers/Api/     # API controllers
│   ├── Models/                   # Eloquent models
│   └── Http/Middleware/          # Custom middleware
├── database/
│   ├── migrations/               # Database migrations
│   └── seeders/                  # Database seeders
├── resources/
│   ├── js/                       # Vue.js frontend
│   │   ├── components/           # Vue components
│   │   ├── views/                # Page components
│   │   ├── stores/               # Pinia stores
│   │   └── services/             # API services
│   └── views/                    # Blade templates
├── routes/
│   ├── api.php                   # API routes
│   └── web.php                   # Web routes
└── storage/
    └── app/public/               # File uploads
```

## 🔧 Configuration

### Database Configuration

The application uses SQLite by default. To switch to MySQL or PostgreSQL:

1. Update `.env` file:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=newradiant
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

2. Run migrations:

```bash
php artisan migrate:fresh --seed
```

### File Storage

Receipt uploads are stored in `storage/app/public/receipts/`. Ensure the storage link is created:

```bash
php artisan storage:link
```

## 🎯 Key Features Explained

### Enrollment Process

1. **Parent Registration**: Parents create accounts and become guardians
2. **Child Enrollment**: Multi-step form with personal, medical, and payment information
3. **Payment Integration**: Receipt upload and payment verification
4. **Admin Review**: Admins verify payments and approve students
5. **Coach Assignment**: Approved students are assigned to coaches

### Payment System

-   **Payment Requests**: Admins can create payment requests for students
-   **Receipt Upload**: Parents upload payment receipts
-   **Verification**: Admins verify payments and update status
-   **Status Tracking**: Complete payment lifecycle management

### Role-Based Access

-   **Admin**: Full system access, user management, payment verification
-   **Coach**: Student management, schedule creation, progress tracking
-   **Parent**: Child enrollment, payment management, progress viewing
-   **Student**: Schedule viewing, progress reports, academy news

## 🐛 Troubleshooting

### Common Issues

1. **Frontend not loading**:

    - Ensure Vite is running: `npm run dev`
    - Check if assets are built: `npm run build`

2. **API authentication errors**:

    - Verify CSRF token is included in requests
    - Check Sanctum configuration

3. **File upload issues**:

    - Ensure storage link exists: `php artisan storage:link`
    - Check file permissions on storage directory

4. **Database errors**:
    - Run migrations: `php artisan migrate`
    - Check database configuration in `.env`

### Debug Mode

Enable debug mode in `.env`:

```env
APP_DEBUG=true
LOG_LEVEL=debug
```

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests if applicable
5. Submit a pull request

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 📞 Support

For support and questions:

-   Email: support@newradiant.mv
-   Website: [New Radiant Sports Club](https://newradiant.mv)

## 🙏 Acknowledgments

-   Laravel framework and community
-   Vue.js team and ecosystem
-   TailwindCSS for styling
-   All contributors and testers

---

**New Radiant Sports Club** - Pride of Maldivian Football since 1979 ⚽
