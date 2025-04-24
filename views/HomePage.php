<!DOCTYPE html>
<html lang="en">
<?php
include 'C:/xampp/htdocs/crop_insurance/config/db_connect.php';
include 'C:/xampp/htdocs/crop_insurance/config/config.php';
// Initialize dropdown data structure
$dropdownData = [
    'states' => [],
    'districts' => [],
    'crops' => [],
    'seasons' => []
];

// Fetch unique data from crop_calender table
$query = "SELECT DISTINCT state, district, crop, season FROM crop_calender ORDER BY state, district, crop, season";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $state = $row['state'];
    $district = $row['district'];
    $crop = $row['crop'];
    $season = $row['season'];

    // Populate states
    if (!in_array($state, $dropdownData['states'])) {
        $dropdownData['states'][] = $state;
    }

    // Populate districts under states
    if (!isset($dropdownData['districts'][$state])) {
        $dropdownData['districts'][$state] = [];
    }
    if (!in_array($district, $dropdownData['districts'][$state])) {
        $dropdownData['districts'][$state][] = $district;
    }

    // Populate crops under districts
    if (!isset($dropdownData['crops'][$district])) {
        $dropdownData['crops'][$district] = [];
    }
    if (!in_array($crop, $dropdownData['crops'][$district])) {
        $dropdownData['crops'][$district][] = $crop;
    }

    // Populate seasons under district-crop pairs
    if (!isset($dropdownData['seasons'][$district])) {
        $dropdownData['seasons'][$district] = [];
    }
    if (!isset($dropdownData['seasons'][$district][$crop])) {
        $dropdownData['seasons'][$district][$crop] = [];
    }
    if (!in_array($season, $dropdownData['seasons'][$district][$crop])) {
        $dropdownData['seasons'][$district][$crop][] = $season;
    }
}

$stmt->close();
?>

<head>
    <link rel="icon" type="image/x-icon" href="C.png">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Crop Insurance</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        body {
            font-family: 'Poppins', sans-serif;
        }
        @keyframes pulse-subtle {
  0%, 100% {
    transform: scale(1);
    opacity: 1;
  }
  50% {
    transform: scale(1.02);
    opacity: 0.95;
  }
}

.animate-pulse-subtle {
  animation: pulse-subtle 2s ease-in-out infinite;
}
    </style>
</head>

