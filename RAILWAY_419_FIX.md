# Fix 419 Page Expired Error on Railway

## Problem
Login works locally but shows "419 Page Expired" error on Railway deployment.

## Root Cause
The 419 error is a **CSRF token mismatch** caused by session cookies not being properly set/read in the production HTTPS environment.

## Solution

### 1. Set These Environment Variables in Railway Dashboard

Go to Railway Dashboard → Your Project → Variables:

```
SESSION_SECURE_COOKIE=true
SESSION_SAME_SITE=lax
SESSION_DOMAIN=null
```

**Important:** Make sure these are set as environment variables in Railway, not in your `.env` file.

### 2. Clear Configuration Cache on Railway

After setting the environment variables, Railway needs to clear the Laravel configuration cache. Add this to your deployment process or run manually:

```bash
php artisan config:clear
php artisan config:cache
```

### 3. Test the Configuration

After deployment, visit your Railway URL + `/debug-csrf` to verify:
- CSRF token is being generated
- Session is started
- `request_secure` is `true` (confirms HTTPS)
- `session_secure` matches your environment (should be `true` for production)

### 4. Key Points

**Why this happens:**
- Railway uses HTTPS automatically
- Your session config was set for HTTP (`secure = false`)
- HTTPS requires `SESSION_SECURE_COOKIE=true` to set cookies properly
- Without proper session cookies, CSRF tokens can't be validated

**The fix:**
- `SESSION_SECURE_COOKIE=true` - Ensures cookies work on HTTPS
- `SESSION_SAME_SITE=lax` - Allows proper cookie behavior
- Updated config automatically detects production environment

### 5. Verification Steps

1. **Check environment variables are set in Railway**
2. **Deploy and test** `/debug-csrf` endpoint
3. **Clear browser cookies** for your Railway domain
4. **Try login again**

### 6. If Still Not Working

Try these additional environment variables in Railway:

```
APP_ENV=production
APP_DEBUG=false
SESSION_DRIVER=file
SESSION_LIFETIME=120
```

### 7. Remove Debug Route

Once working, remove the `/debug-csrf` route from `routes/web.php` for security.

## Files Changed
- ✅ `config/session.php` - Now automatically handles production vs local
- ✅ `routes/web.php` - Added debug route (remove after testing)

## Railway Deployment Command
```bash
git add .
git commit -m "Fix 419 CSRF error for Railway deployment"
git push origin main
```
