# TABASCO LEGAL MANAGEMENT SYSTEM - Full Application Documentation

**Document Version:** 2.0  
**Updated On:** May 27, 2026  
**Project Root:** `G:\wamp64\www\tabasco_legal_code`

## 1. System Overview

Tabasco Legal Management System is a PHP-based legal operations platform used to manage:

- Client onboarding and legal profile creation
- Active legal files and case lifecycle tracking
- Hearings, case actions, and related-case mapping
- Agency collaboration (third party, legal firm, debt collector)
- Financial flows (outstanding, collection, expenses, commission)
- Document upload/retrieval and evidence history
- Audit and activity logging
- Operational and management reporting

The application is built as a custom, framework-less PHP web app with module/page routing through query parameters and Apache rewrite rules.

## 2. Core Technology Stack

- Backend: PHP (procedural + class-based service layer)
- Database: MySQL (PDO wrapper in `lib/class/class.dbcon.php`)
- Frontend: Bootstrap, jQuery, DataTables, Select2, plugin-driven UI
- PDF: `mpdf/mpdf` (Composer managed)
- Runtime Model: Session-based authentication and module/page-level permission checks
- Web Server: Apache (`.htaccess` route rewriting)

## 3. Entry Points and Bootstrap Flow

Primary files:

- `index.php` - authenticated application front controller
- `login.php` - login and agency-login authentication page
- `logout.php` / `login.php?action=logout` - sign-out handlers
- `permission_denied.php` - authorization failure landing page

`index.php` flow:

1. Starts output/session, sets headers and memory config.
2. Reads URL params: `module`, `page`, `action`, `param1`, `param2`.
3. Includes bootstrap dependencies:
   - `lib/config.php`
   - `lib/class/class.dbcon.php`
   - `lib/auth.php`
   - `lib/functions/navigations.php`
   - `lib/functions/select_options.php`
4. Redirects unauthenticated users to `login.php`.
5. Creates CSRF token if missing.
6. Dynamically includes `modules/<module>/<page>.php`.
7. Renders master template: `templates/frontend/master_page.php`.

## 4. URL Routing

Apache rewrite rules in `.htaccess` map pretty URLs to query parameters:

- `module/page/action/param1/param2.html`
- `module/page/action/param1.html`
- `module/page/action.html`
- `module/page.html`
- `module.html`

Example:

- `/case/list.html` -> `index.php?module=case&page=list`

## 5. Configuration and Environment

Main config file: `lib/config.php`

Important constants:

- DB: `IP`, `DB`, `USER`, `DBPWD`
- Base URLs: `ROOT_DIR`, `AJAX_ROOT_DIR`, `SHARE_LINK_FOR_LOGIN`
- Application flags: `LEGAL_PAGES_AUTH`, `PDO_DEBUG`, `PAGINATION_PERPAGE`
- Entity code prefixes (must stay aligned with MySQL triggers):
  - `CLIENT_CODE`
  - `THIRD_PARTY_CODE`
  - `LEGAL_FIRM_CODE`
  - `DEBT_COLLECTOR_CODE`
  - `ACTIVE_LEGAL_CODE`

Timezone is set to `Asia/Dubai` in config.

## 6. Authentication and Session Model

Authentication logic is primarily in `login.php` + `lib/class/class.login.php`.

Login flow:

1. Normal user login attempt (`MainLoginAuthentication`).
2. If not successful, fallback agency authentication (`Agencies_Login_Authentication`).
3. Session values initialized:
   - `LOGIN_LEGAL_ID`
   - `LOGIN_LEGAL_NAME`
   - `LOGIN_LEGAL_TYPE_ID`
   - `LOGIN_LEGAL_TYPE_NAME`
   - `LOGIN_AGENCIES` (`0` internal / `1` agency)
   - `LOGIN_SUPER_ADMIN` (`Y` / `N`)
4. Redirect target:
   - Internal: `dashboard/panel.html`
   - Agency: `dashboard/agencies.html`

