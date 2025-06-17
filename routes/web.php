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
