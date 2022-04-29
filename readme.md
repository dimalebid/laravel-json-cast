# Laravel Json Cast
[![Latest Version on Packagist](https://img.shields.io/packagist/v/dimalebid/laravel-json-cast.svg?style=flat-square)](https://packagist.org/packages/dimalebid/laravel-json-cast)
[![Total Downloads](https://img.shields.io/packagist/dt/dimalebid/laravel-json-cast.svg?style=flat-square)](https://packagist.org/packages/dimalebid/laravel-json-cast)
![Packagist License](https://img.shields.io/packagist/l/dimalebid/laravel-json-cast)

Вы когда-нибудь хотели привести свои столбцы JSON к объекту-значению?

Под капотом он реализует интерфейс Laravel Arrayable, которое обрабатывает сериализацию между JsonCastable и столбцом базы данных JSON.
## Installation
You can install the package via composer:
``` bash
$ composer require dimalebid/laravel-json-cast
```
## Usage
### 1. Создаете `UserSettings`
```php
namespace App\Models\User;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use App\Models\User\Settings\Settings;

class UserSettings implements CastsAttributes
{

    public function get($model, string $key, $value, array $attributes)
    {
        return new Settings((array)json_decode($value, true));
    }

    public function set($model, string $key, $value, array $attributes)
    {
        return json_encode(get_object_vars($value));
    }
}
```
### 2. Создаете `Settings`
```php
namespace App\Models\User\Settings;

use DimaLebid\LaravelJsonCast\JsonCastable;
use App\Models\User\Settings\Auth;

class Settings extends JsonCastable
{
    public Auth $auth;
    public string $country = 'Ukraine';
    public ?string $phone;

    public function __construct(array $attributes)
    {
        $this->auth = new Auth($attributes);
        parent::__construct($attributes);
    }
}
```
Обьект `Auth` похож на `Settings` с одним отличием что в нем нет конструктора.
### 3. Настройте свой атрибут Eloquent для приведения к нему:
```php
namespace App\Models;

use App\Values\Address;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $casts = [
        'settings' => UserSettings::class,
    ];
}
```
## Получить значение из поля JSON
```php
$userId   = 1;
$user     = User::find($userId);
$settings = $user->settings;

dd($settings->country);
//or
dd($settings->auth->facebook);
```
## Сохранить или обновить значение в поле JSON
```php
$userId = 1;
$user   = User::find($userId);

$user->settings->country = 'USA';
$user->save();
```
Вот так легко и просто можно работать с полем JSON.