<body class="bg-gray-50 min-h-screen">
    <!-- Navigation Bar -->
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
        <a href="<?php echo BASE_URL; ?>models/profile_model.php"
           class="w-full block px-4 py-2 text-sm text-gray-700 hover:bg-green-100 hover:text-green-600">
            Profile
        </a>
        <button type="button"
                onclick="apply_check('support_modal')"
                class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-green-100 hover:text-green-600">
            Support
        </button>
        <a href="<?php echo BASE_URL; ?>models/logout_model.php"
           class="w-full block px-4 py-2 text-sm text-gray-700 hover:bg-red-100 hover:text-red-600">
            Logout
        </a>
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

    <!-- Hero Section -->
    <div class="bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div class="space-y-8">
                    <h1 class="text-4xl md:text-5xl font-bold text-gray-900 leading-tight">
                        Protect Your <span class="text-green-600">Crops</span> with <span class="text-yellow-500">Insurance</span>
                    </h1>
                    <p class="text-xl text-gray-600 max-w-lg">
                        Secure your farming future with our comprehensive crop insurance solutions. Get coverage tailored to your specific needs and protect against unexpected losses.
                    </p>
                    <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                        <button onclick="open_popup('ipc_modal');" 
                                class="px-6 py-3 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 transition duration-300 text-lg font-medium">
                            Calculate Premium
                        </button>
                        <button onclick="apply_check('apply_modal')" 
                                class="px-6 py-3 bg-green-500 text-white rounded-md hover:bg-green-600 transition duration-300 text-lg font-medium">
                            Apply Now
                        </button>
                    </div>
                </div>
                <div class="hidden md:block">
                    <div class="bg-green-100 rounded-lg p-8 shadow-lg">
                        <div class="grid grid-cols-2 gap-6">
                            <div class="bg-white p-6 rounded-lg shadow-sm">
                                <div class="text-green-600 text-3xl font-bold mb-2">100%</div>
                                <div class="text-gray-600">Coverage for eligible losses</div>
                            </div>
                            <div class="bg-white p-6 rounded-lg shadow-sm">
                                <div class="text-yellow-500 text-3xl font-bold mb-2">24/7</div>
                                <div class="text-gray-600">Support available</div>
                            </div>
                            <div class="bg-white p-6 rounded-lg shadow-sm">
                                <div class="text-green-600 text-3xl font-bold mb-2">190+</div>
                                <div class="text-gray-600">Crop varieties covered</div>
                            </div>
                            <div class="bg-white p-6 rounded-lg shadow-sm">
                                <div class="text-yellow-500 text-3xl font-bold mb-2">₹5000+</div>
                                <div class="text-gray-600">Average claim amount</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="bg-gray-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">Our Services</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-lg shadow-sm hover:shadow-md transition duration-300">
                    <div class="text-green-500 text-4xl mb-4">🌾</div>
                    <h3 class="text-xl font-semibold mb-2">Premium Calculator</h3>
                    <p class="text-gray-600 mb-4">Calculate insurance premiums based on your crop, area, and other factors.</p>
                    <button onclick="open_popup('ipc_modal');" 
                            class="text-green-600 font-medium hover:text-green-700">
                        Calculate Now →
                    </button>
                </div>
                <div class="bg-white p-8 rounded-lg shadow-sm hover:shadow-md transition duration-300">
                    <div class="text-yellow-500 text-4xl mb-4">📝</div>
                    <h3 class="text-xl font-semibold mb-2">Apply for Insurance</h3>
                    <p class="text-gray-600 mb-4">Get coverage for your crops with our simple application process.</p>
                    <button onclick="apply_check('apply_modal')" 
                            class="text-yellow-600 font-medium hover:text-yellow-700">
                        Apply Now →
                    </button>
                </div>
                <div class="bg-white p-8 rounded-lg shadow-sm hover:shadow-md transition duration-300">
                    <div class="text-green-500 text-4xl mb-4">🏦</div>
                    <h3 class="text-xl font-semibold mb-2">My Insurance</h3>
                    <p class="text-gray-600 mb-4">Check current Insurances under your name.</p>
                    <button onclick="view_ins_check()" 
                            class="text-green-600 font-medium hover:text-green-700">
                        View Insurance →
                    </button>
                </div>
                <div class="bg-white p-8 rounded-lg shadow-sm hover:shadow-md transition duration-300">
                    <div class="text-green-500 text-4xl mb-4">💰</div>
                    <h3 class="text-xl font-semibold mb-2">Claim Insurance</h3>
                    <p class="text-gray-600 mb-4">File claims easily when you experience crop losses.</p>
                    <button onclick="claim_check()" 
                            class="text-green-600 font-medium hover:text-green-700">
                        File Claim →
                    </button>
                </div>
                <div class="bg-white p-8 rounded-lg shadow-sm hover:shadow-md transition duration-300">
                    <div class="text-green-500 text-4xl mb-4">🛡️</div>
                    <h3 class="text-xl font-semibold mb-2">See Claim Status</h3>
                    <p class="text-gray-600 mb-4">Check the current stutus of your Claims.</p>
                    <button onclick="apply_check('claim_modal')" 
                        class="text-yellow-600 font-medium hover:text-yellow-700">
                        Check Status →
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modals -->
    <div class="hidden fixed inset-0 items-center justify-center bg-black bg-opacity-50 z-50 transition-opacity duration-300" id="signup_modal">
    <div class="bg-white rounded-lg relative w-full max-w-md max-h-[90vh] overflow-hidden shadow-xl transform transition-all duration-300 scale-95 opacity-0" id="signup_modal_content">
        <div class="flex justify-between items-center p-6 border-b border-gray-200">
            <h2 class="text-2xl font-bold text-gray-800">Sign Up</h2>
            <button onclick="close_popup('signup_modal')" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="p-6 overflow-y-auto max-h-[calc(90vh-120px)]">
            <form method="POST" action="<?php echo BASE_URL; ?>models/signup_model.php" class="space-y-4" id="signup_form" onsubmit="return validateForm(event)">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                        <input type="text" placeholder="Enter your name" name="name" id="name" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" required>
                        <p id="name_error" class="text-red-500 text-xs mt-1 hidden">Name must be at least 2 characters, letters only.</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Mobile Number</label>
                        <input type="text" placeholder="Enter mobile number" name="mobile_number" id="mobile_number" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" required>
                        <p id="mobile_error" class="text-red-500 text-xs mt-1 hidden">Please enter a valid 10-digit mobile number.</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Age</label>
                        <input type="number" placeholder="Enter age" name="age" id="age" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" required>
                        <p id="age_error" class="text-red-500 text-xs mt-1 hidden">Age must be between 18 and 100.</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Gender</label>
                        <select name="gender" id="gender" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" required>
                            <option value="">Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                        <p id="gender_error" class="text-red-500 text-xs mt-1 hidden">Please select a gender.</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Caste</label>
                        <input type="text" placeholder="Enter caste" name="caste" id="caste" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" required>
                        <p id="caste_error" class="text-red-500 text-xs mt-1 hidden">Caste must be at least 2 characters.</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Farm Type</label>
                        <input type="text" placeholder="Enter farm type" name="farm_type" id="farm_type" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" required>
                        <p id="farm_type_error" class="text-red-500 text-xs mt-1 hidden">Farm type must be at least 2 characters.</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Farm Category</label>
                        <input type="text" placeholder="Enter farm category" name="farm_category" id="farm_category" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" required>
                        <p id="farm_category_error" class="text-red-500 text-xs mt-1 hidden">Farm category must be at least 2 characters.</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">ID Type</label>
                        <input type="text" placeholder="Enter ID type" name="id_type" id="id_type" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" required>
                        <p id="id_type_error" class="text-red-500 text-xs mt-1 hidden">ID type must be at least 2 characters.</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">State</label>
                        <input type="text" placeholder="Enter state" name="state" id="state" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" required>
                        <p id="state_error" class="text-red-500 text-xs mt-1 hidden">State must be at least 2 characters.</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">District</label>
                        <input type="text" placeholder="Enter district" name="district" id="district" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" required>
                        <p id="district_error" class="text-red-500 text-xs mt-1 hidden">District must be at least 2 characters.</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Subdistrict</label>
                        <input type="text" placeholder="Enter subdistrict" name="subdistrict" id="subdistrict" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" required>
                        <p id="subdistrict_error" class="text-red-500 text-xs mt-1 hidden">Subdistrict must be at least 2 characters.</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Village</label>
                        <input type="text" placeholder="Enter village" name="village" id="village" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" required>
                        <p id="village_error" class="text-red-500 text-xs mt-1 hidden">Village must be at least 2 characters.</p>
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                    <input type="text" placeholder="Enter address" name="address" id="address" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" required>
                    <p id="address_error" class="text-red-500 text-xs mt-1 hidden">Address must be at least 2 characters.</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <div class="relative">
                        <input type="password" placeholder="Enter password" name="password" id="password_input" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 pr-10" required>
                        <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 hover:text-gray-700 focus:outline-none">
                            <svg id="eye_icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                    <p id="password_error" class="text-red-500 text-xs mt-1 hidden">Password must be at least 8 characters long.</p>
                </div>
                
                <button type="submit" class="w-full p-3 bg-green-500 text-white rounded-md hover:bg-green-600 transition duration-300 font-medium">Sign Up</button>
            </form>
        </div>
    </div>
