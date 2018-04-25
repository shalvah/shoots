# laravel-mongodb-starter
This is a fresh Laravel install, configured to use MongoDB out of the box.

Just extend your models from `Jenssegers\Mongodb\Eloquent\Model`

```php
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Comment extends Eloquent {
  // ...
}
```

See https://github.com/jenssegers/laravel-mongodb for more info
