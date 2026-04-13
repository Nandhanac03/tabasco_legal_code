# Tabasco Legal - Application Documentation

## 1. Application Analysis and their Description

## 2. Directory Structure

 Directory - Purpose 

 **`/modules`**           -      Feature-specific business logic (Cases, Reports, Commissions, etc.) 
 **`/lib`**               -      Core libraries, shared classes, business logic, and database connection 
 **`/ajax` & `/api`**     -      Entry points for dynamic UI interactions and external integrations 
 **`/templates`**         -      Presentation layer and UI components 
 **`/assets `**           -      Static files (CSS, JS, Images) 
 **`/uploads`**           -      Persistent storage for documents, PDFs, and signed vouchers 
 **`/vendor`**            -      Third-party dependencies managed by Composer 

## 3. Core Modules

 Module - Description 

 **`case`**                 -       End-to-end management of legal cases from entry to closure 
 **`client`**               -       Customer profiling and relationship management 
 **`commissionreport`**     -       Grouping collections into vouchers and generating PDFs 
 **`expensereport`**        -       Tracking payments and operational costs 
 **`debtcollector`**        -       Management of agents and collection targets 
  **`dashboard`**           -       Centralized view of KPIs and active cases 
 **`master`**               -       Global system configuration and lookup tables 

## 4. Database Architecture

 **Clients**:  Stakeholders.
 **Firms/Teams**: Legal professionals assigned to cases.
 **Cases**: Linked to Clients and assigned to Firms.
 **Parties**: Plaintiffs and Defenders involved in cases.


1. **Collections**: Recorded after payments are received.
2. **Commissions**: Automatically calculated based on collection amounts.
3. **Vouchers**: Groups of commissions ready for payout.
4. **Expenses**: Automatic records created when vouchers are paid.





### 5 Database table and their description ###




### 5.1 Case Management Tables
 

 `legal_case`             -     Main table storing case details (Case No, Court, Lawyer, Lawyer ID, etc.) 
 `legal_case_hearing`     -     Stores hearing history and feedback for each case. 
 `legal_case_roots`       -     Tracks different procedural stages (Roots) within a specific case. 
 `legal_case_mode`        -     Lookup table for the mode of legal action (e.g., Civil, Criminal). 
 `legal_category`         -     Global lookup for case categories. 
 `legal_plantiff`         -     Stores details of plaintiffs involved in the case. 
 `legal_defender`         -     Stores details of defendants/debtors involved in the case. 

### 5.2 Client & Active Case Management


 `legal_client`          -        Primary profiles for customers/clients. 
 `legal_activelegal`      -    Links a claim/active case to a client and manages the assignment to agencies like Firms, Debt Collectors, or Third Parties. 
 `legal_document`        -      Stores metadata and paths for all uploaded files (PDFs, Vouchers, etc.). 
 `legal_contacts`        -      Contact directory for specific client representatives. 

### 5.3 Financial & Collection Tables
 

 `legal_collections`           -      Records of individual payments collected against cases. 
 `legal_collection_commission` -      Calculated commissions for different parties based on specific collections. 
 `legal_commission_voucher`    -      Groups of commission records summarized for payout and PDF generation. 
 `legal_activelegal_commission` -     Configuration table for commission rules per active legal entity. 
 `legal_expense`                 -    All operational costs, including case-related expenses and payout settlements. 
 `legal_fees_type`               -      Lookup table defining types of financial fees. 

### 5.4 Agency & User Management


 `legal_firm`              -     Profiles of legal firms handled by the system. 
 `legal_debt_collector`    -     Profiles of internal or external debt collector agents. 
 `legal_third_party`       -     External agencies involved in specialized collection or legal tasks. 
 `users`                   -     System users, including administrators and the internal Legal Team. 

### 5.5 Audit & Logging


 `legal_activity_log`   -    Centralized audit trail recording all Inserts, Updates, and Deletes with user context. 

## 6. Technology Stack
 **PHP Version**: PHP 8.0.13
 **Database**: MySQL 
 **Key Libraries**: 
   **mPDF**: PDF generation 