Login/logout and failed attempts are written to activity logs (`LegalActivityLog`).

## 7. Authorization and Permission Control

Authorization middleware is in `lib/auth.php`.

Behavior summary:

- If agency login (`LOGIN_AGENCIES = 1`), all permission flags default to false.
- If super admin (`LOGIN_SUPER_ADMIN = Y`), all permission flags become true.
- For regular users, permission codes are loaded from DB using `class.legal_permission.php` and mapped to flags:
  - `V` View
  - `A` Add
  - `E` Edit
  - `D` Delete
  - `P` Print
  - `M` Mail

Permission constants exposed to modules:

- `LEGAL_AUTH_VIEW`
- `LEGAL_AUTH_ADD`
- `LEGAL_AUTH_EDIT`
- `LEGAL_AUTH_DELETE`
- `LEGAL_AUTH_PRINT`
- `LEGAL_AUTH_MAIL`

## 8. Database Layer and Data Access

Main DB abstraction: `lib/class/class.dbcon.php`

Capabilities:

- Persistent PDO connection
- Transaction controls (`Begin`, `Commit`, `Rollback`)
- Query execution wrappers:
  - `Query()` for writes
  - `SQL_Fetch()` for single-row fetch
  - `SELECT_MultiFetch()` for list fetches
- Placeholder helper methods for dynamic `IN` filters

Debug behavior is controlled by `PDO_DEBUG` constant.

## 9. Module Architecture

The app follows a modular directory convention:

- `modules/<module>/<page>.php`
- optional `modules/<module>/tpl/*.tpl.php`
- optional `modules/<module>/ajax/*.php`

### 9.1 Key Module Families

- `dashboard` - landing pages and summary views
- `client` - client onboarding, details, document/contact/commission subpages
- `activelegal` - active legal record lifecycle
- `case` - case info, hearings, actions, expenses, related cases
- `actionreport` - action and follow-up reporting views
- `reports` / `reports30apr26` - report pages and variants
- `commissionreport*` - commission statements and voucher reporting
- `expensereport*` - expense reporting variants
- `baddebts`, `closedlegal`, `totallegal` - financial/legal closure reporting
- `master` - master data configuration (area, bank, court, category, etc.)
- `permission` - user/module permission management
- `task` - reminder/task workflows
- `uploads` - file and document handling pages

### 9.2 Module Versioned Variants

There are historical/parallel versions (for example `activelegal-14apr26`, `activelegal21apr26`, `commissionreport30apr26`).

Recommendation:

- Keep only active production variants mapped in navigation.
- Archive or tag legacy variants to reduce ambiguity.

## 10. Important Class Layer Components

Located under `lib/class/`:

- `class.login.php` - authentication services
- `class.legal_permission.php` - user permission resolution
- `class.legal_client.php` - client domain logic
- `class.legal_active_legals.php` - active legal domain logic
- `class.legal_case.php` - case domain logic
- `class.legal_case_hearing.php` - hearing operations
- `class.legal_collection.php` - collections
- `class.legal_expense.php` - expense operations
- `class.legal_collection_commission.php` - commission calculations
- `class.legal_commission_voucher.php` - voucher generation
- `class.legal_document.php` - document handling
- `class.legal_activity_log.php` - audit logging
- `class.crsftoken.php` - CSRF utility
- `class.excel.php` - spreadsheet export helpers
- `class.filemanagement.php` - upload/file utility

## 11. AJAX and Background Endpoint Pattern

AJAX endpoints are mostly placed in module-level `ajax` folders and in top-level `ajax/`.

Examples:

- `modules/case/ajax/case_handle.php`
- `modules/case/ajax/add_legal_case_relation.php`
- `modules/activelegal/ajax/manage_active_legal.php`
- `modules/actionreport/ajax/load_followup_action.php`

Expected controls for each endpoint:

- Include `lib/config.php`, DB class, and auth checks
- Verify session and permissions before mutation
- Validate and sanitize inputs
- Return structured JSON for UI consumption

