# Copilot Instructions: Mobile-First Admin Panel (Slim 4 + Vue 3 - Single Domain)

## 🎯 Project Vision
- **Objective:** Rebuild the Store Management Admin Panel from [pdutie94/quanlycuahang](https://github.com/pdutie94/quanlycuahang).
- **Environment:** Laragon (Single Domain, e.g., `http://quanly.test`).
- **Architecture:** 
    - **Backend:** PHP Slim 4 (API-only, serving from `/api/v1`).
    - **Frontend:** Vue 3 Vite (Built as static assets into Backend's `public/` folder).
    - **Routing Strategy:** Slim handles `/api`, while all other requests fallback to Vue's `index.html` (SPA Mode).

## 📦 Core Modules Logic (Business Requirements)
1.  **Auth:** Stateless JWT. Login/Logout, session persistence via Pinia.
2.  **Dashboard:** KPI Cards (Revenue, Profit, Collected, Debt). Quick actions & low-stock alerts.
3.  **POS:** Mobile-optimized cart, customer selection, quick checkout.
4.  **Orders:** Status management, Debt recording, Soft delete, History logs.
5.  **Products:** CRUD, Categories, Units, Stock tracking, Inventory logs (In/Out).
6.  **Customers:** Profile, purchase history, debt tracking, debt payment records.
7.  **Purchases/Suppliers:** Supplier CRUD, Purchase orders, Inbound logs.
8.  **Metadata:** Category & Unit management.
9.  **Reports:** Periodical Revenue/Profit stats. Implementation: Cache via APCu/File.
10. **Users:** System account management (Admin/Staff).
11. **System Utilities:** 
    - **Migration:** Version-based SQL upgrades (`sql/1.0.*.sql`).
    - **Backup:** Database export/backup logic.
    - **Health:** `health.php` to check DB, Disk, and Migration status.

## 🎨 Design System: Modern Flat UI (Tailwind Only)
- **Style:** 100% Flat Design. **STRICTLY NO LARGE SHADOWS**.
- **Visuals:** Use `border-slate-100` for separation instead of shadows.
- **Colors:** App-bg: `bg-slate-50`, Surface: `bg-white`, Text: `text-slate-800`.
- **Navigation:** **Fixed Bottom Navigation Bar** (Dashboard, Inventory, POS, Wallet).
- **Interactions:** **Bottom Sheets** for Add/Edit forms. **Slide-over** for details.
- **Icons:** `lucide-vue-next` (Stroke: 1.5px, Size: 24px).

## 🐘 Backend Rules (Slim 4 API)
- **Directory:** `/backend`. Entry point: `public/index.php`.
- **Pattern:** Action-Domain-Responder (ADR). Use **Eloquent ORM**.
- **API Prefix:** All routes must be under `/api/v1/`.
- **PHP Standards:** PHP 8.x strict typing, Constructor promotion, Enums for Statuses.
- **Single Domain Helper:** Configure Middleware to serve `index.html` for non-API routes.

## 📱 Frontend Rules (Vue 3)
- **Directory:** `/frontend`. 
- **Build Config:** `build.outDir` set to `../backend/public`.
- **State:** Pinia stores separated by module (e.g., `useAuthStore`).
- **UX:** `inputmode="decimal"` for numbers. Skeleton screens for loading states.
- **Safe Area:** Use `pb-safe` for bottom navigation on mobile devices.

## 🛠 Coding Standards
- **Conciseness:** No redundant comments. Self-documenting code.
- **Security:** Strict server-side validation. JWT stored in Secure HTTPOnly Cookie or Auth Header.
- **Versioning:** Use `.sql` migration files for any DB schema changes.