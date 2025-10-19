# Business Manager - Software Development Business Management System

A comprehensive web application built with Laravel, Blade, and Vue.js to manage your software development business. Track clients, projects, tasks, payments, and business analytics all in one place.

![Laravel](https://img.shields.io/badge/Laravel-10.x-FF2D20?style=flat-square&logo=laravel)
![Vue.js](https://img.shields.io/badge/Vue.js-3.x-4FC08D?style=flat-square&logo=vue.js)
![TailwindCSS](https://img.shields.io/badge/Tailwind-3.x-38B2AC?style=flat-square&logo=tailwind-css)

## ✨ Features

### 🔐 Authentication
- Admin login and registration system
- Secure password management
- Session-based authentication

### 📊 Dashboard
- Overview cards: Total Projects, Active Clients, Total Revenue, Pending Payments
- Interactive charts: Monthly Revenue (line chart), Payment Status (pie chart)
- Recent payments and projects lists
- Real-time statistics

### 👥 Client Management
- Complete CRUD operations for clients
- Track client information (name, email, phone, company, address, notes)
- View total projects and outstanding balance per client
- Client detail pages with project and payment history
- Search and filter clients

### 📁 Project Management
- Full CRUD for projects
- Track project details (title, budget, amount paid, status, dates, description)
- Automatic calculation of pending amounts
- Progress tracking based on task completion
- Project status management (Planning, Active, On Hold, Completed, Cancelled)
- Filter by status and client
- Visual progress bars for tasks and payments

### ✅ Task Management
- CRUD operations for project tasks
- Task statuses: To Do, In Progress, Done
- Real-time status updates with Vue components
- Deadline tracking with overdue indicators
- Automatic project progress calculation
- Drag-and-drop status changes

### 💰 Payment Management
- Complete payment tracking system
- Payment types: Advance, Payment
- Automatic project amount_paid updates
- Filter by client, project, type, and date range
- Export to CSV and PDF
- Payment history per client and project

### 📈 Analytics
- Monthly and yearly revenue trends
- Top 5 clients by revenue
- Payment completion rate percentage
- Project status distribution
- Revenue breakdown by payment type
- Interactive charts and visualizations

### ⚙️ Settings
- Admin profile management
- Logo upload
- Currency preferences (USD, EUR, GBP, JPY, INR, AUD, CAD)
- Dark/light theme toggle
- Password change functionality

## 🛠️ Tech Stack

- **Backend**: Laravel 10.x
- **Frontend**: Blade Templates + Vue.js 3
- **Styling**: Tailwind CSS
- **Charts**: Chart.js
- **Database**: MySQL
- **Build Tool**: Vite
- **PDF Generation**: DomPDF

## 📋 Requirements

- PHP >= 8.1
- Composer
- Node.js >= 16.x
- NPM or Yarn
- MySQL >= 5.7 or MariaDB >= 10.3

## 🚀 Installation

### 1. Clone the Repository

```bash
git clone <repository-url>
cd "bendaikh project"
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Install Node Dependencies

```bash
npm install
```

### 4. Environment Setup

```bash
# Copy the environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 5. Configure Database

Edit `.env` file and set your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=business_manager
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 6. Create Database

```bash
# Create the database using MySQL command line or phpMyAdmin
mysql -u root -p
CREATE DATABASE business_manager;
exit;
```

### 7. Run Migrations

```bash
php artisan migrate
```

### 8. Create Storage Link

```bash
php artisan storage:link
```

### 9. Build Assets

```bash
# For development
npm run dev

# For production
npm run build
```

### 10. Start the Application

```bash
# Start Laravel development server
php artisan serve

# In a separate terminal, start Vite (if using npm run dev)
npm run dev
```

The application will be available at: `http://localhost:8000`

## 👤 First User Setup

1. Navigate to `http://localhost:8000/register`
2. Create your admin account
3. Log in and start managing your business!

## 📁 Project Structure

```
bendaikh-project/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/
│   │   │   │   ├── LoginController.php
│   │   │   │   └── RegisterController.php
│   │   │   ├── AnalyticsController.php
│   │   │   ├── ClientController.php
│   │   │   ├── DashboardController.php
│   │   │   ├── PaymentController.php
│   │   │   ├── ProjectController.php
│   │   │   ├── SettingsController.php
│   │   │   └── TaskController.php
│   │   └── Middleware/
│   └── Models/
│       ├── Client.php
│       ├── Payment.php
│       ├── Project.php
│       ├── Task.php
│       └── User.php
├── database/
│   └── migrations/
├── resources/
│   ├── css/
│   │   └── app.css
│   ├── js/
│   │   ├── components/
│   │   │   ├── PaymentStatusChart.vue
│   │   │   ├── RevenueChart.vue
│   │   │   └── TaskList.vue
│   │   ├── app.js
│   │   └── bootstrap.js
│   └── views/
│       ├── analytics/
│       ├── auth/
│       ├── clients/
│       ├── dashboard/
│       ├── layouts/
│       ├── payments/
│       ├── projects/
│       └── settings/
├── routes/
│   └── web.php
├── composer.json
├── package.json
├── tailwind.config.js
├── vite.config.js
└── .env.example
```

## 🎨 Features Breakdown

### Dashboard
- **Overview Cards**: Quick stats on projects, clients, revenue, and pending payments
- **Charts**: Visual representation of monthly revenue trends and payment status
- **Recent Activity**: Latest payments and projects at a glance

### Client Management
- Add, edit, delete clients
- Search clients by name, email, or company
- View detailed client profiles with project history
- Track outstanding balances per client

### Project Management
- Create projects linked to clients
- Set budgets and track payments
- Monitor project progress with task completion
- Filter projects by status or client
- Visual progress indicators

### Task Management
- Create tasks within projects
- Real-time status updates (To Do → In Progress → Done)
- Set deadlines with overdue warnings
- Automatic project progress calculation
- Delete tasks as needed

### Payment Tracking
- Record payments and advances
- Link payments to projects and clients
- Filter and search payment history
- Export reports to CSV or PDF
- Automatic amount_paid updates

### Analytics Dashboard
- Monthly revenue charts
- Year-over-year comparisons
- Top clients by revenue
- Payment completion rates
- Project status distribution

### Settings
- Update profile information
- Upload business logo
- Change password
- Set currency preference
- Toggle between light and dark themes

## 🔒 Security Features

- CSRF protection on all forms
- Password hashing with bcrypt
- Authentication middleware
- SQL injection prevention through Eloquent ORM
- XSS protection through Blade templating

## 📊 Database Schema

### Users Table
- id, name, email, password, logo, currency, theme, timestamps

### Clients Table
- id, name, email, phone, company, address, notes, timestamps

### Projects Table
- id, client_id, title, budget, amount_paid, status, start_date, end_date, description, timestamps

### Tasks Table
- id, project_id, title, status, deadline, description, timestamps

### Payments Table
- id, project_id, client_id, amount, type, date, notes, timestamps

## 🎯 Usage Tips

1. **Start by adding clients** - Clients are the foundation of your business management
2. **Create projects** - Link projects to clients with clear budgets
3. **Break down work into tasks** - Use tasks to track progress and completion
4. **Record payments** - Keep track of all financial transactions
5. **Review analytics** - Regularly check your analytics dashboard for insights
6. **Export reports** - Use CSV/PDF exports for external reporting needs

## 🐛 Troubleshooting

### Assets not loading
```bash
npm run build
php artisan optimize:clear
```

### Database connection error
- Check `.env` file database credentials
- Ensure MySQL service is running
- Verify database exists

### Permission errors
```bash
chmod -R 775 storage bootstrap/cache
```

### Vue components not working
```bash
npm install
npm run dev
# or
npm run build
```

## 📝 Development

### Running Tests
```bash
php artisan test
```

### Code Style
```bash
# PHP
./vendor/bin/pint

# JavaScript
npm run lint
```

### Building for Production
```bash
# Install dependencies
composer install --optimize-autoloader --no-dev
npm install

# Build assets
npm run build

# Optimize Laravel
php artisan optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📄 License

This project is open-source and available under the MIT License.

## 👨‍💻 Author

Built with ❤️ for software development businesses

## 🆘 Support

For issues, questions, or contributions, please create an issue in the repository.

---

**Happy Managing! 🚀**

