# TABASCO LEGAL - Module-Wise Elaborate Documentation

**Updated:** May 27, 2026  
**Codebase:** `G:\wamp64\www\tabasco_legal_code`

## 1. Dashboard Module (`modules/dashboard`)

### Purpose
Provides operational landing pages for internal users and agency users, including quick visibility into pending work and reminders.

### Main Pages
- `panel.php` + `tpl/panel.tpl.php`: Internal dashboard panel
- `agencies.php` + `tpl/agencies.tpl.php`: Agency-focused dashboard

### Key Flow
- Loads summary widgets and reminders after login redirect.
- Serves as the starting point for navigating case/legal workflows.

### AJAX
- `ajax/update_task_reminder.php`: Updates task reminder status/content.

## 2. Client Module (`modules/client`)

### Purpose
Manages client onboarding, profile details, related documents, contacts, and linked legal relationships.

### Main Pages
- `list.php`: Client listing/search
- `information.php`: Core client profile create/update
- `contact.php`: Contact details and communication points
- `document.php`: Client-level document management
- `commission.php`: Client commission data view/entry
- `plantiff.php`, `defender.php`: Litigation party linkage
- `view.php`: Composite module view wrapper

### Templates
- `tpl/list.tpl.php`, `tpl/information.tpl.php`, `tpl/contact.tpl.php`, `tpl/document.tpl.php`, `tpl/commission.tpl.php`, `tpl/plantiff.tpl.php`, `tpl/defender.tpl.php`

### AJAX
- `ajax/load_client.php`, `ajax/get_client.php`: Client load/fetch
- `ajax/validate_client.php`: Duplicate/validation checks
- `ajax/save_external_client.php`: External client save path

### Business Notes
- Client is a primary parent entity for active legal records and case relationships.
- Data quality here directly affects all downstream reports.

## 3. Active Legal Module (`modules/activelegal`)

### Purpose
Tracks active legal files before/during detailed case progression and acts as a bridge between client, agency, and case operations.

### Main Pages
- `list.php`: Active legal listing
- `information.php`: Core active legal details
- `relatedcases.php`: Case relation visibility
- `document.php`, `contact.php`, `commission.php`: Subsections
- `actionview.php`, `view.php`: Action and consolidated views

### Templates
- `tpl/list.tpl.php`, `tpl/information.tpl.php`, `tpl/relatedcases.tpl.php`, `tpl/document.tpl.php`, `tpl/contact.tpl.php`, `tpl/commission.tpl.php`, `tpl/actionview.tpl.php`

### AJAX
- `ajax/manage_active_legal.php`: Create/update active legal
- `ajax/load_active_legal.php`: Listing and filters
- `ajax/check_active_legal.php`: Duplicate/validation checks
- `ajax/changeLegalStatus.php`: Status transitions
- `ajax/case_notification.php`: Notification triggers
- `ajax/quick_add_case.php`: Fast case creation path
- `ajax/manage_expenses.php`, `ajax/manage_commission.php`, `ajax/save_outstanding.php`
- `ajax/get_cases_by_client.php`, `ajax/get_related_cases_list.php`, `ajax/delete_case.php`, `ajax/shift_active_legal.php`

### Business Notes
- This module is central to operational legal queue management.
- Status transitions here impact reporting modules (closed, bad debts, totals).

## 4. Case Module (`modules/case`)

### Purpose
Handles full legal case lifecycle: case details, hearing schedules, action roots, related-case graph, cheque tracking, and expense attachments.

### Main Pages
- `list.php`: Case listing
- `information.php`: Core case information
- `actions.php`: Action timeline/stages
- `hearing.php`, `case_hearing.php`: Hearing calendar and tracking
- `relatedcases.php`: Relationship management
- `expense.php`: Case-level expense flow
- `document.php`, `document_view.php`: Document lifecycle
- `view.php`: Unified display

### Templates
- `tpl/information.tpl.php`, `tpl/actions.tpl.php`, `tpl/hearing.tpl.php`, `tpl/case_hearing.tpl.php`, `tpl/relatedcases.tpl.php`, `tpl/expense.tpl.php`, `tpl/document.tpl.php`, `tpl/document_view.tpl.php`, `tpl/list.tpl.php`, `tpl/view.tpl.php`

