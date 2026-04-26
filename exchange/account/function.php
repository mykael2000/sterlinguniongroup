<?php 

session_start();
ob_start();


 ini_set('display_errors', 1);
 ini_set('display_startup_errors', 1);
 error_reporting(E_ALL);

if(empty($_SESSION['user_id'])){
    header("location: ../../login.php"); 
    exit();
}

$user_id = $_SESSION["user_id"];
// Ensure the database connection is valid.
if (!$conn) {
    die("Database connection failed.");
}

$stmt_user = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt_user->bind_param("i", $user_id); // "i" for integer type
$stmt_user->execute();
$result_user = $stmt_user->get_result();
$user = $result_user->fetch_assoc();

if($user['registration_fee_paid'] == 0){
    header("location: ../../payment.php"); 
    exit();
}

$user_email = $user["email"];

if (empty($user)) {
    // If not, redirect them to the login page as their session is invalid.
    session_destroy(); // Destroy the session for security.
    header("location: ../../login.php");
    exit();
}
// Fetch all articles from the database
$sql = "SELECT * FROM articles ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);

if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();
}


if(empty($user_email)){
    header("location: ../../login.php"); 
    exit();
}


$sql_fetch = "SELECT * FROM history WHERE client_id = '$user_id'";
$query_fetch = mysqli_query($conn, $sql_fetch);


$sql_with = "SELECT * FROM withdrawals WHERE user_id = '$user_id'";
$query_with = mysqli_query($conn, $sql_with);

function get_crypto_price_usd(string $coin_id): ?float {
    
    // Configuration
    $cache_dir = __DIR__ . '/cache/'; // Set your cache directory path
    $cache_file = $cache_dir . strtolower($coin_id) . '_price.cache';
    $cache_lifetime_seconds = 600; // 10 minutes cache freshness (optional)
    
    // Ensure the cache directory exists
    if (!is_dir($cache_dir)) {
        mkdir($cache_dir, 0755, true);
    }
    
    // --- 1. Attempt to Fetch Live Price ---
    $api_url = "https://api.coingecko.com/api/v3/simple/price?ids={$coin_id}&vs_currencies=usd";
    
    // Use file_get_contents for simplicity, but cURL is generally more reliable
    $response = @file_get_contents($api_url); 
    $data = $response ? json_decode($response, true) : null;

    $price = null;

    if (isset($data[$coin_id]['usd'])) {
        $live_price = (float)$data[$coin_id]['usd'];
        
        // --- 2. Live Fetch SUCCESS: Save to Cache and Return ---
        // Save the fresh price and the current timestamp to the cache file
        $cache_data = json_encode(['price' => $live_price, 'time' => time()]);
        file_put_contents($cache_file, $cache_data);
        
        return $live_price;
    } 
    
    // --- 3. Live Fetch FAILURE: Use Cache as Fallback ---
    
    // Check if a cache file exists
    if (file_exists($cache_file)) {
        $cached_content = file_get_contents($cache_file);
        $cached_data = json_decode($cached_content, true);

        if (isset($cached_data['price'])) {
            // Log that we are using the fallback price
            error_log("Price fetch failed for {$coin_id}. Using cached price from " . date('Y-m-d H:i:s', $cached_data['time']));
            
            // Return the last successful price
            return (float)$cached_data['price'];
        }
    }
    
    // --- 4. Total Failure ---
    error_log("Total failure for {$coin_id}: No live price and no available cache.");
    return null; // The only time null is returned is if no cache is available.
}

function get_trending_coins() {
    $url = "https://api.coingecko.com/api/v3/search/trending";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($ch);
    curl_close($ch);

    if ($response) {
        $data = json_decode($response, true);
        return $data['coins'] ?? [];
    }
    return [];
}

function get_top_gainers_losers($period = '24h') {
    $url = "https://api.coingecko.com/api/v3/coins/markets?vs_currency=usd&order=market_cap_desc&per_page=100&page=1&sparkline=false&price_change_percentage=1h%2C24h%2C7d";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($response, true);
    if (!$data) {
        return ['gainers' => [], 'losers' => []];
    }

    usort($data, function($a, $b) use ($period) {
        return $b["price_change_percentage_{$period}"] <=> $a["price_change_percentage_{$period}"];
    });

    $gainers = array_slice($data, 0, 10);
    $losers = array_slice($data, -10);

    return ['gainers' => $gainers, 'losers' => $losers];
}

// Note: CoinGecko doesn't have a specific "New Listings" endpoint. 
// We will have to simulate this by showing a curated list of popular new coins.
function get_new_listings() {
    return [
        ['symbol' => 'pepe', 'name' => 'Pepe', 'id' => 'pepe'],
        ['symbol' => 'w', 'name' => 'Wormhole', 'id' => 'wormhole'],
        ['symbol' => 'ena', 'name' => 'Ethena', 'id' => 'ethena'],
        ['symbol' => 'jup', 'name' => 'Jupiter', 'id' => 'jupiter'],
    ];
}

?>