</div>




<style>
@media (max-width: 640px) {
    #signup_modal_content {
        max-width: 90%;
    }
    .text-2xl {
        font-size: 1.5rem;
    }
    .p-6 {
        padding: 1rem;
    }
    .text-xs {
        font-size: 0.65rem;
    }
    .grid-cols-1 {
        grid-template-columns: 1fr;
    }
}
</style>

    <!-- Login Modal -->
    <div class="hidden fixed inset-0 items-center justify-center bg-black bg-opacity-50 z-50 transition-opacity duration-300" id="login_modal">
    <div class="bg-white rounded-lg relative w-full max-w-md shadow-xl transform transition-all duration-300 scale-95 opacity-0" id="login_modal_content">
        <div class="flex justify-between items-center p-6 border-b border-gray-200">
            <h2 class="text-2xl font-bold text-gray-800">Login</h2>
            <button onclick="close_popup('login_modal')" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="p-6">
            <form method="POST" action="<?php echo BASE_URL; ?>models/login_model.php" class="space-y-4" id="login_form" onsubmit="return validateForm(event)">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Mobile Number</label>
                    <input type="text" placeholder="Enter mobile number" name="mobile_number" id="mobile_number" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" required>
                    <p id="mobile_error" class="text-red-500 text-xs mt-1 hidden">Please enter a valid 10-digit mobile number.</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <div class="relative">
                        <input type="password" placeholder="Enter password" name="password" id="password_input" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 pr-10" required>
                        <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 hover:text-gray-700 focus:outline-none">
                            <svg id="eye_icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                    <p id="password_error" class="text-red-500 text-xs mt-1 hidden">Password must be at least 8 characters long.</p>
                </div>
                <button type="submit" class="w-full p-3 bg-green-500 text-white rounded-md hover:bg-green-600 transition duration-300 font-medium">Login</button>
            </form>
        </div>
    </div>
