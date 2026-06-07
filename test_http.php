<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

use App\Models\User;
use Illuminate\Support\Facades\Auth;

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$user = User::where('role', 'siswa')->first();
if (!$user) {
    die("No user found!");
}

// Log in the user in session
Auth::login($user);

// Create request with session containing authenticated user
$request = Illuminate\Http\Request::create('/siswa/dashboard', 'GET');
$request->setLaravelSession($app['session']->driver());
$request->session()->put(Auth::getName(), $user->getKey());

try {
    $response = $kernel->handle($request);
    echo "STATUS_CODE: " . $response->getStatusCode() . "\n";
    echo "CONTENT_LENGTH: " . strlen($response->getContent()) . "\n";
    echo "HEADERS: " . json_encode($response->headers->all()) . "\n";
    echo "CONTENT_START:\n" . substr($response->getContent(), 0, 1000) . "\n";
    if (strlen($response->getContent()) > 1000) {
        echo "... [TRUNCATED] ...\n";
        echo "CONTENT_END:\n" . substr($response->getContent(), -500) . "\n";
    }
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n" . $e->getTraceAsString() . "\n";
}
