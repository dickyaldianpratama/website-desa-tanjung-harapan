# Laravel on Vercel Customizations

The following rules apply when deploying this Laravel application to Vercel:

1. **Vercel Read-Only Filesystem Bypass**: Vercel's serverless environment has a read-only filesystem (except for `/tmp`). Laravel will crash with Error 500 (`Target class [view] does not exist` or `PackageManifest directory must be writable`) if it tries to write cache files to `bootstrap/cache`.
   - **Solution implemented**: In `api/index.php`, we explicitly set environment variables to redirect ALL Laravel cache paths to `/tmp` (e.g., `APP_SERVICES_CACHE`, `APP_PACKAGES_CACHE`, `VIEW_COMPILED_PATH`). Never remove this logic as long as the app is hosted on Vercel.

2. **Static Asset Routing (Images, CSS, JS)**: Vercel-PHP sometimes intercepts static file requests if not configured properly, causing 404s for images like `public/images/...`.
   - **Solution implemented**: `vercel.json` uses `routes` with regex matching `/(build|images|assets)/(.*)` to rewrite to `/public/$1/$2`, allowing Vercel's CDN to serve them directly.
   - **Important View Rule**: NEVER use `file_exists(public_path('...'))` in Blade views. Because static files are hoisted to Vercel's CDN Edge network, they don't physically exist in the PHP Lambda container's filesystem. `file_exists()` will always return `false` on Vercel. Just render the `asset()` URL directly.

3. **Vercel Region Optimization**:
   - The Supabase database for this project is hosted in `aws-1-ap-south-1` (Mumbai).
   - By default, Vercel deploys Serverless Functions to `iad1` (US East). This causes extreme latency ("nge-lag") for Asian users.
   - **Solution implemented**: `vercel.json` has `"regions": ["sin1"]` (Singapore) to ensure the serverless function is geographically close to both the database in India and the users in Indonesia, drastically reducing latency.
