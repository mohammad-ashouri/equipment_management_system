
# Persian admin dashboard

## Tech Stack

**Client:** TailwindCSS + DaisyUI + tw-elements + Line Awesome

**Server:** Laravel v10

**Packages and usages:** Jquery + Ajax + TinyMce + morilog/jalali + SweetAlert + niklasravnsborg/laravel-pdf + phpoffice/phpspreadsheet + spatie/laravel-permission

## Installation

Clone this repository

```bash
  cd laravel-admin-panel-template/
  cp env.example env
```

Config .env file


```bash
  composer i
  npm i
  php artisan migrate --seed
  npm run build
```


## Run Locally

Clone the project

```bash
  git clone https://github.com/mohammad-ashouri/laravel-admin-panel-template
```

Go to the project directory

```bash
  cd laravel-admin-panel-template/
```

Copy env.example and modify that

Migrate database

```bash
  php artisan migrate:fresh --seed
```

Install dependencies

```bash
  npm i
  composer i
```

Build from project

```bash
  npm run build
```

To start the server this project run

```bash
  php artisan serve
```

Project starts at localhost:8000
## Usage/Examples

### To change default user:
Go to users migration and change add user query and migrate fresh

```bash
php artisan migrate:fresh --seed
```

### To change menus go to middlewares/MenuMiddleware and add in array like this:
```php
array_number => [
                    'title' => 'Menu Title',
                    'link' => 'Menu Link',
                    'class' => 'Line Awesome Class',
                    'permission' => "Your Permission Name",
                    //If you want to add submenu(s)
                    'childs' => [
                        array_number => [
                            'title' => 'Submenu Title',
                            'link' => 'Submenu Link',
                            'class' => 'Line Awesome Class',
                            'permission' => "Your Permission Name",
                        ],
                    ]
                ],

```

### To set permission for controller functions add this to first of controller class. For example:
```php
function __construct()
    {
        $this->middleware('permission:لیست کاربران', ['only' => ['index']]);
    }
```


## Support

For support, email m.ashouri.wdev@gmail.com.

Please donate me with the following methods to get energy! thank you

Tron (trc20) or Tether (trc20):  TRay31N4sJfDXrT3zSennr74RGX4x9HehU
