<?php
include 'C:/xampp/htdocs/crop_insurance/config/db_connect.php';
include 'C:/xampp/htdocs/crop_insurance/config/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login - CropInsure</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-lg p-8 w-full max-w-md">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900">CropInsure Admin</h1>
            <p class="text-gray-600 mt-2">Login to manage insurance operations</p>
        </div>

        <!-- Dummy Login Fields (non-functional) -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Admin Username</label>
            <input type="text" name="admin_username" placeholder="Enter Admin ID" value="admin123" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <input type="password" name="password" placeholder="Enter Password" value="password123" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
        </div>

        <!-- Dummy Login Button -->
        <button onclick="go()" class="w-full p-3 bg-green-500 text-white rounded-md hover:bg-green-600 transition duration-300 font-medium">Login</button>

        <!-- Optional Dummy Error -->
        <div class="mt-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-md" id="error-message">
            Invalid username or password.
        </div>

        <script>
            setTimeout(function () {
                document.getElementById('error-message').style.display = 'none';
            }, 5000);

            function go() {
                window.location.href = "<?php echo BASE_URL ?>views/admin/Dashboard.php";
            }
        </script>
    </div>
</body>
</html>
