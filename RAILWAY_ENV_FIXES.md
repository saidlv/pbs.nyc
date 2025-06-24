# Railway Environment Variables Fix

## 🔧 Required Railway Environment Variable Updates

Based on the analysis, you need to update these environment variables in Railway:

### 1. APP_URL (Critical)
**Current:** `APP_URL="pbsnyc-production.up.railway.app"`
**Should be:** `APP_URL="https://pbsnyc-production.up.railway.app"`
**Issue:** Missing https:// protocol

### 2. SESSION_SECURE_COOKIE (Critical)
**Current:** `SESSION_SECURE_COOKIE="false"`
**Should be:** `SESSION_SECURE_COOKIE="true"`
**Issue:** Railway uses HTTPS, so secure cookies are required

### 3. SESSION_SAME_SITE (Critical)
**Current:** `SESSION_SAME_SITE="none"`
**Should be:** `SESSION_SAME_SITE="lax"`
**Issue:** SameSite=none requires Secure=true, but 'lax' works better for Railway

### 4. SESSION_DOMAIN (Optional but recommended)
**Current:** `SESSION_DOMAIN=""`
**Should be:** `SESSION_DOMAIN=".up.railway.app"`
**Issue:** More specific domain helps with cookie handling

### 5. SANCTUM_STATEFUL_DOMAINS (If using Sanctum)
**Current:** `SANCTUM_STATEFUL_DOMAINS="localhost:3000"`
**Should be:** `SANCTUM_STATEFUL_DOMAINS="pbsnyc-production.up.railway.app"`
**Issue:** Domain mismatch

## 🚀 Quick Fix Commands for Railway

Update these in your Railway dashboard:

```bash
APP_URL=https://pbsnyc-production.up.railway.app
SESSION_SECURE_COOKIE=true
SESSION_SAME_SITE=lax
SESSION_DOMAIN=.up.railway.app
SANCTUM_STATEFUL_DOMAINS=pbsnyc-production.up.railway.app
```

## 🔍 Testing Steps

1. Update the environment variables in Railway
2. Redeploy the application
3. Visit `/railway-debug` to check configuration
4. Test login flow
5. Test password reset
6. Test registration

## 📋 Root Cause Analysis

The issues were caused by:

1. **CSRF Token Failures (419 errors)**: Caused by incorrect session configuration
2. **Login Loops**: Session cookies not persisting due to insecure cookie settings
3. **SameSite Policy**: Browser blocked cookies due to SameSite=none without Secure=true

## 🎯 Expected Results

After these changes:
- ✅ Login should work and maintain session
- ✅ Logout should work properly  
- ✅ Password reset should work without 419 errors
- ✅ Registration should work without 419 errors
- ✅ CSRF protection should work correctly

## 🗑️ Cleanup

After confirming everything works, remove the debug route:
- Delete `/railway-debug` route from `routes/web.php`

---
*Environment variable fixes for Railway deployment*
*Date: December 2024*
