# FreshTrackMart - User Manual

## Table of Contents
1. [Introduction](#introduction)
2. [Project Overview](#project-overview)
3. [Technology Stack](#technology-stack)
4. [Installation & Setup](#installation--setup)
5. [Getting Started](#getting-started)
6. [Features & Usage](#features--usage)
7. [Project Structure](#project-structure)
8. [Development Guide](#development-guide)
9. [Troubleshooting](#troubleshooting)
10. [Support & Contributing](#support--contributing)

---

## Introduction

Welcome to **FreshTrackMart**! This user manual provides comprehensive guidance for both end-users and developers working with this web-based application. Whether you're setting up the project for the first time or looking to understand specific features, this document will help you navigate through FreshTrackMart.

---

## Project Overview

**FreshTrackMart** is a web application built with modern web technologies. The project combines frontend and backend components to deliver a full-stack experience with a focus on clean code, performance, and user experience.

### Key Characteristics:
- **Frontend-Heavy**: 66% JavaScript, complemented by CSS styling
- **Responsive Design**: CSS (14.2%) and SCSS (5.2%) for advanced styling
- **Template Support**: Blade templating (2.1%) for dynamic content
- **Modern Architecture**: Uses Laravel framework and Vite build tool

---

## Technology Stack

### Frontend Technologies
| Technology | Version | Purpose | Percentage |
|------------|---------|---------|-----------|
| **JavaScript** | Latest | Core application logic and interactivity | 66% |
| **CSS** | CSS3 | Styling and layout | 14.2% |
| **HTML** | HTML5 | Markup and structure | 9.5% |
| **SCSS** | 1.3+ | Advanced CSS preprocessing | 5.2% |
| **Tailwind CSS** | ^3.1.0 | Utility-first CSS framework | Included |
| **Alpine.js** | ^3.4.2 | Lightweight JavaScript framework | Included |

### Backend Technologies
| Technology | Version | Purpose | Percentage |
|------------|---------|---------|-----------|
| **Laravel** | Latest | PHP framework | Backend |
| **Blade** | - | Template engine | 2.1% |
| **Less** | - | CSS preprocessor | 1.4% |

### Build Tools & Dependencies
| Tool | Version | Purpose |
|------|---------|---------|
| **Vite** | ^7.0.7 | Modern frontend build tool |
| **Laravel Vite Plugin** | ^2.0.0 | Laravel integration with Vite |
| **Tailwind CSS** | ^3.1.0 | Utility-first CSS framework |
| **PostCSS** | ^8.4.31 | CSS transformations |
| **Autoprefixer** | ^10.4.2 | Vendor prefix automation |
| **Axios** | ^1.11.0 | HTTP client for API calls |

---

## Installation & Setup

### Prerequisites
Before installing FreshTrackMart, ensure you have:
- **Node.js** (v16.x or higher) - [Download](https://nodejs.org/)
- **npm** (v7.x or higher) or **yarn** - Comes with Node.js
- **PHP** (v8.1 or higher) - If running Laravel backend
- **Composer** - PHP dependency manager
- **Git** - Version control

### Step 1: Clone the Repository

```bash
git clone https://github.com/rgacoronado-pixel/FreshTrackMart.git
cd FreshTrackMart
```

### Step 2: Navigate to the Application Directory

```bash
cd sims2
```

### Step 3: Install Dependencies

#### Frontend Dependencies
```bash
npm install
```

#### Backend Dependencies (if using Laravel)
```bash
composer install
```

### Step 4: Configure Environment

Create a `.env` file from the example:
```bash
cp .env.example .env
```

Edit the `.env` file with your database and application settings:
```
APP_NAME=FreshTrackMart
APP_URL=http://localhost:8000
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=freshtrackmart
DB_USERNAME=root
DB_PASSWORD=
```

### Step 5: Generate Application Key

```bash
php artisan key:generate
```

### Step 6: Run Database Migrations

```bash
php artisan migrate
```

### Step 7: Start Development Server

#### Option A: Using Vite (Recommended)
```bash
npm run dev
```

#### Option B: Using Laravel Development Server
```bash
php artisan serve
```

The application will be available at `http://localhost:8000`

---

## Getting Started

### First-Time Setup Checklist

- [ ] Clone repository
- [ ] Install dependencies (`npm install`)
- [ ] Copy `.env.example` to `.env`
- [ ] Configure database connection
- [ ] Run migrations
- [ ] Start development server
- [ ] Open browser to `http://localhost:8000`

### Building for Production

```bash
npm run build
```

This command will:
1. Optimize JavaScript and CSS
2. Generate minified production files
3. Create optimized asset bundles
4. Output files to the `dist/` directory

---

## Features & Usage

### Frontend Features

#### 1. **Interactive Components**
- Powered by Alpine.js for lightweight interactivity
- No heavy framework overhead
- Responsive to user interactions

#### 2. **Styling System**
- **Tailwind CSS**: Utility-first approach for rapid development
- **SCSS**: For complex, maintainable stylesheets
- **CSS**: Standard stylesheet support
- **Responsive Design**: Mobile-first approach

#### 3. **Form Handling**
- Axios integration for API calls
- Form validation
- Error handling and feedback
- Smooth submission experience

### Backend Features

#### 1. **Templating**
- Blade template engine for dynamic content
- Template inheritance
- Component-based architecture

#### 2. **Database**
- Eloquent ORM for database interactions
- Migration support for version control
- Schema management

#### 3. **API**
- RESTful API endpoints
- Request validation
- Response formatting

---

## Project Structure

```
FreshTrackMart/
├── sims2/
│   ├── app/                          # Laravel application code
│   │   ├── Http/                     # Controllers, middleware
│   │   ├── Models/                   # Database models
│   │   └── ...
│   ├── resources/
│   │   ├── css/                      # Stylesheets (CSS, SCSS)
│   │   ├── js/                       # JavaScript files
│   │   └── views/                    # Blade templates
│   ├── public/
│   │   ├── backend/                  # Backend assets
│   │   │   └── assets/
│   │   │       └── iconfonts/        # Icon fonts (Boxicons)
│   │   ├── css/                      # Compiled CSS
│   │   ├── js/                       # Compiled JavaScript
│   │   └── index.php                 # Entry point
│   ├── routes/
│   │   ├── web.php                   # Web routes
│   │   └── api.php                   # API routes
│   ├── package.json                  # Frontend dependencies
│   ├── composer.json                 # Backend dependencies
│   ├── vite.config.js                # Vite configuration
│   ├── tailwind.config.js            # Tailwind CSS configuration
│   ├── postcss.config.js             # PostCSS configuration
│   └── ...
└── [Other project files]
```

### Key Directories Explained

| Directory | Purpose |
|-----------|---------|
| `app/` | Laravel application logic (controllers, models, services) |
| `resources/css/` | SCSS and CSS stylesheets |
| `resources/js/` | JavaScript application code |
| `resources/views/` | Blade template files |
| `public/` | Static assets and compiled files |
| `routes/` | Route definitions for web and API |

---

## Development Guide

### Frontend Development

#### 1. **Adding JavaScript Files**

Create new JavaScript files in `resources/js/`:

```javascript
// resources/js/components/example.js
export function initializeComponent() {
  console.log('Component initialized');
}
```

#### 2. **Adding Styles**

Create new SCSS files in `resources/css/`:

```scss
// resources/css/components/example.scss
.example-component {
  display: flex;
  align-items: center;
  
  &:hover {
    opacity: 0.8;
  }
}
```

#### 3. **Using Alpine.js**

```html
<div x-data="{ open: false }">
  <button @click="open = !open">Toggle</button>
  <div x-show="open">Content</div>
</div>
```

#### 4. **Making API Calls with Axios**

```javascript
import axios from 'axios';

axios.post('/api/endpoint', {
  data: 'value'
})
.then(response => {
  console.log('Success:', response.data);
})
.catch(error => {
  console.error('Error:', error);
});
```

### Backend Development

#### 1. **Creating a Model**

```bash
php artisan make:model Product
```

#### 2. **Creating a Controller**

```bash
php artisan make:controller ProductController
```

#### 3. **Creating a Migration**

```bash
php artisan make:migration create_products_table
```

#### 4. **Running Artisan Commands**

```bash
php artisan migrate           # Run migrations
php artisan tinker            # Interactive shell
php artisan cache:clear      # Clear cache
php artisan config:cache     # Cache configuration
```

### Hot Module Replacement (HMR)

During development with `npm run dev`, Vite automatically reloads your browser when you make changes to:
- JavaScript files
- CSS/SCSS files
- Blade templates (with configuration)

---

## Troubleshooting

### Common Issues & Solutions

#### Issue 1: Dependencies Installation Fails

**Problem**: `npm install` fails with permission or package errors

**Solutions**:
```bash
# Clear npm cache
npm cache clean --force

# Delete node_modules and package-lock.json
rm -rf node_modules package-lock.json

# Reinstall
npm install
```

#### Issue 2: Port 8000 Already in Use

**Problem**: "Port 8000 is already in use"

**Solutions**:
```bash
# Use different port with Laravel
php artisan serve --port=8001

# Or kill the process on port 8000
# On Windows: netstat -ano | findstr :8000
# On Mac/Linux: lsof -i :8000
```

#### Issue 3: Database Connection Error

**Problem**: "SQLSTATE[HY000]: General error"

**Solutions**:
```bash
# Check .env file database credentials
# Ensure MySQL/database server is running
# Run migrations: php artisan migrate
# Check database exists: mysql -u root -p -e "SHOW DATABASES;"
```

#### Issue 4: Build Fails

**Problem**: `npm run build` produces errors

**Solutions**:
```bash
# Clear node_modules and reinstall
rm -rf node_modules package-lock.json
npm install

# Clear build cache
rm -rf dist/

# Rebuild
npm run build
```

#### Issue 5: Styling Not Applied

**Problem**: Tailwind or SCSS styles not appearing

**Solutions**:
```bash
# Ensure Vite dev server is running: npm run dev
# Clear browser cache (Ctrl+Shift+Delete)
# Check that styles are imported in app.js
# Verify Tailwind config includes correct paths
```

### Debug Mode

Enable debug mode in `.env`:
```
APP_DEBUG=true
```

Check logs at `storage/logs/laravel.log`

---

## Support & Contributing

### Getting Help

- **GitHub Issues**: Report bugs or request features at [GitHub Issues](https://github.com/rgacoronado-pixel/FreshTrackMart/issues)
- **Documentation**: Check official docs for [Laravel](https://laravel.com/docs) and [Vite](https://vitejs.dev/)
- **Community**: Join Laravel and web development communities for support

### Contributing to FreshTrackMart

1. **Fork the repository**
2. **Create a feature branch**: `git checkout -b feature/your-feature`
3. **Make your changes**
4. **Commit your changes**: `git commit -m "Add your feature"`
5. **Push to the branch**: `git push origin feature/your-feature`
6. **Open a Pull Request**

### Code Standards

- Follow PSR-12 for PHP code
- Use ES6+ for JavaScript
- Use SCSS for styling
- Write meaningful commit messages
- Include comments for complex logic
- Test your changes before submitting

### Useful Resources

- [Laravel Documentation](https://laravel.com/docs)
- [Vite Documentation](https://vitejs.dev/)
- [Tailwind CSS Documentation](https://tailwindcss.com/docs)
- [Alpine.js Documentation](https://alpinejs.dev/)
- [MDN Web Docs](https://developer.mozilla.org/)

---

## Glossary

| Term | Definition |
|------|-----------|
| **Vite** | Modern frontend build tool for fast development and optimized production builds |
| **Laravel** | PHP web application framework |
| **Blade** | Laravel's templating engine |
| **Tailwind CSS** | Utility-first CSS framework |
| **Alpine.js** | Lightweight JavaScript framework for interactivity |
| **SCSS** | Supercharged CSS with variables, nesting, and functions |
| **Axios** | Promise-based HTTP client for making API requests |
| **HMR** | Hot Module Replacement - automatically reload modules during development |
| **Migration** | Database version control system |
| **ORM** | Object-Relational Mapping - abstraction layer for database queries |

---

## Version Information

- **Project Name**: FreshTrackMart
- **Repository**: [rgacoronado-pixel/FreshTrackMart](https://github.com/rgacoronado-pixel/FreshTrackMart)
- **Default Branch**: master
- **Last Updated**: May 17, 2026

---

## Document Version

- **Manual Version**: 1.0
- **Last Updated**: 2026-05-17
- **Author**: Auto-generated for FreshTrackMart

---

**Thank you for using FreshTrackMart! Happy coding! 🚀**
