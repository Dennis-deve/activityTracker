# Activity Tracker

A web application for tracking daily activities of an Applications Support Team. Features status updates, personnel tracking, daily handover views, and historical reporting.

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

- **Backend**: PHP 8.x
- **Database**: SQLite
- **Frontend**: HTML, CSS, JavaScript
- **Fonts**: Inter (Google Fonts)

## Requirements

- PHP 8.2 or higher
- Composer

## Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/Dennis-deve/activityTracker.git
   cd activityTracker
   ```

2. **Install dependencies**
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
│   │   ├── Controllers/       # Application controllers
│   │   └── Middleware/        # Role-based access control
│   └── Models/                # Data models
├── database/
│   ├── migrations/            # Schema definitions
│   └── seeders/               # Sample data
├── resources/views/           # UI templates
├── public/
│   ├── css/                   # Stylesheets
│   └── js/                    # Client-side scripts
├── routes/                    # Route definitions
├── Dockerfile                 # Production deployment
├── docker-compose.yml         # Docker orchestration
└── docker/
    ├── nginx.conf             # Nginx configuration
    └── supervisord.conf       # Process management
```

## Docker Deployment

```bash
docker-compose up -d --build
```

The app will be available at `http://localhost`.

## License

This project is proprietary software.

## Author

**Dennis Samuel Asante-Asare**
