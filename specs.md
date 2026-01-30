## 🏗️ Technical Specification: Project & Task Management (OKR Edition)

### 1. Core Tech Stack & Infrastructure

* **Framework:** Laravel 12.x
* **Admin Panel:** Filament PHP v5.x
* **Database:** MySQL / PostgreSQL
* **Permissions:** Spatie Laravel Permission
* **Environment:** **Strictly Dockerized.** All CLI interactions must occur inside the `ngapain-app` container.

### 2. Docker Execution Protocol (Mandatory)

The application is hosted within a Dockerized environment. **No commands should be executed on the host machine.** All interactions with the Laravel framework must be prefixed as follows:

* **Container Name:** `ngapain-app`
* **Working Directory:** `/var/www/html`
* **Execution Template:** `docker exec -it ngapain-app php artisan [command]`

| Action | Command Pattern |
| --- | --- |
| **Migrations** | `docker exec -it ngapain-app php artisan migrate` |
| **Resource Creation** | `docker exec -it ngapain-app php artisan make:filament-resource {Name}` |
| **System Clear** | `docker exec -it ngapain-app php artisan optimize:clear` |
| **Data Seeding** | `docker exec -it ngapain-app php artisan db:seed` |

---

### 3. Database Schema Updates

#### **Tasks Table (Extended)**

* `id` (UUID Primary Key)
* `project_id` (Foreign Key -> projects.id)
* `assigned_user_id` (Foreign Key -> users.id, nullable)
* **`is_self_initiated`** (boolean, default: false) — *Flag for staff-originated tasks.*
* `status` (enum: todo, doing, done)
* `effort_score` (integer, default: 0) — *Range 1-10.*
* `completed_at` (timestamp, nullable)

#### **Daily_Accomplishments Table (The Pulse)**

* `id` (UUID Primary Key)
* `user_id` (Foreign Key -> users.id)
* `date` (date) — *Unique constraint on user_id + date.*
* `content` (text) — *The "Daily Pulse" journal entry.*
* `tasks_completed_snapshot` (json) — *Automatic log of tasks finished that day.*

---

### 4. Functional UX Workflows

#### **A. Multi-Way Assignment (Top-Down & Bottom-Up)**

* **Top-Down:** Managers assign tasks to staff via `TaskResource`.
* **Bottom-Up:** Staff can create a task for themselves. In the Filament Form, if a non-manager creates a task:
* `assigned_user_id` defaults to `auth()->id()`.
* `is_self_initiated` is set to `true`.
* `effort_score` is hidden/disabled for the creator to prevent self-inflation.



#### **B. The "Staff Start" (To-Do List)**

* A custom Dashboard Widget filters tasks where `assigned_user_id == auth()->id()` and `status != 'done'`.
* Tasks are sorted by urgency and project priority.

#### **C. The "Daily Pulse" (Accomplishment)**

* **Daily Mandate:** Every user (Staff, Leader, Supervisor) must submit a log by the end of the day.
* **Automated Summary:** The form should automatically list all tasks the user moved to `done` today to assist their writing.
* **Data Integrity:** A `TaskObserver` ensures that when a status hits 'done', the `completed_at` timestamp is locked.

---

### 5. Multi-Company & Scalability

* **HasCompany Trait:** All models (`Project`, `Task`, `Accomplishment`) must use a `HasCompany` trait to support multi-tenant accounting.
* **Scoping:** Filament resources must be scoped to the active tenant/company context.
