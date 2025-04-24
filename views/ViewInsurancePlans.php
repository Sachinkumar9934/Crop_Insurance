<?php
include 'C:/xampp/htdocs/crop_insurance/config/db_connect.php';
include 'C:/xampp/htdocs/crop_insurance/config/config.php';
// print_r($_SESSION['ins_plans']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="icon" type="image/x-icon" href="C.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insurance Plans - CropInsure</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen antialiased">
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
                        <a href="<?php echo BASE_URL; ?>models/profile_model.php" class="w-full block px-4 py-2 text-sm text-gray-700 hover:bg-green-100 hover:text-green-600">Profile</a>
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
        <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-xl transition-shadow duration-300">
            <h1 class="text-3xl font-bold text-gray-900 mb-6">My Insurance Plans</h1>

            <?php
            $insurance_data = $_SESSION['ins_plans'] ?? [];

            if (!empty($insurance_data)) {
            ?>
                <div class="overflow-x-auto">
                    <table class="w-full border-separate border-spacing-0 rounded-lg">
                        <thead>
                            <tr class="bg-green-700 text-white">
                                <th class="py-4 px-6 text-left text-sm font-semibold rounded-tl-lg">#</th>
                                <th class="py-4 px-6 text-left text-sm font-semibold">Plan ID</th>
                                <th class="py-4 px-6 text-left text-sm font-semibold">Crop Name</th>
                                <th class="py-4 px-6 text-left text-sm font-semibold">Area (acres)</th>
                                <th class="py-4 px-6 text-left text-sm font-semibold">Sum Insured</th>
                                <th class="py-4 px-6 text-left text-sm font-semibold rounded-tr-lg">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($insurance_data as $index => $plan) {
                                // Status badge logic
                                $status_text = intval($plan['status']) === 1 ? "&nbsp;&nbsp;Active&nbsp;&nbsp;" : "InActive";
                                $status_class = intval($plan['status']) === 1 ? "bg-green-500" : "bg-red-500";

                                echo "<tr class='border-b border-gray-200 hover:bg-gray-50 transition-colors duration-150'>";
                                echo "<td class='py-4 px-6 text-gray-700'>" . ($index + 1) . "</td>";
                                echo "<td class='py-4 px-6 font-semibold text-gray-900'>" . htmlspecialchars($plan['insurance_plan_id']) . "</td>";
                                echo "<td class='py-4 px-6 text-gray-700'>" . htmlspecialchars($plan['crop_name']) . "</td>";
                                echo "<td class='py-4 px-6 text-gray-700'>" . htmlspecialchars($plan['area']) . " acres</td>";
                                echo "<td class='py-4 px-6 text-gray-700'>₹" . number_format($plan['sum_insured'], 2) . "</td>";
                                echo "<td class='py-4 px-6'><span class='px-3 py-1 text-white text-sm font-semibold rounded-full $status_class'>$status_text</span></td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            <?php
            } else {
            ?>
                <div class="bg-amber-50 border-l-4 border-amber-500 text-amber-800 p-6 rounded-lg">
                    <h3 class="text-xl font-semibold mb-2">No insurance plans found.</h3>
                    <p class="text-amber-700">You have not registered for any insurance plans yet.</p>
                    <div class="mt-4">
                        <a href="<?php echo BASE_URL; ?>views/HomePage.php" 
                           class="inline-block px-4 py-2 bg-amber-500 text-white rounded-lg hover:bg-amber-600 hover:shadow-md transform hover:-translate-y-0.5 transition-all duration-300">
                            Apply for Insurance
                        </a>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
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
</html>