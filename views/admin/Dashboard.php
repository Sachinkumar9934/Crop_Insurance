<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Crop Insurance</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body {
            font-family: 'Inter', sans-serif;
        }
        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">
    <nav class="bg-gradient-to-r from-blue-600 to-blue-800 shadow-lg">
        <div class="container mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <a class="text-2xl font-semibold text-white" href="#">Admin Dashboard</a>
                <button class="text-white md:hidden focus:outline-none" onclick="toggleMenu()">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <div class="hidden md:flex space-x-6 items-center" id="navbar">
                    <a class="text-white font-medium hover:text-gray-200 transition" href="Dashboard.php">Dashboard</a>
                    <a class="text-white font-medium hover:text-gray-200 transition" href="ManageInsurance.php">Insurance Plans</a>
                    <a class="text-white font-medium hover:text-gray-200 transition" href="ManageClaims.php">Claims</a>
                    <a class="text-white font-medium hover:text-gray-200 transition" href="ManageUsers.php">Users</a>
                    <a class="text-white font-medium hover:text-gray-200 transition" href="Reports.php">Reports</a>
                    <a class="text-white font-medium hover:text-gray-200 transition" href="../logout.php">Logout</a>
                </div>
            </div>
            <!-- Mobile Menu -->
            <div class="md:hidden hidden flex-col space-y-2 mt-4" id="mobileMenu">
                <a class="text-white font-medium hover:text-gray-200 transition" href="Dashboard.php">Dashboard</a>
                <a class="text-white font-medium hover:text-gray-200 transition" href="ManageInsurance.php">Insurance Plans</a>
                <a class="text-white font-medium hover:text-gray-200 transition" href="ManageClaims.php">Claims</a>
                <a class="text-white font-medium hover:text-gray-200 transition" href="ManageUsers.php">Users</a>
                <a class="text-white font-medium hover:text-gray-200 transition" href="Reports.php">Reports</a>
                <a class="text-white font-medium hover:text-gray-200 transition" href="../logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-4 py-8">
        <h2 class="text-3xl font-semibold text-gray-900 mb-8">Dashboard Overview</h2>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white rounded-xl shadow-md card-hover p-6 text-center bg-gradient-to-br from-blue-500 to-blue-600 text-white">
                <h5 class="text-lg font-medium mb-2">Total Users</h5>
                <h2 class="text-3xl font-bold">150</h2>
            </div>
            <div class="bg-white rounded-xl shadow-md card-hover p-6 text-center bg-gradient-to-br from-green-500 to-green-600 text-white">
                <h5 class="text-lg font-medium mb-2">Active Policies</h5>
                <h2 class="text-3xl font-bold">85</h2>
            </div>
            <div class="bg-white rounded-xl shadow-md card-hover p-6 text-center bg-gradient-to-br from-yellow-400 to-yellow-500 text-gray-900">
                <h5 class="text-lg font-medium mb-2">Pending Claims</h5>
                <h2 class="text-3xl font-bold">12</h2>
            </div>
            <div class="bg-white rounded-xl shadow-md card-hover p-6 text-center bg-gradient-to-br from-cyan-500 to-cyan-600 text-white">
                <h5 class="text-lg font-medium mb-2">Total Revenue</h5>
                <h2 class="text-3xl font-bold">₹1,250,000</h2>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-8">
            <div class="bg-white rounded-xl shadow-md card-hover">
                <div class="bg-gray-50 px-6 py-4 rounded-t-xl border-b border-gray-200">
                    <h5 class="text-lg font-semibold text-gray-900">Recent Insurance Applications</h5>
                </div>
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="p-3 font-semibold text-gray-700">User</th>
                                    <th class="p-3 font-semibold text-gray-700">Plan</th>
                                    <th class="p-3 font-semibold text-gray-700">Date</th>
                                    <th class="p-3 font-semibold text-gray-700">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="p-3 text-gray-600">John Doe</td>
                                    <td class="p-3 text-gray-600">Crop Protect Plus</td>
                                    <td class="p-3 text-gray-600">2025-04-10</td>
                                    <td class="p-3 text-gray-600">Pending</td>
                                </tr>
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="p-3 text-gray-600">Jane Smith</td>
                                    <td class="p-3 text-gray-600">Basic Crop Cover</td>
                                    <td class="p-3 text-gray-600">2025-04-09</td>
                                    <td class="p-3 text-gray-600">Approved</td>
                                </tr>
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="p-3 text-gray-600">Ravi Kumar</td>
                                    <td class="p-3 text-gray-600">Premium Plan</td>
                                    <td class="p-3 text-gray-600">2025-04-08</td>
                                    <td class="p-3 text-gray-600">Rejected</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-md card-hover">
                <div class="bg-gray-50 px-6 py-4 rounded-t-xl border-b border-gray-200">
                    <h5 class="text-lg font-semibold text-gray-900">Recent Claims</h5>
                </div>
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="p-3 font-semibold text-gray-700">User</th>
                                    <th class="p-3 font-semibold text-gray-700">Amount</th>
                                    <th class="p-3 font-semibold text-gray-700">Date</th>
                                    <th class="p-3 font-semibold text-gray-700">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="p-3 text-gray-600">Alice Brown</td>
                                    <td class="p-3 text-gray-600">₹50,000</td>
                                    <td class="p-3 text-gray-600">2025-04-12</td>
                                    <td class="p-3 text-gray-600">Pending</td>
                                </tr>
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="p-3 text-gray-600">Bob Wilson</td>
                                    <td class="p-3 text-gray-600">₹75,000</td>
                                    <td class="p-3 text-gray-600">2025-04-11</td>
                                    <td class="p-3 text-gray-600">Approved</td>
                                </tr>
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="p-3 text-gray-600">Sita Sharma</td>
                                    <td class="p-3 text-gray-600">₹30,000</td>
                                    <td class="p-3 text-gray-600">2025-04-10</td>
                                    <td class="p-3 text-gray-600">Rejected</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleMenu() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('hidden');
        }
    </script>
</body>
</html>