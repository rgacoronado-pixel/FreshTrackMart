# FreshTrackMart - User Manual

## Table of Contents
1. [Introduction](#introduction)
2. [Project Overview](#project-overview)
3. [Technology Stack](#technology-stack)
4. [Installation & Setup](#installation--setup)
5. [Getting Started](#getting-started)
6. [Features & Usage](#features--usage)
7. [User Interface Guide](#user-interface-guide)
8. [Step-by-Step Function & Button Guide](#step-by-step-function--button-guide)
9. [Admin Guide](#admin-guide)
10. [Project Structure](#project-structure)
11. [Development Guide](#development-guide)
12. [Troubleshooting](#troubleshooting)
13. [Support & Contributing](#support--contributing)

---

## Introduction

Welcome to **FreshTrackMart**! This user manual provides comprehensive guidance for both end-users and developers working with this web-based application. Whether you're setting up the project for[...]

---

## Project Overview

**FreshTrackMart** is a web application built with modern web technologies. The project combines frontend and backend components to deliver a full-stack experience with a focus on clean code, perf[...]

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

## User Interface Guide

### Navigation & Layout

The FreshTrackMart interface is organized with the following main sections:

#### Header Navigation
- **Home** - Returns to main dashboard
- **Products** - Access to product listings
- **Inventory** - Track stock levels
- **Reports** - View analytics and reports
- **Settings** - User and system preferences
- **User Profile** - Account management and logout

#### Sidebar (if present)
Contains quick links to:
- Dashboard
- Main Features
- Admin Tools (if admin user)
- Help & Documentation

### Common UI Patterns

#### Buttons
- **Primary Buttons** (Blue) - Main actions (Save, Submit, Add)
- **Secondary Buttons** (Gray) - Alternative actions (Cancel, Back)
- **Danger Buttons** (Red) - Destructive actions (Delete, Remove)

#### Forms
- Required fields are marked with an asterisk (*)
- Error messages appear in red text below the field
- Success messages appear as green notifications
- Form validation occurs on blur and submission

#### Tables
- Click headers to sort columns
- Use pagination controls at bottom to navigate pages
- Check boxes for multi-select actions
- Action buttons appear in the rightmost column

---

## Step-by-Step Function & Button Guide

### Dashboard Access

#### How to Access the Dashboard
1. **Open your browser** and navigate to `http://localhost:8000` (or your configured domain)
2. **Login Page** appears if not authenticated
   - Enter your **Email Address** in the email field
   - Enter your **Password** in the password field
   - Click **Login** button (blue button at bottom)
3. **Dashboard Loads** - You are now on the main dashboard
4. **Verify Login** - Your username appears in the top-right corner

### Product Management

#### Adding a New Product

**Location**: Main Menu > Products > Add New Product

**Step-by-Step Instructions**:

1. **Navigate to Products**
   - Click on "Products" in the main navigation menu (top navigation bar)
   - From the dropdown, select "Add New Product" or click the "➕ Add Product" button

2. **Fill in Product Information**
   - **Product Name** field: Enter the name of the product (e.g., "Fresh Apples")
   - **Category** dropdown: Select the product category (e.g., "Fruits", "Vegetables")
   - **Price** field: Enter the selling price (e.g., "5.99")
   - **Stock Quantity** field: Enter available units
   - **Expiry Date** field: Click calendar icon and select expiration date
   - **Description** text area: Add detailed product description (optional)

3. **Upload Product Image** (Optional)
   - Click on "📷 Upload Image" button
   - Select an image file from your computer
   - Image preview will appear below the button

4. **Review Information**
   - Double-check all entered information
   - Ensure all required fields (marked with *) are filled

5. **Save the Product**
   - Click the blue **"Save Product"** button at bottom-right
   - A green success message appears: "Product added successfully!"
   - You are redirected to the Products List page

6. **Verify Addition**
   - Your new product should appear at the top of the Products list
   - Product details are now visible in the table

#### Editing a Product

**Location**: Products List > Action Column

**Step-by-Step Instructions**:

1. **Go to Products List**
   - Click "Products" in the main menu
   - View the list of all products

2. **Find the Product to Edit**
   - Scroll through the list to locate your product
   - Use the **Search Bar** (top of table) to quickly find the product by name
   - Type product name and press Enter

3. **Open Edit Form**
   - In the product row, locate the action buttons on the right
   - Click the **✏️ Edit** button (pencil icon)
   - The edit form opens with pre-filled product information

4. **Modify Information**
   - Change any fields as needed:
     - Update Product Name
     - Change Category
     - Adjust Price
     - Update Stock Quantity
     - Change Expiry Date
   - Leave fields unchanged if no modification needed

5. **Save Changes**
   - Click the blue **"Update Product"** button at bottom-right
   - A green success message confirms: "Product updated successfully!"
   - Returns to Products List

#### Deleting a Product

**Location**: Products List > Action Column

**Step-by-Step Instructions**:

1. **Navigate to Products List**
   - Click "Products" in the main menu

2. **Find the Product**
   - Locate the product you want to delete in the list
   - Use search if needed

3. **Initiate Deletion**
   - In the product row, click the **🗑️ Delete** button (trash icon - red)
   - A confirmation dialog appears asking: "Are you sure you want to delete this product?"

4. **Confirm Deletion**
   - Click **"Yes, Delete"** button (red) to confirm
   - OR click **"Cancel"** button (gray) to abort deletion

5. **Verify Deletion**
   - Upon confirmation, product is removed from list
   - Success message appears: "Product deleted successfully!"

### Inventory Management

#### Checking Stock Levels

**Location**: Main Menu > Inventory > Stock Levels

**Step-by-Step Instructions**:

1. **Go to Inventory Section**
   - Click "Inventory" in the main navigation menu
   - Click "Stock Levels" from the submenu

2. **View Stock Information**
   - Table displays all products with current stock quantities
   - **Columns** show:
     - Product Name
     - Current Stock (quantity)
     - Minimum Stock Level (warning threshold)
     - Status (In Stock / Low Stock / Out of Stock)

3. **Identify Low Stock Items**
   - Items with status "Low Stock" appear highlighted in yellow
   - Items with status "Out of Stock" appear highlighted in red

4. **Update Stock Quantity** (if needed)
   - Click the product name to open product details
   - Click **"Update Stock"** button
   - Enter new quantity in the popup dialog
   - Click **"Confirm"** button

5. **Export Stock Report** (Optional)
   - Click the **"📥 Export Report"** button (top-right)
   - Select format: CSV or Excel
   - Report downloads to your computer

### Reports & Analytics

#### Generating a Sales Report

**Location**: Main Menu > Reports > Sales Report

**Step-by-Step Instructions**:

1. **Access Reports Section**
   - Click "Reports" in the main navigation menu
   - Select "Sales Report" from dropdown

2. **Set Report Filters** (Optional)
   - **Date Range**: 
     - Click "From Date" field, select start date
     - Click "To Date" field, select end date
   - **Product Category**: 
     - Click dropdown to select specific category (or leave as "All")
   - **Status Filter**: 
     - Select "Completed" / "Pending" / "All" orders

3. **Generate Report**
   - Click the blue **"Generate Report"** button
   - Report loads and displays in table below

4. **View Report Data**
   - Table shows:
     - Order Date
     - Product Name
     - Quantity Sold
     - Revenue
     - Customer Name
   - Totals row appears at bottom showing sum of all columns

5. **Export Report**
   - Click **"📥 Download as CSV"** or **"📥 Download as PDF"** button
   - File downloads to your default Downloads folder

6. **Print Report** (Optional)
   - Click **"🖨️ Print"** button
   - Print dialog opens
   - Select printer and click "Print"

### User Account Management

#### Updating Your Profile

**Location**: Top-Right Corner > User Profile Icon > My Profile

**Step-by-Step Instructions**:

1. **Access Profile Settings**
   - Look at the top-right corner of the page
   - Click on your **User Profile Icon** (avatar with initials)
   - Click "My Profile" from the dropdown menu

2. **Edit Profile Information**
   - **Full Name** field: Update your name if needed
   - **Email Address** field: Change email
   - **Phone Number** field: Update contact number (optional)
   - **Address** field: Enter/update address

3. **Change Password** (Optional)
   - Scroll down to "Change Password" section
   - Click **"Change Password"** button
   - Enter **Current Password** in first field
   - Enter **New Password** in second field
   - Re-enter **Confirm Password** in third field
   - Click **"Update Password"** button

4. **Save Changes**
   - Click the blue **"Save Profile"** button at bottom
   - Success message confirms: "Profile updated successfully!"

#### Logging Out

**Location**: Top-Right Corner > User Profile Icon > Logout

**Step-by-Step Instructions**:

1. **Access Logout Option**
   - Click on your **User Profile Icon** in the top-right corner
   - A dropdown menu appears

2. **Logout**
   - Click **"Logout"** option from the dropdown
   - Session ends and you return to the login page

---

## Admin Guide

### Admin Dashboard Overview

**Location**: Main Menu > Admin Dashboard (visible only to admin users)

Admin users have access to enhanced features for managing the entire system. This section provides detailed instructions for all admin functions.

#### Accessing Admin Panel

**Step-by-Step Instructions**:

1. **Login as Admin**
   - Enter your admin credentials on the login page
   - Click **"Login"** button

2. **Navigate to Admin Panel**
   - Click on "Admin" in the main navigation menu (appears only for admin users)
   - Admin Dashboard loads with administrative options

3. **Verify Admin Status**
   - "Admin Panel" label appears next to your username in top-right corner
   - Dashboard displays admin-specific widgets and statistics

### User Management

#### Viewing All Users

**Location**: Admin Dashboard > User Management > View All Users

**Step-by-Step Instructions**:

1. **Access User Management**
   - Click on "Admin" in the main navigation menu
   - Click "User Management" from the submenu or admin options
   - Select "View All Users"

2. **View User List**
   - Table displays all registered users with columns:
     - User ID
     - Full Name
     - Email Address
     - Role (Admin / Staff / Customer)
     - Registration Date
     - Status (Active / Inactive)
     - Action Buttons

3. **Search for a User**
   - Use the **Search Bar** at top of table
   - Enter user name or email
   - Press Enter or click **"Search"** button
   - Results filter automatically

4. **Sort Users**
   - Click on column headers to sort (Name, Email, Date, etc.)
   - Click again to reverse sort order (ascending/descending)

#### Creating a New User

**Location**: Admin Dashboard > User Management > Create New User

**Step-by-Step Instructions**:

1. **Navigate to Create User**
   - Click "Admin" in the main menu
   - Click "User Management" submenu
   - Click "➕ Create New User" button (blue button, top-right)

2. **Fill in User Information**
   - **Full Name** field: Enter complete name (e.g., "John Smith")
   - **Email Address** field: Enter valid email (e.g., "john@example.com")
   - **Phone Number** field: Enter contact number (optional)
   - **Address** field: Enter user's address (optional)
   - **Password** field: Enter temporary password (user will change on first login)
   - **Confirm Password** field: Re-enter password

3. **Select User Role**
   - **Role** dropdown: Select from options:
     - **Admin**: Full system access
     - **Staff**: Limited administrative functions
     - **Customer**: Basic user access

4. **Set User Status**
   - **Status** toggle: Select "Active" or "Inactive"
     - Active: User can login immediately
     - Inactive: User account is disabled

5. **Review Information**
   - Double-check all entered data
   - Ensure email is unique (not already in system)

6. **Create User**
   - Click the blue **"Create User"** button at bottom-right
   - Green success message: "User created successfully!"
   - New user appears in the Users list
   - An email with login credentials is sent to the user

#### Editing a User

**Location**: Admin Dashboard > User Management > Users List > Edit Action

**Step-by-Step Instructions**:

1. **Go to User Management**
   - Click "Admin" in main menu
   - Click "User Management" > "View All Users"

2. **Find the User**
   - Locate user in the table
   - Use search bar if needed to filter

3. **Open Edit Form**
   - Click the **✏️ Edit** button in the user's row (action column on right)
   - Edit form opens with pre-filled user information

4. **Modify User Details**
   - Change any fields as needed:
     - Full Name
     - Email Address
     - Phone Number
     - Address
   - To change password, scroll to "Change Password" section and enter new password

5. **Update User Role**
   - Click **Role** dropdown to change user's access level
   - Select: Admin, Staff, or Customer

6. **Update User Status**
   - Toggle **Status** between Active/Inactive
   - Click **Save Changes** button

7. **Save Changes**
   - Click the blue **"Update User"** button at bottom-right
   - Confirmation message: "User updated successfully!"
   - Returns to Users list

#### Deactivating a User

**Location**: Admin Dashboard > User Management > Users List > Action Column

**Step-by-Step Instructions**:

1. **Navigate to Users List**
   - Click "Admin" > "User Management" > "View All Users"

2. **Find the User to Deactivate**
   - Locate user in table
   - Click **✏️ Edit** button

3. **Change User Status**
   - Scroll to **Status** field
   - Toggle from "Active" to **"Inactive"**
   - User will no longer be able to login

4. **Save Changes**
   - Click **"Update User"** button
   - Success message appears

5. **Verify Deactivation**
   - User row now shows **Status: Inactive** (grayed out text)

#### Deleting a User

**Location**: Admin Dashboard > User Management > Users List > Delete Action

**Step-by-Step Instructions**:

1. **Go to User Management**
   - Click "Admin" in main menu
   - Click "User Management" > "View All Users"

2. **Find the User**
   - Locate user in the list
   - Use search to find quickly

3. **Initiate Deletion**
   - Click the **🗑️ Delete** button (red trash icon) in user's row
   - A confirmation dialog appears:
     - "Are you sure you want to delete this user?"
     - "This action cannot be undone!"

4. **Confirm Deletion**
   - Click **"Yes, Delete Permanently"** button (red) to confirm
   - OR click **"Cancel"** button (gray) to abort

5. **Verify Deletion**
   - Upon confirmation, user is removed from the system
   - Success message: "User deleted successfully!"
   - User no longer appears in Users list

### System Settings

#### Accessing System Settings

**Location**: Admin Dashboard > Settings > System Configuration

**Step-by-Step Instructions**:

1. **Navigate to Settings**
   - Click "Admin" in the main navigation menu
   - Click "Settings" from the submenu
   - Select "System Configuration"

2. **View Settings Options**
   - Page displays various system configuration options grouped into sections:
     - **General Settings** (App name, timezone, etc.)
     - **Database Settings** (Read-only display)
     - **Security Settings** (Session timeout, password policies)
     - **Email Settings** (SMTP configuration)

#### Updating General Settings

**Location**: Admin Dashboard > Settings > System Configuration > General Tab

**Step-by-Step Instructions**:

1. **Access General Settings**
   - Click "Admin" > "Settings" > "System Configuration"
   - Click the **"General"** tab

2. **Modify Settings**
   - **Application Name** field: Change app name if needed
   - **Application Timezone** dropdown: Select timezone (e.g., "UTC", "EST", "PST")
   - **Default Currency** field: Set currency symbol (e.g., "$", "€")
   - **Support Email** field: Enter support contact email
   - **Support Phone** field: Enter support phone number

3. **Save Settings**
   - Scroll to bottom of form
   - Click blue **"Save Settings"** button
   - Green confirmation: "Settings saved successfully!"

#### Configuring Email Settings

**Location**: Admin Dashboard > Settings > System Configuration > Email Tab

**Step-by-Step Instructions**:

1. **Access Email Settings**
   - Click "Admin" > "Settings" > "System Configuration"
   - Click the **"Email"** tab

2. **Configure SMTP Settings**
   - **SMTP Host** field: Enter mail server address (e.g., "smtp.gmail.com")
   - **SMTP Port** field: Enter port number (usually 587 or 465)
   - **SMTP Username** field: Enter email account username
   - **SMTP Password** field: Enter email account password
   - **From Email Address** field: Email address that sends system notifications
   - **From Name** field: Name displayed in emails (e.g., "FreshTrackMart Support")

3. **Test Email Configuration**
   - Click **"Send Test Email"** button
   - Enter test recipient email address
   - Click **"Send"** button
   - Check confirmation message (success or error)

4. **Save Configuration**
   - Click **"Save Email Settings"** button
   - Success message: "Email settings updated!"

### Reports & Analytics (Admin View)

#### Accessing Advanced Reports

**Location**: Admin Dashboard > Reports > Advanced Analytics

**Step-by-Step Instructions**:

1. **Navigate to Advanced Reports**
   - Click "Admin" in main menu
   - Click "Reports" submenu
   - Select "Advanced Analytics"

2. **View Dashboard Metrics**
   - Page displays:
     - **Total Revenue** (last 30 days)
     - **Total Orders** (count and trend)
     - **Active Users** (currently online)
     - **System Health** (uptime, performance)

3. **Generate Detailed Reports**
   - **Revenue Report by Period**: 
     - Select date range (From Date > To Date)
     - Click **"Generate Revenue Report"** button
     - View breakdown by time period
   
   - **User Activity Report**:
     - Select date range
     - Click **"Generate Activity Report"** button
     - See login times, actions performed per user
   
   - **Product Performance Report**:
     - Click **"Generate Product Report"** button
     - View top-selling products, low-stock items

4. **Export Reports**
   - Click **"📥 Download as CSV"**, **"📥 Download as Excel"**, or **"📥 Download as PDF"** button
   - Select location to save
   - File downloads to computer

5. **Schedule Automated Reports** (if available)
   - Click **"⚙️ Schedule Reports"** button
   - Select report type
   - Set frequency (Daily / Weekly / Monthly)
   - Enter recipient email addresses
   - Click **"Schedule"** button

### System Maintenance

#### Clearing Cache

**Location**: Admin Dashboard > Maintenance > Clear Cache

**Step-by-Step Instructions**:

1. **Access Maintenance Tools**
   - Click "Admin" in main menu
   - Click "Maintenance" submenu
   - Select "Clear Cache"

2. **View Cache Status**
   - Current cache size is displayed
   - Number of cached items shown

3. **Clear Application Cache**
   - Click **"Clear Application Cache"** button (orange/warning button)
   - Confirmation dialog appears:
     - "This will clear all cached data. Continue?"
   
4. **Confirm Action**
   - Click **"Yes, Clear Cache"** button (orange) to confirm
   - OR click **"Cancel"** to abort

5. **Verify Completion**
   - Success message: "Cache cleared successfully!"
   - Cache size resets to minimal

#### Backup Database

**Location**: Admin Dashboard > Maintenance > Database Backup

**Step-by-Step Instructions**:

1. **Navigate to Backup**
   - Click "Admin" in main menu
   - Click "Maintenance" submenu
   - Select "Database Backup"

2. **View Backup Information**
   - Last backup date and time displayed
   - List of previous backups shown with:
     - Backup date
     - File size
     - Download option

3. **Create New Backup**
   - Click **"🔄 Create New Backup"** button (blue)
   - Processing message appears: "Creating backup... Please wait"

4. **Wait for Completion**
   - Process may take several minutes depending on database size
   - Progress indicator shows completion percentage

5. **Download Backup**
   - Once complete, success message appears: "Backup created successfully!"
   - New backup appears in the list
   - Click **"📥 Download"** button next to backup to save locally

6. **Verify Backup**
   - File downloads to computer's Downloads folder
   - Filename format: `freshtrackmart_backup_YYYY-MM-DD_HHMMSS.sql`

### Activity Logging

#### Viewing System Activity Logs

**Location**: Admin Dashboard > Logs > Activity Logs

**Step-by-Step Instructions**:

1. **Access Activity Logs**
   - Click "Admin" in main menu
   - Click "Logs" submenu
   - Select "Activity Logs"

2. **View Log Entries**
   - Table displays all system activities with:
     - Timestamp (date and time)
     - User (who performed action)
     - Action (what was done)
     - Module (Products, Users, Orders, etc.)
     - IP Address
     - Status (Success / Error)

3. **Filter Logs**
   - **Date Range**: Select From Date and To Date
   - **User Filter**: Select specific user from dropdown
   - **Action Type**: Filter by action (Create, Update, Delete, Login, etc.)
   - **Module Filter**: Select module (Products, Users, etc.)
   - Click **"Apply Filters"** button

4. **Search Logs**
   - Use **Search Box** at top to find specific entries
   - Enter keyword (username, product name, IP address)
   - Press Enter or click **"Search"** button

5. **View Detailed Log Entry**
   - Click on any log row to expand and view full details
   - Shows complete information about the action

6. **Export Activity Logs**
   - Click **"📥 Export as CSV"** or **"📥 Export as PDF"** button
   - Select date range if prompted
   - File downloads to computer

#### Viewing Error Logs

**Location**: Admin Dashboard > Logs > Error Logs

**Step-by-Step Instructions**:

1. **Access Error Logs**
   - Click "Admin" in main menu
   - Click "Logs" submenu
   - Select "Error Logs"

2. **View Errors**
   - Table displays system errors and exceptions with:
     - Timestamp
     - Error Type (Exception, Warning, Notice)
     - Error Message
     - File and Line Number where error occurred
     - Stack Trace (for technical details)

3. **Filter by Severity**
   - **Error Severity** dropdown: Select:
     - Critical (system down)
     - Error (functionality broken)
     - Warning (potential issues)
     - Info (informational only)

4. **Search and Filter**
   - Use date range filters
   - Search by error message keywords
   - Click **"Apply Filters"** button

5. **View Detailed Error**
   - Click on error row to expand
   - Full stack trace displayed for debugging

6. **Clear Old Errors**
   - Click **"🗑️ Clear Errors Older Than..."** button
   - Select time period (7 days, 30 days, 90 days)
   - Click **"Clear"** button to remove old log entries

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

- **Manual Version**: 3.0
- **Last Updated**: 2026-05-17
- **Author**: Auto-generated for FreshTrackMart
- **Updates**: Added comprehensive Admin Guide section with step-by-step instructions for all admin functions and buttons

---

**Thank you for using FreshTrackMart! Happy coding! 🚀**
