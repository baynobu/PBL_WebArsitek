# AGENTS.md

This file serves as the long-term memory, decision framework, and knowledge base for any AI Agent working on this project. Always consult this document before initiating work to ensure architectural alignment, consistency in coding standards, and to avoid repeating past mistakes.

---

## 1. Agent Identity & Purpose

- **Role**: Senior Laravel developer and UI designer.
- **Primary Goal**: Maintain, optimize, and build features for the PBL WebArsitek application while maintaining the aesthetic integrity (Stone/Amber theme), security, and database constraints.
- **Work Priorities**:
  1. **Correctness**: Code must parse correctly, have matched Blade blocks, and adhere to controller-view validation.
  2. **Security & Authorization**: Strictly separate client, architect (arsitek), and administrator actions. Never expose sensitive prices/actions (e.g. "Terima Proposal" or other candidate bids) to non-authorized roles.
  3. **Maintainability**: Prefer vanilla Blade structure, native Laravel features over heavy packages (e.g. Filament has been removed to simplify the codebase into a single route gate).
  4. **Responsiveness**: Ensure layouts adjust perfectly on mobile, tablet, and desktop viewports.
- **Strict Guidelines**:
  - Always verify that all `@if` directives are properly closed with `@endif`.
  - Always use Indonesian vocabulary matching KBBI for UI strings.
  - Never edit or update model structures without confirming existing migrations.
  - Check `AGENTS.md` at the start of every session.

---

## 2. Project Understanding Memory

```
Project: PBL WebArsitek
Purpose: A platform linking clients (who post project tenders) and architects (who submit proposals and execute projects).
Technology: Laravel 13, PHP 8.5, Tailwind CSS, Alpine.js, Blade, SQLite/MySQL.
Architecture: MVC (Model-View-Controller) utilizing Laravel routing, middleware, and Blade views.
Important Components:
- Proyek (Project Model): Managed by clients; can have status 'open', 'progress', 'done'.
- Proposal (Proposal Model): Submitted by architects to apply for open project tenders.
- User (User Model): Handles authentication, verification, and role-based permissions (admin, client, arsitek).
- AdminController: Single unified admin portal replacing Filament admin panels.
```

---

## 3. Decision Memory System

## Decision ID: DEC-001
Date: 2026-06-11
Context: Admin operations were split between a custom `/dashboard` layout and a separate `/admin` Filament panel.
Problem: Having two admin gates caused layout inconsistencies and required extra package overhead.
Options Considered:
- **Option A**: Keep Filament panel under `/admin` and style it to match the rest of the application.
- **Option B**: Build a unified custom admin dashboard using Blade tabs under the main `/dashboard` route and completely uninstall Filament.
Chosen Decision: **Option B**
Reasoning: Eliminates duplicate pages, avoids package maintenance issues, and unifies the design system under a custom Stone/Amber responsive style.
Impact: Filament providers and packages were disabled/removed. All admin features (Landing Page CRUD, project verification, user verification) now exist under the `/dashboard` route gated by `role:admin`.
Future Reference: Gating all admin updates directly through `AdminController` actions.

## Decision ID: DEC-002
Date: 2026-06-11
Context: Architect dashboard and tender listing page.
Problem: Previously, the architect dashboard redirected to `/arsitek/proyek` (Proyek Saya), and a separate duplicate page "Daftar Tender" was created.
Options Considered:
- **Option A**: Keep them separate, forcing the user to navigate to "Daftar Tender" to browse and apply.
- **Option B**: Display the available tender listing directly on the Architect's dashboard `/dashboard`, leaving `/arsitek/proyek` purely for active workspaces/proposals.
Chosen Decision: **Option B**
Reasoning: Decreases UI clutter and duplicates, offering a clean entry point where architects immediately see available jobs.
Impact: "Daftar Tender" navbar link removed. `/dashboard` for architects serves the listing dynamically.
Future Reference: Do not recreate a recreation route for tender lists.

## Decision ID: DEC-003
Date: 2026-06-16
Context: Implementing client draft projects and scheduled posting systems.
Problem: Need a way to save drafts and schedule publications without causing duplicate database records or overly complex schemas.
Options Considered:
- **Option A**: Create a new `draft_proyek` table for drafts and scheduling metadata.
- **Option B**: Add a `scheduled_at` datetime column directly to the existing `proyek` table and introduce `'draft'` and `'scheduled'` statuses.
Chosen Decision: **Option B**
Reasoning: Eliminates database joins, keeps schema clean, makes transitions to `'open'` straightforward through a single table update, and reuses all existing project relations.
Impact: Added `scheduled_at` column to `proyek`. Configured an Artisan command (`app:publish-scheduled-projects`) run by Laravel Scheduler every minute to automatically publish scheduled tenders.
Future Reference: Exclude unpublished projects using the `Proyek::published()` scope.

---

## 4. Logic Memory

- **Rule: Project Deletion Constraints**
  - *Logic*: A client can only delete/hide a project if its status is exactly `open`, `draft`, or `scheduled`.
  - *Reason*: Preventing clients from deleting projects that have already been accepted or are `progress`/`done` preserves database integrity and prevents orphaned task/proposal states.

- **Rule: Proposal/Bid Price Privacy**
  - *Logic*: Only the client owning the project and the specific architect submitting the bid are allowed to view the bid pricing and detail notes.
  - *Reason*: Prevents competing architects from seeing other bids.

- **Rule: Route Match for Profile Uploads**
  - *Logic*: Use `Route::match(['post', 'patch'])` instead of strict patch routes when forms submit multipart data with standard Laravel spoofing to avoid route method exceptions.
  - *Reason*: Solves standard Laravel form upload request redirection bugs.

