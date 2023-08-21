<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
  <!-- Include Tailwind CSS via CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-black text-white">
  @include('errors')
  @include('header', ['isAdmin' => false])
  <div class="container max-w-[40rem] mt-[4rem] mx-auto p-8">
    <h1 class="text-4xl font-semibold mb-6">Register</h1>
    <form method="POST" action="{{ route('register') }}" class="">
      @csrf
      <div class="mb-4">
        <label for="email" class="block text-lg font-medium mb-2">Email:</label>
        <input type="email" id="email" name="email" required
          class="w-full px-4 py-2 bg-gray-700 rounded-lg focus:outline-none focus:ring focus:border-purple-300">
      </div>
      <div class="mb-6">
        <label for="password" class="block text-lg font-medium mb-2">Password:</label>
        <input type="password" id="password" name="password" required
          class="w-full px-4 py-2 bg-gray-700 rounded-lg focus:outline-none focus:ring focus:border-purple-300">
      </div>
      <button type="submit"
        class="w-full bg-purple-500 hover:bg-purple-600 text-white font-semibold py-2 px-4 rounded-lg focus:outline-none focus:ring focus:border-purple-300 transition duration-300 ease-in-out">Register</button>
    </form>
  </div>
</body>

</html>