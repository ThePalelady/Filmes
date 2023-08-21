<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $movie->name }}</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-900 text-white">
  @include('header', ['isAdmin' => $isAdmin])
  <main class="mx-auto  py-6 sm:px-6 lg:px-8">
    <div class="movie-details grid grid-cols-1 md:grid-cols-2 gap-6">
      <!-- Movie Info Section -->
      <div class=" rounded-md shadow-lg">
        <div class="movie-detail">
          <h3 class="text-2xl font-bold">
            {{$movie->name}}
          </h3>
        </div>
        <div class="movie-detail">
          <h3 class="text-lg font-bold">Year:</h3>
          <p class="text-gray-400">{{ $movie->year }}</p>
        </div>
        <div class="movie-detail">
          <h3 class="text-lg font-bold">Synopsis:</h3>
          <p class="text-gray-400">{{ $movie->synopsis }}</p>
        </div>
        <div class="movie-detail">
          <h3 class="text-lg font-bold">Categories:</h3>
          <ul class="list-disc list-inside">
            @if ($movie->categories->count() === 0)
            <p class="text-gray-400">No categories found.</p>
            @else
            @foreach($movie->categories as $category)
            <li class="text-gray-400">{{ $category->name }}</li>
            @endforeach
            @endif
          </ul>
        </div>
        <div class="rounded-md shadow-lg mt-8">
          <iframe width="560" height="315" src="{{ 'https://www.youtube.com/embed/' . $movie->trailer_link }}"
            frameborder="0" allowfullscreen></iframe>
        </div>
        <!-- Edit and Delete Buttons -->
        @if ($isAdmin)
        <div class="mt-8">
          <button
            class="bg-purple-500 hover:bg-purple-700 text-white font-semibold py-2 px-4 rounded-md focus:outline-none focus:ring focus:ring-purple-300"
            id="editMovieButton">Edit</button>
          <form action="{{ route('delete', $movie) }}" method="POST" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit"
              class="bg-red-500 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-md focus:outline-none focus:ring focus:ring-red-300">Delete</button>
          </form>
        </div>

        <!-- Edit Movie Modal -->
        <div id="editMovieModal" class="modal hidden fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-75 m-0">
          <div class="bg-gray-900 p-8 rounded-md shadow-md md:w-[50%] overflow-y-scroll max-h-[80%]">
            <form action="{{ route('update', $movie) }}" method="POST" id="editMovieForm" enctype="multipart/form-data">
              @csrf
              @method('PUT')
              <div class="mb-4">
                <label for="editName" class="text-white font-bold">Name:</label>
                <input type="text" id="editName" name="name" value="{{ $movie->name }}" required
                  class="bg-gray-800 text-white border rounded-md px-4 py-2 w-full focus:outline-none focus:border-purple-500">
              </div>
              <div class="mb-4">
                <label for="editSynopsis" class="text-white font-bold">Synopsis:</label>
                <textarea id="editSynopsis" name="synopsis" required
                  class="bg-gray-800 text-white border rounded-md px-4 py-2 w-full focus:outline-none focus:border-purple-500">{{ $movie->synopsis }}</textarea>
              </div>
              <div class="mb-4">
                <label for="editYear" class="text-white font-bold">Year:</label>
                <input type="number" min="1900" max="2023" id="editYear" name="year" value="{{ $movie->year }}" required
                  class="bg-gray-800 text-white border rounded-md px-4 py-2 w-full focus:outline-none focus:border-purple-500">
              </div>
              <div class="mb-4">
                <label for="category" class="text-white font-bold">Categories:</label>
                @if ($categories->count() === 0)
                <p class="text-gray-500">No categories found. Please add a category first.</p>
                @else
                @foreach ($categories as $category)
                <div class="flex items-center gap-2 mb-2">
                  <input type="checkbox" id="category_{{ $category->id }}" name="categories[]"
                    value="{{ $category->id }}" class="h-5 w-5 text-purple-500 border-gray-400 rounded-md focus:ring-purple-400 focus:border-purple-400 dark:bg-gray-800 dark:border-gray-600 dark:text-purple-500 dark:focus:ring-purple-400 dark:focus:border-purple-400">
                  <label for="category_{{ $category->id }}" class="text-white">{{ $category->name }}</label>
                </div>
                @endforeach
                @endif
              </div>
              @include('preview', ['previousValue' => $movie->trailer_link])
              <div class="mb-4">
                <label for="editCoverImage" class="text-white">Cover Image:</label>
                <input type="file" id="editCoverImage" name="cover_image" accept="image/*"
                  class="bg-gray-800 text-white border rounded-md px-4 py-2 w-full focus:outline-none focus:border-purple-500">
              </div>
              <button type="submit"
                class="bg-purple-500 hover:bg-purple-700 text-white font-semibold py-2 px-4 rounded-md focus:outline-none focus:ring focus:ring-purple-300">Save</button>
            </form>
          </div>
        </div>

        @endif
      </div>

      <!-- Cover Image Section -->
      <div class="p-2 rounded-md shadow-lg">
        <img src="{{ asset('storage/' . $movie->cover_image) }}" alt="{{ $movie->name }} Cover"
          class="rounded-md max-h-screen">
      </div>
    </div>
  </main>

  <!-- JavaScript for modal handling -->
  <script>
    const editButton = document.getElementById('editMovieButton');
    const editModal = document.getElementById('editMovieModal');

    // Open the edit modal when clicking the "Edit" button
    editButton.addEventListener('click', () => {
      editModal.classList.remove('hidden');
    });

    // Close the modal when clicking outside of it
    window.addEventListener('click', (event) => {
      if (event.target === editModal) {
        editModal.classList.add('hidden');
      }
    });

  </script>
</body>

</html>
