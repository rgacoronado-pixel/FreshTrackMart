# FreshTrackMart - Administrator Guide

## Table of Contents
1. [Introduction](#introduction)
2. [Admin Dashboard](#admin-dashboard)
3. [User Management](#user-management)
4. [System Settings](#system-settings)
5. [Database Management](#database-management)
6. [Monitoring & Logs](#monitoring--logs)
7. [Security & Backup](#security--backup)
8. [Performance Optimization](#performance-optimization)
9. [Troubleshooting Admin Issues](#troubleshooting-admin-issues)
10. [Advanced Administration](#advanced-administration)

---

## Introduction

This Administrator Guide provides comprehensive instructions for managing and maintaining the FreshTrackMart application. It covers user administration, system configuration, database management, security, and troubleshooting for administrative users with elevated privileges.

### Who Should Read This Guide?

- System Administrators
- Database Administrators (DBAs)
- Development Team Leads
- Application Managers
- System Maintenance Personnel

### Admin Prerequisites

- Administrator account credentials
- SSH/Terminal access to the server
- Database administration tools
- Server file system access
- Basic command-line knowledge

---

## Admin Dashboard

### Accessing the Admin Panel

#### Step 1: Login as Administrator
1. Navigate to `http://your-domain.com/admin` or login with admin account
2. Enter your **Administrator Email** (provided during setup)
3. Enter your **Administrator Password**
4. Click **Login** button
5. Two-Factor Authentication (if enabled) - enter verification code

#### Step 2: Admin Dashboard Overview
Once logged in, the admin dashboard displays:

**Key Metrics Section** (Top of Dashboard)
- **Total Users**: Number of registered users in the system
- **Active Sessions**: Currently logged-in users
- **System Health**: Green (Healthy) / Yellow (Warning) / Red (Critical)
- **Storage Usage**: Current database and file storage percentage

**Quick Actions** (Center of Dashboard)
- "👥 Manage Users" button
- "⚙️ System Settings" button
- "📊 View Reports" button
- "🔧 Maintenance" button
- "📜 View Logs" button

**System Activity** (Bottom Section)
- Recent user logins
- Recent database changes
- System errors and warnings
- Recent admin actions

### Dashboard Navigation

**Top Menu Bar**
- **Dashboard** - Return to main admin dashboard
- **Users** - Manage user accounts
- **Settings** - Configure system settings
- **Database** - Database management tools
- **Logs** - View system and activity logs
- **Backup** - Backup and restore options
- **Support** - Help and documentation

**Left Sidebar** (if present)
- Quick navigation to main admin functions
- Search functionality
- Admin profile access

---

## User Management

### Viewing All Users

**Location**: Admin Menu > Users > All Users

#### Step-by-Step Instructions

1. **Navigate to User Management**
   - Click "Users" in the admin menu
   - Select "All Users" from dropdown
   - User list page loads

2. **View User Information**
   - Table displays all registered users with columns:
     - **User ID**: Unique identifier
     - **Name**: User's full name
     - **Email**: Email address
     - **Role**: User role (Admin / Manager / Customer / etc.)
     - **Status**: Active / Inactive / Suspended
     - **Joined Date**: Account creation date
     - **Last Login**: Last access timestamp
     - **Actions**: Edit / View / Suspend / Delete

3. **Search for Specific User**
   - Use search bar at top of table
   - Enter user email, name, or ID
   - Press Enter to filter results

4. **Filter Users by Role**
   - Click "Filter by Role" dropdown
   - Select: Admin / Manager / Customer / All Roles
   - Table updates to show filtered results

5. **Filter Users by Status**
   - Click "Filter by Status" dropdown
   - Select: Active / Inactive / Suspended / All Statuses
   - List updates accordingly

6. **Sort Users**
   - Click on column headers to sort
   - Click again to reverse sort order
   - Options: Sort by Name, Email, Join Date, Last Login

### Creating a New User

**Location**: Admin Menu > Users > Add New User

#### Step-by-Step Instructions

1. **Navigate to Add User**
   - Click "Users" in the admin menu
   - Click "Add New User" button (+ icon)
   - New user form opens

2. **Enter User Information**
   - **First Name** field: Enter first name
   - **Last Name** field: Enter last name
   - **Email Address** field: Enter unique email
   - **Phone Number** field: Enter contact number (optional)
   - **Date of Birth** field: Click calendar and select date (optional)
   - **Address** field: Enter complete address

3. **Set User Credentials**
   - **Username** field: Auto-generated or enter custom username
   - **Temporary Password** field: Click "Generate Password" button
     - Strong password auto-generates (shown in gray field)
     - Can manually enter custom password
   - **Send Welcome Email**: Check box to email credentials to user

4. **Assign User Role**
   - **User Role** dropdown: Select from:
     - **Admin**: Full system access and management capabilities
     - **Manager**: Department or project management access
     - **Staff**: Standard employee access
     - **Customer**: Limited user access
     - **Guest**: Read-only access
   
5. **Set Permissions** (if available for selected role)
   - Check boxes for specific permissions:
     - Product Management
     - Inventory Management
     - Reports Access
     - User Management
     - Settings Access
   - Different roles have different default permissions

6. **Account Status**
   - **Active**: User can immediately login
   - **Inactive**: User cannot login until activated
   - Select appropriate status

7. **Additional Settings**
   - **Department** field: Select user's department
   - **Manager** field: Assign reporting manager (dropdown)
   - **Cost Center** field: Assign cost center code

8. **Review and Save**
   - Click **"Create User"** button (green)
   - Success message appears: "User created successfully!"
   - New user account is now active (if set to Active status)

9. **Verify Creation**
   - User appears in the Users list
   - Welcome email sent to user's email address (if option enabled)

### Editing User Information

**Location**: Users List > User Row > Edit Button

#### Step-by-Step Instructions

1. **Locate User**
   - Go to Users > All Users
   - Find user in list (use search if needed)

2. **Open Edit Form**
   - Click **✏️ Edit** button in the user's row
   - Or click the user's name to open user details page
   - Click **"Edit"** button on details page
   - Edit form opens with current user information

3. **Modify User Information**
   - **Personal Information**:
     - Update First Name / Last Name
     - Change Email (if allowed)
     - Update Phone Number
   - **Role & Permissions**:
     - Change User Role from dropdown
     - Update permission checkboxes
   - **Status**:
     - Change account status (Active / Inactive / Suspended)
   - **Department**:
     - Reassign department if needed

4. **Update Changes**
   - Click blue **"Update User"** button
   - Success message: "User updated successfully!"
   - Changes take effect immediately

5. **Password Management**
   - **To Reset User Password**:
     - Click "🔑 Reset Password" button in edit form
     - Click "Generate New Password"
     - New temporary password displays
     - Click "Copy" to copy password
     - Click "Send Email" to email new password to user
     - User can change password at next login

### Suspending a User Account

**Location**: Users List > User Row > Actions

#### Step-by-Step Instructions

1. **Find User in List**
   - Navigate to Users > All Users
   - Locate the user to suspend

2. **Suspend Account**
   - Click **"⏸️ Suspend"** button (pause icon) in user's row
   - Confirmation dialog appears: "Suspend user account?"
   - Click **"Yes, Suspend"** to confirm
   - Success message: "User account suspended"

3. **Effects of Suspension**
   - User cannot login to the system
   - Active sessions are terminated
   - User still appears in user list
   - Can be reactivated later

4. **Reactivate Suspended User**
   - Click user row / open user details
   - Click **"▶️ Reactivate"** button
   - Confirmation: "Reactivate user account?"
   - Click **"Yes, Reactivate"**
   - User can login again

### Deleting a User Account

**Location**: Users List > User Row > Delete Option

#### Step-by-Step Instructions

1. **Navigate to User**
   - Go to Users > All Users
   - Find the user to delete

2. **Initiate Deletion**
   - Click **"🗑️ Delete"** button (trash icon - red) in user's row
   - Warning dialog appears: "Permanently delete this user? This action cannot be undone!"

3. **Confirm Deletion**
   - Click **"Yes, Delete Permanently"** (red button) to confirm
   - OR click **"Cancel"** (gray button) to abort

4. **Verify Deletion**
   - User is removed from the system
   - User email address becomes available
   - All user data is deleted (unless backup archived)
   - Success message confirms deletion

### Viewing User Activity

**Location**: Users > [User Name] > Activity Log

#### Step-by-Step Instructions

1. **Open User Details**
   - Go to Users > All Users
   - Click on user's name to open details page

2. **View Activity Tab**
   - Click on **"📋 Activity"** tab
   - Activity log displays showing:
     - **Timestamp**: Date and time of action
     - **Action**: What user did (Login, View Page, Update Record, etc.)
     - **Details**: Additional information about action
     - **IP Address**: User's IP address when action occurred

3. **Filter Activity**
   - **Date Range**: Select start and end dates
   - **Action Type**: Filter by specific actions
   - **Status**: Filter by success/failure of actions
   - Click **"Apply Filters"** to update log

4. **Export Activity Log**
   - Click **"📥 Download as CSV"** button
   - Or click **"📥 Download as PDF"** button
   - File downloads to your computer

---

## System Settings

### Accessing System Settings

**Location**: Admin Menu > Settings > System Settings

#### Navigation Instructions

1. Click "Settings" in admin menu
2. Select "System Settings" from dropdown
3. Settings page loads with multiple configuration tabs

### General Application Settings

#### Location: Settings > General

**Step-by-Step Instructions**:

1. **Access General Settings**
   - Go to Settings > General tab

2. **Configure Application Information**
   - **Application Name**: Enter application name (default: "FreshTrackMart")
   - **Application URL**: Enter base URL (e.g., `http://localhost:8000`)
   - **Application Email**: Set system email address for notifications
   - **Application Logo**: Upload company/app logo image
   - **Favicon**: Upload favicon (appears in browser tab)

3. **Set System Language**
   - **Default Language**: Select from dropdown:
     - English
     - Spanish
     - French
     - German
     - (Add more as available)
   - **Allow User Language Change**: Toggle on/off

4. **Configure Timezone**
   - **System Timezone**: Select from dropdown (e.g., UTC, EST, PST, etc.)
   - All times display in this timezone

5. **Save Changes**
   - Click blue **"Save Settings"** button
   - Success message: "Settings saved successfully!"

### Email & Notification Settings

#### Location: Settings > Email

**Step-by-Step Instructions**:

1. **Navigate to Email Settings**
   - Go to Settings > Email tab

2. **Configure SMTP Server**
   - **SMTP Host**: Enter mail server address (e.g., smtp.gmail.com)
   - **SMTP Port**: Enter port number (usually 587 or 465)
   - **SMTP Username**: Enter email account username
   - **SMTP Password**: Enter email account password
   - **Encryption**: Select TLS or SSL

3. **Test Email Configuration**
   - Enter **Test Email Address** field
   - Click blue **"Send Test Email"** button
   - Confirmation: "Test email sent successfully!" or error message

4. **Configure Notification Email**
   - **From Name**: Name emails appear from (e.g., "FreshTrackMart Support")
   - **From Email**: Email address notifications send from
   - **Reply-To Email**: Where user replies go

5. **Notification Settings**
   - Check boxes for notification types to enable:
     - ☑️ New User Registration Notifications
     - ☑️ Order Notifications
     - ☑️ System Error Notifications
     - ☑️ Daily Admin Report
     - ☑️ Weekly Summary Report

6. **Save Email Settings**
   - Click **"Save Email Settings"** button
   - Settings applied immediately

### Security Settings

#### Location: Settings > Security

**Step-by-Step Instructions**:

1. **Navigate to Security Settings**
   - Go to Settings > Security tab

2. **Password Policy**
   - **Minimum Password Length**: Set minimum characters (default: 8)
   - **Require Uppercase Letters**: Toggle on/off
   - **Require Numbers**: Toggle on/off
   - **Require Special Characters**: Toggle on/off
   - **Password Expiration Days**: Enter days before password expires (0 = no expiration)
   - **Password History**: Prevent reuse of last N passwords

3. **Login Security**
   - **Maximum Login Attempts**: Number of failed attempts before lockout (e.g., 5)
   - **Lockout Duration (minutes)**: How long account locked after failed attempts (e.g., 15)
   - **Two-Factor Authentication**: Toggle on/off
   - **IP Whitelist**: Enter trusted IPs (one per line) - only these IPs can access admin panel

4. **Session Management**
   - **Session Timeout (minutes)**: Idle time before session expires (e.g., 30)
   - **Concurrent Sessions**: Allow multiple logins per user? Toggle on/off
   - **Max Sessions Per User**: Maximum concurrent sessions (if allowed)

5. **Data Protection**
   - **Enable HTTPS**: Toggle on (required for production)
   - **SSL Certificate**: Upload SSL certificate file (for HTTPS)
   - **Encrypt Sensitive Data**: Toggle on
   - **Enable Data Encryption**: Toggle encryption for database fields

6. **Save Security Settings**
   - Click **"Save Security Settings"** button
   - Settings take effect after confirmation

### Backup Settings

#### Location: Settings > Backup

**Step-by-Step Instructions**:

1. **Navigate to Backup Settings**
   - Go to Settings > Backup tab

2. **Configure Automatic Backups**
   - **Enable Automatic Backup**: Toggle on/off
   - **Backup Frequency**: 
     - Select: Daily / Weekly / Monthly
   - **Backup Time**: Select time to run backup (e.g., 2:00 AM)
   - **Backup Destination**: Select storage location

3. **Backup Retention**
   - **Keep Backups For (days)**: How long to retain backups (e.g., 30)
   - **Maximum Backup Count**: Maximum number of backups to keep (e.g., 10)

4. **Backup Content**
   - Check boxes for what to include in backup:
     - ☑️ Database
     - ☑️ Application Files
     - ☑️ Uploaded Files
     - ☑️ Configurations

5. **Manual Backup**
   - Click blue **"Create Manual Backup Now"** button
   - Backup process starts
   - Success message when complete

6. **Save Backup Settings**
   - Click **"Save Backup Settings"** button

---

## Database Management

### Database Connection Information

**Location**: Admin Menu > Database > Connection Info

#### Viewing Database Details

1. **Navigate to Database Section**
   - Click "Database" in admin menu
   - Click "Connection Info"

2. **View Current Connection**
   - **Database Type**: MySQL, PostgreSQL, SQLite, etc.
   - **Host**: Database server address
   - **Port**: Database port number
   - **Database Name**: Current database name
   - **Username**: Database user account
   - **Status**: Connected / Disconnected

### Running Database Migrations

#### Location: Admin Menu > Database > Run Migrations

**Step-by-Step Instructions**:

1. **Access Migration Tool**
   - Go to Database > Run Migrations
   - Page shows pending migrations to run

2. **Review Pending Migrations**
   - List displays all migrations not yet executed
   - Shows migration name and description

3. **Execute Migrations**
   - Click blue **"Run All Pending Migrations"** button
   - System begins running migrations
   - Progress bar shows completion percentage
   - Logs display migration steps

4. **Verify Completion**
   - Success message: "All migrations completed successfully!"
   - No pending migrations remain in list

5. **Rollback Migrations** (if needed)
   - Click **"Rollback"** button to reverse last migration
   - Confirmation: "Rollback last migration?"
   - Click "Confirm" to proceed

### Optimizing Database

#### Location: Admin Menu > Database > Optimization

**Step-by-Step Instructions**:

1. **Navigate to Database Optimization**
   - Go to Database > Optimization

2. **Review Current Statistics**
   - Display shows:
     - Database size
     - Table count
     - Record count
     - Indexes count
     - Last optimization date

3. **Run Optimization**
   - Click blue **"Optimize Database"** button
   - Optimization process runs
   - System analyzes tables and rebuilds indexes

4. **View Optimization Results**
   - Space saved amount displays
   - Performance improvement percentage shown
   - Completed tables list shows

5. **Schedule Regular Optimization**
   - **Automated Optimization**: Toggle on/off
   - **Run Optimization**: Select frequency (Weekly / Monthly)
   - **Preferred Time**: Select time to run
   - Click "Save Schedule"

### Database Backup & Restore

#### Creating Database Backup

**Location**: Admin Menu > Backup > Database Backup

**Step-by-Step Instructions**:

1. **Navigate to Backup Section**
   - Go to Backup > Database Backup

2. **Create New Backup**
   - Click blue **"Create Database Backup"** button
   - Backup file creation starts
   - Progress indicator shows status

3. **Backup Options**
   - **Include Tables**: Select which tables to backup (or All)
   - **Compression**: Toggle compression on/off (saves space)
   - **Include Data**: Toggle on/off (if only backing up schema)

4. **Monitor Backup**
   - Backup time displays (estimated completion)
   - Files included counter shows progress
   - Can cancel backup with "Cancel Backup" button

5. **Backup Complete**
   - Success message: "Backup completed successfully!"
   - Backup file available for download

6. **Download Backup**
   - Click **"📥 Download"** button next to backup
   - File downloads to your computer
   - Backup is also stored on server

#### Restoring Database from Backup

**Location**: Admin Menu > Backup > Restore Database

**Step-by-Step Instructions**:

1. **Navigate to Restore Option**
   - Go to Backup > Restore Database

2. **Select Backup File**
   - **From Server Backups**: Click to view available backups
     - List shows all backups with date and size
     - Click **"Select"** button next to desired backup
   - **Upload File**: Click to upload backup file from computer
     - Click **"Browse"** button
     - Select .sql or .zip file
     - Click "Upload"

3. **Confirm Restoration**
   - Warning dialog: "Restore database? Current data will be overwritten!"
   - **Backup Current Data First**: Toggle on (recommended)
     - If on, current data backed up before restore
   - Click **"Yes, Restore"** to proceed
   - Click "Cancel" to abort

4. **Monitor Restoration**
   - Progress bar shows restoration progress
   - Current action displays (Restoring tables, importing data, etc.)
   - Estimated time remaining shown

5. **Restoration Complete**
   - Success message: "Database restored successfully!"
   - System resumes normal operation
   - All data from backup now restored

---

## Monitoring & Logs

### Accessing System Logs

**Location**: Admin Menu > Logs > System Logs

#### Viewing System Logs

1. **Navigate to Logs Section**
   - Click "Logs" in admin menu
   - Click "System Logs"
   - Logs display in reverse chronological order (newest first)

2. **Log Information Displayed**
   - **Timestamp**: Date and time of event
   - **Level**: Info / Warning / Error / Critical
   - **Module**: Part of system where log originated
   - **Message**: Detailed log message
   - **User**: Admin who triggered the log (if applicable)

3. **Filter Logs**
   - **Log Level**: Filter by Info / Warning / Error / Critical
   - **Date Range**: Select start and end dates
   - **Module**: Filter by system module
   - **Search**: Search for specific text in logs
   - Click **"Apply Filters"** to update

4. **View Log Details**
   - Click on log entry to expand full details
   - Shows full message text and additional information
   - Stack trace displays for errors

5. **Export Logs**
   - Click **"📥 Export as CSV"** button
   - Or click **"📥 Export as PDF"** button
   - File downloads to your computer

### Activity Logs

**Location**: Admin Menu > Logs > Activity Logs

#### Step-by-Step Instructions

1. **Navigate to Activity Logs**
   - Go to Logs > Activity Logs
   - Shows all user and admin activities

2. **Review Activity Entries**
   - Columns show:
     - **Timestamp**: When activity occurred
     - **User**: Who performed action
     - **Action**: What was done (Created, Updated, Deleted, Viewed, etc.)
     - **Resource**: What was affected (Product, User, etc.)
     - **Details**: Additional information
     - **IP Address**: User's IP address
     - **Status**: Success / Failure

3. **Filter Activities**
   - **Action Type**: Select specific action to filter
   - **User**: Filter by specific user
   - **Date Range**: Select date range
   - Click **"Filter"** to apply

4. **Advanced Search**
   - Click **"Advanced Search"** option
   - Search by multiple criteria:
     - User email
     - Resource type
     - Action type
     - Date range
     - IP address
   - Click **"Search"** to find specific activities

### Performance Monitoring

**Location**: Admin Menu > Monitoring > System Performance

#### Checking System Performance

1. **Navigate to Performance Monitor**
   - Go to Monitoring > System Performance
   - Dashboard displays performance metrics

2. **View Performance Metrics**
   - **CPU Usage**: Current percentage and chart
   - **Memory Usage**: RAM usage percentage
   - **Disk Usage**: Storage space used
   - **Database Queries**: Number of queries per second
   - **Response Time**: Average page load time

3. **View Performance Charts**
   - Charts display data over time period
   - **Time Range**: Select 1 Hour / 6 Hours / 24 Hours / 7 Days
   - Hover over chart to see specific values

4. **Identify Performance Issues**
   - Red indicators show critical issues
   - Yellow indicators show warnings
   - Green indicators show healthy status

5. **Get Optimization Recommendations**
   - System displays optimization suggestions
   - Click **"Apply Recommendation"** to implement
   - Some recommendations require system restart

---

## Security & Backup

### Managing Admin Accounts

**Location**: Admin Menu > Settings > Admin Accounts

#### Step-by-Step Instructions

1. **Navigate to Admin Accounts**
   - Go to Settings > Admin Accounts
   - List of all administrator accounts displays

2. **View Admin Account Details**
   - Shows all admins with:
     - Name
     - Email
     - Last Login
     - Status (Active / Inactive)
     - Permissions
     - Created Date

3. **Change Admin Permissions**
   - Click **"⚙️ Edit Permissions"** button
   - Checkboxes for available permissions display
   - Select/deselect permissions as needed
   - Click **"Update Permissions"** to save

4. **Disable Admin Account**
   - Click **"⏸️ Disable"** button
   - Admin cannot login but account not deleted
   - Can be re-enabled later

5. **Enable Disabled Admin**
   - Click **"▶️ Enable"** button
   - Admin can login again

### Two-Factor Authentication (2FA)

**Location**: Admin Menu > Settings > Security > Two-Factor Auth

#### Enabling 2FA for Admin

1. **Navigate to 2FA Settings**
   - Go to Settings > Security > Two-Factor Auth

2. **Enable 2FA**
   - Click **"Enable 2FA"** button
   - Choose authentication method:
     - **Authenticator App**: Google Authenticator, Microsoft Authenticator, etc.
     - **SMS**: Text message with code
     - **Email**: Email with code

3. **Setup Authenticator App**
   - Click "Authenticator App" option
   - QR code displays on screen
   - Scan QR code with authenticator app on phone
   - Or enter manual setup key if QR not available
   - App generates 6-digit code
   - Enter code in "Verification Code" field
   - Click "Verify" to confirm setup

4. **Setup SMS 2FA**
   - Select "SMS" option
   - Enter phone number
   - Click "Send Verification Code"
   - Code texted to phone number
   - Enter code and click "Verify"

5. **Backup Codes**
   - System generates backup codes (10 codes)
   - Store in secure location
   - Use if phone/authenticator not available
   - Download and print codes for safekeeping
   - Click "🖨️ Print" to print backup codes

6. **Disable 2FA**
   - Click "Disable 2FA" button
   - Confirmation prompt appears
   - Enter admin password to confirm
   - 2FA disabled after confirmation

### User Security Audit

**Location**: Admin Menu > Security > Audit

#### Running Security Audit

1. **Navigate to Security Audit**
   - Go to Security > Audit

2. **Run Security Scan**
   - Click blue **"Run Security Audit"** button
   - System scans for security issues:
     - Weak passwords
     - Unused accounts
     - Suspicious login patterns
     - Permission issues
     - Configuration issues

3. **Review Audit Results**
   - Issues list displays with severity levels
   - Each issue shows:
     - Issue description
     - Severity (Critical / High / Medium / Low)
     - Affected users/items
     - Recommended action

4. **Address Issues**
   - For each issue:
     - Click "🔧 Fix Automatically" to let system fix
     - Or click "ℹ️ Learn More" for manual fix instructions
   - System fixes applicable issues
   - Manual issues require admin action

5. **View Audit History**
   - Click **"Audit History"** tab
   - Previous audits listed with date and results
   - Can compare security posture over time

---

## Performance Optimization

### Caching Configuration

**Location**: Admin Menu > Settings > Performance > Caching

#### Configuring Cache

1. **Navigate to Cache Settings**
   - Go to Settings > Performance > Caching

2. **Select Cache Driver**
   - **Cache Driver**: Choose from:
     - File (default, slower)
     - Redis (faster, requires Redis server)
     - Memcached (fast, requires Memcached)
     - Database (slower)
   - Select appropriate option for your setup

3. **Configure Cache Settings**
   - **Cache TTL (minutes)**: Time before cache expires (e.g., 60)
   - **Cache Prefix**: Prefix for all cache keys (e.g., "freshtrackmart_")
   - **Cache All Database Queries**: Toggle on/off
   - **Cache API Responses**: Toggle on/off

4. **Clear Cache**
   - Click blue **"Clear All Cache"** button
   - Confirmation: "Clear all cached data?"
   - Click "Confirm"
   - Success message: "Cache cleared successfully!"

5. **Monitor Cache Performance**
   - **Cache Hit Rate**: Percentage of cache hits
   - **Cache Size**: Total cache memory used
   - Chart shows hit rate over time

6. **Save Cache Settings**
   - Click **"Save Cache Settings"** button

### Database Query Optimization

**Location**: Admin Menu > Database > Query Optimization

#### Identifying Slow Queries

1. **View Slow Query Log**
   - Go to Database > Query Optimization
   - Table displays slow queries (queries taking longer than threshold)

2. **Analyze Query Performance**
   - **Query**: SQL query text
   - **Execution Time**: How long query takes (milliseconds)
   - **Calls**: Number of times query executed
   - **Total Time**: Sum of all execution times
   - Click **"Analyze"** to see optimization suggestions

3. **Apply Optimization**
   - System suggests indexes to create
   - Or suggests query rewrites
   - Click **"Apply Index"** to create recommended index
   - Index creation logs display

### Enabling Compression

**Location**: Admin Menu > Settings > Performance > Compression

#### Step-by-Step Instructions

1. **Navigate to Compression Settings**
   - Go to Settings > Performance > Compression

2. **Enable GZIP Compression**
   - **Compression Enabled**: Toggle on
   - Reduces data transfer size
   - Improves page load times

3. **Configure Compression**
   - **Compression Level**: Select 1-9 (1=fast, 9=maximum compression)
   - Recommended: 6 (good balance)
   - **Compress Images**: Toggle on/off
   - **Minify CSS**: Toggle on
   - **Minify JavaScript**: Toggle on
   - **Minify HTML**: Toggle on

4. **Test Compression**
   - Click blue **"Test Compression"** button
   - System tests compression ratio
   - Results show compression effectiveness
   - Time savings and bandwidth reduction displayed

5. **Save Compression Settings**
   - Click **"Save Settings"** button

---

## Troubleshooting Admin Issues

### Common Admin Problems

#### Issue 1: Cannot Access Admin Panel

**Problem**: Login page shows but credentials don't work

**Solution Steps**:

1. **Verify Admin Account Exists**
   ```bash
   cd sims2
   php artisan tinker
   >>> App\Models\User::where('role','admin')->get();
   ```

2. **Reset Admin Password**
   ```bash
   php artisan tinker
   >>> $user = App\Models\User::find(1); // Assuming admin ID is 1
   >>> $user->password = Hash::make('newpassword');
   >>> $user->save();
   >>> exit
   ```

3. **Check Admin IP Whitelist**
   - Go to Settings > Security
   - Verify your IP is in whitelist (or whitelist is empty)
   - Click "Add My IP" to add current IP

4. **Clear Admin Sessions**
   - Go to Logs > Sessions
   - Click "Clear All Sessions"
   - Logout and login again

#### Issue 2: Database Connection Error in Admin Panel

**Problem**: "Error: Could not connect to database"

**Solution Steps**:

1. **Verify Database Credentials**
   - Open `.env` file in application root
   - Check DB_HOST, DB_PORT, DB_USERNAME, DB_PASSWORD
   - Ensure credentials are correct

2. **Test Database Connection**
   ```bash
   php artisan tinker
   >>> DB::connection()->getPdo();
   ```
   - Should return database connection object
   - If error, credentials are incorrect

3. **Restart Database Server**
   ```bash
   # On Windows (if MySQL)
   net stop MySQL80
   net start MySQL80
   
   # On Mac/Linux
   sudo service mysql restart
   ```

4. **Check Database Server is Running**
   - Verify MySQL/PostgreSQL service is active
   - Verify port is correct (default MySQL: 3306)

#### Issue 3: Admin Actions Not Saving

**Problem**: Changes made in admin panel don't persist

**Solution Steps**:

1. **Check Database Permissions**
   ```bash
   # Verify database user has write permissions
   mysql -u root -p -e "GRANT ALL ON freshtrackmart.* TO 'db_user'@'localhost';"
   ```

2. **Verify Disk Space**
   - Check server has available disk space
   - Full disk prevents database writes
   - Run: `df -h` (on Linux/Mac)

3. **Clear Laravel Cache**
   ```bash
   php artisan cache:clear
   php artisan config:cache
   php artisan view:clear
   ```

4. **Check Database Lock**
   - Long-running processes may lock database
   - Check active processes: `SHOW PROCESSLIST;` in MySQL
   - Kill long queries if needed

#### Issue 4: Performance Issues in Admin Panel

**Problem**: Admin panel is slow to load or respond

**Solution Steps**:

1. **Check System Resources**
   - Go to Monitoring > System Performance
   - Review CPU, memory, disk usage
   - If any above 90%, investigate

2. **Optimize Database**
   - Go to Database > Optimization
   - Click "Optimize Database"
   - Rebuilds indexes and reclaims space

3. **Clear Cache**
   - Go to Settings > Performance > Caching
   - Click "Clear All Cache"
   - May take 2-3 seconds to rebuild

4. **Enable Compression**
   - Go to Settings > Performance > Compression
   - Enable GZIP compression
   - Enable minification options

5. **Check Slow Queries**
   - Go to Database > Query Optimization
   - Review slow queries
   - Apply recommended optimizations

---

## Advanced Administration

### Command Line Administration

#### Useful Artisan Commands

```bash
# User management
php artisan make:user --admin        # Create admin user
php artisan user:list               # List all users

# Database management
php artisan migrate                  # Run migrations
php artisan migrate:rollback         # Rollback migrations
php artisan migrate:refresh          # Refresh all migrations
php artisan migrate:reset            # Reset all migrations

# Cache management
php artisan cache:clear              # Clear cache
php artisan route:cache              # Cache routes
php artisan config:cache             # Cache config

# Maintenance
php artisan maintenance:on           # Enable maintenance mode
php artisan maintenance:off          # Disable maintenance mode
php artisan storage:link             # Create storage symlink

# Queue jobs
php artisan queue:work               # Process queue jobs
php artisan queue:failed             # Show failed jobs
php artisan queue:retry              # Retry failed jobs

# Debugging
php artisan tinker                   # Interactive shell
php artisan debug:event-listeners    # List event listeners
```

### Backup & Disaster Recovery

#### Full System Backup Procedure

1. **Create Database Backup**
   - Go to Backup > Database Backup
   - Click "Create Database Backup"
   - Download backup file

2. **Backup Application Files**
   ```bash
   tar -czf freshtrackmart-backup.tar.gz /path/to/application
   ```

3. **Store Backups Securely**
   - Store on external drive
   - Store in cloud storage (Google Drive, Dropbox, AWS S3)
   - Maintain at least 3 backup copies

4. **Test Backup Recovery**
   - Periodically restore backups to test system
   - Ensure restored system works properly
   - Verify data integrity

#### Disaster Recovery Steps

If system fails:

1. **Restore Application Files**
   ```bash
   tar -xzf freshtrackmart-backup.tar.gz -C /path/to/restore
   ```

2. **Restore Database**
   - Go to Backup > Restore Database
   - Select backup file
   - Complete restoration process

3. **Verify System**
   - Test application login
   - Verify data integrity
   - Check that all functionality works

4. **Update Admin Contacts**
   - Notify administrators of restoration
   - Ask to verify their data

### Scheduled Tasks & Automation

#### Setting Up Automated Tasks

1. **Configure Cron Jobs** (Linux/Mac)
   - Edit crontab: `crontab -e`
   - Add laravel scheduler:
     ```
     * * * * * cd /path/to/application && php artisan schedule:run >> /dev/null 2>&1
     ```

2. **Schedule Tasks in Admin Panel**
   - Go to Admin > Settings > Scheduled Tasks
   - Click "Add New Task"
   - Select task type (Backup, Report, Cleanup, etc.)
   - Set frequency (Daily, Weekly, Monthly)
   - Set execution time
   - Click "Save"

3. **Monitor Scheduled Tasks**
   - Go to Admin > Logs > Task Logs
   - View last execution time
   - View success/failure status
   - Review task output logs

---

## Version Information

- **Project Name**: FreshTrackMart
- **Repository**: [rgacoronado-pixel/FreshTrackMart](https://github.com/rgacoronado-pixel/FreshTrackMart)
- **Default Branch**: master
- **Admin Guide Version**: 1.0
- **Last Updated**: May 17, 2026

---

## Support & Resources

### Getting Help

- **Admin Documentation**: Internal documentation at `/docs/admin`
- **GitHub Issues**: [Report Admin Issues](https://github.com/rgacoronado-pixel/FreshTrackMart/issues)
- **Laravel Documentation**: [Laravel Admin Documentation](https://laravel.com/docs)
- **Community Support**: GitHub discussions and Laravel community forums

### Useful Commands Reference

```bash
# Quick reference for common commands
php artisan list                     # List all available commands
php artisan help migrate             # Get help for specific command
php artisan env                      # Show current environment
```

---

**Thank you for administering FreshTrackMart! For questions or issues, please refer to the support section above. 🚀**
