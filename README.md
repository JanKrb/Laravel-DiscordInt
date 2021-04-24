# Laravel Socialite Discord
This discord integration is based on laravel framework with Argon Bootstrap template. Its build on martinbean's discord socialite provider and should show how it can be implemented.

## Installation

Laravel-DiscordInt requires PHP 7.2+, composer and npm.

Install dependencies
```sh
git clone https://github.com/JanKrb/Laravel-DiscordInt
cd Laravel-DiscordInt
npm install
composer install
```

Setup project

- Copy .env.example to file .env
- Fill out fields in .env
    - If you don't know what to fill with, leave it out
    - The Debug variable should be false in production use
    - The Key variable will be generated later
- Run command ``php artisan key:generate`` for key generating
- Run command ``php artisan migrate --seed`` for generating the database

## Development

Want to contribute? Great!

Make a change in your file and instantaneously see your updates!

Done with your updates? Just create a new pull request I will take a took and merge it as soon as possible.

## Credits
Laravel - [Framework](https://laravel.com/)
Discord Socialite - [martinbean](https://github.com/martinbean/socialite-discord-provider)
Argon Design - [Argon](https://www.creative-tim.com/product/argon-design-system)
## License

MIT