</div>

<style>
@media (max-width: 640px) {
    #login_modal_content {
        max-width: 90%;
    }
    .text-2xl {
        font-size: 1.5rem;
    }
    .p-6 {
        padding: 1rem;
    }
    .text-xs {
        font-size: 0.65rem;
    }
}
</style>

    <!-- Insurance Premium Calculator Modal -->
    <div class="hidden fixed inset-0 items-center justify-center bg-black bg-opacity-50 z-50 transition-opacity duration-300" id="ipc_modal">
        <div class="bg-white rounded-lg relative w-full max-w-md shadow-xl transform transition-all duration-300 scale-95 opacity-0" id="ipc_modal_content">
            <div class="flex justify-between items-center p-6 border-b border-gray-200">
                <h2 class="text-2xl font-bold text-gray-800">Premium Calculator</h2>
                <button onclick="close_popup('ipc_modal')" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="p-6">
                <form method="POST" action="<?php echo BASE_URL; ?>models/ipc_model.php" onsubmit="return validateForm('ipc')" class="space-y-4" target="_blank">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">State</label>
                        <select name="state" id="ipc_state_select" onchange="updateSelectOptions('ipc_district_select', 'districts', this.value)" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                            <option value="">SELECT STATE</option>
                            <?php foreach ($dropdownData['states'] as $state) {
                                echo "<option value='$state'>" . strtoupper($state) . "</option>";
                            } ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">District</label>
                        <select name="district" id="ipc_district_select" onchange="updateSelectOptions('ipc_crop_select', 'crops', this.value)" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                            <option value="">SELECT DISTRICT</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Crop</label>
                        <select name="crop" id="ipc_crop_select" onchange="updateSeasonOptions('ipc', this.value)" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                            <option value="">SELECT CROP</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Season</label>
                        <select name="season" id="ipc_season_select" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                            <option value="">SELECT SEASON</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Area (in hectares)</label>
                        <input type="number" placeholder="Enter area" name="area" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" required min='1'>
                    </div>
                    <button type="submit" class="w-full p-3 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 transition duration-300 font-medium">Calculate Premium</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Apply for Insurance Modal -->
    <div class="hidden fixed inset-0 items-center justify-center bg-black bg-opacity-50 z-50 transition-opacity duration-300" id="apply_modal">
        <div class="bg-white rounded-lg relative w-full max-w-md shadow-xl transform transition-all duration-300 scale-95 opacity-0" id="apply_modal_content">
            <div class="flex justify-between items-center p-6 border-b border-gray-200">
                <h2 class="text-2xl font-bold text-gray-800">Apply for Insurance</h2>
                <button onclick="close_popup('apply_modal')" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="p-6">
                <form method="POST" action="<?php echo BASE_URL; ?>models/apply_inc_model.php" onsubmit="return validateForm('apply')" class="space-y-4" target="_blank">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">State</label>
                        <select name="state" id="apply_state_select" onchange="updateSelectOptions('apply_district_select', 'districts', this.value)" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                            <option value="">SELECT STATE</option>
                            <?php foreach ($dropdownData['states'] as $state) {
                                echo "<option value='$state'>" . strtoupper($state) . "</option>";
                            } ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">District</label>
                        <select name="district" id="apply_district_select" onchange="updateSelectOptions('apply_crop_select', 'crops', this.value)" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                            <option value="">SELECT DISTRICT</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Crop</label>
                        <select name="crop" id="apply_crop_select" onchange="updateSeasonOptions('apply', this.value)" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                            <option value="">SELECT CROP</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Season</label>
                        <select name="season" id="apply_season_select" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                            <option value="">SELECT SEASON</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Area (in hectares)</label>
                        <input type="text" placeholder="Enter area" name="area" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" required>
                    </div>
                    <button type="submit" class="w-full p-3 bg-green-500 text-white rounded-md hover:bg-green-600 transition duration-300 font-medium">Apply</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Claim Insurance Modal -->
    <div class="hidden fixed inset-0 items-center justify-center bg-black bg-opacity-50 z-50 transition-opacity duration-300" id="claim_modal">
        <div class="bg-white rounded-lg relative w-full max-w-md shadow-xl transform transition-all duration-300 scale-95 opacity-0" id="claim_modal_content">
            <div class="flex justify-between items-center p-6 border-b border-gray-200">
                <h2 class="text-2xl font-bold text-gray-800">Claim Insurance</h2>
                <button onclick="close_popup('claim_modal')" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="p-6">
                <form method="POST" action="<?php echo BASE_URL; ?>models/claim_check.php" class="space-y-4" target="_blank">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Insurance ID</label>
                        <input type="text" placeholder="Enter insurance ID" name="insurance_id" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" required>
                    </div>
                    <button type="submit" class="w-full p-3 bg-green-500 text-white rounded-md hover:bg-green-600 transition duration-300 font-medium">Check Status</button>
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

    <!-- Support Modal -->
    <div class="hidden fixed inset-0 items-center justify-center bg-black bg-opacity-50 z-50 transition-opacity duration-300" id="support_modal">
        <div class="bg-white rounded-lg relative w-full max-w-md shadow-xl transform transition-all duration-300 scale-95 opacity-0" id="support_modal_content">
            <div class="flex justify-between items-center p-6 border-b border-gray-200">
                <h2 class="text-2xl font-bold text-gray-800">Support</h2>
                <button onclick="close_popup('support_modal')" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="p-6">
                <p class="text-gray-600 mb-4">Need help? Contact our support team for assistance.</p>
                <form method="POST" action="<?php echo BASE_URL; ?>models/support_model.php" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                        <input type="text" placeholder="Enter your name" name="name" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" placeholder="Enter your email" name="email" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                        <textarea placeholder="Describe your issue" name="message" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="w-full p-3 bg-green-500 text-white rounded-md hover:bg-green-600 transition duration-300 font-medium">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
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
                        <li><a href="<?php echo BASE_URL; ?>views/about_us.html" class="text-gray-400 hover:text-white transition duration-300">About Us</a></li>
                        <li><button onclick="" class="text-gray-400 hover:text-white transition duration-300">Github</button></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; <?php echo date('Y'); ?> CropInsure. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <?php if (isset($_SESSION['login_error'])): ?>
        <div class="fixed bottom-4 right-4 bg-red-500 text-white px-6 py-3 rounded-md shadow-lg" id="error-message">
            <?php echo htmlspecialchars($_SESSION['login_error']); unset($_SESSION['login_error']); ?>
        </div>
        <script>
            setTimeout(function() {
                document.getElementById('error-message').style.display = 'none';
            }, 5000);
        </script>
    <?php endif; ?>

