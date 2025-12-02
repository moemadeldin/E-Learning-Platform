# MindByte - Laravel Learning Platform

<p align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
</p>

<p align="center">
  A comprehensive, modern learning management system built with Laravel 12, featuring course creation, student enrollment, payment processing, and interactive learning experiences.
</p>

## 📋 Table of Contents

- [Features](#features)
- [Tech Stack](#tech-stack)
- [Requirements](#requirements)
- [Installation](#installation)
- [Configuration](#configuration)
- [Database Setup](#database-setup)
- [Running the Application](#running-the-application)
- [Project Structure](#project-structure)
- [User Roles](#user-roles)
- [Key Features Explained](#key-features-explained)
- [API Routes](#api-routes)
- [Testing](#testing)
- [Contributing](#contributing)
- [License](#license)

## ✨ Features

### 🎓 Course Management
- **Course Creation**: Teachers can create comprehensive courses with rich content
- **Course Structure**: Organized into Sections and Lessons for better learning flow
- **Course Levels**: Beginner, Intermediate, and Advanced difficulty levels
- **Course Categories**: Categorize courses for easy discovery
- **Free & Paid Courses**: Support for both free and premium course offerings
- **Course Thumbnails**: Visual course representation with image uploads
- **Course Requirements**: Define prerequisites and learning objectives

### 👥 User Management
- **Role-Based Access Control**: Three distinct roles (Admin, Teacher, Student)
- **Teacher Registration**: Special registration flow with admin approval system
- **User Profiles**: Comprehensive user profile management
- **Account Activation**: User account status management
- **Password Recovery**: Secure password reset functionality via email

### 💳 Payment & Enrollment
- **Stripe Integration**: Secure payment processing for course purchases
- **Shopping Cart**: Add multiple courses to cart before checkout
- **Buy Now**: Instant purchase option for single courses
- **Enrollment Tracking**: Track student progress and enrollment history
- **Free Course Claiming**: One-click enrollment for free courses

### 📚 Learning Experience
- **Lesson Types**: Support for Video, PDF, Image, Audio, and Document attachments
- **Lesson Comments**: Interactive discussion on individual lessons
- **Course Comments**: Community engagement through course-level discussions
- **Course Reviews**: Rating and review system for courses
- **My Courses Dashboard**: Personalized dashboard for enrolled courses
- **Progress Tracking**: Monitor learning progress through enrollments

### 🔐 Admin Features
- **Dashboard**: Comprehensive admin dashboard with statistics
- **User Management**: Full CRUD operations for user accounts
- **Category Management**: Create and manage course categories
- **Course Oversight**: Admin can view and manage all courses
- **Teacher Approval**: Review and approve/reject teacher registration requests

### 🎨 Teacher Features
- **Teacher Dashboard**: Dedicated dashboard for course creators
- **Course Management**: Full CRUD operations for courses
- **Section Management**: Organize courses into logical sections
- **Lesson Management**: Create and manage lessons with attachments
- **Course Analytics**: Track course performance and student engagement

## 🛠 Tech Stack

### Backend
- **Laravel 12**: Modern PHP framework
- **PHP 8.2+**: Latest PHP features and performance improvements
- **MySQL/PostgreSQL**: Robust database support

### Frontend
- **Tailwind CSS 4**: Utility-first CSS framework
- **Vite**: Next-generation frontend build tool
- **Blade Templates**: Laravel's powerful templating engine
- **Axios**: HTTP client for API requests

### Third-Party Integrations
- **Stripe**: Payment processing
- **Laravel Debugbar**: Development debugging tool (dev only)

### Development Tools
- **Laravel Pint**: Code style fixer
- **PHPUnit**: Testing framework
- **Laravel Sail**: Docker development environment
- **Laravel Pail**: Log viewer

## 📦 Requirements

- PHP >= 8.2
- Composer
- Node.js >= 18.x and npm
- MySQL >= 8.0 or PostgreSQL >= 13
- Stripe account (for payment processing)
- Mail server configuration (for email notifications)

## 🚀 Installation

### 1. Clone the Repository

```bash
git clone https://github.com/yourusername/MindByte.git
cd MindByte
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Install Node Dependencies

```bash
npm install
```

### 4. Environment Configuration

Copy the environment file and configure it:

```bash
cp .env.example .env
php artisan key:generate
```

### 5. Configure Environment Variables

Edit `.env` file with your configuration:

```env
APP_NAME=MindByte
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mindbyte
DB_USERNAME=root
DB_PASSWORD=

STRIPE_SK=your_stripe_secret_key
STRIPE_PK=your_stripe_public_key

MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

## 🗄 Database Setup

### Run Migrations

```bash
php artisan migrate
```

### Seed Database (Optional)

```bash
php artisan db:seed
```

This will seed:
- Default roles (Admin, Teacher, User)
- Sample data for testing

## ▶ Running the Application

### Development Mode

For a complete development setup with server, queue, and Vite:

```bash
composer dev
```

Or run individually:

```bash
# Terminal 1: Start Laravel server
php artisan serve

# Terminal 2: Start queue worker
php artisan queue:listen

# Terminal 3: Start Vite dev server
npm run dev
```

### Production Build

```bash
# Build frontend assets
npm run build

# Optimize Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 📁 Project Structure

```
MindByte/
├── app/
│   ├── Actions/              # Action classes for business logic
│   │   ├── Admin/           # Admin-specific actions
│   │   ├── Comments/        # Comment-related actions
│   │   ├── Reviews/         # Review-related actions
│   │   └── Teacher/         # Teacher-specific actions
│   ├── Console/             # Artisan commands
│   ├── DTOs/                # Data Transfer Objects
│   ├── Enums/               # Enumeration classes
│   ├── Events/              # Event classes
│   ├── Http/
│   │   ├── Controllers/     # Application controllers
│   │   ├── Middleware/      # Custom middleware
│   │   └── Requests/        # Form request validation
│   ├── Interfaces/          # Service interfaces
│   ├── Listeners/           # Event listeners
│   ├── Mail/                # Mail classes
│   ├── Models/              # Eloquent models
│   ├── Notifications/       # Notification classes
│   ├── Policies/            # Authorization policies
│   ├── Providers/           # Service providers
│   ├── Services/            # Service classes
│   └── Traits/              # Reusable traits
├── database/
│   ├── factories/           # Model factories
│   ├── migrations/          # Database migrations
│   └── seeders/             # Database seeders
├── resources/
│   ├── css/                 # Stylesheets
│   ├── js/                  # JavaScript files
│   └── views/               # Blade templates
│       ├── components/      # Reusable components
│       ├── dashboard/       # Dashboard views
│       ├── pages/           # Page views
│       └── partials/        # Partial views
├── routes/
│   ├── admin.php            # Admin routes
│   ├── auth.php             # Authentication routes
│   ├── guest.php            # Guest routes
│   ├── teacher.php          # Teacher routes
│   └── web.php              # General web routes
└── tests/                   # Test files
```

## 👤 User Roles

### Admin
- Full system access
- User management
- Category management
- Course oversight
- Teacher registration approval
- Dashboard analytics

### Teacher
- Create and manage courses
- Organize courses into sections
- Create lessons with attachments
- View enrolled students
- Manage course content

### Student (User)
- Browse and search courses
- Enroll in courses
- Access course content
- Leave reviews and comments
- Track learning progress
- Manage profile

## 🔑 Key Features Explained

### Course Structure
Courses are organized hierarchically:
- **Course** → Contains multiple **Sections**
- **Section** → Contains multiple **Lessons**
- **Lesson** → Can have multiple **Attachments** (Video, PDF, Image, Audio, Document)

### Payment Flow
1. Student adds courses to cart or uses "Buy Now"
2. Redirected to Stripe checkout
3. Upon successful payment, enrollment is created
4. Student gains access to course content

### Teacher Registration Flow
1. User registers as a teacher with additional information
2. Admin reviews the registration request
3. Admin approves or rejects the request
4. Approved teachers can create courses

### Comment System
- Polymorphic comment system supporting:
  - Course comments
  - Lesson comments
- Users can edit and delete their own comments

## 🛣 API Routes

### Public Routes
- `GET /` - Home page
- `GET /courses` - List all courses
- `GET /courses/{course}` - View course details
- `GET /about-us` - About page

### Authentication Routes
- `GET /register` - Registration form
- `POST /register` - Register new user
- `GET /login` - Login form
- `POST /login` - Authenticate user
- `POST /logout` - Logout user
- `GET /forgot-password` - Password recovery form
- `POST /forgot-password` - Send recovery email
- `GET /reset-password` - Reset password form
- `POST /reset-password` - Reset password

### Teacher Routes
- `GET /teacher-register` - Teacher registration form
- `POST /teacher-register` - Submit teacher registration
- `GET /dashboard/teacher` - Teacher dashboard
- `GET /dashboard/teacher/courses` - Teacher's courses
- `POST /dashboard/teacher/courses` - Create course
- `PUT /dashboard/teacher/courses/{course}` - Update course
- `DELETE /dashboard/teacher/courses/{course}` - Delete course

### Admin Routes
- `GET /dashboard` - Admin dashboard
- `GET /dashboard/users` - User management
- `GET /dashboard/categories` - Category management
- `GET /dashboard/courses` - Course management
- `GET /dashboard/teachers-requests` - Teacher requests

### Authenticated User Routes
- `GET /my-courses` - User's enrolled courses
- `GET /carts` - Shopping cart
- `POST /courses/{course}/add-to-cart` - Add to cart
- `POST /checkout` - Checkout process
- `POST /courses/{course}/reviews` - Add review
- `POST /courses/{course}/comments` - Add comment
- `POST /lessons/{lesson}/comments` - Add lesson comment

## 🧪 Testing

Run the test suite:

```bash
composer test
```

Or use PHPUnit directly:

```bash
php artisan test
```

## 🎨 Code Style

This project uses Laravel Pint for code formatting:

```bash
./vendor/bin/pint
```

## 📝 Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

### Coding Standards
- Follow PSR-12 coding standards
- Write meaningful commit messages
- Add tests for new features
- Update documentation as needed

## 🔒 Security

If you discover any security vulnerabilities, please send an email to the maintainers instead of using the issue tracker.

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 🙏 Acknowledgments

- Built with [Laravel](https://laravel.com)
- Styled with [Tailwind CSS](https://tailwindcss.com)
- Payment processing by [Stripe](https://stripe.com)

## 📞 Support

For support, email support@mindbyte.com or open an issue in the repository.

---

<p align="center">Made with ❤️ using Laravel</p>
