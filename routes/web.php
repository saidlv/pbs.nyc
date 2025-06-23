<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Simple test route to verify routes are loading
Route::get('/test', function () {
    return 'Routes are working!';
});

Route::get('/', function () {
    return view('frontend.index');
})->name('home');

Route::get('/about-us', function () {
    return view('frontend.aboutus');
})->name('aboutus');

Route::get('/member-portal', function () {
    return view('frontend.memberportal');
})->name('memberportal');

Route::get('/billing-agreement', function () {
    return view('frontend.billingagreement');
})->name('billingagreement');

Route::get('/termsofservices', function () {
    return view('frontend.tos');
})->name('tos');

Route::get('/calender', function () {
    return view('frontend.frontendcalendly');
})->name('frontendcalendly');

Route::get('/contact-us', function () {
    return view('frontend.contact');
})->name('contactus');

Route::get('/property-add', function () {
    return view('frontend.addproperty');
})->name('addpropertyrequest');

Route::get('/alerts', function () {
    return view('frontend.alerts');
})->name('alerts');

Route::get('/filing-representation', function () {
    return view('frontend.filingrepresentation');
})->name('filingrepresentation');

Route::get('/general-contracting', function () {
    return view('frontend.generalcontracting');
})->name('generalcontracting');

Route::get('/membership', function () {
    return view('frontend.membership');
})->name('membership');

//Route::get('/construction-management', function () {
//    return view('frontend.constructionmanagement');
//})->name('constructionmanagement');

Route::get('/super-intendent', function () {
    return view('frontend.superintendent');
})->name('superintendent');

Route::get('/network', function () {
    return view('frontend.network');
})->name('network');

Route::get('/maintenance', function () {
    return view('frontend.maintenance');
})->name('maintenance');

Route::get('/violation-correction', function () {
    return view('frontend.violationcorrection');
})->name('violationcorrection');

Route::get('/nyc-dob-code', function () {
    return view('frontend.nycdobcode');
})->name('nycdobcode');

Route::get('/nyc-fdny-code', function () {
    return view('frontend.nyfdnycode');
})->name('nycfdnycode');

Route::get('/dob-service-updates', function () {
    return view('frontend.nycdepcode');
})->name('nycdepcode');

Route::get('/search', function () {
    return view('frontend.partials.propertysearch');
});

Route::get('/blog/article/{slug}', 'FrontendController@showArticle')->name('frontend.blog.article.show');
Route::get('/blog', 'FrontendController@showBlog')->name('frontend.blog.show');


Route::post('/subscribe', 'FrontendController@subscribeNewsLetter')->name('subscribe')->middleware('throttle:10,1');
Route::post('/sent-quick-email-to-us', 'FrontendController@sentQuickContactEmail')->name('contactwithquickemail')->middleware('throttle:10,1');
Route::post('/sent-email-to-us', 'FrontendController@sentContactEmail')->name('contactwithemail')->middleware('throttle:10,1');
Route::post('/sent-property-add-request', 'FrontendController@sentPropertyAddRequestEmail')->name('propertywithemail')->middleware('throttle:10,1');

Route::post('/api/search-property', 'PropertySearchController@search')->name('property.search.ac');
Route::post('/api/search-property-by-bin', 'PropertySearchController@searchByBin')->name('property.searchbybin.ac');
Route::post('/api/register-for-alerts', 'FreeAlertSystemController@register')->name('property.register')->middleware('throttle:10,1');

Route::post('/api/add-property-to-user', 'FrontendController@addPropertyToUser')->name('add.property.to.user')->middleware('auth');
Route::post('/api/delete-property-from-user', 'FrontendController@deletePropertyFromUser')->name('delete.property.from.user')->middleware('auth');
Route::post('/api/delete-single-property-from-user', 'FrontendController@deleteSinglePropertyFromUser')->name('delete.single.property.from.user')->middleware('auth');
Route::get('/api/get-properties-of-user', 'FrontendController@getPropertyList')->name('get.property.list.of.user')->middleware('auth');

// Test email route (Remove after testing)
Route::get('/test-email', function () {
    try {
        Mail::raw('Test email from PBS.NYC', function($message) {
            $message->to('your-email@example.com')
                   ->subject('Test Email');
        });
        return 'Email sent successfully!';
    } catch (\Exception $e) {
        return 'Error sending email: ' . $e->getMessage();
    }
});

// Temporary debug route for Railway deployment
Route::get('/debug-db', function () {
    echo "<h2>Database Connection Debug</h2>";
    echo "<pre>";
    echo "DB_CONNECTION: " . (env('DB_CONNECTION') ?: 'NOT SET') . "\n";
    echo "DB_HOST: " . (env('DB_HOST') ?: 'NOT SET') . "\n";
    echo "DB_PORT: " . (env('DB_PORT') ?: 'NOT SET') . "\n";
    echo "DB_DATABASE: " . (env('DB_DATABASE') ?: 'NOT SET') . "\n";
    echo "DB_USERNAME: " . (env('DB_USERNAME') ?: 'NOT SET') . "\n";
    echo "DATABASE_URL: " . (env('DATABASE_URL') ?: 'NOT SET') . "\n";
    
    try {
        $host = env('DB_HOST') ?: '127.0.0.1';
        $port = env('DB_PORT') ?: '5432';
        $database = env('DB_DATABASE') ?: 'forge';
        $username = env('DB_USERNAME') ?: 'forge';
        $password = env('DB_PASSWORD') ?: '';
        
        echo "\nAttempting connection to: $host:$port\n";
        
        $dsn = "pgsql:host=$host;port=$port;dbname=$database";
        $pdo = new PDO($dsn, $username, $password);
        echo "✅ Database connection successful!\n";
        
    } catch (PDOException $e) {
        echo "❌ Database connection failed: " . $e->getMessage() . "\n";
    }
    echo "</pre>";
});

