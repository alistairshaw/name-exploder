## Install

Via Composer

``` bash
$ composer require alistairshaw/name-exploder:^0.1
```

## Titles
There is some data included for titles in English (default) and Spanish.
If you need it for another language, please feel free to pull request
or simply send me the list and I will add your language. Include any
rules so we can improve the plugin.

It is possible to attach your own data (see below).

## Usage

```php
require 'vendor/autoload.php';

use AlistairShaw\NameExploder\NameExploder;

// You can get a Name object by passing in the full name
$nameExploder = new NameExploder();
$name = $nameExploder->explode('Mr Alistair Shaw');

// get the pieces back
echo $name->firstName();
echo $name->lastName();
echo $name->title();
echo $name->middleInitial();

// cast the Name object as string to just get full name back
echo $name;

// pass in the language for the titles (default is english)
$nameExploder = new NameExploder('es');
$name = $nameExploder->explode('Mr Alistair Shaw');
```

## Attaching your own data for titles
You can easily write a new repository (implement \AlistairShaw\NameExploder\Title\TitleRepository)
and inject it into the main class  Just ensure you return an array of Title objects, and it will work great!

```php
require 'vendor/autoload.php';

use AlistairShaw\NameExploder\NameExploder;

// pass in a custom repository implementation
$nameExploder = new NameExploder('es', new CustomTitleRepository());
$name = $nameExploder->explode('Mr Alistair Shaw');
```

## Notes

I realise that this is pretty basic at the moment, I plan to improve it over time,
specifically adding new languages is high on the list of priorities. Would love to
hear from people who speak non-latin languages to make this work for them.

## Contributing

Contributions are very welcome and will be fully credited, just please make sure to add tests.


## Credits

- [Alistair Shaw](https://github.com/alistairshaw)
- [All Contributors](https://github.com/alistairshaw/name-the-color/contributors)

## License

The MIT License (MIT).
