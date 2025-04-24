<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports - Crop Insurance</title>
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
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
        }
        .nav-link {
            transition: color 0.2s ease, background-color 0.2s ease;
        }
        .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 0.375rem;
        }
        .status-positive {
            background-color: #10b981;
            color: white;
        }
        .status-negative {
            background-color: #ef4444;
            color: white;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-200 min-h-screen">
    <nav class="bg-gradient-to-r from-indigo-600 to-indigo-800 shadow-xl">
        <div class="container mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <a class="text-2xl font-bold text-white tracking-tight" href="#">CropInsure Admin</a>
                <button class="text-white md:hidden focus:outline-none" onclick="toggleMenu()">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <div class="hidden md:flex space-x-4 items-center" id="navbar">
                    <a class="text-white font-medium px-3 py-2 nav-link" href="Dashboard.php">Dashboard</a>
                    <a class="text-white font-medium px-3 py-2 nav-link" href="ManageInsurance.php">Insurance Plans</a>
                    <a class="text-white font-medium px-3 py-2 nav-link" href="ManageClaims.php">Claims</a>
                    <a class="text-white font-medium px-3 py-2 nav-link" href="ManageUsers.php">Users</a>
                    <a class="text-white font-medium px-3 py-2 nav-link bg-white bg-opacity-10 rounded-md" href="Reports.php">Reports</a>
                    <a class="text-white font-medium px-3 py-2 bg-red-500 hover:bg-red-600 rounded-md transition" href="../logout.php">Logout</a>
                </div>
            </div>
            <!-- Mobile Menu -->
            <div class="md:hidden hidden flex-col space-y-2 mt-4 pb-2" id="mobileMenu">
                <a class="text-white font-medium px-3 py-2 nav-link" href="Dashboard.php">Dashboard</a>
                <a class="text-white font-medium px-3 py-2 nav-link" href="ManageInsurance.php">Insurance Plans</a>
                <a class="text-white font-medium px-3 py-2 nav-link" href="ManageClaims.php">Claims</a>
                <a class="text-white font-medium px-3 py-2 nav-link" href="ManageUsers.php">Users</a>
                <a class="text-white font-medium px-3 py-2 nav-link bg-white bg-opacity-10 rounded-md" href="Reports.php">Reports</a>
                <a class="text-white font-medium px-3 py-2 bg-red-500 hover:bg-red-600 rounded-md transition" href="../logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Reports</h2>
            <a href="#" class="bg-indigo-600 text-white px-5 py-2.5 rounded-lg hover:bg-indigo-700 transition font-semibold text-sm shadow-md">Generate Report</a>
        </div>

        <!-- Reports Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
            <div class="bg-white rounded-2xl shadow-lg card-hover p-6 border border-gray-100">
                <h3 class="text-xl font-bold text-gray-900 mb-3">Revenue Overview</h3>
                <p class="text-gray-500 text-sm mb-4 leading-relaxed">Total revenue from insurance plans this quarter.</p>
                <div class="space-y-3 text-sm">
                    <p><span class="font-semibold text-gray-700">Total:</span> ₹1,250,000</p>
                    <p><span class="font-semibold text-gray-700">Change:</span> <span class="status-positive px-2 py-1 rounded-full text-xs font-medium">+12%</span></p>
                    <p><span class="font-semibold text-gray-700">Period:</span> Q1 2025</p>
                </div>
                <div class="mt-5">
                    <a href="#" class="text-indigo-600 hover:text-indigo-800 font-semibold text-sm">View Details</a>
                </div>
            </div>
            <div class="bg-white rounded-2xl shadow-lg card-hover p-6 border border-gray-100">
                <h3 class="text-xl font-bold text-gray-900 mb-3">User Activity</h3>
                <p class="text-gray-500 text-sm mb-4 leading-relaxed">New user registrations and activity trends.</p>
                <div class="space-y-3 text-sm">
                    <p><span class="font-semibold text-gray-700">New Users:</span> 45</p>
                    <p><span class="font-semibold text-gray-700">Change:</span> <span class="status-positive px-2 py-1 rounded-full text-xs font-medium">+8%</span></p>
                    <p><span class="font-semibold text-gray-700">Period:</span> April 2025</p>
                </div>
                <div class="mt-5">
                    <a href="#" class="text-indigo-600 hover:text-indigo-800 font-semibold text-sm">View Details</a>
                </div>
            </div>
            <div class="bg-white rounded-2xl shadow-lg card-hover p-6 border border-gray-100">
                <h3 class="text-xl font-bold text-gray-900 mb-3">Claims Processed</h3>
                <p class="text-gray-500 text-sm mb-4 leading-relaxed">Total claims processed and approval rates.</p>
                <div class="space-y-3 text-sm">
                    <p><span class="font-semibold text-gray-700">Processed:</span> 20</p>
                    <p><span class="font-semibold text-gray-700">Approval Rate:</span> <span class="status-negative px-2 py-1 rounded-full text-xs font-medium">65%</span></p>
                    <p><span class="font-semibold text-gray-700">Period:</span> April 2025</p>
                </div>
                <div class="mt-5">
                    <a href="#" class="text-indigo-600 hover:text-indigo-800 font-semibold text-sm">View Details</a>
                </div>
            </div>
        </div>

        <!-- Reports Table -->
        <div class="bg-white rounded-2xl shadow-lg card-hover border border-gray-100">
            <div class="bg-gray-50 px-6 py-5 rounded-t-2xl border-b border-gray-200">
                <h5 class="text-xl font-bold text-gray-900">Detailed Reports</h5>
            </div>
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="p-4 font-semibold text-gray-700">Report Type</th>
                                <th class="p-4 font-semibold text-gray-700">Metric</th>
                                <th class="p-4 font-semibold text-gray-700">Value</th>
                                <th class="p-4 font-semibold text-gray-700">Change</th>
                                <th class="p-4 font-semibold text-gray-700">Period</th>
                                <th class="p-4 font-semibold text-gray-700">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-4 text-gray-600">Revenue Overview</td>
                                <td class="p-4 text-gray-600">Total Revenue</td>
                                <td class="p-4 text-gray-600">₹1,250,000</td>
                                <td class="p-4"><span class="status-positive px-2 py-1 rounded-full text-xs font-medium">+12%</span></td>
                                <td class="p-4 text-gray-600">Q1 2025</td>
                                <td class="p-4">
                                    <a href="#" class="text-indigo-600 hover:text-indigo-800 mr-3 font-semibold text-sm">View</a>
                                    <a href="#" class="text-red-600 hover:text-red-800 font-semibold text-sm">Download</a>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-4 text-gray-600">User Activity</td>
                                <td class="p-4 text-gray-600">New Users</td>
                                <td class="p-4 text-gray-600">45</td>
                                <td class="p-4"><span class="status-positive px-2 py-1 rounded-full text-xs font-medium">+8%</span></td>
                                <td class="p-4 text-gray-600">April 2025</td>
                                <td class="p-4">
                                    <a href="#" class="text-indigo-600 hover:text-indigo-800 mr-3 font-semibold text-sm">View</a>
                                    <a href="#" class="text-red-600 hover:text-red-800 font-semibold text-sm">Download</a>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-4 text-gray-600">Claims Processed</td>
                                <td class="p-4 text-gray-600">Approval Rate</td>
                                <td class="p-4 text-gray-600">65%</td>
                                <td class="p-4"><span class="status-negative px-2 py-1 rounded-full text-xs font-medium">65%</span></td>
                                <td class="p-4 text-gray-600">April 2025</td>
                                <td class="p-4">
                                    <a href="#" class="text-indigo-600 hover:text-indigo-800 mr-3 font-semibold text-sm">View</a>
                                    <a href="#" class="text-red-600 hover:text-red-800 font-semibold text-sm">Download</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
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