// Temporary debug route for Railway CSRF/Session issues (Remove after fixing)
Route::get('/debug-csrf', function () {
    return response()->json([
        'csrf_token' => csrf_token(),
        'session_id' => session()->getId(),
        'app_env' => env('APP_ENV'),
        'app_url' => env('APP_URL'),
        'session_secure' => config('session.secure'),
        'session_domain' => config('session.domain'),
        'session_same_site' => config('session.same_site'),
        'request_secure' => request()->isSecure(),
        'request_host' => request()->getHost(),
        'request_scheme' => request()->getScheme(),
        'cookies_enabled' => !empty($_COOKIE),
        'session_started' => session()->isStarted(),
        'all_headers' => request()->headers->all(),
        'forwarded_proto' => request()->header('X-Forwarded-Proto'),
        'forwarded_host' => request()->header('X-Forwarded-Host'),
        'server_https' => $_SERVER['HTTPS'] ?? 'not set',
        'session_cookie_name' => config('session.cookie'),
        'cookies' => $_COOKIE,
    ]);
});

// Enhanced debug route with HTML output for better readability
Route::get('/debug-session', function () {
    echo "<h2>Railway Session & CSRF Debug</h2>";
    echo "<style>pre { background: #f5f5f5; padding: 10px; border-radius: 5px; }</style>";
    
    echo "<h3>🔒 CSRF & Session Status</h3>";
    echo "<pre>";
    echo "CSRF Token: " . csrf_token() . "\n";
    echo "Session ID: " . session()->getId() . "\n";
    echo "Session Started: " . (session()->isStarted() ? 'YES' : 'NO') . "\n";
    echo "</pre>";
    
    echo "<h3>🌐 Request Information</h3>";
    echo "<pre>";
    echo "Is Secure (HTTPS): " . (request()->isSecure() ? 'YES' : 'NO') . "\n";
    echo "Host: " . request()->getHost() . "\n";
    echo "Scheme: " . request()->getScheme() . "\n";
    echo "Full URL: " . request()->url() . "\n";
    echo "</pre>";
    
    echo "<h3>📋 Headers (Proxy Detection)</h3>";
    echo "<pre>";
    echo "X-Forwarded-Proto: " . (request()->header('X-Forwarded-Proto') ?: 'NOT SET') . "\n";
    echo "X-Forwarded-Host: " . (request()->header('X-Forwarded-Host') ?: 'NOT SET') . "\n";
    echo "X-Forwarded-Port: " . (request()->header('X-Forwarded-Port') ?: 'NOT SET') . "\n";
    echo "</pre>";
    
    echo "<h3>⚙️ Session Configuration</h3>";
    echo "<pre>";
    echo "Driver: " . config('session.driver') . "\n";
    echo "Secure Cookie: " . (config('session.secure') ? 'true' : 'false') . "\n";
    echo "Domain: " . (config('session.domain') ?: 'null') . "\n";
    echo "Same Site: " . config('session.same_site') . "\n";
    echo "Cookie Name: " . config('session.cookie') . "\n";
    echo "</pre>";
    
    echo "<h3>🍪 Current Cookies</h3>";
    echo "<pre>";
    if (!empty($_COOKIE)) {
        foreach ($_COOKIE as $name => $value) {
            echo "$name: " . substr($value, 0, 50) . (strlen($value) > 50 ? '...' : '') . "\n";
        }
    } else {
        echo "No cookies found\n";
    }
    echo "</pre>";
    
    echo "<h3>🔧 Troubleshooting</h3>";
    $issues = [];
    if (!request()->isSecure()) $issues[] = "❌ Request not detected as HTTPS";
    if (!config('session.secure') && env('APP_ENV') === 'production') $issues[] = "❌ SESSION_SECURE_COOKIE should be true for production";
    if (!session()->isStarted()) $issues[] = "❌ Session not started";
    if (empty($_COOKIE)) $issues[] = "❌ No cookies found - session cookies may not be set";
    
    if (empty($issues)) {
        echo "<pre style='background: #d4edda; color: #155724;'>✅ All checks passed!</pre>";
    } else {
        echo "<pre style='background: #f8d7da; color: #721c24;'>";
        foreach ($issues as $issue) {
            echo $issue . "\n";
        }
        echo "</pre>";
    }
    
    echo "<h3>🧪 Test Login Form</h3>";
    echo "<form method='POST' action='" . route('login') . "' style='background: #f8f9fa; padding: 20px; border-radius: 5px;'>";
    echo csrf_field();
    echo "<div style='margin-bottom: 10px;'>";
    echo "<label>Email:</label><br>";
    echo "<input type='email' name='email' value='test@example.com' style='width: 300px; padding: 5px;'>";
    echo "</div>";
    echo "<div style='margin-bottom: 10px;'>";
    echo "<label>Password:</label><br>";
    echo "<input type='password' name='password' value='password' style='width: 300px; padding: 5px;'>";
    echo "</div>";
    echo "<button type='submit' style='background: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 3px;'>Test Login</button>";
    echo "</form>";
});
