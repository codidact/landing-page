# codidact-landing-page

The Codidact project landing page. Join us in project development on our [Discourse forum](https://forum.codidact.org/). We use a [Discord server](https://discord.gg/7jf8UzS) for live communication.

[See the page in action at codidact.org!](https://codidact.org/)

## Setting up your local development environment

-   Ensure node and npm are installed locally [(`nvm` recommended)](https://github.com/nvm-sh/nvm).
-   Run `npm install` to install project dependencies.

## Linting

Whilst CI tools will be used at a later date, before submitting a PR ensure your code is linted
running `npm run lint`. Any submitted PRs wil lbe rejected if linting does not pass.

-   All formatting (except JS) handled by Prettier (recommended to install a auto-formatter for you IDE) - config in `.prettierrc`.
-   JS formatting and linting handled by ESLint - JSON config in `.eslintrc` (to be added).
-   CSS linting handled by stylelint - JSON config in `.stylelintrc`.
