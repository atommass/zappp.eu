# Zappp Project Outline - Report Preparation

## 1. Project Overview

### 1.1 Project Name & Purpose
- **Project Name:** Zappp (formerly zippp)
- **Type:** Web Application - URL Shortener Service
- **Description:** A lightweight, user-friendly URL shortener built on the Laravel framework designed for small teams and personal use
- **Target Users:** Individuals and small teams needing to manage and track shortened URLs
- **Live Domain:** zappp.eu

### 1.2 Key Features
1. **URL Shortening & Management**
   - Convert long URLs into custom short links
   - Per-user link management with dashboard interface
   - Automatic or custom slug generation
   - Pagination support for large link collections

2. **Link Expiration Management**
   - Configurable expiration dates per link
   - Default expiration period: 90 days
   - "Never expire" option for permanent links
   - Automatic pruning of expired links via scheduled command

3. **Security Features**
   - Optional per-link password protection
   - Hashed password storage (not plaintext)
   - Password verification required before following protected links
   - User authentication and email verification required

4. **Analytics & Tracking**
   - Redirect counting per link
   - Analytics dashboard for users
   - QR code generation for links
   - QR code download functionality

5. **User Management**
   - User registration and login
   - Email verification
   - Profile management and account settings
   - Per-user link limits (configurable)
   - User profile customization

6. **Additional Features**
   - Customer support page with contact form
   - QR code generation and management
   - Cookie policy compliance
   - Email notifications (Mailgun integration)

---

## 2. Technical Architecture

### 2.1 Technology Stack

#### Backend
- **Framework:** Laravel 11.0
- **PHP Version:** 8.0.2+
- **Database:** SQL (migrations configured for relational DB)
- **HTTP Client:** Guzzle 7.2
- **Authentication:** Laravel Sanctum 4.0
- **QR Code Generation:** 
  - chillerlan/php-qrcode 5.0
  - simplesoftwareio/simple-qrcode 4.2

#### Frontend
- **Build Tool:** Vite 4.0
- **Styling:** Tailwind CSS 3.1
- **UI Framework:** Alpine.js 3.4.2
- **CSS Utilities:** @tailwindcss/forms 0.5.2
- **Date Picker:** Flatpickr 4.6.13
- **Icons:** Font Awesome 7.1.0
- **HTTP Client:** Axios 1.1.2
- **Utilities:** Lodash 4.17.19
- **CSS Processing:** PostCSS 8.4.31 with Autoprefixer 10.4.2

#### Testing & Development
- **Testing Framework:** Pest 3.8 with Laravel plugin
- **Mocking:** Mockery 1.4.4
- **Faker:** FakerPHP 1.9.1
- **Linting:** Laravel Pint 1.13
- **Error Tracking:** Spatie Laravel Ignition 2.0
- **Local Development:** Laravel Sail, Laravel Breeze

#### External Services
- **Email Provider:** Mailgun with Symfony integration
- **HTTP Client:** Symfony HTTP Client 7.4

### 2.2 Project Structure