<script>
    const dropdownData = <?php echo json_encode($dropdownData, JSON_HEX_TAG); ?>;
    const isLoggedIn = <?php echo isset($_SESSION['user_farmer_id']) ? 'true' : 'false'; ?>;

    function updateSelectOptions(selectId, dataType, selectedValue) {
        const selectElement = document.getElementById(selectId);
        selectElement.innerHTML = `<option value="">SELECT ${dataType.toUpperCase()}</option>`;

        if (dropdownData[dataType] && dropdownData[dataType][selectedValue]) {
            const options = dropdownData[dataType][selectedValue];
            options.forEach(option => {
                const opt = document.createElement('option');
                opt.value = option;
                opt.textContent = option.toUpperCase();
                selectElement.appendChild(opt);
            });
        }
    }
    function validateForm(event) {
    event.preventDefault();
    let isValid = true;

    // Name validation
    const nameInput = document.getElementById('name');
    const nameError = document.getElementById('name_error');
    const nameRegex = /^[A-Za-z\s]{2,}$/;
    if (!nameRegex.test(nameInput.value)) {
        nameError.classList.remove('hidden');
        nameInput.classList.add('border-red-500');
        isValid = false;
    } else {
        nameError.classList.add('hidden');
        nameInput.classList.remove('border-red-500');
    }

    // Mobile number validation
    const mobileInput = document.getElementById('mobile_number');
    const mobileError = document.getElementById('mobile_error');
    const mobileRegex = /^\d{10}$/;
    if (!mobileRegex.test(mobileInput.value)) {
        mobileError.classList.remove('hidden');
        mobileInput.classList.add('border-red-500');
        isValid = false;
    } else {
        mobileError.classList.add('hidden');
        mobileInput.classList.remove('border-red-500');
    }

    // Age validation
    const ageInput = document.getElementById('age');
    const ageError = document.getElementById('age_error');
    const ageValue = parseInt(ageInput.value);
    if (isNaN(ageValue) || ageValue < 18 || ageValue > 100) {
        ageError.classList.remove('hidden');
        ageInput.classList.add('border-red-500');
        isValid = false;
    } else {
        ageError.classList.add('hidden');
        ageInput.classList.remove('border-red-500');
    }

    // Gender validation
    const genderInput = document.getElementById('gender');
    const genderError = document.getElementById('gender_error');
    if (genderInput.value === '') {
        genderError.classList.remove('hidden');
        genderInput.classList.add('border-red-500');
        isValid = false;
    } else {
        genderError.classList.add('hidden');
        genderInput.classList.remove('border-red-500');
    }

    // Generic text field validation (caste, farm_type, farm_category, id_type, state, district, subdistrict, village, address)
    const textFields = ['caste', 'farm_type', 'farm_category', 'id_type', 'state', 'district', 'subdistrict', 'village', 'address'];
    textFields.forEach(field => {
        const input = document.getElementById(field);
        const error = document.getElementById(`${field}_error`);
        if (input.value.length < 2) {
            error.classList.remove('hidden');
            input.classList.add('border-red-500');
            isValid = false;
        } else {
            error.classList.add('hidden');
            input.classList.remove('border-red-500');
        }
    });

    // Password validation
    const passwordInput = document.getElementById('password_input');
    const passwordError = document.getElementById('password_error');
    if (passwordInput.value.length < 8) {
        passwordError.classList.remove('hidden');
        passwordInput.classList.add('border-red-500');
        isValid = false;
    } else {
        passwordError.classList.add('hidden');
        passwordInput.classList.remove('border-red-500');
    }

    if (isValid) {
        document.getElementById('signup_form').submit();
    }
    return isValid;
}

