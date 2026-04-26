<nav id="sidebar" class="fixed top-0 right-0 w-full h-full bg-[#121414] border-l border-gray-700/50 z-50 transform translate-x-full transition-transform duration-300 ease-in-out">
    <div class="p-4 flex flex-col h-full">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <img height="30px" width="30px" src="<?php if(empty($user['profilePic'])){echo 'profile.jpg';}else{echo 'uploads/profile_pics/'.$user['profilePic'];} ?>" alt="User Profile" class="rounded-full">
                <div>
                    <div class="font-bold text-white"><?php echo $user['firstname'].' '.$user['lastname']; ?></div>
                    <div class="text-sm text-gray-400">View Profile</div>
                </div>
            </div>
            <button id="close-menu-btn" class="p-2 rounded-full hover:bg-gray-800 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="mt-8 flex-1 overflow-y-auto no-scrollbar">
            <ul class="space-y-4 text-gray-300 font-medium">
                <li>
                    <a href="index.php" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-[#1f2125]">
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="index.php?page=deposit" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-[#1f2125]">
                        <span>Deposit</span>
                    </a>
                </li>
                <li>
                    <a href="withdrawal.php" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-[#1f2125]">
                        <span>Withdrawal</span>
                    </a>
                </li>
                <li>
                    <a href="plans.php" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-[#1f2125]">
                        <span>Investment Plans</span>
                    </a>
                </li>
                <!--<li>
                    <a href="history.php" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-[#1f2125]">
                        <span>Transaction History</span>
                    </a>
                </li>-->
                <li>
                    <a href="index.php" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-[#1f2125]">
                        <span>New Listing</span>
                    </a>
                </li>
                <!--<li>
                    <a href="" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-[#1f2125]">
                        <span>My Rewards</span>
                    </a>
                </li>-->
                <li>
                    <a href="profile.php" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-[#1f2125]">
                        <span>Security</span>
                    </a>
                </li>
                <li>
                    <a href="kyc.php" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-[#1f2125]">
                        <span>Verification</span>
                    </a>
                </li>
                <li>
                    <a href="referral.php" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-[#1f2125]">
                        <span>Referral Hub</span>
                    </a>
                </li>
                <!--<li>
                    <a href="settings.php" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-[#1f2125]">
                        <span>Settings</span>
                    </a>
                </li>-->
            </ul>
        </div>

        <div class="mt-auto pt-4 border-t border-gray-700/50 w-full text-center px-4">
            <a href="logout.php" class="inline-flex items-center justify-center w-full space-x-2 p-2 rounded-lg hover:bg-red-500/20 text-red-400 font-semibold">
                <span>Log out</span>
            </a>
        </div>
    </div>
</nav>
    
<div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden"></div>

<header class="p-4 flex items-center justify-between bg-[#121417] border-b border-gray-700/50">
    <div class="flex items-center space-x-2">
        <a href="profile.php" class="p-2 rounded-full hover:bg-gray-800 focus:outline-none">
            <img src="<?php if(empty($user['profilePic'])){echo 'profile.jpg';}else{echo 'uploads/profile_pics/'.$user['profilePic'];} ?>" height="30px" width="30px" class="rounded-full">
        </a>
    </div>
    <div class="flex items-center space-x-2">
        <button class="p-2 rounded-full hover:bg-gray-800 focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>
        </button>
        <button id="menu-btn" class="p-2 rounded-full hover:bg-gray-800 focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>
</header>
<!-- Smartsupp Live Chat script -->
<script type="text/javascript">
var _smartsupp = _smartsupp || {};
_smartsupp.key = '125bebc9d02572792ba63a6cca13a29bf2505bdb';
window.smartsupp||(function(d) {
  var s,c,o=smartsupp=function(){ o._.push(arguments)};o._=[];
  s=d.getElementsByTagName('script')[0];c=d.createElement('script');
  c.type='text/javascript';c.charset='utf-8';c.async=true;
  c.src='https://www.smartsuppchat.com/loader.js?';s.parentNode.insertBefore(c,s);
})(document);
</script>
<noscript>Powered by <a href="https://www.smartsupp.com" target="_blank">Smartsupp</a></noscript>
