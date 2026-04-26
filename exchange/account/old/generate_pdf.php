<?php
// Enable error reporting for debugging.
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// Include your local files
include('connection.php');
include('functions.php');

// Include the manually downloaded libraries in the correct order.
require_once(__DIR__ . '/TCPDF-main/tcpdf.php');
require_once(__DIR__ . '/php-barcode-generator-main/src/BarcodeBar.php');
require_once(__DIR__ . '/php-barcode-generator-main/src/BarcodeGenerator.php');
require_once(__DIR__ . '/php-barcode-generator-main/src/Barcode.php');
require_once(__DIR__ . '/php-barcode-generator-main/src/BarcodeGeneratorPNG.php');
require_once(__DIR__ . '/php-barcode-generator-main/src/Types/TypeInterface.php');
require_once(__DIR__ . '/php-barcode-generator-main/src/Types/TypeCode128.php');
require_once(__DIR__ . '/php-barcode-generator-main/src/Renderers/RendererInterface.php');
require_once(__DIR__ . '/php-barcode-generator-main/src/Renderers/PngRenderer.php');

// Use the necessary classes with their namespaces.
use Picqer\Barcode\BarcodeGeneratorPNG;

// 1. Get the transaction ID from the URL.
$tranx_id = $_GET['id'];
if (empty($tranx_id)) {
    die('Transaction ID is required.');
}

// 2. Fetch the transaction details from the database.
$query = "SELECT * FROM history WHERE tranx_id = '" . mysqli_real_escape_string($conn, $tranx_id) . "'";
$result = mysqli_query($conn, $query);
$transaction = mysqli_fetch_assoc($result);

if (!$transaction) {
    die('Transaction not found.');
}

function format_wallet_address($address, $start_length = 5, $end_length = 5) {
    // Check if the address is long enough to be shortened
    if (strlen($address) <= $start_length + $end_length) {
        return $address;
    }

    // Get the first part of the string
    $first_part = substr($address, 0, $start_length);

    // Get the last part of the string
    $last_part = substr($address, -$end_length);

    // Combine them with "..." in the middle
    return $first_part . '......' . $last_part;
}

// Example usage with a dummy wallet address
$sender_address = format_wallet_address($transaction['sender_address'], 4, 3);
$receiver_address =  format_wallet_address($transaction['receiver_address'], 4, 3);
$tranx_hash = format_wallet_address($transaction['tranx_hash'], 5, 5);

$dummy_data = [
    'date_time'      => $transaction['date_of_hist'],
    'asset'          => $transaction['coin'],
    'crypto_amt'     => $transaction['amount'],
    'fiat_amt_live'  => '$0.00',
    'exchange_rate'  => $transaction['exchange_rate'],
    'txn_fee'        => $transaction['fees'] ?? '0.00551001',
    'sender_amt'     => $transaction['amount'],
    'receiver_amt'   => $transaction['amount']-$transaction['fees'],
    'sender_addr'    => $sender_address,
    'receiver_addr'  => $receiver_address,
    'txn_hash'       => $tranx_hash,
    
];

// Combine real transaction data with dummy data, prioritizing real data
$display_data = array_merge($dummy_data, $transaction);

// 3. Generate the barcode image.
$barcode_text = $display_data['tranx_id'];
$barcode_path = 'temp_barcode.png';

$generator = new BarcodeGeneratorPNG();
file_put_contents(
    $barcode_path,
    $generator->getBarcode($barcode_text, $generator::TYPE_CODE_128)
);

// 4. Create a new PDF document.
// Correct way to set the page format directly in the constructor.
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, [80, 200], true, 'UTF-8', false);

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetTitle('Transaction Receipt');

$pdf->SetPrintHeader(false);
$pdf->SetPrintFooter(false);

$pdf->SetMargins(5, 5, 5, true);
$pdf->SetAutoPageBreak(TRUE, 5);

$pdf->SetFont('helvetica', '', 10);
$pdf->SetTextColor(0, 0, 0);

$pdf->AddPage();

