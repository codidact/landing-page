# codidact-landing-page

The Codidact project landing page. Join us in discussions on our [Discourse form](https://forum.codidact.org/). We use a [Discord server](https://discord.gg/7jf8UzS) for communication.

[See it in action](https://codidact.org/)

## Setting up your local development environment

-   Ensure node and npm are installed locally [(nvm recommended)](https://github.com/nvm-sh/nvm).
-   Run `npm install` to install project dependencies.

## Linting

Whilst CI tools will be used at a later date, before submitting a PR ensure your code is linted by running `npm run lint`. Any submitted PRs will be rejected if linting does not pass.

-   All formatting (except JS) is handled by Prettier (we recommend installing an auto-formatter for your IDE). The configuration is located in `.prettierrc`.
-   JS formatting and linting is handled by ESLint. JSON config resides in `.eslintrc` (to be added).
-   CSS linting handled by stylelint. JSON config in `.stylelintrc`.