```
zappp/
├── app/                           # Application source code
│   ├── Console/
│   │   ├── Kernel.php             # Task scheduling and commands
│   │   └── Commands/              # Artisan commands
│   ├── Exceptions/
│   │   └── Handler.php            # Exception handling
│   ├── Http/
│   │   ├── Controllers/           # Application controllers
│   │   │   ├── AnalyticsController.php      # Analytics logic
│   │   │   ├── LinkController.php           # Link CRUD operations
│   │   │   ├── ProfileController.php        # User profile management
│   │   │   ├── QrCodeController.php         # QR code generation
│   │   │   ├── RedirectController.php       # URL redirect logic
│   │   │   ├── SupportController.php        # Support contact handling
│   │   │   ├── Auth/                        # Authentication controllers
│   │   │   └── Controller.php               # Base controller
│   │   ├── Kernel.php             # HTTP middleware configuration
│   │   ├── Middleware/            # HTTP middleware classes
│   │   └── Requests/              # Form request validation
│   ├── Mail/
│   │   └── SupportContact.php      # Support email mailable
│   ├── Models/                    # Eloquent models
│   │   ├── Link.php               # Link model (main data entity)
│   │   ├── Redirect.php           # Redirect tracking model
│   │   └── User.php               # User model
│   ├── Providers/                 # Service providers
│   │   ├── AppServiceProvider.php
│   │   ├── AuthServiceProvider.php
│   │   ├── BroadcastServiceProvider.php
│   │   ├── EventServiceProvider.php
│   │   └── RouteServiceProvider.php
│   └── View/
│       └── Components/            # Blade view components
├── bootstrap/                     # Bootstrap files
│   ├── app.php
│   └── cache/
├── config/                        # Configuration files
│   ├── app.php                    # App configuration
│   ├── auth.php                   # Authentication config
│   ├── broadcasting.php
│   ├── cache.php
│   ├── cors.php                   # CORS configuration
│   ├── database.php               # Database configuration
│   ├── filesystems.php
│   ├── hashing.php
│   ├── logging.php
│   ├── mail.php                   # Mail service configuration
│   ├── queue.php
│   ├── sanctum.php                # API authentication
│   ├── services.php
│   ├── session.php
│   └── view.php
├── database/
│   ├── factories/                 # Model factories for testing
│   │   ├── LinkFactory.php
│   │   ├── RedirectFactory.php
│   │   └── UserFactory.php
│   ├── migrations/                # Database migrations
│   │   ├── 2014_10_12_000000_create_users_table.php
│   │   ├── 2014_10_12_100000_create_password_resets_table.php
│   │   ├── 2019_08_19_000000_create_failed_jobs_table.php
│   │   ├── 2019_12_14_000001_create_personal_access_tokens_table.php
│   │   ├── 2026_01_01_121434_create_links_table.php
│   │   └── 2026_01_01_121553_create_redirects_table.php
│   └── seeders/
│       └── DatabaseSeeder.php     # Database seeding
├── lang/                          # Language/localization files
│   └── en/
├── public/                        # Public web root
│   ├── index.php                  # Application entry point
│   ├── robots.txt
│   ├── build/                     # Compiled assets
│   ├── fonts/
│   └── zippp.eu.png               # Logo asset
├── resources/
│   ├── css/                       # CSS stylesheets
│   ├── js/                        # JavaScript modules
│   └── views/                     # Blade templates
├── routes/                        # Route definitions
│   ├── web.php                    # Web routes
│   ├── api.php                    # API routes
│   ├── auth.php                   # Authentication routes
│   ├── channels.php               # WebSocket channels
│   └── console.php                # Console routes
├── storage/                       # Application storage
│   ├── app/
│   ├── framework/
│   └── logs/
├── tests/                         # Test suite
│   ├── Feature/                   # Feature tests
│   ├── Unit/                      # Unit tests
│   ├── CreatesApplication.php
│   ├── Pest.php
│   └── TestCase.php
├── vendor/                        # Composer dependencies
├── artisan                        # Laravel CLI entry point
├── composer.json                  # PHP dependencies
├── package.json                   # Node.js dependencies
├── vite.config.js                 # Vite build configuration
├── tailwind.config.js             # Tailwind CSS configuration
├── postcss.config.js              # PostCSS configuration
├── phpunit.xml                    # PHPUnit test configuration
├── README.md                      # Project documentation
└── test_seed.php                  # Test data seeding
```

---

## 3. Data Model & Database Architecture

### 3.1 Database Schema

#### Users Table
- **Columns:**
  - `id` (Primary Key)
  - `name` (string)
  - `email` (unique string)
  - `email_verified_at` (nullable datetime)
  - `password` (string, hashed)
  - `remember_token` (nullable string)
  - `created_at`, `updated_at` (timestamps)

#### Links Table
- **Purpose:** Stores shortened URL records
- **Columns:**
  - `id` (Primary Key)
  - `user_id` (Foreign Key → users.id, cascade on delete)
  - `target` (string) - Original/destination URL
  - `slug` (unique string) - Short URL identifier
  - `expires_at` (nullable datetime) - Link expiration date
  - `password_hash` (nullable string) - Hashed password for link protection
  - `created_at`, `updated_at` (timestamps)
- **Key Features:**
  - Belongs to User (many-to-one relationship)
  - Has many Redirects (one-to-many relationship)
  - Custom scope: `active()` - filters unexpired links

#### Redirects Table
- **Purpose:** Tracks each time a link is accessed
- **Columns:**
  - `id` (Primary Key)
  - `link_id` (Foreign Key → links.id, cascade on delete)
  - `created_at`, `updated_at` (timestamps)
- **Key Features:**
  - Belongs to Link (many-to-one relationship)
  - Used for analytics and redirect counting

#### Password Resets Table
- Manages password reset tokens for users

#### Personal Access Tokens Table
- Manages API tokens for user authentication via Sanctum

#### Failed Jobs Table
- Tracks failed queue jobs (for production monitoring)

### 3.2 Model Relationships

```
User (1) ──→ (Many) Links
     ├─→ (Many) Redirects (through Links)
     └─→ (One) Profile

Link (1) ──→ (Many) Redirects
    └─→ (One) User

Redirect (Many) ──→ (1) Link
         └─→ (1) User (through Link)
```

---

## 4. Core Functionality & Features

### 4.1 Link Management

#### Create Link (`POST /links/store`)
- **Controller:** `LinkController::store()`
- **Process:**
  1. User submits target URL
  2. Optional custom slug provided or auto-generated
  3. Optional expiration date (defaults to 90 days)
  4. Optional password protection
  5. Server-side link limit validation
  6. Link saved to database with user association

#### View Links (`GET /dashboard`)
- **Controller:** `LinkController::index()`
- **Features:**
  - Paginated list of user's links
  - Display target URL and short slug
  - Show redirect count
  - Display expiration status
  - Link filtering and search

#### Edit Link (`GET /links/{link}/edit`, `PATCH /links/{link}/update`)
- **Controller:** `LinkController::edit()` and `LinkController::update()`
- **Editable Fields:**
  - Target URL
  - Slug
  - Expiration date
  - Password protection

