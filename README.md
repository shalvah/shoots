# shoots
Realtime spreadsheets app similar to Google Sheets.

## Description
- Realtime spreadsheet editing by multiple users
- "Who's viewing" the sheet, updated in realtime 

## Prerequisites
- PHP >= 7.2
- Composer
- MongoDB 3.4 or greater
- A [Pusher account](https://pusher.com/signup) and [Pusher app credentials](http://dashboard.pusher.com/)

## Getting started
Clone the project and install dependencies:

```bash
git clone https://github.com/shalvah/shoots
cd shoots && composer install
```

Copy the `.env.example` file to a `.env` file. Add your Pusher app credentials to this file:
```
PUSHER_APP_ID=your-app-id
PUSHER_APP_KEY=your-app-key
PUSHER_APP_SECRET=your-app-secret
PUSHER_APP_CLUSTER=your-app-cluster
```

Look for these lines of JavaScript in `resources/views/spreadsheet.blade.php`:
```javascript
let pusher = new Pusher('your-app-key', {
    cluster: 'your-app-cluster'
});
```
Insert your Pusher app key and cluster in the appropriate places.

If your MongoDB server requires a username and password, add those in your `.env` file as the `DB_USERNAME` and `DB_PASSWORD` respectively.

Then:

```bash
# generate an application key
php artisan key:generate

# start the app
php artisan serve
```
## Built With

* [Pusher](https://pusher.com/) - APIs to enable devs building realtime features
* [Laravel](http://laravel.com) - the PHP framework for web artisans :sunglasses:
* [Handsontable](https://github.com/handsontable/handsontable) - Spreadsheet component UI for web apps

