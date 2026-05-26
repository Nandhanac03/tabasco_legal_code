# TABASCO LEGAL MANAGEMENT SYSTEM — Application Documentation

> **Version:** 1.0  
> **Last Updated:** May 26, 2026  
> **Client:** TABASCO TECH CONT LLC  
> **Powered By:** ARABINFOTEC  
> **Timezone:** Asia/Dubai (UTC+4)

---

## Table of Contents

1. [Application Overview](#1-application-overview)
2. [Technology Stack](#2-technology-stack)
3. [Project Structure](#3-project-structure)
4. [Application Architecture](#4-application-architecture)
5. [Configuration](#5-configuration)
6. [URL Routing](#6-url-routing)
7. [Authentication & Authorization](#7-authentication--authorization)
8. [Database Layer](#8-database-layer)
9. [Core Modules](#9-core-modules)
    - 9.1 [Dashboard](#91-dashboard)
    - 9.2 [Client Management](#92-client-management)
    - 9.3 [Active Legal Management](#93-active-legal-management)
    - 9.4 [Case Management](#94-case-management)
    - 9.5 [Collection Management](#95-collection-management)
    - 9.6 [Expense Management](#96-expense-management)
    - 9.7 [Commission Management](#97-commission-management)
    - 9.8 [Commission Report & Voucher](#98-commission-report--voucher)
    - 9.9 [Document Management](#99-document-management)
    - 9.10 [Reports Module](#910-reports-module)
    - 9.11 [Task & Reminders](#911-task--reminders)
    - 9.12 [Master Data](#912-master-data)
    - 9.13 [User & Permission Management](#913-user--permission-management)
    - 9.14 [Third-Party / Agency Management](#914-third-party--agency-management)
10. [PDF Generation](#10-pdf-generation)
11. [Activity Logging](#11-activity-logging)
12. [Security Features](#12-security-features)
13. [Frontend Architecture](#13-frontend-architecture)
14. [Key Database Tables](#14-key-database-tables)
15. [API / AJAX Endpoints](#15-api--ajax-endpoints)
16. [Deployment Notes](#16-deployment-notes)

---

## 1. Application Overview

The **Tabasco Legal Management System** is a comprehensive web-based legal case management platform designed to manage the full lifecycle of legal proceedings for **TABASCO TECH CONT LLC** (UAE). The system enables:

- **Client & Case Tracking** — Register clients, create active legal files, and manage legal cases from initiation to closure.
- **Financial Management** — Track outstanding amounts, collections, expenses, and commission payments for legal firms, debt collectors, and third parties.
- **Agency Collaboration** — Third parties, legal firms, debt collectors, and internal legal teams can log in with restricted views to access assigned cases.
- **Document Management** — Upload, categorize, and manage legal documents per client, case, or entity.
- **Reporting** — Generate action reports, expense reports, statement-based reports, commission reports, bad debts reports, and more.
- **PDF Generation** — Generate commission voucher PDFs using the mPDF library.
- **Activity Logging** — Every data operation (insert, update, delete, login, logout) is recorded in an activity log for full audit trail.
- **Role-Based Access Control** — Granular permission system per module with View/Add/Edit/Delete/Print/Mail capabilities.

---

## 2. Technology Stack

| Layer | Technology | Details |
|---|---|---|
| **Backend** | PHP (Procedural + OOP) | No framework; custom MVC-like architecture |
| **Database** | MySQL | Via PDO with persistent connections |
| **Frontend** | HTML5, CSS3, JavaScript, jQuery | Bootstrap 5 theme with responsive layout |
| **CSS Framework** | Bootstrap 5 | With extended custom CSS themes |
| **UI Components** | Select2, DataTables, MetisMenu, BS Stepper, Ionicons, SimplerBar, Perfect Scrollbar | |
| **PDF Library** | mPDF v8.2+ | Via Composer (`mpdf/mpdf`) |
| **PDF Utility** | FPDI (setasign/fpdi) | PDF import/template overlays |
| **Spreadsheet** | PhpSpreadsheet | Excel export capabilities |
| **Email** | PHPMailer | Built-in class for email notifications |
| **Web Server** | Apache (WAMP) | `.htaccess` URL rewriting |
| **Authentication** | Session-based | AES-256-CBC encrypted passwords |
| **Package Manager** | Composer | For mPDF and FPDI dependencies |

---

## 3. Project Structure

```
tabasco_legal_code/
│
├── index.php                      # Main application entry point (front controller)
├── login.php                      # Login page & authentication handler
├── logout.php                     # Session logout handler
├── permission_denied.php          # Access denied page
├── .htaccess                      # Apache URL rewrite rules
├── composer.json                  # Composer dependencies (mPDF)
│
├── lib/                           # Core library layer
│   ├── config.php                 # Application configuration & constants
│   ├── auth.php                   # Permission loading & authorization logic
│   ├── auth_ajax.php              # AJAX-specific auth handler
│   ├── class/                     # PHP classes (business logic)
│   │   ├── class.dbcon.php        # Database connection (PDO wrapper)
│   │   ├── class.legal_client.php            # Client CRUD
│   │   ├── class.legal_active_legals.php     # Active Legal CRUD
│   │   ├── class.legal_case.php              # Case & Case Roots CRUD
│   │   ├── class.legal_case_hearing.php      # Hearing management
│   │   ├── class.legal_collection.php        # Collection (payments) CRUD
│   │   ├── class.legal_expense.php           # Expense CRUD
│   │   ├── class.legal_collection_commission.php  # Commission calculations
│   │   ├── class.legal_commission_voucher.php     # Commission voucher & PDF
│   │   ├── class.legal_document.php          # Document upload & management
│   │   ├── class.legal_users.php             # User CRUD
│   │   ├── class.legal_permission.php        # Permission management
│   │   ├── class.legal_activity_log.php      # Activity logging
│   │   ├── class.legal_activitylog_amount.php # Financial amount change log
│   │   ├── class.legal_firm.php              # Legal firm management
│   │   ├── class.legal_third_party.php       # Third party management
│   │   ├── class.legal_debt_collector.php    # Debt collector management
│   │   ├── class.legal_bank.php              # Bank master data
│   │   ├── class.legal_category.php          # Category master data
│   │   ├── class.legal_court.php             # Court master data
│   │   ├── class.legal_area.php              # Area master data
│   │   ├── class.legal_location.php          # Location master data
│   │   ├── class.legal_case_mode.php         # Case mode master data
│   │   ├── class.legal_document_types.php    # Document types master data
│   │   ├── class.legal_fees_type.php         # Fees types master data
│   │   ├── class.legal_plantiff.php          # Plaintiff management
│   │   ├── class.legal_defender.php          # Defendant management
│   │   ├── class.legal_contact.php           # Contact management
│   │   ├── class.legal_cheque.php            # Cheque tracking
│   │   ├── class.legal_case_notification.php # Case notifications
│   │   ├── class.legal_task_reminders.php    # Task/reminder management
│   │   ├── class.legal_case_root_actions.php # Case root action tracking
│   │   ├── class.legal_common_selection.php  # Common dropdown selections
│   │   ├── class.legal_action_subcategory.php # Action subcategory
│   │   ├── class.legal_temp_case.php         # Temporary case handling
│   │   ├── class.login.php                   # Login authentication class
│   │   ├── class.common.php                  # Common utilities
│   │   ├── class.validator.php               # Input validation
│   │   ├── class.crsftoken.php               # CSRF token management
│   │   ├── class.phpmailer.php               # PHPMailer integration
│   │   ├── class.excel.php                   # Excel export utilities
│   │   ├── class.filemanagement.php          # File upload management
│   │   ├── class.settings.php                # Application settings
│   │   └── class.item.php                    # Item management
│   └── functions/
│       ├── navigations.php        # Navigation helper functions
│       └── select_options.php     # Dropdown option generators
│
├── core/                          # Core infrastructure (alternate DB layer)
│   ├── dbcon.php                  # Singleton PDO connection
│   └── LegalActivityLog.php      # Activity log implementation
│
├── modules/                       # Application modules (MVC pages)
│   ├── dashboard/                 # Dashboard module
│   ├── client/                    # Client management
│   ├── activelegal/               # Active legal management
│   ├── case/                      # Case management
│   ├── commissionreport/          # Commission reporting
│   ├── expensereport/             # Expense reporting
│   ├── reports/                   # General reports
│   ├── master/                    # Master data management
│   ├── settings/                  # Application settings
│   ├── permission/                # User permission management
│   ├── legalfirm/                 # Legal firm module
│   ├── legalteam/                 # Legal team module
│   ├── thirdparty/                # Third party module
│   ├── debtcollector/             # Debt collector module
│   ├── internalstaff/             # Internal staff module
│   ├── task/                      # Task/reminder module
│   ├── notifications/             # Notification module
│   ├── closedlegal/               # Closed legal cases
│   ├── baddebts/                  # Bad debts tracking
│   ├── totallegal/                # Total legal overview
│   ├── actionreport/              # Action reports
│   ├── design/                    # UI design templates
│   └── uploads/                   # Upload module
│
├── templates/                     # Layout templates
│   └── frontend/
│       ├── master_page.php        # Main layout (sidebar + header + footer)
│       ├── content_holder.php     # Dynamic content area
│       └── login_master_page.php  # Login page layout
│
├── assets/                        # Static assets
│   ├── css/                       # Stylesheets (Bootstrap, custom themes)
│   ├── js/                        # JavaScript files
│   ├── plugins/                   # Third-party plugins
│   └── images/                    # Images and logos
│
├── vendor/                        # Composer dependencies
│   ├── mpdf/                      # mPDF library
│   ├── setasign/fpdi/             # FPDI PDF utilities
│   └── PhpSpreadsheet/            # Excel handling
│
├── uploads/                       # User-uploaded files
├── files/                         # Generated files
├── database/                      # SQL schemas & migration scripts
├── api/                           # REST API endpoints
├── ajax/                          # Global AJAX handlers
├── excel/                         # Excel export scripts
└── images/                        # Public images
```

---

## 4. Application Architecture

### 4.1 Request Lifecycle

```
Client Browser
    │
    ▼
Apache (.htaccess URL Rewriting)
    │
    ▼
index.php (Front Controller)
    ├── lib/config.php         → Load constants & configuration
    ├── lib/class/class.dbcon.php → Initialize database connection
    ├── lib/auth.php           → Load permissions for current user
    ├── lib/functions/         → Load helper functions
    │
    ├── Session check → if not logged in → redirect to login.php
    │
    ├── Parse ?module=X&page=Y&action=Z
    ├── Include: modules/{module}/{page}.php
    │   └── Module sets $body = "template_name.tpl"
    │
    └── Include: templates/frontend/master_page.php
        └── content_holder.php → includes modules/{module}/tpl/{$body}.php
```

### 4.2 Module Pattern

Each module follows a consistent structure:

```
modules/{module_name}/
├── list.php              # List view controller
├── view.php              # Detail view controller
├── information.php       # Create/Edit form controller
├── commission.php        # Module-specific sub-pages
├── ajax/                 # AJAX handlers for this module
│   ├── save_*.php        # Data save/update handlers
│   ├── delete_*.php      # Soft delete handlers
│   └── fetch_*.php       # Data retrieval handlers
└── tpl/                  # Template (view) files
    ├── list.tpl.php      # List view template
    ├── view.tpl.php      # Detail view template
    └── information.tpl.php  # Form template
```

### 4.3 Class Hierarchy

All business logic classes extend the `Dbcon` base class, inheriting database connectivity:

```
Dbcon (class.dbcon.php)
  ├── Clients (class.legal_client.php)
  ├── ActiveLegal (class.legal_active_legals.php)
  ├── LegalCase (class.legal_case.php)
  ├── Collection (class.legal_collection.php)
  ├── Expense (class.legal_expense.php)
  ├── LegalCollectionCommission (class.legal_collection_commission.php)
  ├── processDocument (class.legal_document.php)
  ├── UsersClass (class.legal_users.php)
  ├── userPermission (class.legal_permission.php)
  ├── LegalActivityLog (class.legal_activity_log.php)
  ├── LegalActivityLogAmount (class.legal_activitylog_amount.php)
  ├── Login (class.login.php)
  └── ... (other entity classes)
```

**Exception:** `LegalCommissionVoucher` uses **composition** — it creates its own `Dbcon` instance internally rather than inheriting.

---

## 5. Configuration

### `lib/config.php`

This file defines all application-wide constants and configuration:

| Constant | Description | Example |
|---|---|---|
| `IP` | Database host | `localhost` |
| `DB` | Database name | `tabasco_legal` |
| `USER` | Database user | `root` |
| `DBPWD` | Database password | (empty for local) |
| `ROOT_DIR` | Application root URL | `http://localhost/tabasco_legal_code/` |
| `AJAX_ROOT_DIR` | AJAX base URL | Same as `ROOT_DIR` |
| `SITE_NAME` | Application title | `TABASCO LEGAL MANAGEMENT SYSTEM` |
| `CLIENT_CODE` | Client code prefix | `TABL/CL/` |
| `THIRD_PARTY_CODE` | Third party code prefix | `TABL/TP/` |
| `LEGAL_FIRM_CODE` | Legal firm code prefix | `TABL/LF/` |
| `DEBT_COLLECTOR_CODE` | Debt collector code prefix | `TABL/DC/` |
| `ACTIVE_LEGAL_CODE` | Active legal code prefix | `TABL/AL/` |
| `THIRD_PARTY_C_ID` | Category ID for Third Party | `1` |
| `LEGAL_FIRM_C_ID` | Category ID for Legal Firm | `2` |
| `DEBT_COLLECTOR_C_ID` | Category ID for Debt Collector | `3` |
| `LEGAL_TEAM_C_ID` | Category ID for Legal Team | `4` |
| `PAGINATION_PERPAGE` | Records per page | `15` |
| `LEGAL_PAGES_AUTH` | Enable page-level authorization | `TRUE` |
| `secretKey` | AES-256-CBC encryption key | (32-char string) |

### Utility Functions in config.php

- **`decryptPassword($data, $key)`** — Decrypts AES-256-CBC encrypted passwords.
- **`getOS($userAgent)`** — Detects the operating system from user agent string.
- **`percentile_rank($arr, $val)`** — Calculates percentile rank for analytics.
- **`fetch_variable_value($key)`** / **`fetch_header_value($key)`** — Multi-language label retrieval.
- **`generateRandomString($length)`** — Generates random strings for authentication tokens.

---

## 6. URL Routing

### `.htaccess` Rewrite Rules

The application uses Apache mod_rewrite to create clean URLs:

| Clean URL Pattern | Maps To |
|---|---|
| `{module}.html` | `index.php?module={module}` |
| `{module}/{page}.html` | `index.php?module={module}&page={page}` |
| `{module}/{page}/{action}.html` | `index.php?module={module}&page={page}&action={action}` |
| `{module}/{page}/{action}/{param1}.html` | `...&param1={param1}` |
| `{module}/{page}/{action}/{param1}/{param2}.html` | `...&param2={param2}` |

### URL Examples

| URL | Module | Page | Action |
|---|---|---|---|
| `dashboard/panel.html` | dashboard | panel | — |
| `client/list.html` | client | list | — |
| `activelegal/information/edit/42.html` | activelegal | information | edit (param1=42) |
| `case/view/edit/15.html` | case | view | edit (param1=15) |
| `master/category.html` | master | category | — |
| `commissionreport/commission.html` | commissionreport | commission | — |

---

## 7. Authentication & Authorization

### 7.1 Login Flow

```
login.php
    │
    ├── POST request with username + password
    │
    ├── Normal User Authentication:
    │   └── Login::MainLoginAuthentication()
    │       ├── On success → Set sessions → Redirect to dashboard/panel.html
    │       └── On failure → Try agency login
    │
    └── Agency Authentication:
        └── Login::Agencies_Login_Authentication()
            ├── Third Party (TP) → dashboard/agencies.html
            ├── Legal Firm (LF) → dashboard/agencies.html
            └── Debt Collector (DC) → dashboard/agencies.html
```

### 7.2 Session Variables

| Session Key | Description |
|---|---|
| `LOGIN_LEGAL_ID` | Authenticated user's ID |
| `LOGIN_LEGAL_NAME` | Authenticated user's display name |
| `LOGIN_LEGAL_TYPE_ID` | User type code (e.g., `TP`, `LF`, `DC`) |
| `LOGIN_LEGAL_TYPE_NAME` | User type display name |
| `LOGIN_AGENCIES` | `0` = Internal user, `1` = Agency user |
| `LOGIN_SUPER_ADMIN` | `Y` = Super Admin, `N` = Regular |
| `csrf_token` | CSRF protection token |

### 7.3 Authorization System (`lib/auth.php`)

The system implements granular page-level permissions:

**Permission Flags:**

| Flag | Code | Description |
|---|---|---|
| `LEGAL_AUTH_VIEW` | `V` | Can view the page |
| `LEGAL_AUTH_ADD` | `A` | Can create records |
| `LEGAL_AUTH_EDIT` | `E` | Can edit records |
| `LEGAL_AUTH_DELETE` | `D` | Can delete records |
| `LEGAL_AUTH_PRINT` | `P` | Can print/export |
| `LEGAL_AUTH_MAIL` | `M` | Can send emails |

**Permission Resolution:**

1. **Agency Users** (`LOGIN_AGENCIES == 1`) → All permissions set to `false`.
2. **Super Admins** (`LOGIN_SUPER_ADMIN == 'Y'`) → All permissions set to `true`.
3. **Normal Users** → Permissions loaded from database via `userPermission::get_user_allowed_permissions()`.

**Page-to-Menu ID Mapping** — Each page/module is mapped to a numeric menu ID (1–36). Permissions are stored per user per menu ID in the database.

---

## 8. Database Layer

### 8.1 Primary Connection Class: `Dbcon` (`lib/class/class.dbcon.php`)

The application uses a PDO-based database abstraction layer:

| Method | Description |
|---|---|
| `__construct()` | Establishes persistent PDO connection to MySQL |
| `Query($query, $values)` | Executes INSERT/UPDATE/DELETE queries with prepared statements |
| `SQL_Fetch($query, $values)` | Fetches a single row |
| `SELECT_MultiFetch($query, $values)` | Fetches all matching rows |
| `mysqlInsertid()` | Returns last inserted ID |
| `Begin()` | Starts a transaction |
| `Commit()` | Commits a transaction |
| `Rollback()` | Rolls back a transaction |
| `return_IN_array($input_array)` | Generates named parameters for `IN` clauses |
| `return_IN_comma($input_array)` | Generates comma-separated placeholders for `IN` clauses |
| `get_query($string, $data)` | Debug utility: interpolates params into SQL for logging |

### 8.2 Alternate Core Connection (`core/dbcon.php`)

A second, simplified singleton PDO connection exists in `core/dbcon.php` used by the `LegalActivityLog` class. This uses `PDO::FETCH_ASSOC` as default fetch mode.

### 8.3 Error Handling

Error reporting is controlled by the `PDO_DEBUG` constant:

| Level | Behavior |
|---|---|
| `1` | Generic error message |
| `2` | Show error message + SQL statement |
| `3` | Full traceback with SQL + error details |

---

## 9. Core Modules

### 9.1 Dashboard

**Files:** `modules/dashboard/panel.php` → `tpl/panel.tpl.php`

- Displays case notifications via `Casenotification::get_notifications()`
- Shows task reminders via `LegalTask_reminders::get_taskReminders()`
- Filtered by logged-in user and their role
- Agency users are redirected to `dashboard/agencies.html`

---

### 9.2 Client Management

**Files:** `modules/client/` | **Class:** `Clients` (`class.legal_client.php`)

**Table:** `legal_client`

**Features:**
- Create/edit client information (name, contact, address, marketing person, etc.)
- Auto-generated client code using prefix `TABL/CL/` + zero-padded sequential ID
- Visiting card upload (JPG, PNG, PDF — max 1MB)
- Outstanding amount tracking (total, with cheque, without cheque)
- Soft delete with cascading status change to related documents and contacts
- Client-level amount change activity logging

**Key Methods:**

| Method | Description |
|---|---|
| `Manage_Client_information($data, $id)` | Insert or update client |
| `Get_Client_Information(...)` | Fetch client(s) with filters, pagination, search |
| `Get_Client_TOTAL_COUNT(...)` | Count total clients matching filters |
| `Get_Last_Client_ID()` | Generate next client code |
| `Update_Client_Records_Status($id)` | Soft delete client + related records |
| `Update_Cheque_OutStanding($id, $data)` | Update outstanding amounts |

---

### 9.3 Active Legal Management

**Files:** `modules/activelegal/` | **Class:** `ActiveLegal` (`class.legal_active_legals.php`)

**Table:** `legal_activelegal`

An **Active Legal** represents a legal file opened for a client, assigned to an agency (third party, legal firm, debt collector, or legal team).

**Features:**
- Create/edit active legal records linked to clients and agencies
- Auto-generated code: `TABL/AL/` + zero-padded sequential ID
- Outstanding amount tracking (total, with cheque, without cheque)
- Claim amount, collected amount, balance claim, expense tracking
- Legal status management with reason
- Agency shifting history (transfer between firms)
- Commission management per agency per active legal
- Related case linking

**Key Methods:**

| Method | Description |
|---|---|
| `Manage_ActiveLegal($data, $id)` | Insert or update active legal |
| `Get_ActiveLegal_Information($filters)` | Fetch with complex JOINs across clients, agencies, cases |
| `Get_LEGAL_TOTAL_COUNT(...)` | Count with filters |
| `shift_active_legal($data, $id)` | Record agency shift history |
| `get_shifting($id, $active_legal_id)` | Fetch shifting records |
| `save_commission($data, $id)` | Save commission percentage setup |
| `get_commission($id, $active_legal_id)` | Fetch commission settings |
| `disable_active_legal($data, $id)` | Soft delete with activity logging |

**Agency Categories:**

| Category ID | Code | Type |
|---|---|---|
| 1 | TP | Third Party |
| 2 | LF | Legal Firm |
| 3 | DC | Debt Collector |
| 4 | LT | Legal Team (Internal) |

---

### 9.4 Case Management

**Files:** `modules/case/` | **Class:** `LegalCase` (`class.legal_case.php`)

**Tables:** `legal_case`, `legal_case_roots`, `legal_case_root_actions`, `legal_case_hearing`, `legal_case_relations`, `legal_case_to_case_relations`

**Features:**
- Create/edit legal cases linked to active legals
- Case information: case number, category, court, plaintiff, defendant, lawyer, location, register date, case mode
- Outstanding amount tracking at case level
- Case hearing management (hearing dates, feedback)
- Case roots system with nested actions (multi-stage case tracking)
- Related case linking (bidirectional many-to-many)
- Claim amount tracking

**Key Methods:**

| Method | Description |
|---|---|
| `saveCase($data, $id)` | Insert or update case |
| `get_case($id, $active_legal_id, $case_number)` | Fetch case with latest hearing date |
| `get_case_info(...)` | Extended case info with lawyer name resolution |
| `disable_case($data, $id)` | Soft delete case |
| `saveRoots($data, $id)` | Save case root (stage-level sub-case) |
| `get_roots(...)` | Fetch case roots with filters |
| `all_get_roots(...)` | Fetch roots with court, category, and action details |
| `saveCaseRelation($case_id, $related_id)` | Create case-to-case relation |
| `syncCaseRelations($case_id, $related_ids)` | Sync related cases (add/remove) |
| `getCaseRelations($case_id)` | Get all related case IDs |
| `get_case_root_clients($case_id)` | Get plaintiffs via case → active legal → client chain |
| `get_case_root_clients_defender($case_id)` | Get defendants via same chain |

**Case Roots Architecture:**
```
Legal Case
 └── Case Root (stage/phase)
      ├── Court assignment
      ├── Category
      ├── Plaintiff / Defendant
      └── Root Actions
           ├── Date
           ├── Description
           ├── Document attachment
           └── UAE Pass reference
```

---

### 9.5 Collection Management

**Files:** `modules/` (collection sub-pages) | **Class:** `Collection` (`class.legal_collection.php`)

**Table:** `legal_collections`

**Features:**
- Record payment collections linked to case, client, active legal, and agency
- Tracks: amount, date, fees type, description, remark, document attachment
- Total collection calculation per active legal or per case
- Marketing person association

**Key Methods:**

| Method | Description |
|---|---|
| `save_collection($data, $id)` | Insert or update collection |
| `getting_collection($id, $case_id)` | Fetch collections for a case |
| `get_collection($id, $filters)` | Fetch with full JOINs (client, firm, marketing person) |
| `total_collection($active_legal_id, $case_id)` | Calculate total collected amount |
| `get_last_collection($case_id)` | Get the most recent collection record |
| `delete_hearing($data, $id)` | Soft delete a collection record |

---

### 9.6 Expense Management

**Class:** `Expense` (`class.legal_expense.php`)

**Table:** `legal_expense`

**Features:**
- Record expenses linked to case, client, active legal, and agency
- Similar structure to collections (mirror class)
- Tracks: amount, date, fees type, description, remark, document
- Total expense calculation

**Key Methods:**

| Method | Description |
|---|---|
| `save_expense($data, $id)` | Insert or update expense |
| `getting_expense($id, $case_id)` | Fetch expenses for a case |
| `get_expense($id, $filters)` | Fetch with full JOINs |
| `total_expense($active_legal_id, $case_id)` | Calculate total expenses |

---

### 9.7 Commission Management

**Class:** `LegalCollectionCommission` (`class.legal_collection_commission.php`)

**Table:** `legal_collection_commission`

**Features:**
- Automatic commission calculation based on collection amounts and commission percentages
- Links to: collection, case, active legal, party (third party/legal firm/debt collector/legal team)
- Zero commission flag support
- Commission aggregation per active legal
- Received amount calculation: `(amount × commission_percentage / 100)`

**Key Methods:**

| Method | Description |
|---|---|
| `save_collection_commission($data, $id)` | Insert or update commission record |
| `get_collection_commission($filters)` | Fetch commission records |
| `get_collection_commission_with_collection($filters)` | Fetch with collection & party details |
| `get_collection_commission_aggregates($filters)` | Aggregate commissions per active legal |

---

### 9.8 Commission Report & Voucher

**Files:** `modules/commissionreport/` | **Class:** `LegalCommissionVoucher` (`class.legal_commission_voucher.php`)

**Table:** `legal_commission_voucher`

**Features:**
- Generate commission vouchers with voucher number, date, and total amount
- PDF generation for commission vouchers using mPDF
- Voucher statuses: `Printed`, `Paid`
- Stores generated PDF file reference in `commission_pdf` column

**Key Methods:**

| Method | Description |
|---|---|
| `createVoucher($data)` | Create a new commission voucher |
| `get_all_commission_vouchers()` | Fetch all vouchers |
| `get_all_vouchers()` | Fetch vouchers with status `Printed` or `Paid` and amount > 0 |
| `get_vouchers()` | Fetch unpaid vouchers |

---

### 9.9 Document Management

**Class:** `processDocument` (`class.legal_document.php`)

**Tables:** `legal_document`, `legal_document_type`

**Features:**
- Upload documents with type classification
- Parent entity linking (Client `C`, Third Party `TP`, Legal Firm `LF`, etc.)
- Document type lookup from master data
- Soft delete with activity logging

**Key Methods:**

| Method | Description |
|---|---|
| `upload_document($data)` | Upload a new document |
| `get_document($id, $parent_id, $parent_type)` | Fetch documents with type names |
| `Delete_document($id, $data)` | Soft delete document |

---

### 9.10 Reports Module

**Files:** `modules/reports/`

The reports module provides multiple report types:

| Report | URL Path | Description |
|---|---|---|
| Bad Debts Report | `reports/bad_debts.html` | Cases classified as bad debts |
| Closed Legal Report | `reports/closed_legal_report.html` | Closed/settled legal files |
| Total Legal Statement | `reports/total_legal_report.html` | Comprehensive legal file overview |
| Client Base Action Report | `reports/client_base_action_report_list.html` | Actions organized by client |
| Statement Base Report | `reports/statementbase_report_list.html` | Statement-oriented report |
| Expense Report | `reports/expense_report_list.html` | Expense summary & details |
| Action Report | `reports/action_report_list.html` | Case actions summary |
| UAE Pass Report | `reports/case_report_list.html` | UAE Pass compliance report |

---

### 9.11 Task & Reminders

**Class:** `LegalTask_reminders` (`class.legal_task_reminders.php`)

**Features:**
- Create task reminders for users
- Filter by user, type, super admin status
- Active/viewed status tracking
- Dashboard integration for pending reminders

---

### 9.12 Master Data

**Files:** `modules/master/`

The master data module manages lookup/reference data used throughout the application:

| Master Entity | Class | Table | URL |
|---|---|---|---|
| Area | `LegalArea` | `legal_area` | `master/area.html` |
| Bank | `LegalBank` | `legal_bank` | `master/bank.html` |
| Category | `LegalCategory` | `legal_category` | `master/category.html` |
| Sub Category | `LegalActionSubcategory` | `legal_action_subcategory` | `master/subcategory.html` |
| Lawyer | — | — | `master/lawyer.html` |
| Document Types | `LegalDocumentTypes` | `legal_document_type` | `master/dtype.html` |
| Fees Types | `LegalFeesType` | `legal_fees_type` | `master/fees_type.html` |
| Location | `LegalLocation` | `legal_location` | `master/location.html` |
| Court | `LegalCourt` | `legal_court` | `master/court.html` |
| Case Mode | `LegalCaseMode` | `legal_case_mode` | `master/case_mode.html` |

---

### 9.13 User & Permission Management

**Class:** `UsersClass` (`class.legal_users.php`)

**Tables:** `users`, `usertype`

**Features:**
- User CRUD with duplicate email/login name validation
- User types via `usertype` table
- User module filter (`user_module = 'TL'` for Tabasco Legal)
- Permission management for super admins (`permission/userlist.html`)

**Key Fields:**
- `user_Id`, `user_name`, `user_emailId`, `user_loginname`, `user_password`
- `user_typeId`, `user_mob`, `user_tel`, `user_address`
- `user_photo`, `user_profile`, `user_legal_access`, `user_module`
- `user_status` (A = Active)

---

### 9.14 Third-Party / Agency Management

Three types of agencies can be managed and can also log in to the system:

| Type | Module | Class | Table | Code Prefix |
|---|---|---|---|---|
| Third Party | `modules/thirdparty/` | `LegalThirdParty` | `legal_third_party` | `TABL/TP/` |
| Legal Firm | `modules/legalfirm/` | `LegalFirm` | `legal_firm` | `TABL/LF/` |
| Debt Collector | `modules/debtcollector/` | `LegalDebtCollector` | `legal_debt_collector` | `TABL/DC/` |

Agency users log in through the same login page but are routed to `dashboard/agencies.html` with restricted permissions.

---

## 10. PDF Generation

### 10.1 Library

The application uses **mPDF v8.2+** (installed via Composer) for PDF generation. The **FPDI** library (`setasign/fpdi`) is also available for importing existing PDF templates.

### 10.2 Commission Voucher PDF Workflow

```
Commission Report Page
    │
    ├── User selects commissions to print
    │
    ├── AJAX call to commission print handler
    │   ├── Build HTML template for commission voucher
    │   ├── Initialize mPDF engine
    │   ├── Render HTML → PDF
    │   ├── Save PDF file to server
    │   └── Return PDF path
    │
    ├── LegalCommissionVoucher::createVoucher()
    │   ├── Inserts record into `legal_commission_voucher` table
    │   ├── Fields: voucher_no, voucher_date, total_amount, commission_pdf
    │   ├── Sets status to 'Printed'
    │   └── Logs activity via LegalActivityLog
    │
    └── PDF served to user for download/print
```

### 10.3 `legal_commission_voucher` Table Schema

| Column | Type | Description |
|---|---|---|
| `id` | INT (PK, AUTO_INCREMENT) | Unique voucher ID |
| `voucher_no` | VARCHAR | Generated voucher number |
| `voucher_date` | DATE | Voucher creation date |
| `total_amount` | DECIMAL | Total commission amount |
| `status` | VARCHAR | `Printed` or `Paid` |
| `printed_at` | DATETIME | Timestamp of print |
| `created_by` | INT | User who created voucher |
| `created_at` | DATETIME | Creation timestamp |
| `commission_pdf` | VARCHAR | Path to generated PDF file |

### 10.4 Composer Dependency

```json
{
    "require": {
        "mpdf/mpdf": "^8.2"
    }
}
```

---

## 11. Activity Logging

### 11.1 Primary Activity Log

**Class:** `LegalActivityLog` (`class.legal_activity_log.php`)

**Table:** `legal_activity_logs`

Every significant action in the system is logged:

| Column | Description |
|---|---|
| `log_user` | User ID who performed the action |
| `log_utype` | User type/role |
| `log_action` | Action type (`INSERT`, `UPDATE`, `DELETE`, `DISABLE`, `LOGIN`, `LOGOUT`, `LOGIN_FAILED`, `UPLOAD`) |
| `log_menu` | Module/table affected |
| `log_message` | Human-readable description |
| `log_url` | Request URI |
| `log_refr_id` | Reference ID (e.g., record ID) |
| `beforei` | JSON snapshot of data before change |
| `afteri` | JSON snapshot of data after change |
| `ip` | Client IP address |
| `log_datetime` | Exact timestamp |
| `log_date` | Date only |

### 11.2 Amount Activity Log

**Class:** `LegalActivityLogAmount` (`class.legal_activitylog_amount.php`)

A specialized log for tracking financial amount changes across clients, active legals, and cases. Captures before/after values for:
- Total outstanding
- Outstanding with cheque (PDC)
- Outstanding without cheque (Invoices)

---

## 12. Security Features

### 12.1 SQL Injection Prevention
- All database queries use **PDO prepared statements** with named parameters (`:param`).
- No raw user input is concatenated into SQL strings in business logic classes.

### 12.2 CSRF Protection
- CSRF tokens are generated per session using `bin2hex(random_bytes(32))`.
- Token is stored in `$_SESSION['csrf_token']`.
- Managed via the `csrftoken` class (`class.crsftoken.php`).

### 12.3 Password Encryption
- Passwords are encrypted using **AES-256-CBC** with a configurable secret key.
- Decryption is handled by `decryptPassword()` in `config.php`.

### 12.4 Input Validation
- Input sanitization via `validator::clean_string()`.
- File upload validation for type (JPG, PNG, PDF) and size (1MB limit).

### 12.5 Session Security
- Sessions are cleared on logout with `session_unset()` and `session_destroy()`.
- Login activity (successful and failed) is logged with IP addresses.

### 12.6 Soft Deletes
- Records are never physically deleted. Status is changed to `D` (Deleted).
- All queries filter on `status = 'A'` (Active) by default.

---

## 13. Frontend Architecture

### 13.1 Master Template (`templates/frontend/master_page.php`)

The main layout consists of:

```
┌─────────────────────────────────────────┐
│                 HEADER                   │
│  [Toggle] [Dark Mode] [Apps] [Profile]  │
├──────────┬──────────────────────────────┤
│          │                              │
│ SIDEBAR  │       CONTENT AREA           │
│          │                              │
│ • Dashboard   (content_holder.php)      │
│ • Master      ↓                         │
│ • Reports     modules/{module}/tpl/     │
│ • Settings    {$body}.php               │
│          │                              │
├──────────┴──────────────────────────────┤
│            FOOTER / SCRIPTS             │
└─────────────────────────────────────────┘
```

### 13.2 Navigation Structure (Internal Users)

```
Dashboard
Master ▸
    Area, Bank, Category, Sub Category, Lawyer,
    Document Types, Fees Types, Location, Court, Case Mode
Report ▸
    Bad Debts, Closed Legal, Total Legal Statement,
    Client Base Action, Statement Base, Expense Report,
    Action Report, UAE Pass Report
Settings ▸
    Set Permissions (Super Admin only)
    Logout
```

### 13.3 Frontend Libraries

| Library | Purpose |
|---|---|
| **jQuery** | DOM manipulation, AJAX calls |
| **Bootstrap 5** | Responsive grid, components, modals |
| **Select2** | Enhanced searchable dropdowns |
| **DataTables** | Sortable/searchable/paginated tables |
| **MetisMenu** | Sidebar accordion menu |
| **BS Stepper** | Multi-step form wizard |
| **Ionicons** | Icon library |
| **LobiBox** | Notification popups |
| **Perfect Scrollbar** | Custom scrollbars |
| **SimpleBar** | Sidebar scroll enhancement |

### 13.4 Theme Support

- **Light Theme** (default)
- **Dark Theme** (`dark-theme.css`)
- **Semi-Dark Theme** (`semi-dark.css`)
- **Customizable Header Colors** (`header-colors.css`)
- Toggle via dark mode icon in header

---

## 14. Key Database Tables

### Entity Tables

| Table | Description |
|---|---|
| `legal_client` | Client master data |
| `legal_activelegal` | Active legal file records |
| `legal_case` | Legal case information |
| `legal_case_roots` | Case root stages/phases |
| `legal_case_root_actions` | Actions within case roots |
| `legal_case_hearing` | Case hearing dates & feedback |
| `legal_case_relations` | Case-to-case relations |
| `legal_case_to_case_relations` | Bidirectional case linking |
| `legal_collections` | Payment collection records |
| `legal_expense` | Expense records |
| `legal_collection_commission` | Commission calculation records |
| `legal_activelegal_commission` | Commission % setup per active legal |
| `legal_commission_voucher` | Commission voucher (PDF) records |
| `legal_document` | Uploaded documents |
| `legal_shift_active_legal` | Agency shifting history |

### Master Data Tables

| Table | Description |
|---|---|
| `legal_area` | Area/region lookup |
| `legal_bank` | Bank master data |
| `legal_category` | Case/legal category |
| `legal_action_subcategory` | Action sub-categories |
| `legal_court` | Court names |
| `legal_location` | Location lookup |
| `legal_case_mode` | Case modes/types |
| `legal_document_type` | Document type classifications |
| `legal_fees_type` | Fee type classifications |

### Entity Management Tables

| Table | Description |
|---|---|
| `legal_third_party` | Third party agency details |
| `legal_firm` | Legal firm details |
| `legal_debt_collector` | Debt collector details |
| `legal_plantiff` | Plaintiff records |
| `legal_defender` | Defendant records |
| `legal_contacts` | Contact details (per entity) |
| `legal_cheque` | Cheque tracking |

### System Tables

| Table | Description |
|---|---|
| `users` | System users |
| `usertype` | User type definitions |
| `legal_activity_logs` | Full activity audit trail |
| `legal_case_notification` | Case-related notifications |
| `legal_task_reminders` | Task/reminder entries |

---

## 15. API / AJAX Endpoints

### Module AJAX Pattern

Each module has an `ajax/` subdirectory with specific handlers:

```
modules/{module}/ajax/
├── save_{entity}.php           # Create or update record
├── delete_{entity}.php         # Soft delete record
├── fetch_{entity}.php          # Retrieve data (JSON response)
├── save_outstanding.php        # Update financial outstanding amounts
└── print_commission.php        # Generate PDF (commission module)
```

### Global AJAX Directory

```
ajax/
├── user_login.php              # Login API endpoint
└── ...                         # Other global AJAX handlers
```

### Common AJAX Response Pattern

```php
// Typical save handler structure
include_once("lib/config.php");
include_once("lib/class/class.dbcon.php");
include_once("lib/class/class.{entity}.php");
include_once("lib/auth_ajax.php");

$obj = new EntityClass();
$data = [
    'field1' => $_POST['field1'],
    'field2' => $_POST['field2'],
    // ...
];
$result = $obj->saveEntity($data, $id);

if ($result) {
    $_SESSION['PAGE_SUCCESS'] = "Record saved successfully!";
    header("location: " . ROOT_DIR . "module/page.html");
} else {
    // Handle error
}
```

---

## 16. Deployment Notes

### 16.1 Local Development (WAMP)

```
Server: Apache + MySQL via WAMP
URL: http://localhost/tabasco_legal_code/
Database: tabasco_legal (user: root, password: empty)
PHP: Requires 7.4+ (for typed properties in core/dbcon.php)
Memory: ini_set('memory_limit', '-1')
```

### 16.2 Production Configuration

Update the following in `lib/config.php`:

```php
// Switch from LOCAL to LIVE credentials
define("IP", "localhost");
define("DB", "demouser_talegal");
define("USER", "demouser_talegal");
define("DBPWD", "mevda5GM4SDD");

define("ROOT_DIR", "https://yourdomain.com/");
define("AJAX_ROOT_DIR", "https://yourdomain.com/");
```

### 16.3 Dependencies Installation

```bash
# Install Composer dependencies (mPDF)
composer install
```

### 16.4 Required PHP Extensions

- `pdo_mysql` — Database connectivity
- `openssl` — Password encryption/decryption
- `mbstring` — Multi-byte string handling (mPDF requirement)
- `gd` — Image processing (mPDF requirement)
- `fileinfo` — File upload MIME detection

### 16.5 File Permissions

Ensure the following directories are writable by the web server:
- `uploads/` — User file uploads
- `files/` — Generated files (PDFs, exports)
- `vendor/mpdf/mpdf/tmp/` — mPDF temporary files
- `vendor/mpdf/mpdf/ttfontdata/` — mPDF font cache

---

> **Copyright © 2026 TABASCO TECH CONT LLC. Powered by ARABINFOTEC.**  
> **All rights reserved.**