## 12. Reports and Export Layer

Reporting exists via:

- HTML report pages inside modules
- Excel export scripts under `excel/`
- PDF documents via mPDF/FPDI classes

Common export scripts include:

- `excel/activelegal.php`
- `excel/expense_report.php`
- `excel/followupactions.php`
- `excel/totallegal_report.php`

## 13. Security Controls (Current)

Implemented:

- Session-based authentication guard in `index.php`
- Role/permission constants loaded via `auth.php`
- CSRF token generation in `index.php`
- Server-side validator utility (`class.validator.php`)
- Activity logging for auth and operational events

Operational concerns to review:

- `error_reporting(0)` in runtime can hide critical issues in non-prod debugging
- hardcoded DB/base URL values in `lib/config.php` should be environment-specific
- mixed legacy helpers in config should be modernized (without changing behavior)

## 14. Database and Schema Assets

Schema and SQL assets are in:

- `database/db_backup/` - base DB dumps
- `database/SQL_Alterations/` - incremental schema updates
- `database/schema_activity_log.sql` - activity log schema reference
- `database/*/insert.txt` and `update.txt` - seed/update snippets

Deployment order recommendation:

1. Import base dump.
2. Apply legal/live alteration scripts in release order.
3. Validate menu/permission tables before first login.

## 15. Local Setup Procedure

1. Create database (example: `tabasco_legal`).
2. Import SQL from `database/db_backup/tabasco_legal_dB.sql`.
3. Apply pending scripts in `database/SQL_Alterations/legal/` and related release folders.
4. Set `IP`, `DB`, `USER`, `DBPWD` in `lib/config.php`.
5. Set `ROOT_DIR` and `AJAX_ROOT_DIR` to local host path.
6. Install dependencies with Composer (`composer install`).
7. Confirm Apache rewrite is enabled and `.htaccess` is honored.
8. Open `http://localhost/tabasco_legal_code/login.php`.

## 16. Operational Logging and Diagnostics

Relevant files/scripts:

- `core/LegalActivityLog.php`
- `debug_activity_log.php`
- `errors.log`
- `debug_request.log`

Use these for troubleshooting login flow, permission behavior, and action histories.

## 17. Directory Map (High-Level)

- `ajax/` - generic asynchronous handlers
- `api/` - API style endpoints/utilities
- `assets/` - CSS/JS/plugins/media
- `common/` - shared view fragments and handlers
- `core/` - core helpers and activity logger
- `database/` - schema dumps and patch scripts
- `excel/` - Excel export scripts
- `lib/` - configuration, auth, classes, function helpers
- `modules/` - functional business modules
- `templates/` - master/page templates
- `uploads/` - document storage and upload targets
- `vendor/` - Composer packages

## 18. Maintenance Recommendations

- Move environment constants to per-environment config or `.env` strategy.
- Standardize naming (`expense` vs `expence`, module variants with date suffix).
- Add a centralized route registry to reduce hidden module coupling.
- Add automated smoke tests for login, permission checks, and key CRUD flows.
- Introduce stricter response conventions for AJAX endpoints.

## 19. Known Legacy Characteristics

- Mixed coding patterns (procedural + OOP service classes)
- Duplicate/backup files retained in working tree
- Multiple dated module variants coexisting
- Large dependency/plugin footprint inside repository

These are manageable but should be treated as technical debt items for staged refactoring.

## 20. Quick Reference

- Front Controller: `index.php`
- Config: `lib/config.php`
- Auth Guard: `lib/auth.php`
- Login Handler: `login.php`
- DB Wrapper: `lib/class/class.dbcon.php`
- Main Modules: `modules/`
- Templates: `templates/frontend/`
- Exports: `excel/`
- SQL Assets: `database/`

---

For onboarding, start with `index.php`, `lib/config.php`, `lib/auth.php`, and `modules/case/` to understand end-to-end request flow.
