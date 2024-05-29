## Kanban Planning App

![GitHub Actions Workflow Status](https://img.shields.io/github/actions/workflow/status/tesseeaye/planning-app/testing.yml)
![Test Coverage](https://raw.githubusercontent.com/tesseeaye/planning-app/main/badge-coverage.svg)

> [!WARNING]
> This application isn't meant to be ran in a production environment.

This Laravel 11 application exists for me to explore what I'm learning with the framework. If you feel like tinkering around along with me, feel free to clone this repository and build from where ever I'm at. You can take it in your own direction from there, or contribute back here if you want.

## Setup
1. Run `composer install` in cloned repository's directory.
2. Create `.env` file `cp .\.env.example .\.env`.
3. Run `php artisan key:generate`.
4. Run `php artisan migrate` and respond _yes_ when prompted to create the `database.sqlite` file.
5. Create a [Github API key](https://docs.github.com/en/authentication/keeping-your-account-and-data-secure/managing-your-personal-access-tokens), if you're serving your development site over `php artisan serve` set your "Authorization callback URL" on your Github OAuth application to _http://localhost:port/oauth/github/callback_. If you're using Valet or Herd you can set it to _http://application-name.test/oauth/github/callback_. Copy your **Client ID** and your **Client Secret** in their respective spots in the _\.env_ file.
6. Run `npm install` in cloned repository's directory.
7. Run `npm run build` in cloned repository's directory.
8. You can use `php artisan:serve` or if using Valet or Herd go to your app's URL in the browser and start playing around with my app!


## License
Kanban Planning App is open-sourced software licensed under the [MIT license](LICENSE).
