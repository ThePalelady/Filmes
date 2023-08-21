<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
  <div class="flex h-16 items-center justify-between">
    <div class="flex items-center">
      <div class="flex-shrink-0">
        <a href="{{ route('home') }}" class="text-2xl">
          Choose<b class="text-3xl">PHP</b>Movies
        </a>
      </div>
      <div class="hidden md:block">
        <div class="ml-10 flex items-baseline space-x-4">
          @if (!auth()->check())
          <a href="{{ route('loginPage') }}" class="bg-gray-900 text-white rounded-md px-3 py-2 text-sm font-medium"
            aria-current="page">
            Login
          </a>
          <a href="{{ route('registerPage') }}"
            class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">
            Register
          </a>
          @endif
        </div>
      </div>
    </div>
    @if (auth()->check())
    <div class="flex items-center gap-4 relative ml-3">
      <p>
        Welcome, {{ auth()->user()->email }}!
        <a href="{{ route('logout') }}"
          class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">
          Logout
        </a>
      </p>

    </div>
    @endif

    @if ($isAdmin)
    <div class="flex items-center justify-center gap-4">
      <button id="addMovieButton">Add Movie</button>
      <button id="addCategoryButton">Add Category</button>
    </div>
    <div id="movieModal"
      class="modal hidden fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-75">
      <div class="bg-gray-900 p-4 rounded-md shadow-md md:w-[40%] overflow-y-scroll max-h-[80%]">
        <form id="movieForm" enctype="multipart/form-data" action="{{ route('create') }}" method="POST">
          @csrf
          <div class="mb-4">
            <label class="block text-white text-sm font-bold mb-2" for="name">Name:</label>
            <input type="text" id="name" name="name" required
              class="border rounded-md px-4 py-2 w-full bg-gray-800 text-white focus:outline-none focus:border-purple-500">
          </div>
          <div class="mb-4">
            <label class="block text-white text-sm font-bold mb-2" for="synopsis">Synopsis:</label>
            <textarea id="synopsis" name="synopsis" required
              class="border rounded-md px-4 py-2 w-full bg-gray-800 text-white focus:outline-none focus:border-purple-500"></textarea>
          </div>
          <div class="mb-4">
            <label class="block text-white text-sm font-bold mb-2" for="year">Year:</label>
            <input type="number" min="1900" max="2023" id="year" name="year" required
              class="border rounded-md px-4 py-2 w-full bg-gray-800 text-white focus:outline-none focus:border-purple-500">
          </div>

          <div class="mb-4">
            <label class="block text-white text-sm font-bold mb-2">Categories:</label>
            @if ($categories->count() === 0)
            <p class="text-gray-500">No categories found. Please add a category first.</p>
            @else
            @foreach ($categories as $category)
            <div class="mb-2 flex items-center">
              <input type="checkbox" id="category_{{ $category->id }}" name="categories[]" value="{{ $category->id }}"
                class="h-5 w-5 text-purple-500 border-gray-400 rounded-md focus:ring-purple-400 focus:border-purple-400 dark:bg-gray-800 dark:border-gray-600 dark:text-purple-500 dark:focus:ring-purple-400 dark:focus:border-purple-400">
              <label for="category_{{ $category->id }}" class="text-white ml-2">{{ $category->name }}</label>
            </div>
            @endforeach

            @endif
          </div>

          <div class="mb-4">
            <label class="block text-white text-sm font-bold mb-2" for="cover_image">Cover Image:</label>
            <input type="file" id="cover_image" name="cover_image" accept="image/*" required
              class="border rounded-md px-4 py-2 w-full bg-gray-800 text-white focus:outline-none focus:border-purple-500">
          </div>

          @include('preview', ['previousValue' => ''])

          <div class="flex justify-end">
            <button type="submit"
              class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded-md focus:outline-none focus:shadow-outline-purple active:bg-purple-800">Add</button>
          </div>
        </form>
      </div>
    </div>

    <div id="categoryModal"
      class="modal hidden fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-75">
      <div class="bg-gray-800 p-8 rounded-md shadow-md w-96">
        <form id="categoryForm" action="{{ route('createCategory') }}" method="POST">
          @csrf
          <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="category_name">Category
              Name:</label>
            <input type="text" id="category_name" name="category_name" required
              class="border rounded-md px-4 py-2 w-full focus:outline-none focus:border-purple-500 dark:bg-gray-700 dark:text-white">
          </div>
          <button type="submit"
            class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded-md focus:outline-none focus:shadow-outline-purple w-full active:bg-purple-800">Add
            Category</button>
        </form>
        <h2 class="mt-4 text-gray-700 dark:text-gray-300 text-lg font-semibold">Available Categories</h2>
        <ul>
          @if ($categories->count() === 0)
          <p class="text-gray-500 dark:text-gray-400">No categories found. Please add a category first.</p>
          @else
          @foreach ($categories as $category)
          <li class="text-gray-700 dark:text-gray-300">{{ $category->name }}</li>
          @endforeach
          @endif
        </ul>
      </div>
    </div>
    @endif
    <script>
      const addMovieButton = document.getElementById('addMovieButton');
      const movieModal = document.getElementById('movieModal');

      addMovieButton.addEventListener('click', () => {
        movieModal.classList.remove('hidden');
      });

      window.addEventListener('click', (event) => {
        if (event.target === movieModal) {
          movieModal.classList.add('hidden');
        }
      });

      const addCategoryButton = document.getElementById('addCategoryButton');
      const categoryModal = document.getElementById('categoryModal');

      addCategoryButton.addEventListener('click', () => {
        categoryModal.classList.remove('hidden');
      });

      window.addEventListener('click', (event) => {
        if (event.target === categoryModal) {
          categoryModal.classList.add('hidden');
        }
      });
    </script>

  </div>
</div>
