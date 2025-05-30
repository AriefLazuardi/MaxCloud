# MAXCLOUD

MaxCloud is an application created with the Laravel framework for the management and billing of VPS (Virtual Private Server) services automatically every hour. This application handles the billing process, low balance notification, automatic suspension of VPS when the balance is insufficient, as well as sending notifications to the database and email.

## 🔧 Features

-   Automatic billing based on resources (CPU, RAM, storage)
-   Service suspension in case of insufficient balance
-   Daily low balance notification
-   Email and database notifications
-   Artisan command billing: scheduled process

## 🚀 Installation

### 1. Clone repository

```bash
git clone https://github.com/username/maxcloud.git
cd maxcloud 2. Install dependensi
```

### 2. Install Dependencies

```bash
npm install && npm run dev
```

### 3. Environment configuration

Copy file .env from template:

```bash
cp .env.example .env
```

Then set the environment such as:

```bash
APP_NAME=MaxCloud
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=maxcloud
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=your_mail_host
MAIL_PORT=587
MAIL_USERNAME=your_email_username
MAIL_PASSWORD=your_email_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=no-reply@maxcloud.test
MAIL_FROM_NAME="MaxCloud"
```

### 4. Generate key

```bash
   php artisan key:generate
```

### 5. Migration & seeding

```bash
   php artisan migrate:fresh --seed
```

### 6. Run the server

```bash
   php artisan serve
```

## ⚙️ Billing Scheduling

The billing:process command is run every hour through Laravel Scheduler. Make sure you add cron to your system:

```bash
-   -   -   -   -   cd /path/to/maxcloud && php artisan schedule:run >> /dev/null 2>&1
```

## 📬 Notification

-   Low balance: saved to database and emailed (if not already today)
-   Suspended account: saved and emailed when balance is negative

## 🧪 Testing (Opsional)

Add it if you have FeatureTest or UnitTest.

## 📄 License

This project is under the MIT license.

```

```

```

```

```

```

```

```

```

```