### AJAX
- `ajax/case_handle.php`: Core create/update
- `ajax/case_autopopulate.php`: Data prefill helpers
- `ajax/check_duplicate_stage.php`: Action stage integrity
- `ajax/roots_handling.php`: Root/action hierarchy operations
- `ajax/case_hearing_date.php`, `ajax/hearing_date.php`: Hearing schedule updates
- `ajax/get_related_cases.php`, `ajax/get_legal_case_relations.php`
- `ajax/add_legal_case_relation.php`, `ajax/delete_legal_case_relation.php`
- `ajax/load_ajax_cheque.php`, `ajax/delete_cheque.php`
- `ajax/save_outstanding.php`, `ajax/search_legal_cases.php`

### Business Notes
- This is the most process-heavy module and primary legal audit source.
- Case actions and hearing logs feed follow-up and compliance reporting.

## 5. Action Report Module (`modules/actionreport`)

### Purpose
Provides action-wise and follow-up wise analysis for legal progress monitoring.

### Main Pages
- `list.php`, `view.php`
- `caseactions.php`, `caselist.php`
- `followuplist.php`, `followupview.php`, `followupactions.php`

### Templates
- `tpl/list.tpl.php`, `tpl/view.tpl.php`, `tpl/caseactions.tpl.php`, `tpl/caselist.tpl.php`, `tpl/followuplist.tpl.php`, `tpl/followupview.tpl.php`, `tpl/followupactions.tpl.php`, `tpl/followupcaseview.tpl.php`

### AJAX
- `ajax/load_action_stage.php`
- `ajax/load_action_root_data.php`
- `ajax/load_case_action.php`
- `ajax/load_followup_action.php`

### Business Notes
- Used by operations and management to identify pending stages and delay points.

## 6. Reports Module (`modules/reports`)

### Purpose
Central reporting suite for financial, legal, and performance views.

### Report Pages
- Action reports: `action_report.php`, `action_report_list.php`, `action_report_client.php`, `action_report_with_clain_ex.php`
- Case reports: `case_report_list.php`, `case_report_client.php`
- Client-base reports: `client_base_action_report_list.php`, `clientbase_action_report_client.php`, `client_base_statement.php`
- Expense reports: `expense_report.php`, `expense_report_list.php`, `expense_report_client.php`
- Statement-based reports: `statementbase_report_list.php`, `statementbase_report_client.php`
- Summary reports: `total_legal_report.php`, `closed_legal_report.php`, `bad_debts.php`
- Audit page: `activity_log.php`

### AJAX
- `ajax/load_ajax_action_report_list.php`
- `ajax/load_ajax_case_report_list.php`
- `ajax/load_ajax_clientbaseaction_report_list.php`
- `ajax/load_ajax_expense_report_list.php`
- `ajax/load_ajax_statementbase_report_list.php`
- `ajax/load_total_legal_report.php`, `ajax/load_closed_report.php`, `ajax/load_bad_debts_report.php`
- `ajax/get_activity_log.php`

### Business Notes
- This module is management-facing and highly dependent on clean source data from Client/Active Legal/Case flows.

## 7. Commission Report Module (`modules/commissionreport`)

### Purpose
Handles commission calculations, voucher workflow, printed statements, and commission PDF generation.

### Main Pages
- `commission.php`
- `printedcommission.php`, `printed_commission.php`

### Templates
- `tpl/commission.tpl.php`
- `tpl/printedcommission.tpl.php`, `tpl/printed_commission.tpl.php`

### AJAX
- `ajax/load_commission_list.php`
- `ajax/get_commission_details.php`
- `ajax/get_printed_commission.php`
- `ajax/get_voucher_options.php`
- `ajax/save_commission_voucher.php`
- `ajax/update_commission_status.php`
- `ajax/generate_commission_pdf.php`

### Business Notes
- Financially sensitive module; voucher status transitions should be strictly audited.

## 8. Expense Report Module (`modules/expensereport`)

### Purpose
Tracks and reports legal expense claims and related collection adjustments.

### Main Pages
- `list.php`, `expenselist.php`, `expense.php`, `claimamount.php`

### Templates
- `tpl/list.tpl.php`, `tpl/expenselist.tpl.php`, `tpl/expense.tpl.php`, `tpl/claimamount.tpl.php`

### AJAX
- `ajax/get_active_legal.php`
- `ajax/load_all_clients.php`
- `ajax/save_expense.php`
- `ajax/save_collection.php`

### Business Notes
- Used for claim accuracy and reconciliation with commission/collection records.

## 9. Master Module (`modules/master`)

