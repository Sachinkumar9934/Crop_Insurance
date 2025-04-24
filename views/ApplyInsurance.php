<?php
include 'C:/xampp/htdocs/crop_insurance/config/db_connect.php';
include 'C:/xampp/htdocs/crop_insurance/config/config.php';

// Insurance company details
$data=$_SESSION['company_details'];
$company_name = $data['company_name'];
unset($_SESSION['company_details']);

$farmer_id=$_SESSION['user_farmer_id'];

$user_name=$_SESSION['user_name'];
$user_mobile_number=$_SESSION['user_mobile_number'];
$user_farm_type=$_SESSION['user_farm_type'];
$user_state=$_SESSION['user_state'];
$user_district=$_SESSION['user_district'];
$user_sub_district=$_SESSION['user_sub_district'];
$user_village=$_SESSION['user_village'];
$user_address=$_SESSION['user_address'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" type="image/x-icon" href="C.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Insurance Application Summary - CropInsure</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Navigation Bar -->
    <nav class="bg-green-600 shadow-md sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            <div class="flex items-center">
                <span class="text-3xl font-bold text-white">CropInsure</span>
            </div>
            <div class="flex items-center space-x-4">
                <?php if (isset($_SESSION['user_farmer_id'])): ?>
                    <div class="relative group">
                    <span class="inline-block text-lg font-bold text-white cursor-pointer px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl animate-pulse-subtle">
                        Hi, <?php echo htmlspecialchars($_SESSION['user_name']); ?>
                    </span>
                    <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                        <div class="py-1">
                        <a href="<?php echo BASE_URL; ?>views/profile.php" class="w-full block px-4 py-2 text-sm text-gray-700 hover:bg-green-100 hover:text-green-600">Profile</a>
                        <a href="<?php echo BASE_URL; ?>models/logout_model.php" class="w-full block px-4 py-2 text-sm text-gray-700 hover:bg-green-100 hover:text-green-600">Logout</a>
                        <button onclick="apply_check('support_modal')" class=" block px-4 py-2 pr-36 text-sm text-gray-700 hover:bg-green-100 hover:text-green-600">Help</a>
                        </div>
                    </div>
                    </div>
                <?php else: ?>
                    <div class="flex space-x-4">
                        <button onclick="open_popup('login_modal')" 
                                class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-700 transition duration-300 text-sm font-medium">
                            Login
                        </button>
                        <button onclick="open_popup('signup_modal')" 
                                class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 transition duration-300 text-sm font-medium">
                            Sign Up
                        </button>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-white shadow-lg rounded-lg p-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-6">Insurance Application Summary</h1>

            <!-- Farmer Details Section -->
            <div class="mb-8 bg-gray-50 rounded-lg p-6">
                <h2 class="text-xl font-semibold text-gray-700 border-b-2 border-gray-300 pb-2 mb-4">Farmer Details</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-gray-700 mb-2"><span class="font-medium">Farmer ID:</span> <?php echo htmlspecialchars($farmer_id); ?></p>
                        <p class="text-gray-700 mb-2"><span class="font-medium">Name:</span> <?php echo htmlspecialchars($user_name); ?></p>
                        <p class="text-gray-700 mb-2"><span class="font-medium">Mobile Number:</span> <?php echo htmlspecialchars($user_mobile_number); ?></p>
                        <p class="text-gray-700 mb-2"><span class="font-medium">Farm Type:</span> <?php echo htmlspecialchars($user_farm_type); ?></p>
                    </div>
                    <div>
                        <p class="text-gray-700 mb-2"><span class="font-medium">State:</span> <?php echo htmlspecialchars($user_state); ?></p>
                        <p class="text-gray-700 mb-2"><span class="font-medium">District:</span> <?php echo htmlspecialchars($user_district); ?></p>
                        <p class="text-gray-700 mb-2"><span class="font-medium">Sub-District:</span> <?php echo htmlspecialchars($user_sub_district); ?></p>
                        <p class="text-gray-700 mb-2"><span class="font-medium">Village:</span> <?php echo htmlspecialchars($user_village); ?></p>
                    </div>
                </div>
                <p class="text-gray-700 mt-2"><span class="font-medium">Address:</span> <?php echo htmlspecialchars($user_address); ?></p>
            </div>

            <!-- Insurance Company Details Section -->
            <div class="mb-8 bg-gray-50 rounded-lg p-6">
                <h2 class="text-xl font-semibold text-gray-700 border-b-2 border-gray-300 pb-2 mb-4">Insurance Company Details</h2>
                <div class="grid grid-cols-1 gap-4">
                    <p class="text-gray-700 mb-2"><span class="font-medium">Company Name:</span> <?php echo htmlspecialchars($company_name); ?></p>
                    <!--<p class="text-gray-700 mb-2"><span class="font-medium">Email:</span> <?php echo htmlspecialchars($email); ?></p>
                    -->                </div>
            </div>

            <form id="insuranceForm" method="POST" action="<?php echo BASE_URL; ?>models/sumbit_inc.php" onsubmit="return validateForm()" class="bg-yellow-50 rounded-lg p-6">
                <div class="flex items-center mb-4">
                    <input type="checkbox" name="verify" id="verifyCheckbox" class="h-5 w-5 text-green-600 border-gray-300 rounded focus:ring-green-500" required>
                    <label for="verifyCheckbox" class="ml-2 text-gray-700 font-medium">I verify that all provided information is accurate</label>
                </div>
                <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                    <button type="submit" class="px-6 py-3 bg-green-500 text-white rounded-md hover:bg-green-600 transition duration-300 font-medium">Submit Insurance</button>
                    <a href="<?php echo BASE_URL; ?>views/HomePage.php" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition duration-300 font-medium text-center">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <div class="hidden fixed inset-0 items-center justify-center bg-black bg-opacity-50 z-50 transition-opacity duration-300" id="support_modal">
        <div class="bg-white rounded-2xl relative w-full max-w-lg shadow-2xl transform transition-all duration-300 scale-95 opacity-0 glassmorphism" id="support_modal_content">
            <div class="flex justify-between items-center p-8 border-b border-gray-200">
                <h2 class="text-3xl font-bold text-gray-800">Premium Support</h2>
                <button onclick="close_popup('support_modal')" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="p-8">
                <p class="text-gray-600 mb-6 text-lg">Our dedicated team is here to assist you with any claim-related queries.</p>
                <form method="POST" action="<?php echo BASE_URL; ?>models/support_model.php" class="space-y-6">
                    <div>
                        <label class="block text-base font-medium text-gray-700 mb-2">Name</label>
                        <input type="text" placeholder="Enter your name" name="name" class="w-full p-4 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500" required>
                    </div>
                    <div>
                        <label class="block text-base font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" placeholder="Enter your email" name="email" class="w-full p-4 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500" required>
                    </div>
                    <div>
                        <label class="block text-base font-medium text-gray-700 mb-2">Message</label>
                        <textarea placeholder="Describe your issue" name="message" class="w-full p-4 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500" rows="5" required></textarea>
                    </div>
                    <button type="submit" class="w-full p-4 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-xl hover:from-green-600 hover:to-emerald-700 transition duration-300 font-semibold text-lg">Submit</button>
                </form>
            </div>
        </div>
    </div>
    <div class="fixed bottom-4 right-4 z-50">
        <button onclick="apply_check('support_modal')" class="flex items-center px-4 py-3 bg-green-600 text-white rounded-full shadow-lg hover:bg-green-700 transition duration-300 font-medium">
            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636a9 9 0 11-12.728 12.728 9 9 0 0112.728-12.728M12 9v3m0 3h.01"></path>
            </svg>
            Support
        </button>
    </div>
    <footer class="bg-gray-800 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-20">
                <div>
                    <h3 class="text-xl font-bold mb-4">CropInsure</h3>
                    <p class="text-gray-400">Protecting farmers and their livelihoods with comprehensive crop insurance solutions.</p>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><button onclick="open_popup('ipc_modal');" class="text-gray-400 hover:text-white transition duration-300">Premium Calculator</button></li>
                        <li><button onclick="apply_check('apply_modal')" class="text-gray-400 hover:text-white transition duration-300">Apply for Insurance</button></li>
                        <li><button onclick="apply_check('claim_modal')" class="text-gray-400 hover:text-white transition duration-300">Claim Insurance</button></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-4">Contact Us</h3>
                    <ul class="space-y-2">
                        <li><button onclick="open_popup('ipc_modal');" class="text-gray-400 hover:text-white transition duration-300">About Us</button></li>
                        <li><button onclick="apply_check('apply_modal')" class="text-gray-400 hover:text-white transition duration-300">Github</button></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; <?php echo date('Y'); ?> CropInsure. All rights reserved.</p>
            </div>
        </div>
    </footer>
    <script>
        const isLoggedIn = <?php echo isset($_SESSION['user_farmer_id']) ? 'true' : 'false'; ?>;

        function apply_check(id) {
            if (isLoggedIn) {
                if (document.getElementById(id)) {
                    open_popup(id);
                }
            } else {
                alert('Kindly Login First');
            }
        }

        function open_popup(id) {
            const modal = document.getElementById(id);
            const modalContent = document.getElementById(`${id}_content`);
            
            modal.classList.remove("hidden");
            modal.classList.add("flex");
            
            setTimeout(() => {
                modalContent.classList.remove("scale-95", "opacity-0");
                modalContent.classList.add("scale-100", "opacity-100");
            }, 10);
        }

        function close_popup(id) {
            const modal = document.getElementById(id);
            const modalContent = document.getElementById(`${id}_content`);
            
            modalContent.classList.remove("scale-100", "opacity-100");
            modalContent.classList.add("scale-95", "opacity-0");
            
            setTimeout(() => {
                modal.classList.add("hidden");
                modal.classList.remove("flex");
            }, 300);
        }
    </script>
</body>

<script>
    function validateForm() {
        const verifyCheckbox = document.getElementById('verifyCheckbox');
        if (!verifyCheckbox.checked) {
            alert('Please verify that all provided information is accurate by checking the box.');
            return false;
        }
        return true;
    }
</script>
</html>