<?php
include('connection.php');
include('functions.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <script type="text/javascript" src="https://js.stripe.com/v3/"></script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="DwT5c6Zsf4pO0gBQPkbrDWcBnfPNop8qMUS0bkwa">
    <title>Sterling Union Group| User Account Dashboard</title>
            <link rel="icon" href="../temp/images/ooboP2V2SRTZZheNE3L648tgmBq9fs2S15n2luZN.png" type="image/png" />
        <!-- Font Awesome 5 -->

        <link rel="stylesheet" href="css/all.min.css">
        <!-- Page CSS -->
        <link rel="stylesheet" href="css/fullcalendar.min.css">
        <!-- Purpose CSS -->
        <link rel="stylesheet" href="css/purpose.css" id="stylesheet">
        <link rel="stylesheet" href="css/animate.min.css">
        <link rel="stylesheet" type="text/css"
            href="https://cdn.datatables.net/v/bs4/dt-1.10.21/af-2.3.5/b-1.6.3/b-flash-1.6.3/b-html5-1.6.3/b-print-1.6.3/r-2.2.5/datatables.min.css" />
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css">
        <!-- Bootstrap Notify -->
        <script src="css/bootstrap-notify.min.js "></script>
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.1/dist/alpine.min.js" defer></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

        <link rel="stylesheet" href="../iziToast.min.css">
        <script src="../iziToast.min.js "></script>
        <script src="../sweetalert.min.js "></script>

        <script src="../qrcode.min.js"></script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
        <style >[wire\:loading], [wire\:loading\.delay], [wire\:loading\.inline-block], [wire\:loading\.inline], [wire\:loading\.block], [wire\:loading\.flex], [wire\:loading\.table], [wire\:loading\.grid], [wire\:loading\.inline-flex] {display: none;}[wire\:loading\.delay\.shortest], [wire\:loading\.delay\.shorter], [wire\:loading\.delay\.short], [wire\:loading\.delay\.long], [wire\:loading\.delay\.longer], [wire\:loading\.delay\.longest] {display:none;}[wire\:offline] {display: none;}[wire\:dirty]:not(textarea):not(input):not(select) {display: none;}input:-webkit-autofill, select:-webkit-autofill, textarea:-webkit-autofill {animation-duration: 50000s;animation-name: livewireautofill;}@keyframes livewireautofill { from {} }</style>
   <style>
        div.skiptranslate,#google_translate_element2{display:none!important}body{top:0!important} 
    </style>
    
    <style type="text/css">
	    .ibox {
            position: relative;
            background-color: #fff;
            -webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
            box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
            color: white !important;
        }
        .widget-stat .ibox-body {
            padding: 12px 15px;
        }
        .widget-stat-icon {
            position: absolute;
            top: 0;
            right: 0;
            width: 60px;
            height: 100%;    
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            font-size: 30px;
            background-color: rgba(0, 0, 0, 0.1);
        }
        .font-strong {
            font-weight: 600 !important;
        }
        /* Dark Mode Colors */
:root {
    --dark-bg-color: #1a1a1a;
    --card-bg-color: #2c2c2c;
    --text-color: #f0f0f0;
    --secondary-text-color: #b0b0b0;
    --border-color: #444;
    --green-icon: #28a745;
    --red-icon: #dc3545;
}

/* Container for the entire history list (Dark Mode) */
.wallet-history {
    display: flex;
    flex-direction: column;
    gap: 15px;
    padding: 15px;
    background-color: var(--dark-bg-color);
    border-radius: 8px;
    color: var(--text-color);
}

/* Individual transaction card */
.transaction-card {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px;
    background-color: var(--card-bg-color);
    border: 1px solid var(--border-color);
    border-radius: 8px;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

/* Hover effect */
.transaction-card:hover {
    transform: scale(1.02); /* Expands the card slightly */
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.5); /* A more prominent shadow */
    cursor: pointer;
}

/* Left side content (icon, type, details, fees) */
.icon-container {
    margin-right: 15px;
    flex-shrink: 0;
}

.transaction-icon {
    font-size: 1.5em;
}

/* Color the icons based on the transaction type class */
.transaction-card.credit .transaction-icon {
    color: var(--green-icon);
}

.transaction-card.debit .transaction-icon {
    color: var(--red-icon);
}

.transaction-details {
    display: flex;
    flex-direction: column;
    flex-grow: 1;
    flex-shrink: 1; /* Allows this section to shrink */
    min-width: 0; /* Prevents overflow in some browsers */
}

.transaction-type {
    font-weight: bold;
    font-size: 1.1em;
}

.details-text {
    font-size: 0.9em;
    color: var(--secondary-text-color);
    white-space: normal; /* Allow text to wrap to the next line */
}

.fees-text {
    font-size: 0.8em;
    color: var(--secondary-text-color);
}

/* Right side content (amounts) */
.transaction-amount-container {
    text-align: right;
    flex-shrink: 0; /* Prevents this section from shrinking */
    margin-left: 10px; /* Adds space between details and amount */
    white-space: nowrap; /* Prevents the amount from wrapping */
    overflow: hidden; /* Hides any content that might overflow */
}

.transaction-amount-dollar {
    font-weight: bold;
    font-size: 0.9em;
}

.transaction-amount-coin {
    font-size: 0.7em;
    color: var(--secondary-text-color);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis; /* Optional: adds "..." if content is too long */
}
      @media (max-width: 768px) {
    .transaction-card {
        flex-wrap: nowrap; /* Prevents items from wrapping to a new line */
    }
}
      /* Removes default link styling */
.transaction-link {
    text-decoration: none;
    color: inherit;
    display: block; /* Make the link a block element to wrap the card */
}

/* Re-applies the hover effect to the card itself */
.transaction-link:hover .transaction-card {
    transform: scale(1.02);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.5);
}
	</style>