// 5. Add content to the PDF using HTML, styled to match the Xapo receipt.
$html = '
<style>
    body {
        font-family: Arial, sans-serif;
        font-size: 10pt;
        color: #000000;
    }
    .main-container {
        width: 100%;
        background-color: #FFFFFF;
        box-sizing: border-box;
    }
    .top-bar {
        background-color: #F8F8F8;
        padding: 5px 5px;
        font-size: 10pt;
        border-bottom: 1px solid #EEEEEE;
        text-align: left;
    }
    .top-bar strong {
        font-weight: bold;
        color: #555555;
    }
    .content-area {
        padding: 10px 5px;
    }
    /* 💡 NEW: Container for title and barcode for positioning */
    .header-layout {
        position: relative; /* Essential for absolute positioning of child elements */
        height: 60px; /* Give it enough height for the barcode */
        margin-bottom: 10px;
    }
    .title {
        font-size: 12pt;
        font-weight: normal;
        color: #000000;
        margin: 0; /* Remove default margins to prevent extra space */
        padding-top: 10px; /* Adjust as needed for vertical alignment */
        text-align: center;
    }
    .sub-title {
        font-size: 10pt;
        font-weight: bold;
        color: #000000;
        margin-bottom: 10px;
        text-align: center;
    }
    .details-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 15px;
    }
    .details-table td {
        padding: 4px 0;
        vertical-align: top;
        font-size: 9pt;
        line-height: 1.4;
    }
    .details-table td:first-child {
        width: 35%;
        color: #555555;
    }
    .details-table td:last-child {
        width: 65%;
        text-align: right;
        font-weight: bold;
        color: #000000;
    }
    .amount-negative {
        color: #E74C3C;
    }
    .amount-positive {
        color: #27AE60;
    }
    .footer-text {
        text-align: center;
        font-size: 8pt;
        color: #999999;
        margin-top: 15px;
        padding-top: 10px;
        border-top: 1px solid #EEEEEE;
    }
    .page-info {
        text-align: center;
        font-size: 8pt;
        color: #AAAAAA;
        margin-top: 5px;
    }
    /* 💡 NEW: Absolute positioning for barcode */
    .barcode-img {
        position: absolute;
        top: 0; /* Align to the top of the .header-layout container */
        right: 0; /* Align to the right of the .header-layout container */
        width: 60px;
        height: 60px;
    }
    .footer-text {
        text-align: center;
        font-size: 8pt;
        color: #999999;
        margin-top: 15px;
        padding: 10px 5px; /* Added padding: 10px top/bottom, 5px left/right */
        border-top: 1px solid #EEEEEE;
    }
    .barcode-container {
        text-align: center;
        margin: 20px 0; /* Add margin for spacing above and below the barcode */
    }

</style>

<div class="main-container">
    <div class="top-bar">
        <strong>Sterling Union GroupWALLET</strong>
    </div>
    <div class="content-area">
        <div class="header-layout">
            <h2 class="title">Sterling Union GroupWALLET</h2>
            <div class="barcode-container">
                <img src="' . $barcode_path . '" alt="Transaction Barcode" style="width: 50px; height: 50px;">
            </div>
        </div>

        <h3 class="sub-title">Transaction Receipt</h3>

        <table class="details-table">
            <tr>
                <td>Transaction ID:</td>
                <td>' . htmlspecialchars($display_data['tranx_id']) . '</td>
            </tr>
            <tr>
                <td>Date & Time:</td>
                <td>' . htmlspecialchars($display_data['date_time']) . '</td>
            </tr>
            <tr>
                <td>Type:</td>
                <td>' . htmlspecialchars(ucfirst($display_data['type'] ?? 'Receive')) . '</td>
            </tr>
            <tr>
                <td>Asset:</td>
                <td>' . htmlspecialchars($display_data['asset']) . '</td>
            </tr>
            <tr>
                <td>Crypto Amt:</td>
                <td>' . number_format((float)$display_data['crypto_amt'], 7) . '</td>
            </tr>
            <tr>
                <td>Fiat Amt (Live):</td>
                <td>' . htmlspecialchars($display_data['fiat_amt_live']) . '</td>
            </tr>
            <tr>
                <td>Exchange Rate:</td>
                <td>' . htmlspecialchars($display_data['exchange_rate']) . '</td>
            </tr>
            <tr>
                <td>Txn Fee:</td>
                <td>' . number_format((float)$display_data['txn_fee'], 8) . '</td>
            </tr>
            <tr>
                <td>Sender\'s Amt:</td>
                <td class="amount-negative">' . htmlspecialchars($display_data['sender_amt']) . '</td>
            </tr>
            <tr>
                <td>Receiver\'s Amt:</td>
                <td class="amount-positive">' . htmlspecialchars($display_data['receiver_amt']) . '</td>
            </tr>
            <tr>
                <td>Sender\'s Addr:</td>
                <td>' . htmlspecialchars($display_data['sender_addr']) . '</td>
            </tr>
            <tr>
                <td>Receiver\'s Addr:</td>
                <td>' . htmlspecialchars($display_data['receiver_addr']) . '</td>
            </tr>
            <tr>
                <td>Txn Hash:</td>
                <td>' . htmlspecialchars($display_data['txn_hash']) . '</td>
            </tr>
        </table>
		<br>
        <br>
        <br>
        
        <table class="footer-text-container" style="width:100%; border-collapse:collapse; margin-top:15px;">
            <tr>
                <td style="text-align: center; font-size: 8pt; color: #999999; padding: 10px 5px;">
                    Powered by Prime Jarvis
                </td>
            </tr>
        </table>
    </div>
    <div class="page-info">
        Page 1/1
    </div>
</div>
';

// ... (rest of your PHP code) ...
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->Output('transaction_receipt_' . $tranx_id . '.pdf', 'I');
unlink($barcode_path);
?>