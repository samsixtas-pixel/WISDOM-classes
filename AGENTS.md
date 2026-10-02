# PHP Engineering Guidelines

## Identify the real stack first
- This project is framework-free PHP 8.1+ with MySQLi, Composer PSR-4 (`Wisdom\`), and a small dependency container; it is not Laravel or Yii. Do not introduce framework conventions or dependencies without an explicit requirement and compatibility review.
- Read [README.md](README.md) and the relevant schema/code before changing behavior. Verify the implementation when documentation and code disagree.
- The request flow is generally `public/*.php` page → `Services/` business logic → `Repositories/` SQL → `Models/`; shared infrastructure and construction are in `src/Core/` and `config/`. Keep pages thin and follow the existing boundaries.

## Safe implementation
- Trace input, authentication/authorization, validation, data access, and output for the specific workflow before editing. Treat all request data as untrusted; preserve CSRF checks, permission checks, prepared statements, output escaping, and private-file access controls.
- Preserve existing business rules and data. Use transactions and database constraints where an operation spans related writes; inspect `database/schema.sql` before changing persistence. Never run destructive schema/data commands against an existing database.
- Use constructor injection and existing classes/services. Match PSR-4 namespace, path, filename, and class casing exactly; deployments run on case-sensitive Linux filesystems. If adding a service or repository, inspect the `App` container wiring as well as autoloading.
- Keep secrets out of source, logs, chat output, and commits. Treat `.env` as sensitive; use `.env.example` and configuration code to understand settings without printing secret values. Require explicit least-privilege deployment credentials; do not rely on development defaults.
- Keep uploads and logs outside the served `public/` tree. Serve protected files only through an authorization-checked endpoint. Configure the web document root to `public/`; the PHP built-in server is for local development only.

## Verification
- No automated test suite or static-analysis scripts are currently declared in `composer.json`; do not claim test coverage that was not run. For PHP changes, run `php -l` on every changed PHP file and perform focused workflow checks when the required database/environment is available.
- Check the configured PHP runtime/extensions (notably `mysqli`, `fileinfo`, and support for `mysqli_stmt::get_result()`), then inspect logs and relevant response behavior. Report environmental blockers separately from code failures.
- See [README.md](README.md) for setup, project layout, and operational requirements; see [database/schema.sql](database/schema.sql) for the current database contract.