</head>

<body class="application application-offset">


    <!-- Application container -->
    <div class="container-fluid container-application">
        
        <!-- Sidenav -->
<div class="sidenav" id="sidenav-main">
    <!-- Sidenav header -->
    <div class="sidenav-header d-flex align-items-center">
        <a class="navbar-brand d-md-none" href="./">
            <img style="border-radius: 50%;" src="../../logo.png" class="navbar-brand-img" alt="logo">
        </a>
        <div class="ml-auto">
            <!-- Sidenav toggler -->
            <div class="sidenav-toggler sidenav-toggler-dark d-md-none" data-action="sidenav-unpin"
                data-target="#sidenav-main">
                <div class="sidenav-toggler-inner">
                    <i class="bg-white sidenav-toggler-line"></i>
                    <i class="bg-white sidenav-toggler-line"></i>
                    <i class="bg-white sidenav-toggler-line"></i>
                </div>
            </div>
        </div>
    </div>
    <!-- User mini profile -->
    <!--<div class="text-center sidenav-user d-flex flex-column align-items-center justify-content-between my-md-5">-->
        <!-- Avatar -->
    <!--    <div>-->
    <!--        <a href="#" class="avatar rounded-circle avatar-xl">-->
    <!--            <i class="fas fa-user-circle fa-4x"></i>-->
    <!--        </a>-->
    <!--        <div class="mt-4">-->
    <!--            <h5 class="mb-0 text-white"></h5>-->
    <!--            <span class="mb-3 text-sm text-white d-block opacity-8">online</span>-->
    <!--            <a href="#" class="shadow btn btn-sm btn-white btn-icon rounded-pill hover-translate-y-n3">-->
    <!--                <span class="btn-inner--icon"><i class="far fa-coins"></i></span>-->
    <!--                <span class="btn-inner--text">$0.00</span>-->
    <!--            </a>-->
    <!--        </div>-->
    <!--    </div>-->
    <!--     User info -->
        <!-- Actions -->
    <!--    <div class="mt-0 w-100 actions d-flex justify-content-between">-->
    <!--        -->
    <!--        -->
    <!--    </div>-->
    <!--</div>-->
    <!-- Application nav -->
    <div class="clearfix nav-application mt-md-5 pt-md-5">
        <a href="index.php" class="text-sm btn btn-square active border">
            <span class="btn-inner--icon d-block"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 9L12 2L21 9" />
                <path d="M9 22V12H15V22" />
                <path d="M2 22H22" />
                </svg>
            </span>
            <span class="pt-2 btn-inner--icon d-block">Home</span>
        </a>
        <a href="buy-plan.php" class="text-sm btn btn-square  ">
            <span class="btn-inner--icon d-block">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="3" width="7" height="7" rx="1"/>
                <rect x="14" y="3" width="7" height="7" rx="1"/>
                <rect x="3" y="14" width="7" height="7" rx="1"/>
                <rect x="14" y="14" width="7" height="7" rx="1"/>
            </svg>

            </span>
            <span class="pt-2 btn-inner--icon d-block">Packages</span>
        </a>
        <!--<a href="myplans/All" class="text-sm btn btn-square  ">-->
        <!--    <span class="btn-inner--icon d-block"><i class="far fa-hand-holding-seedling fa-2x"></i></span>-->
        <!--    <span class="pt-2 btn-inner--icon d-block">Investments</span>-->
        <!--</a>-->
        <a href="deposit.php" class="text-sm btn btn-square  ">
            <span class="btn-inner--icon d-block"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 7H17A2 2 0 0 1 19 9V15A2 2 0 0 1 17 17H3V7Z"/>
                <path d="M19 9H22V15H19" />
                <circle cx="16" cy="12" r="1"/>
                </svg>
            </span>
            <span class="pt-2 btn-inner--icon d-block">Receive</span>
        </a>
        <a href="withdrawals.php" class="text-sm btn btn-square  ">
            <span class="btn-inner--icon d-block">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="2" y="7" width="20" height="14" rx="2" ry="2"/>
                <path d="M16 7V4A2 2 0 0 0 14 2H10A2 2 0 0 0 8 4V7"/>
                <path d="M2 13H22"/>
                </svg>
            </span>
            <span class="pt-2 btn-inner--icon d-block">Send</span>
        </a>
         <!--</a>-->
        <a href="wallet.php" class="text-sm btn btn-square  ">
            <span class="btn-inner--icon d-block"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 7H17A2 2 0 0 1 19 9V15A2 2 0 0 1 17 17H3V7Z"/>
                <path d="M19 9H22V15H19" />
                <circle cx="16" cy="12" r="1"/>
                </svg>
            </span>
            <span class="pt-2 btn-inner--icon d-block">Connect Wallet</span>
        </a>
        <!--<a href="tradinghistory" class="text-sm btn btn-square ">-->
        <!--    <span class="btn-inner--icon d-block"><i class="far fa-history fa-2x"></i></span>-->
        <!--    <span class="pt-2 btn-inner--icon d-block">Profit History</span>-->
        <!--</a>-->
        <a href="accounthistory.php" class="text-sm btn btn-square ">
            <span class="btn-inner--icon d-block"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M14 2H6A2 2 0 0 0 4 4V20A2 2 0 0 0 6 22H18A2 2 0 0 0 20 20V8Z"/>
                <path d="M14 2V8H20"/>
                </svg>
            </span>
            <span class="pt-2 btn-inner--icon d-block">Transactions</span>
        </a>
        <!---->
        <!--    <a href="asset-balance" class="text-sm btn btn-square  ">-->
        <!--        <span class="btn-inner--icon d-block"><i class="fab fa-stack-exchange fa-2x"></i></span>-->
        <!--        <span class="pt-2 btn-inner--icon d-block">Swap Crypto</span>-->
        <!--    </a>-->
        <!---->
        <!---->
        <!--    <a href="transfer-funds" class="text-sm btn btn-square ">-->
        <!--        <span class="btn-inner--icon d-block"><i class="fas fa-exchange fa-2x"></i></span>-->
        <!--        <span class="pt-2 btn-inner--icon d-block">Transfer funds</span>-->
        <!--    </a>-->
        <!---->
        <!---->
        <!--    <a href="subtrade" class="text-sm btn btn-square ">-->
        <!--        <span class="btn-inner--icon d-block"><i class="far fa-receipt fa-2x"></i></span>-->
        <!--        <span class="pt-2 btn-inner--icon d-block">Managed Accounts</span>-->
        <!--    </a>-->
        <!---->
        
        <a href="referuser.php" class="text-sm btn btn-square ">
            <span class="btn-inner--icon d-block">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="9" cy="7" r="4"/>
                <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                <line x1="19" y1="8" x2="19" y2="14"/>
                <line x1="16" y1="11" x2="22" y2="11"/>
                </svg>

            </span>
            <span class="pt-2 btn-inner--icon d-block">Referrals</span>
        </a>
         <a href="account-settings.php" class="text-sm btn btn-square ">
            <span class="btn-inner--icon d-block">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="2" y="4" width="20" height="16" rx="2" ry="2"/>
                <circle cx="9" cy="10" r="3"/>
                <path d="M4 16a4 4 0 0 1 8 0"/>
                <line x1="16" y1="8" x2="20" y2="8"/>
                <line x1="16" y1="12" x2="20" y2="12"/>
                <line x1="16" y1="16" x2="20" y2="16"/>
            </svg>

            </span>
            <span class="pt-2 btn-inner--icon d-block">Profile</span>
        </a>
      <a href="swap.php" class="text-sm btn btn-square ">
            <span class="btn-inner--icon d-block">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                   viewBox="0 0 24 24" fill="none" stroke="currentColor"
                   stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M16 3h5v5" />
                <path d="M21 3l-6.5 6.5a4 4 0 0 1-5.6 0L3 3" />
                <path d="M8 21H3v-5" />
                <path d="M3 21l6.5-6.5a4 4 0 0 1 5.6 0L21 21" />
              </svg>
            </span>
            <span class="pt-2 btn-inner--icon d-block">Swap Token</span>
        </a>
        
        <!--<a href="support" class="text-sm btn btn-square ">-->
        <!--    <span class="btn-inner--icon d-block"><i class="far fa-envelope fa-2x"></i></span>-->
        <!--    <span class="pt-2 btn-inner--icon d-block">Support</span>-->
        <!--</a>-->
    </div>
    <!-- Misc area -->
    <!--<div class="card bg-gradient-warning">-->
    <!--    <div class="card-body">-->
    <!--        <h5 class="text-white">Need Help!</h5>-->
    <!--        <p class="mb-4 text-white">-->
    <!--           Contact our 24/7 customer support center-->
    <!--        </p>-->
    <!--        <a href="support"-->
    <!--            class="btn btn-sm btn-block btn-white rounded-pill">Contact Us</a>-->
    <!--    </div>-->
    <!--</div>-->