- **Rule: Published Projects Scope**
  - *Logic*: Architect search, landing pages, and dashboard tenders must strictly filter projects using `Proyek::published()` (meaning status is `'open'` and `scheduled_at` is null or in the past).
  - *Reason*: Prevents drafts and scheduled projects from leaking to candidate architects.

---

## 5. Architecture Memory

```
Architecture Decision: Single Gate Dashboard Routing
Component: Web Routes & Dashboard Controller
Responsibility: Directing authenticated users to their specific interface according to their role.
Dependency: auth & account.verified middleware.
Communication Flow:
- User accesses /dashboard -> Middleware validates -> Controller parses role (admin / client / arsitek) -> Returns unified dashboard.blade.php populated with corresponding query data.
Reason: Prevents developers from writing separate dashboard controllers or routes, concentrating layout choices in one Blade template with clean conditional logic.
```

---

## 6. Coding Standards Memory

```
Language: PHP 8.5+
Framework: Laravel 13

Naming Convention:
- Controllers: StudlyCase (e.g. ProfilArsitekController)
- Views: kebab-case (e.g. show.blade.php)
- Routes: camelCase/kebab-case named dot notation (e.g. arsitek.profile.edit)

Function Structure:
- Small, focused controller methods.
- Validation of input inside controllers or Request classes.

Error Handling:
- Graceful redirects with ->with('error', 'Message') to notify users via UI banners.

Logging:
- Use standard Laravel Log facade for debug/errors in file uploads.

Security Practice:
- Always enforce role-based gates. Never trust the query parameter for model updates (e.g., check $user->id === $proyek->client_id before delete).

Performance Rule:
- Eager load relationships (e.g., with(['arsitekTerpilih', 'tasks'])) to prevent N+1 query loops.
```

---

## 7. Problem Solving History

```
Problem ID: ERR-001
Issue: MethodNotAllowedHttpException on architect profile update.
Root Cause: The form used POST method with PATCH spoofing but route was strictly POST.
Investigation: The controller expected patch but multipart/form-data upload headers sometimes interfered.
Solution: Route changed to Route::match(['post', 'patch'], '/arsitek/profile/edit', ...).
Prevention: Always use match for complex forms involving file uploads and PATCH spoofing.

Problem ID: ERR-002
Issue: Blade ParseError: syntax error, unexpected end of file, expecting "elseif" or "else" or "endif".
Root Cause: An outer `@if($isClientOwner)` in show.blade.php lacked its closing `@endif`, causing compile failure.
Investigation: Looked at nested `@if` blocks near line 160-180.
Solution: Added `@endif` at line 173 to isolate the status check from the open-status deletion check.
Prevention: Format templates and carefully trace nesting levels when adding conditional items.

Problem ID: ERR-003
Issue: Leakage of `@block('content') @endblock` in portofolio index view.
Root Cause: Leftover mockup templates containing non-blade block directives.
Solution: Replaced with `@extends('layouts.app')` and `@section('content')`.
Prevention: Avoid mixing different templating syntax or unparsed tags in Blade files.
```

---

## 8. Failed Attempt Memory

```
Attempt: Using Filament Admin Package for moderation
Goal: Provide an admin portal for verification and page updates.
Implementation: Setup Filament resource panels.
Failure Reason: Added overhead and clashed visually with the dark custom Stone/Amber Tailwind styling.
Lesson Learned: Custom vanilla Blade views provide tighter design control and simpler route integration.
```

---

## 9. User Preference Memory

```
Communication Style: Concise, action-oriented.
Technical Depth: High. Direct code snippets and diffs.
Preferred Explanation: Straightforward Indonesian KBBI vocabulary for application elements.
Coding Preference: Clean Tailwind templates, vanilla CSS, and standard Laravel structure.
Decision Preference: Consolidate views and pages instead of adding new ones.
```

---

## 10. Workflow Memory

```
Before Coding:
1. Parse the requirement.
2. Read c:\laragon\www\PBL Arsitek\PBL_WebArsitek\AGENTS.md.
3. Trace existing routes and Blade view structures.

During Coding:
1. Maintain Stone/Amber premium theme styling.
2. Ensure mobile responsiveness.
3. Validate authorization gates for all actions.

After Coding:
1. Run local tests / verify syntax.
2. Update AGENTS.md with any new decisions or resolved bugs.
```

---

## 11. Knowledge Update Rules

The AI Agent **MUST** update `AGENTS.md` whenever:
1. A new core architectural decision is made (e.g. changing database queries, routing flows).
2. A new bug is resolved (add to **Problem Solving History**).
3. A coding standard or logic rule changes.

---

## 12. Decision Making Framework

Prioritize decisions in this order:
1. **Security & Authorization** (no unauthorized reads or writes).
2. **Platform Correctness** (no syntax or runtime errors).
3. **Consolidation / Simplicity** (reduce file counts and duplicate routes).
4. **Visual Aesthetics** (adhere to the Stone/Amber theme).

Every decision must trace:
- Problem & Constraints
- Feasible Solutions
- Trade-offs
- Selected Path
- Long-term codebase impact

---

## 13. Memory Retrieval Rules

Before taking any task:
1. Retrieve `AGENTS.md` contents.
2. Cross-reference files to edit with **Problem Solving History** and **Decision Memory**.
3. Align code changes with **Coding Standards Memory**.

---

## 14. Continuous Improvement

```
What worked: Removing Filament to consolidate features on a single custom dashboard; matching POST/PATCH routes.
What failed: Leaving unclosed Blade directives during quick visual additions.
What should improve: Always verify code compilation.
New knowledge: Keeping architect lists, profiles, and tender listing under central routes minimizes routing conflicts.
```
