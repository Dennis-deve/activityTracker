# Activity Tracker

A modern Laravel web application for tracking daily activities of an Applications Support Team. Features status updates, personnel tracking, daily handover views, and historical reporting.

## Features

- **Daily Activity Dashboard** — View and manage all activities for any given day with status indicators and assignment tracking
- **Status Updates & Audit Trail** — Record status changes (done/pending) with remarks, timestamps, and personnel details
- **Handover Management** — Assign pending activities to the next person on shift with one click
- **Activity Management** — Admins can create, edit, and deactivate activity templates
- **Reporting & Export** — Filter reports by date range, activity, status, or team member, and export to CSV
- **Team Management** — Admins manage team members, roles, and departments
- **Dark/Light Mode** — Toggle between themes with a sleek, modern UI
- **Responsive Design** — Works on desktop, tablet, and mobile

## Tech Stack

- **Backend**: PHP 8.x, Laravel 13
- **Database**: SQLite (zero-configuration)
- **Frontend**: Blade templates, vanilla CSS (custom design system), vanilla JavaScript
- **Fonts**: Inter (Google Fonts)

## Requirements

- PHP 8.2 or higher
- Composer
- Node.js & npm (for asset compilation, optional)

## Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/Dennis-deve/activityTracker.git
   cd activityTracker
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Configure environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Set up the database**
   ```bash
   touch database/database.sqlite
   php artisan migrate
   ```

5. **Seed sample data**
   ```bash
   php artisan db:seed
   ```

6. **Start the development server**
   ```bash
   php artisan serve
   ```

7. **Open in browser**
   ```
   http://127.0.0.1:8000
   ```

## Default Login Credentials

| Role   | Email             | Password  |
|--------|-------------------|-----------|
| Admin  | admin@team.com    | password  |
| Member | daniel@team.com   | password  |
| Member | grace@team.com    | password  |
| Member | samuel@team.com   | password  |

## Project Structure

```
activity-tracker/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── ActivityController.php       # Activity CRUD (admin)
│   │   │   ├── ActivityUpdateController.php # Status updates
│   │   │   ├── AuthController.php           # Login/register/logout
│   │   │   ├── DashboardController.php      # Daily activity view
│   │   │   ├── HandoverController.php       # Activity assignment
│   │   │   ├── ReportController.php         # Reports & CSV export
│   │   │   └── UserController.php           # Team member management
│   │   └── Middleware/
│   │       └── AdminMiddleware.php          # Role-based access control
│   └── Models/
│       ├── Activity.php
│       ├── ActivityUpdate.php
│       ├── DailyActivityLog.php
│       └── User.php
├── database/
│   ├── migrations/                          # Schema definitions
│   └── seeders/
│       └── DatabaseSeeder.php               # Sample data
├── resources/views/
│   ├── layouts/                             # App & auth layouts
│   ├── activities/                          # Activity CRUD views
│   ├── auth/                                # Login & register
│   ├── reports/                             # Reporting view
│   ├── users/                               # User management views
│   └── dashboard.blade.php                  # Main dashboard
├── public/css/app.css                       # Design system (1500+ lines)
├── public/js/app.js                         # Theme toggle, modals, interactions
├── routes/web.php                           # Route definitions
├── Dockerfile                               # Production deployment
├── docker-compose.yml                       # Docker orchestration
└── docker/
    ├── nginx.conf                           # Nginx configuration
    └── supervisord.conf                     # Process management
```

## Docker Deployment

```bash
docker-compose up -d --build
```

The app will be available at `http://localhost`.

## Screenshots

### Dashboard
The daily activity view shows all activities with status badges, assigned personnel, update timelines, and quick-action buttons.

### Reports
Filter and export activity data by date range, activity type, status, and team member.

## License

This project is proprietary software.

## Author

**Dennis Samuel Asante-Asare**