</div>        <!-- Content -->
        <div class="main-content position-relative">
            <!-- Main nav -->
            <!-- Main nav -->
<nav class="navbar navbar-main navbar-expand-lg navbar-dark bg-primary navbar-border" id="navbar-main">
    <div class="container-fluid">
        <!-- Brand + Toggler (for mobile devices) -->
        <div class="pl-4 d-block">
            <a class="navbar-brand" href="./">
                <img src="../../logo.png" alt="..." class="img-fluid" width="100px" style="border-radius: 50%; height:80% !important">
            </a> 
        </div>
       
        <!-- User's navbar -->
        <div class="ml-auto navbar-user d-lg-none">
            <ul class="flex-row navbar-nav align-items-center">
                <li class="nav-item">
                    <a href="#" class="nav-link nav-link-icon sidenav-toggler" data-action="sidenav-pin"
                        data-target="#sidenav-main"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <path d="M3 6h18M3 12h18M3 18h18"/>
                    </svg></a>
                </li>
                
                
                <li class="nav-item dropdown dropdown-animate shadow-none">
                    <a class="nav-link pr-lg-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <span class="avatar avatar-sm rounded-circle">
                            <img height="30px" width="30px" src="uploads/<?php echo $user['profilePic'] ?>" />
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right dropdown-menu-arrow shadow-none">
                        <!--<h6 class="px-0 dropdown-header">Hi,!</h6>-->
                        <a href="account-settings.php" class="dropdown-item">
                            <i class="far fa-user"></i>
                            <span>My profile</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        
                        <a class="dropdown-item text-danger" href="logout.php" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                         <i class="far fa-sign-out-alt"></i>
                         <span>Logout</span>
                        </a>
                        <form id="logout-form" action="logout.php" method="POST"
                            style="display: none;">
                            <input type="hidden" name="csrfmiddlewaretoken" value="wKbVpGcGAp9B0uIZcft3Gti5wgC8ttmpFLLi7e7Gy92P4NxkRHg8orXxYLonQgzq">
                        </form>
                    </div>
                </li>
            </ul>
        </div>
        <!-- Navbar nav -->
        <div class="collapse navbar-collapse navbar-collapse-fade" id="navbar-main-collapse">
            
            <!-- Right menu -->
            <ul class="navbar-nav ml-lg-auto align-items-center d-none d-lg-flex">
                <li class="nav-item">
                    <a href="#" class="nav-link nav-link-icon sidenav-toggler" data-action="sidenav-pin"
                        data-target="#sidenav-main"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <path d="M3 6h18M3 12h18M3 18h18"/>
                    </svg>
                    </a>
                </li>
                
                                
                <li class="nav-item dropdown dropdown-animate">
                    <a class="nav-link pr-lg-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <div class="media media-pill align-items-center">
                            <span class="avatar rounded-circle">
                                <img height="30px" width="30px" src="uploads/<?php echo $user['profilePic'] ?>" />
                            </span>
                            <div class="ml-2 d-none d-lg-block">
                                <span class="mb-0 text-sm font-weight-bold"><?php  echo $user['firstname'].' '.$user['lastname']; ?></span>
                            </div>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right dropdown-menu-arrow">
                        <h6 class="px-0 dropdown-header">Hi, <?php  echo $user['firstname'].' '.$user['lastname']; ?>!</h6>
                        <a href="account-settings.php" class="dropdown-item">
                            <i class="far fa-user"></i>
                            <span>My profile</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        
                        <a class="dropdown-item text-danger" href="logout.php" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                         <i class="far fa-sign-out-alt"></i>
                         <span>Logout</span>
                        </a>
                        <form id="logout-form" action="logout.php" method="POST"
                            style="display: none;">
                            <input type="hidden" name="csrfmiddlewaretoken" value="wKbVpGcGAp9B0uIZcft3Gti5wgC8ttmpFLLi7e7Gy92P4NxkRHg8orXxYLonQgzq">
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>