#### Delete Link (`DELETE /links/{link}/destroy`)
- **Controller:** `LinkController::destroy()`
- **Behavior:** Cascade delete associated redirects

### 4.2 URL Redirection

#### Follow Link (`GET /{slug}`)
- **Controller:** `RedirectController::__invoke()`
- **Process:**
  1. Lookup link by slug
  2. Check if link is expired (via `isExpired()` method)
  3. If password protected:
     - Display unlock form
     - Require password verification
  4. If valid:
     - Record redirect event in `redirects` table
     - Redirect user to target URL

#### Password Unlock (`GET /{slug}/unlock`, `POST /{slug}/unlock`)
- **Controller:** `RedirectController::unlockForm()` and `RedirectController::unlock()`
- **Process:**
  1. Display password entry form
  2. Verify submitted password against `password_hash`
  3. If correct, allow access to actual redirect or store session
  4. If incorrect, display error and retry

### 4.3 Analytics & Tracking

#### Analytics Dashboard (`GET /analytics`)
- **Controller:** `AnalyticsController::index()`
- **Metrics Displayed:**
  - Total links created
  - Total redirects across all links
  - Top performing links (by redirect count)
  - Recently created links
  - Performance trends

#### QR Code Generation

##### Display QR Code (`GET /qr/{code}`)
- **Controller:** `QrCodeController::show()`
- **Purpose:** Display QR code image for a link

##### Download QR Code (`GET /qr/{code}/download`)
- **Controller:** `QrCodeController::download()`
- **Purpose:** Allow users to download QR code as image file

**Technology:** Uses `chillerlan/php-qrcode` and `simplesoftwareio/simple-qrcode` libraries

### 4.4 User Management

#### User Registration & Login
- **Routes:** Defined in `routes/auth.php`
- **Authentication:** Laravel Breeze scaffolding
- **Requirements:**
  - Email verification required
  - Password hashing with Laravel's Hashing service

#### Profile Management (`GET /profile`, `PATCH /profile`, `DELETE /profile`)
- **Controller:** `ProfileController`
- **Features:**
  - View profile information
  - Update profile details
  - Delete account (cascade deletes all associated links)

### 4.5 Support System

#### Support Contact Form (`GET /support`, `POST /support/send`)
- **Controller:** `SupportController::create()` and `SupportController::store()`
- **Email Service:** Uses Mailgun via `SupportContact` mailable
- **Features:**
  - Contact form submission
  - Email notification to support team

### 4.6 Automated Tasks

#### Link Pruning (`links:prune-expired`)
- **Location:** `app/Console/Kernel.php`
- **Schedule:** Daily at midnight
- **Function:** Automatically deletes expired links
- **Activation:** Requires cron job or Task Scheduler configured
- **Trigger Commands:**
  - Linux/macOS: `* * * * * cd /path/to/project && php artisan schedule:run`
  - Windows: Use Task Scheduler to run every minute

---

## 5. API & Routing

### 5.1 Web Routes

| Method | Route | Controller | Purpose |
|--------|-------|-----------|---------|
| GET | `/` | Static view | Welcome page |
| GET | `/cookie-policy` | Static view | Legal compliance |
| GET | `/email-logo` | Static controller | Email asset serving |
| GET | `/dashboard` | LinkController@index | User's link dashboard |
| GET | `/analytics` | AnalyticsController@index | Analytics dashboard |
| POST | `/links/store` | LinkController@store | Create new link |
| PATCH | `/links/{link}/update` | LinkController@update | Update link |
| GET | `/links/{link}/edit` | LinkController@edit | Edit form |
| DELETE | `/links/{link}/destroy` | LinkController@destroy | Delete link |
| GET | `/qr/{code}` | QrCodeController@show | Display QR code |
| GET | `/qr/{code}/download` | QrCodeController@download | Download QR code |
| GET | `/profile` | ProfileController@edit | View profile |
| PATCH | `/profile` | ProfileController@update | Update profile |
| DELETE | `/profile` | ProfileController@destroy | Delete profile |
| GET/POST | `/support` | SupportController@* | Support contact form |
| GET | `/{slug}/unlock` | RedirectController@unlockForm | Password prompt |
| POST | `/{slug}/unlock` | RedirectController@unlock | Verify password |
| GET | `/{slug}` | RedirectController@__invoke | Redirect to target |

### 5.2 API Routes

| Method | Route | Purpose |
|--------|-------|---------|
| GET | `/api/user` | Get authenticated user (Sanctum) |

*Note: Application primarily uses web routes with form submissions; minimal API endpoints currently*

---

## 6. Frontend Architecture

### 6.1 Templating
- **Template Engine:** Blade (Laravel)
- **Asset Pipeline:** Vite
- **Component-Based UI:** Blade view components in `resources/views/components/`

### 6.2 Styling
- **CSS Framework:** Tailwind CSS 3.1
- **Form Utilities:** @tailwindcss/forms plugin
- **Configuration:** `tailwind.config.js`

### 6.3 Interactivity
- **Framework:** Alpine.js 3.4.2
- **Purpose:** Lightweight reactive components
- **Use Cases:**
  - Form interactions
  - Modal dialogs
  - Dynamic field updates
  - Real-time form validation