### Purpose
Stores master data used application-wide by forms, dropdowns, and validation logic.

### Main Pages
- `area.php`, `bank.php`, `category.php`, `court.php`, `case_mode.php`, `dtype.php`, `fees_type.php`, `location.php`, `subcategory.php`
- `lawyer.php`, `lawyer_info.php`

### AJAX
- Corresponding handlers in `ajax/` for each master entity.

### Business Notes
- Incorrect master records can cascade into invalid case/report output.

## 10. Permission Module (`modules/permission`)

### Purpose
Assigns per-user module permissions with operation-level granularity.

### Main Pages
- `userlist.php`: User permission overview
- `set.php`: Permission assignment page

### Templates
- `tpl/userlist.tpl.php`, `tpl/set.tpl.php`

### AJAX
- `ajax/save_permissions.php`
- `ajax/save_permissions_bulk.php`

### Business Notes
- Works with `lib/auth.php` page-menu mapping and permission constants.

## 11. Task Module (`modules/task`)

### Purpose
Manages legal task reminders and periodic follow-up activities.

### Main Pages
- `list.php`

### Templates
- `tpl/list.tpl.php`

### AJAX
- `ajax/task_reminders.php`

### Business Notes
- Integrates with dashboard reminder update functions.

## 12. Agency Entity Modules

These modules share a common sub-structure (`list`, `information`, `contact`, `document`, `commission`, `view`) and represent agency-specific entities.

### 12.1 Third Party (`modules/thirdparty`)
- AJAX: `ajax/load_thirdparty.php`
- Use: external legal collaborator tracking.

### 12.2 Legal Firm (`modules/legalfirm`)
- AJAX: `ajax/load_legalfirm.php`
- Use: law firm management and commission coordination.

### 12.3 Debt Collector (`modules/debtcollector`)
- AJAX: `ajax/load_debtcollector.php`
- Use: debt recovery channel operations.

### Business Notes
- These entities are heavily tied to active legal and commission workflows.

## 13. Internal Team Modules

### 13.1 Internal Staff (`modules/internalstaff`)
- Pages: `list.php`, `information.php`
- AJAX: `ajax/loadinternalStaff.php`

### 13.2 Legal Team (`modules/legalteam`)
- Pages: `list.php`, `information.php`
- AJAX: `ajax/loadLegalteam.php`, `ajax/validateDuplicate.php`

### Business Notes
- Supports assignment and operational ownership in legal processes.

## 14. Legal Status Result Modules

### 14.1 Closed Legal (`modules/closedlegal`)
- Pages: list/information/contact/document/commission/view
- AJAX: `ajax/load_closed_legal.php`
- Purpose: completed/closed legal matters.

### 14.2 Bad Debts (`modules/baddebts`)
- Pages: list/information/contact/document/commission/view
- AJAX: `ajax/load_baddebts_legal.php`
- Purpose: non-recoverable/legal write-off tracking.

### 14.3 Total Legal (`modules/totallegal`)
- Pages: list/information/contact/document/commission/view
- AJAX: `ajax/load_total_legal.php`
- Purpose: combined legal dataset and lifecycle overview.

## 15. Versioned / Legacy Variants

Present in codebase:
- `activelegal-14apr26`, `activelegal21apr26`
- `commissionreport-old`, `commissionreport30apr26`
- `expensereport-old`, `expensereport-14apr26`, `expensereport12mar26`
- `reports30apr26`, plus `*demo` modules

### Recommendation
- Freeze one production variant per domain module.
- Archive legacy variants to reduce accidental routing/use.

## 16. End-to-End Lifecycle (Cross-Module)

1. Client created (`client`)
2. Active legal file opened (`activelegal`)
3. Case progression managed (`case`)
4. Task/follow-up monitored (`task`, `actionreport`)
5. Financial outcomes tracked (`expensereport`, `commissionreport`)
6. Final status reflected (`closedlegal` / `baddebts` / `totallegal`)
7. Management insights generated (`reports`)

## 17. Module Governance Checklist

For each module in production:
- Permission map entry exists in `lib/auth.php`
- AJAX endpoints validate session and action permissions
- Insert/update/delete actions are activity-logged
- Templates and page controllers are synchronized
- Legacy copies (`-old`, dated files) are not linked in navigation

---

If you want, I can now convert this exact module-wise document into a polished PDF (`MODULEWISE_DOCUMENTATION_PROFESSIONAL.pdf`) like the previous professional output.
