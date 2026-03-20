# QLCH

Monorepo khoi tao cho admin panel mobile-first theo kien truc Slim 4 API + Vue 3 frontend.

## Cau truc

- `api`: Slim 4 API theo huong ADR, san sang mo rong Eloquent, JWT, migration theo file SQL.
- `frontend`: Vue 3 + Vite + Tailwind CSS cho giao dien admin mobile-first.
- `sql`: cac file migration version-based theo dinh dang `x.y.z.sql`.

## Bat dau

### API

```bash
cd api
composer install
copy .env.example .env
php -S localhost:8080 -t public
```

### Frontend

```bash
cd frontend
npm install
npm run dev
```

### Laragon 1 domain (tu dong)

Muc tieu: vao `http://qlch2.test/` hien thi login Vue, API van o `http://qlch2.test/api/v1/*`.

Khong can doi `DocumentRoot` hoac tao them domain.

1. Build frontend:

```bash
cd frontend
npm run build
```

Vite da duoc cau hinh build thang vao `api/public`.

2. Truy cap ngay:
- `http://qlch2.test/` -> Vue SPA (login/dashboard)
- `http://qlch2.test/api/v1/modules` -> Slim API

Root gateway (`index.php`) + root rewrite (`.htaccess`) se tu dong:
- route `/api/*`, `/health` vao Slim
- tra file static da build
- fallback SPA route ve `index.html`

### Deploy 1 lenh (1 domain)

Muc tieu: deploy nhanh len hosting voi 1 domain, khong can upload source Vue.

Chay lenh:

```bash
bash scripts/deploy-package.sh
```

Lenh nay se:
- build frontend production
- cai Composer production cho `api` (neu co Composer)
- tao goi deploy tai `.release/`
- tao file `release.zip` (neu may co `zip`)

Khi upload hosting, chi can upload noi dung trong `.release/` (hoac giai nen `release.zip`) vao document root cua domain.

## Endpoint khoi tao

- `GET /health`: kiem tra DB, disk, migration status.
- `GET /api/v1/modules`: danh sach module khoi tao.
- `GET /api/v1/dashboard/summary`: du lieu dashboard demo.

## Huong trien khai tiep

1. Bo sung middleware JWT va login/logout.
2. Ket noi Eloquent model cho products, customers, orders.
3. Chuyen du lieu mock frontend sang call API thuc.
4. Them MigrationService runner va backup utility.