### 6.4 UI Components
- **Date Picker:** Flatpickr 4.6.13 (for expiration date selection)
- **Icons:** Font Awesome 7.1.0 for UI icons

### 6.5 Build Process
- **Development:** `npm run dev` (Vite dev server with hot reload)
- **Production:** `npm run build` (optimized production build)
- **Full Stack Dev:** `npm run dev:full` (concurrent PHP and Vite servers)

---

## 7. Security Implementation

### 7.1 Authentication & Authorization
- **Framework:** Laravel built-in authentication with Breeze
- **API Auth:** Laravel Sanctum for API token-based authentication
- **Email Verification:** Required for accessing protected routes
- **Middleware:** `auth` and `verified` middleware groups

### 7.2 Password Security
- **Storage:** Hashed with Laravel's default hasher (bcrypt)
- **Link Protection:** Password hashes stored in `password_hash` column
- **Verification:** Server-side password checking before redirect

### 7.3 Database Security
- **Foreign Keys:** Cascade deletes ensure data integrity
- **Input Validation:** Form request classes for input sanitization
- **SQL Injection Prevention:** Eloquent ORM prevents SQL injection

### 7.4 CORS Configuration
- **Configuration File:** `config/cors.php`
- **Purpose:** Control cross-origin requests

---

## 8. Testing & Quality Assurance

### 8.1 Testing Framework
- **Primary:** Pest 3.8 with Laravel plugin
- **Mocking:** Mockery 1.4.4 for mocking dependencies
- **Data:** FakerPHP 1.9.1 for generating test data

### 8.2 Test Structure
```
tests/
├── Feature/          # Full feature integration tests
├── Unit/             # Unit tests for individual components
├── CreatesApplication.php
├── Pest.php          # Pest configuration
└── TestCase.php      # Base test class
```

### 8.3 Code Quality
- **Linting:** Laravel Pint for code style enforcement
- **Error Tracking:** Spatie Laravel Ignition for development error pages
- **Configuration:** `phpunit.xml` for PHPUnit settings

---

## 9. Deployment & Infrastructure

### 9.1 Environment Configuration
- **Configuration:** `.env` file (database, mail, app settings)
- **Example:** `.env.example` provided
- **Key Settings:**
  - `DB_CONNECTION`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`
  - `APP_URL` (application domain)
  - `MAIL_DRIVER` (Mailgun configured)

### 9.2 Installation Steps
1. Clone repository
2. Run `composer install` (PHP dependencies)
3. Copy and configure `.env` file
4. Generate app key: `php artisan key:generate`
5. Create database and run migrations: `php artisan migrate`
6. Seed test data (optional): `php artisan db:seed`
7. Install frontend deps: `npm install` and `npm run build`
8. Serve application: `php artisan serve`

### 9.3 Scheduled Tasks (Production)
- **Linux/macOS:** Add cron entry for scheduler every minute
- **Windows:** Use Task Scheduler to run `php artisan schedule:run` periodically
- **Scheduled Command:** `links:prune-expired` runs daily at midnight

### 9.4 Development Servers
- **PHP Server:** `php artisan serve` (default: http://127.0.0.1:8000)
- **Asset Pipeline:** `vite` development server for hot module replacement
- **Combined:** `npm run dev:full` runs both servers concurrently

---

## 9.5 AWS Hosting & Deployment

### 9.5.1 AWS Services Overview

**Current Production Setup:**
- **Compute Instance:** t3.small (1 vCPU, 2 GB RAM)
- **Storage:** 20 GB EBS volume
- **Environment:** AWS Elastic Beanstalk

**Architecture Components:**
1. **Compute:** AWS Elastic Beanstalk with t3.small instance
2. **Database:** Amazon RDS (MySQL/PostgreSQL)
3. **Storage:** Amazon S3 (for QR codes, exports, user uploads)
4. **Email:** Amazon SES (Simple Email Service) - alternative to Mailgun
5. **CDN:** Amazon CloudFront (for static assets distribution)
6. **Monitoring:** AWS CloudWatch (logs, metrics, alarms)
7. **SSL/TLS:** AWS Certificate Manager (free SSL certificates)
8. **Domain:** Route 53 (DNS management)

### 9.5.2 AWS Elastic Beanstalk Deployment (Current Production Setup)

**Current Instance Configuration:**
- **Instance Type:** t3.small (1 vCPU, 2 GB RAM)
- **Root Volume:** 20 GB gp3 (General Purpose SSD)
- **Environment:** Production (Multi-AZ with load balancing optional)

**Benefits of Elastic Beanstalk:**
- Easy deployment and scaling without server management
- Automatic load balancing and health monitoring
- Environment management and version control
- Integrated with CloudWatch for monitoring
- Automatic OS and security patches
- Zero-downtime deployments

**Deployment Steps:**

1. **Install EB CLI:**
   ```bash
   pip install awsebcli --upgrade --user
   ```

2. **Initialize Elastic Beanstalk (if setting up new environment):**
   ```bash
   eb init -p "PHP 8.3 running on 64bit Amazon Linux 2023" zappp-app --region us-east-1
   ```

3. **Create/Update Environment:**
   ```bash
   eb create zappp-prod --instance-type t3.small
   # Or update existing environment
   eb scale 1  # Number of instances
   ```

4. **Configure Environment Variables:**
   ```bash
   eb setenv APP_KEY=your_app_key \
     DB_HOST=your_rds_endpoint \
     DB_DATABASE=zappp \
     DB_USERNAME=admin \
     DB_PASSWORD=your_password \
     APP_ENV=production
   ```

5. **Deploy Application:**
   ```bash
   eb deploy
   ```

6. **Monitor Deployment:**
   ```bash
   eb status
   eb logs --stream  # View real-time logs
   ```

7. **SSH into Instance (for debugging):**
   ```bash
   eb ssh
   ```

**Beanstalk Configuration File (.ebextensions/php.config):**
```yaml
packages:
  yum:
    php-pecl-imagick: []

