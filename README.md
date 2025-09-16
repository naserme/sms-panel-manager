# Sms Panel manager

A lightweight and practical system built with Laravel 12 for collecting and displaying SMS reports from multiple websites managed by a single company.  
The panel shows overall statistics of sent messages, total costs, message details (content, receiver number, date), allows balance top-up (for company information purposes), and sending SMS directly from the dashboard.

## Features
- Display list of websites with total sent messages and total SMS cost
- View details of each website including: list of messages, number of sends, content, receiver number, and date
- Dedicated user dashboard showing all sent messages with their details
- Balance top-up functionality (informational for the company)
- Ability to send SMS from the dashboard
- Modular design, extendable for integration with different SMS gateways

## Quick Installation
1. Clone the repository:
   ```bash
   git clone <repo-url>
   cd <repo-folder>
## Install dependencies:

bash
Copy code
composer install
npm install
npm run build
Configure environment file:

bash
Copy code
cp .env.example .env
php artisan key:generate
Set database, SMS service, and app configuration in .env.

## Run migrations and seeders (if available):

bash
Copy code
php artisan migrate --seed
Start development server:

bash
Copy code
php artisan serve
Structure
app/Http/Controllers — panel and API controllers

app/Models — models: Site, Message, Transaction, etc.

database/migrations — tables for SMS, sites, transactions, and users

resources/views — admin panel and user dashboard views (Blade)

routes/web.php and routes/api.php — routes for panel and API

## SMS Service Integration
The project is designed to support multiple SMS providers.
Just create a new service in Services/Sms and register it in the service container.

## Security Notes
Keep all sensitive data in .env and never commit it to a public repo.

For production use, configure queues, caching, and SSL properly.

## Contribution
Pull requests are welcome. Before submitting, please:

Add unit tests or provide clear explanations of changes

Follow the coding standards of the project

# License
This project is released under the MIT License.

Contact
For integration or customization, open an issue or reach out via email.