// Real-time validation
document.getElementById('name').addEventListener('input', function() {
    const nameError = document.getElementById('name_error');
    const nameRegex = /^[A-Za-z\s]{2,}$/;
    if (!nameRegex.test(this.value) && this.value !== '') {
        nameError.classList.remove('hidden');
        this.classList.add('border-red-500');
    } else {
        nameError.classList.add('hidden');
        this.classList.remove('border-red-500');
    }
});

document.getElementById('mobile_number').addEventListener('input', function() {
    const mobileError = document.getElementById('mobile_error');
    const mobileRegex = /^\d{10}$/;
    if (!mobileRegex.test(this.value) && this.value !== '') {
        mobileError.classList.remove('hidden');
        this.classList.add('border-red-500');
    } else {
        mobileError.classList.add('hidden');
        this.classList.remove('border-red-500');
    }
});

document.getElementById('age').addEventListener('input', function() {
    const ageError = document.getElementById('age_error');
    const ageValue = parseInt(this.value);
    if ((isNaN(ageValue) || ageValue < 18 || ageValue > 100) && this.value !== '') {
        ageError.classList.remove('hidden');
        this.classList.add('border-red-500');
    } else {
        ageError.classList.add('hidden');
        this.classList.remove('border-red-500');
    }
});

document.getElementById('gender').addEventListener('change', function() {
    const genderError = document.getElementById('gender_error');
    if (this.value === '') {
        genderError.classList.remove('hidden');
        this.classList.add('border-red-500');
    } else {
        genderError.classList.add('hidden');
        this.classList.remove('border-red-500');
    }
});