option_settings:
  aws:elasticbeanstalk:container:php:staticfiles:
    /public: /public
    /storage/app: /storage/app
  aws:elasticbeanstalk:application:environment:
    COMPOSER_OPTS: "--prefer-dist --no-dev --optimize-autoloader"
    APP_ENV: production
    APP_DEBUG: "false"
  aws:autoscaling:launchconfiguration:
    InstanceType: t3.small
    RootVolumeSize: 20
    RootVolumeType: gp3
  aws:elasticbeanstalk:cloudwatch:logs:
    StreamLogs: true
    DeleteOnTerminate: false
    RetentionInDays: 7

commands:
  01_composer_install:
    command: "/opt/elasticbeanstalk/tasks/bundlelogs.d/01_composer.sh"
    ignoreErrors: false
  02_artisan_config_cache:
    command: "php artisan config:cache"
  03_artisan_route_cache:
    command: "php artisan route:cache"
  04_artisan_view_cache:
    command: "php artisan view:cache"
```

**t3.small Instance Monitoring:**
- Monitor CPU utilization (should average 20-40%)
- Watch memory usage (2 GB available)
- Track network throughput
- Set CloudWatch alarms for high CPU (>75%) or memory warnings
- Review application performance in AWS X-Ray (if enabled)

**Optimization Tips for t3.small:**
- Enable gzip compression in web server
- Implement caching strategies (Redis if upgrading)
- Optimize database queries and add indexes
- Use CloudFront for static assets
- Implement lazy loading for images
- Monitor and clean up old logs regularly

### 9.5.3 Amazon RDS Database Setup

**Current Configuration:**

1. **Create RDS Instance:**
   - **Engine:** MySQL 8.0 or PostgreSQL 15+
   - **Instance Class:** db.t3.micro (suitable for current load)
   - **Storage:** 20-50 GB (adjustable based on growth)
   - **Backup Retention:** 7-30 days
   - **Multi-AZ:** Enabled (for production reliability)
   - **Performance Insights:** Optional monitoring

2. **Database Creation:**
   ```sql
   CREATE DATABASE zappp;
   CREATE USER zappp_user@'%' IDENTIFIED BY 'strong_password';
   GRANT ALL PRIVILEGES ON zappp.* TO zappp_user@'%';
   ```

3. **Environment Variables in Elastic Beanstalk:**
   ```
   DB_CONNECTION=mysql
   DB_HOST=your-rds-endpoint.rds.amazonaws.com
   DB_PORT=3306
   DB_DATABASE=zappp
   DB_USERNAME=zappp_user
   DB_PASSWORD=your_strong_password
   ```

4. **Run Migrations:**
   ```bash
   eb ssh
   php artisan migrate --force
   ```

**RDS Optimization for t3.small Setup:**
- Use db.t3.micro instance to match compute tier
- Enable automated backups (7-14 day retention)
- Set backup window during off-peak hours (e.g., 2-3 AM UTC)
- Monitor storage usage and enable auto-scaling at 85% capacity
- Use CloudWatch RDS metrics to track performance
- Consider db.t3.small upgrade if CPU consistently > 70%

**Connection Pooling (Important for t3.small):**

Update `config/database.php`:
```php
'mysql' => [
    'driver' => 'mysql',
    'host' => env('DB_HOST'),
    'port' => env('DB_PORT', 3306),
    'database' => env('DB_DATABASE'),
    'username' => env('DB_USERNAME'),
    'password' => env('DB_PASSWORD'),
    'unix_socket' => env('DB_SOCKET', ''),
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'prefix' => '',
    'prefix_indexes' => true,
    'strict' => true,
    'engine' => null,
    'options' => extension_loaded('pdo_mysql') ? array_filter([
        PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
        PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false,
    ]) : [],
    'pool' => [
        'min' => 2,
        'max' => 4,
    ]
],
```

### 9.5.4 Amazon S3 for File Storage

**Use Cases:**
- QR code exports
- User uploaded files
- Application backups

**Configuration:**

1. **Create S3 Bucket:**
   ```bash
   aws s3 mb s3://zappp-app-storage
   ```

2. **Configure Laravel Filesystem:**
   
   Update `config/filesystems.php`:
   ```php
   's3' => [
       'driver' => 's3',
       'key' => env('AWS_ACCESS_KEY_ID'),
       'secret' => env('AWS_SECRET_ACCESS_KEY'),
       'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
       'bucket' => env('AWS_BUCKET'),
       'url' => env('AWS_URL'),
       'endpoint' => env('AWS_ENDPOINT'),
       'use_path_style_endpoint' => false,
   ],
   ```

3. **Environment Variables:**
   ```
   FILESYSTEM_DISK=s3
   AWS_ACCESS_KEY_ID=your_access_key
   AWS_SECRET_ACCESS_KEY=your_secret_key
   AWS_DEFAULT_REGION=us-east-1
   AWS_BUCKET=zappp-app-storage
   ```

4. **Install S3 Driver:**
   ```bash
   composer require league/flysystem-aws-s3-v3
   ```

5. **Set S3 Bucket Policy (public access for QR codes):**
   ```json
   {
       "Version": "2012-10-17",
       "Statement": [
           {
               "Sid": "PublicReadGetObject",
               "Effect": "Allow",
               "Principal": "*",
               "Action": "s3:GetObject",
               "Resource": "arn:aws:s3:::zappp-app-storage/*"
           }
       ]
   }
   ```

### 9.5.5 Amazon SES for Email Notifications

**Alternative to Mailgun:**

1. **Verify Email Address:**
   ```bash
   aws ses verify-email-identity --email-address support@zappp.eu --region us-east-1
   ```

2. **Create SMTP Credentials:**
   - Navigate to SES Console → Account Dashboard
   - Generate SMTP credentials for your application

3. **Configure Laravel Mail:**
   
   Update `config/mail.php`:
   ```php
   'mailers' => [
       'ses' => [
           'transport' => 'ses',
       ],
   ],
   ```

4. **Environment Variables:**
   ```
   MAIL_MAILER=ses
   AWS_ACCESS_KEY_ID=your_access_key
   AWS_SECRET_ACCESS_KEY=your_secret_key
   AWS_DEFAULT_REGION=us-east-1
   ```

5. **Install AWS SDK:**
   ```bash
   composer require aws/aws-sdk-php
   ```

**SES Sandbox Considerations:**
- Initially limited to verified addresses only
- Request production access for unlimited sending
- Monitor bounce and complaint rates
- Maintain sender reputation (keep bounce rate < 5%)

### 9.5.6 CloudFront CDN Configuration

**Benefits:**
- Faster asset delivery globally
- Reduced bandwidth costs
- DDoS protection

**Setup:**

1. **Create CloudFront Distribution:**
   - **Origin Domain:** Your Elastic Beanstalk endpoint
   - **Origin Protocol:** HTTPS
   - **Viewer Protocol Policy:** Redirect HTTP to HTTPS
   - **Cache Behaviors:**
     - Cache static assets (CSS, JS, images) for 1 year
     - Don't cache dynamic content (HTML, API)

2. **Cache Policy (for static assets):**
   - Path Pattern: `/public/build/*`
   - Caching Duration: 365 days
   - Compress Objects: Yes

3. **Domain Configuration:**
   - Create CNAME: `cdn.zappp.eu` → CloudFront distribution domain
   - Use AWS Certificate Manager for SSL

4. **Update Application References:**
   ```php
   // In Blade templates
   {{ asset('css/app.css') }} // Automatically uses CloudFront if configured
   ```

### 9.5.7 CloudWatch Monitoring & Logging

**Setup:**

1. **Configure CloudWatch Logs:**
   
   Update `config/logging.php`:
   ```php
   'channels' => [
       'cloudwatch' => [
           'driver' => 'cloudwatch',
           'log_group' => 'zappp-app',
           'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
       ],
   ],
   ```

2. **Environment Variables:**
   ```
   LOG_CHANNEL=cloudwatch
   ```

3. **Install CloudWatch Driver:**
   ```bash
   composer require aws/aws-sdk-php
   ```

4. **Set CloudWatch Alarms:**
   - CPU Utilization > 70%
   - Unhealthy host count > 0
   - ELB 5xx error rate > 1%
   - RDS CPU > 80%
   - RDS Disk space < 20%

### 9.5.8 AWS Secrets Manager Integration

**Secure credential storage:**

1. **Store Database Credentials:**
   ```bash
   aws secretsmanager create-secret --name zappp/database \
     --secret-string '{"username":"admin","password":"your_password"}'
   ```

2. **Update Application:**
   
   Create `app/Providers/SecretsManagerProvider.php`:
   ```php
   use Aws\SecretsManager\SecretsManagerClient;
   
   public function boot()
   {
       $client = new SecretsManagerClient(['region' => env('AWS_DEFAULT_REGION')]);
       $secret = $client->getSecretValue(['SecretId' => 'zappp/database']);
       $credentials = json_decode($secret['SecretString'], true);
       
       config([
           'database.connections.mysql.username' => $credentials['username'],
           'database.connections.mysql.password' => $credentials['password'],
       ]);
   }
   ```

### 9.5.9 AWS Cost Estimation

**Monthly Cost Breakdown (Current Production Setup - t3.small):**

| Service | Configuration | Estimate |
|---------|---------------|----------|
| Elastic Beanstalk (t3.small) | 1 vCPU, 2 GB RAM | $25-35/month |
| RDS MySQL/PostgreSQL (db.t3.micro, Multi-AZ) | 1 vCPU, 1 GB RAM | $30-50/month |
| EBS Storage (20 GB) | General Purpose SSD | $2/month |
| S3 Storage (50 GB) | Standard tier | $1/month |
| S3 Data Transfer | 1 TB/month inbound/outbound | $1-5/month |
| CloudFront (1 TB/month) | CDN distribution | $15-20/month |
| SES (10k emails/month) | Simple Email Service | $0-1/month |
| CloudWatch Logs (100 MB/month) | Application logs | $0.50/month |
| Route 53 (hosted zone) | DNS management | $0.50/month |
| **Total Estimated** | **t3.small Production** | **$75-112/month** |

**Breakdown by Component:**
- **Compute Cost:** ~$25-35/month (Beanstalk + t3.small instance)
- **Database Cost:** ~$30-50/month (RDS with backups)
- **Data Transfer & CDN:** ~$16-25/month
- **Other Services:** ~$3-4/month

**t3.small Specifications:**
- **vCPU:** 1 (burnable to higher with CPU credits)
- **Memory:** 2 GB RAM
- **Network:** Up to 5 Gbps
- **EBS-optimized:** Supported (recommended)
- **Baseline Performance:** 20% CPU utilization
- **CPU Credits:** Earn when under 20%, spend when above

**Performance Considerations for t3.small:**
- Suitable for small to medium user base (~100-500 concurrent users)
- Handle ~50,000 requests/day comfortably
- May experience brief slowdowns during traffic spikes
- Storage (20 GB) sufficient for:
  - ~10,000 links with metadata
  - ~500,000 redirect records
  - Log files (~5-10 days retention)

**Scaling Strategy:**
- Current: Single t3.small instance
- Phase 1 (Growth): Increase to t3.medium (2 vCPU, 4 GB RAM)
- Phase 2 (High Traffic): Enable auto-scaling with 2-4 instances
- Phase 3 (Enterprise): Consider t3.large or use dedicated infrastructure

### 9.5.10 Auto-Scaling Configuration

**Current Setup (Single t3.small Instance):**

Currently, the application runs on a single t3.small instance. As traffic grows, implement the following auto-scaling strategy:

**Phase 1: Monitor & Optimize (Current)**
```yaml
# .ebextensions/autoscaling.config
option_settings:
  aws:autoscaling:asg:
    MinSize: 1
    MaxSize: 1  # Single instance for cost efficiency
  aws:autoscaling:trigger:
    MeasureName: CPUUtilization
    Statistic: Average
    Unit: Percent
    UpperThreshold: 80
    LowerThreshold: 20
    BreachDuration: 300
```

**Phase 2: Enable Auto-Scaling (When Traffic Grows)**
```yaml
option_settings:
  aws:autoscaling:asg:
    MinSize: 1
    MaxSize: 3
  aws:autoscaling:trigger:
    MeasureName: CPUUtilization
    Statistic: Average
    Unit: Percent
    UpperThreshold: 70
    LowerThreshold: 30
    BreachDuration: 300
```

**Scaling Triggers:**
- Scale up if CPU > 70% for 5 minutes
- Scale down if CPU < 30% for 5 minutes
- Load balancer distributes traffic across instances
- Minimum 1 instance, maximum 3 instances

**When to Scale Up:**
- Expected user growth > 200% of current capacity
- Average CPU > 60% during peak hours
- Response times > 2 seconds
- Deploy strategy requires zero-downtime updates

### 9.5.11 Backup & Disaster Recovery

**AWS Backup Strategy:**

1. **Database Backups:**
   - RDS automated backups (7-30 days retention)
   - Daily snapshots to separate AWS account
   - Test restore procedures monthly

2. **Application Code:**
   - GitHub repository (already in place)
   - Deploy from main branch to production

3. **S3 Backups:**
   - Enable versioning on S3 buckets
   - Cross-region replication for critical files

4. **Recovery Procedures:**
   - RDS restore: 5-15 minutes
   - EB redeployment: 5-10 minutes
   - Full application recovery: 15-30 minutes

### 9.5.12 Deployment Pipeline (CI/CD with GitHub Actions)

**Automated Deployment to AWS:**

```yaml
# .github/workflows/deploy.yml
name: Deploy to AWS Elastic Beanstalk

on:
  push:
    branches: [ main ]

jobs:
  deploy:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v2
      
      - name: Install EB CLI
        run: pip install awsebcli
      
      - name: Deploy to EB
        env:
          AWS_ACCESS_KEY_ID: ${{ secrets.AWS_ACCESS_KEY_ID }}
          AWS_SECRET_ACCESS_KEY: ${{ secrets.AWS_SECRET_ACCESS_KEY }}
        run: |
          eb deploy zappp-prod --use-latest-platform
      
      - name: Run Database Migrations
        env:
          AWS_ACCESS_KEY_ID: ${{ secrets.AWS_ACCESS_KEY_ID }}
          AWS_SECRET_ACCESS_KEY: ${{ secrets.AWS_SECRET_ACCESS_KEY }}
        run: |
          eb ssh zappp-prod -c "php artisan migrate --force"
```

---

## 11. Key Configuration Files

| File | Purpose |
|------|---------|
| `composer.json` | PHP dependencies and autoloading |
| `package.json` | Node.js dependencies and scripts |
| `vite.config.js` | Vite bundler configuration |
| `tailwind.config.js` | Tailwind CSS theme customization |
| `postcss.config.js` | PostCSS processing (Autoprefixer) |
| `config/app.php` | Application general settings |
| `config/database.php` | Database connection configuration |
| `config/mail.php` | Email service configuration |
| `config/sanctum.php` | API token authentication |
| `config/auth.php` | Authentication guards and providers |
| `config/cors.php` | CORS policies |
| `phpunit.xml` | Testing configuration |

---

## 12. Dependencies Overview

### 11.1 Core Dependencies
- **laravel/framework:** Main application framework
- **laravel/sanctum:** API authentication
- **guzzlehttp/guzzle:** HTTP client for external requests
- **symfony/http-client:** Alternative HTTP client
- **symfony/mailgun-mailer:** Mailgun email integration

### 11.2 Frontend Dependencies
- **alpine.js:** Reactive UI framework
- **tailwindcss:** CSS utility framework
- **vite:** Modern build tool
- **flatpickr:** Date picker component
- **axios:** Promise-based HTTP client
- **lodash:** JavaScript utility library
- **@fortawesome/fontawesome-free:** Icon library

### 11.3 Development Dependencies
- **laravel/breeze:** Authentication scaffolding
- **pestphp/pest:** Testing framework
- **fakerphp/faker:** Test data generation
- **mockery/mockery:** Mocking library
- **laravel/pint:** Code style fixer
- **spatie/laravel-ignition:** Development error page

---

## 13. Performance Considerations

### 12.1 Optimization Strategies
- **Database Indexing:** Unique index on `links.slug` for fast lookups
- **Pagination:** Links dashboard implements pagination to handle large datasets
- **Caching:** Laravel cache configuration available for performance optimization
- **Asset Minification:** Vite handles CSS/JS minification in production builds
- **Lazy Loading:** Alpine.js components load only when needed

### 12.2 Scheduled Maintenance
- **Daily Pruning:** Expired links automatically removed to keep database lean
- **Link Expiration:** Default 90-day expiration reduces stale data accumulation

---

## 14. Project Status & Metadata

### 13.1 Project Information
- **Repository:** atommass/zappp.eu (on GitHub)
- **Branch:** main (default)
- **Current Date:** January 9, 2026
- **PHP Version Required:** 8.0.2+
- **Laravel Version:** 11.0
- **Node.js Version:** Required for frontend build

### 13.2 Development Environment
- **Supported Platforms:** Windows, macOS, Linux
- **Database Systems:** Configured for relational databases (MySQL, PostgreSQL, SQLite, etc.)
- **Development Tools:**
  - Laravel Sail for containerized development
  - Laravel Tinker for interactive shell
  - Pest for testing
  - Laravel Pint for code quality

---

## 15. Key Files Summary

| File | Purpose |
|------|---------|
| [README.md](README.md) | Project documentation and setup guide |
| [test_seed.php](test_seed.php) | Test database seeding script |
| [app/Http/Controllers/LinkController.php](app/Http/Controllers/LinkController.php) | Main link management logic |
| [app/Http/Controllers/RedirectController.php](app/Http/Controllers/RedirectController.php) | URL redirection and tracking |
| [app/Models/Link.php](app/Models/Link.php) | Link data model |
| [app/Console/Kernel.php](app/Console/Kernel.php) | Task scheduling configuration |
| [routes/web.php](routes/web.php) | Web route definitions |
| [database/migrations/](database/migrations/) | Database schema definitions |

---

## 16. Future Enhancement Opportunities

Based on the current architecture, potential enhancements could include:

1. **Advanced Analytics**
   - Geographic tracking of redirects
   - Device type analytics
   - Referrer tracking
   - Time-based analytics charts

2. **Link Management**
   - Link categorization/tagging
   - Link sorting and filtering options
   - Bulk operations (bulk edit, bulk delete)
   - Link duplication

3. **API Development**
   - Full REST API for programmatic link creation
   - Webhook support for external integrations
   - Rate limiting for API endpoints

4. **UI/UX Improvements**
   - Dark mode support
   - Keyboard shortcuts
   - Drag-and-drop reordering
   - Advanced search and filtering

5. **Security Enhancements**
   - Two-factor authentication (2FA)
   - IP address whitelist for links
   - Rate limiting per link
   - Suspicious activity detection

6. **Team Features**
   - Organization/workspace support
   - User roles and permissions
   - Shared link collections
   - Team analytics

7. **Integrations**
   - Slack integration for link creation
   - Google Analytics integration
   - Social media integration
   - Custom domain support

---

**Document Generated:** January 9, 2026  
**Project:** Zappp - URL Shortener Application  
**Version:** 1.0
