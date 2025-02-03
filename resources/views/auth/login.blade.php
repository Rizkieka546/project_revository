<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="flex items-center justify-center min-h-screen bg-gradient-to-r from-teal-500 to-indigo-600">
    <div class="w-full max-w-md p-8 bg-white rounded-xl shadow-lg">
        <h3 class="text-3xl font-bold text-center text-gray-700 mb-6">Login</h3>
        @if ($errors->has('login'))
            <div class="mb-4 p-3 text-red-700 bg-red-100 border border-red-400 rounded">
                {{ $errors->first('login') }}
            </div>
        @endif
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="username" class="block text-sm font-semibold text-gray-600">Username</label>
                <input type="text" name="username" id="username"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500"
                    required>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-semibold text-gray-600">Password</label>
                <input type="password" name="password" id="password"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500"
                    required>
            </div>
            <button type="submit"
                class="w-full bg-teal-600 text-white py-2 rounded-lg text-lg font-semibold hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-opacity-50 transition">Login</button>
        </form>
        <p class="text-sm text-gray-600 text-center mt-4">Belum punya akun? <a href="#"
                class="text-teal-600 font-semibold hover:underline">Daftar</a></p>
    </div>
</body>

</html>