['caste', 'farm_type', 'farm_category', 'id_type', 'state', 'district', 'subdistrict', 'village', 'address'].forEach(field => {
    document.getElementById(field).addEventListener('input', function() {
        const error = document.getElementById(`${field}_error`);
        if (this.value.length < 2 && this.value !== '') {
            error.classList.remove('hidden');
            this.classList.add('border-red-500');
        } else {
            error.classList.add('hidden');
            this.classList.remove('border-red-500');
        }
    });
});

document.getElementById('password_input').addEventListener('input', function() {
    const passwordError = document.getElementById('password_error');
    if (this.value.length < 8 && this.value !== '') {
        passwordError.classList.remove('hidden');
        this.classList.add('border-red-500');
    } else {
        passwordError.classList.add('hidden');
        this.classList.remove('border-red-500');
    }
});
    function updateSeasonOptions(modalPrefix, selectedCrop) {
        const districtSelect = document.getElementById(`${modalPrefix}_district_select`);
        const seasonSelect = document.getElementById(`${modalPrefix}_season_select`);
        const district = districtSelect.value;

        seasonSelect.innerHTML = '<option value="">SELECT SEASON</option>';

        if (dropdownData['seasons'][district] && dropdownData['seasons'][district][selectedCrop]) {
            const seasons = dropdownData['seasons'][district][selectedCrop];
            seasons.forEach(season => {
                const opt = document.createElement('option');
                opt.value = season;
                opt.textContent = season.toUpperCase();
                seasonSelect.appendChild(opt);
            });
        }
    }
    function togglePassword() {
        const passwordInput = document.getElementById("password_input");
        const eyeIcon = document.getElementById("eye_icon");

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            eyeIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a10.05 10.05 0 011.658-3.043m2.538-2.538A9.966 9.966 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.966 9.966 0 01-4.138 5.151M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />
            `;
        } else {
            passwordInput.type = "password";
            eyeIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            `;
        }
    }
    function apply_check(id) {
        if (isLoggedIn) {
            if(document.getElementById(id)){
                open_popup(id);
            }
        } else {
            alert('Kindly Login First');
        }
    }
    
    function ins_check(){
        if(isLoggedIn){
            window.open("<?php echo BASE_URL; ?>models/insurance_model.php", "_blank");
        }
        else{
            alert('kindly log in');
        }
    }
    
    function claim_check(){
        if(isLoggedIn){
            window.open("<?php echo BASE_URL?>views/ApplyClaim.php")
        }else{
            alert('kindly log in');
        }
    }

    function view_ins_check(){
        if(isLoggedIn){
            window.open("<?php echo BASE_URL?>models/my_insurance.php")
        }else{
            alert('kindly log in');
        }
    }
    function open_popup(id) {
        const modal = document.getElementById(id);
        const modalContent = document.getElementById(`${id}_content`);
        
        modal.classList.remove("hidden");
        modal.classList.add("flex");
        
        // Add animation
        setTimeout(() => {
            modalContent.classList.remove("scale-95", "opacity-0");
            modalContent.classList.add("scale-100", "opacity-100");
        }, 10);
    }

    function close_popup(id) {
        const modal = document.getElementById(id);
        const modalContent = document.getElementById(`${id}_content`);
        
        // Add closing animation
        modalContent.classList.remove("scale-100", "opacity-100");
        modalContent.classList.add("scale-95", "opacity-0");
        
        // Wait for animation to complete before hiding
        setTimeout(() => {
            modal.classList.add("hidden");
            modal.classList.remove("flex");
        }, 300);
    }

    function validateForm(modalPrefix) {
        const fields = ['state', 'district', 'crop', 'season'];
        for (let field of fields) {
            const select = document.getElementById(`${modalPrefix}_${field}_select`);
            if (!select.value) {
                alert(`Please select a ${field}.`);
                return false;
            }
        }
        const area = document.querySelector(`#${modalPrefix}_modal input[name='area']`);
        if (!area.value) {
            alert("Please enter an area.");
            return false;
        }
        return true;
    }
    function validateForm(event) {
    event.preventDefault();
    let isValid = true;

    // Mobile number validation
    const mobileInput = document.getElementById('mobile_number');
    const mobileError = document.getElementById('mobile_error');
    const mobileRegex = /^\d{10}$/;
    if (!mobileRegex.test(mobileInput.value)) {
        mobileError.classList.remove('hidden');
        mobileInput.classList.add('border-red-500');
        isValid = false;
    } else {
        mobileError.classList.add('hidden');
        mobileInput.classList.remove('border-red-500');
    }

    // Password validation
    const passwordInput = document.getElementById('password_input');
    const passwordError = document.getElementById('password_error');
    if (passwordInput.value.length < 8) {
        passwordError.classList.remove('hidden');
        passwordInput.classList.add('border-red-500');
        isValid = false;
    } else {
        passwordError.classList.add('hidden');
        passwordInput.classList.remove('border-red-500');
    }

    if (isValid) {
        document.getElementById('login_form').submit();
    }
    return isValid;
}

// Real-time validation
document.getElementById('mobile_number').addEventListener('input', function() {
    const mobileError = document.getElementById('mobile_error');
    const mobileRegex = /^\d{10}$/;
    if (!mobileRegex.test(this.value) && this.value !== '') {
        mobileError.classList.remove('hidden');
        this.classList.add('border-red-500');
    } else {
        mobileError.classList.add('hidden');
        this.classList.remove('border-red-500');
    }
});

document.getElementById('password_input').addEventListener('input', function() {
    const passwordError = document.getElementById('password_error');
    if (this.value.length < 8 && this.value !== '') {
        passwordError.classList.remove('hidden');
        this.classList.add('border-red-500');
    } else {
        passwordError.classList.add('hidden');
        this.classList.remove('border-red-500');
    }
});
</script>
</body>
</html>