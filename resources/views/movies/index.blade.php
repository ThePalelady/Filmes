<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Movie Filter</title>
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="text-white bg-black">
  @include('errors')
  <div class="min-h-full">
    @include('header', ['isAdmin' => $isAdmin])
    <main class="mx-auto max-w-[85%] py-6 sm:px-6 lg:px-8">
      <div class="flex flex-col md:flex-row items-start gap-4">
        <div class="w-full md:w-[20%]">
          <h3 class="text-2xl">Filter</h3>
          <form action="{{ route('home') }}" method="get" class="shadow-md rounded-md-8 pt-6 pb-8 mb-4">
            <div class="flex flex-col gap-2">
              <label class="block text-sm font-bold" for="year">
                Year:
              </label>
              <input
                class="shadow appearance-none border rounded-md-full py-1 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                type="number" min="1900" max="2023" name="year" id="year" value="{{ request('year') }}">
              <label class="block text-sm font-bold" for="name">
                Name:
              </label>
              <input
                class="shadow appearance-none border rounded-md-full py-1 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                type="text" name="name" id="name" value="{{ request('name') }}">
              <label class="block text-sm font-bold mt-2" for="category">
                Categories:
              </label>
              <div class="flex items-center justify-center md:flex-col md:items-stretch  space-y-2">
                <a href="{{ route('home') }}"
                  class="px-3 py-1 rounded-md border border-thin border-gray-800 text-white hover:bg-gray-900 text-center">All</a>
                @foreach ($categories as $category)
                <a href="{{ route('home', ['category' => $category->id]) }}"
                  class="px-3 py-1 rounded-md border border-thin border-gray-800 text-white hover:bg-gray-900 text-center">{{
                  $category->name }}</a>
                @endforeach
              </div>
            </div>
            <button type="submit"
              class="bg-purple-500 mt-4 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded-md:outline-none focus:shadow-outline w-full">
              Search
            </button>
          </form>
        </div>

        <div class="flex flex-col flex-1">
          <h2 class="text-3xl mb-4">Movies</h2>
          <ul class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
            @if ($movies->count() === 0)
            <p class="text-gray-600">No movies found.</p>
            @else
            @foreach ($movies as $movie)
            <li class="flex flex-col gap-1 rounded-md shadow-md p-4 border border-purple-500">
              <h3 class="text-xl font-semibold">{{ $movie->name }}</h3>
              <p class="text-gray-300">
                <a href="{{ route('home', ['year' => $movie->year]) }}" class="text-gray-300 underline">
                  Year: {{ $movie->year }}
                </a>
              </p>
              <p>
                @if ($movie->categories->count() === 0)
                No categories.
                @endif
                @foreach ($movie->categories as $category)
                <a href="{{ route('home', ['category' => $category->id]) }}" class="text-gray-300 underline">
                  {{ $category->name }}
                </a>
                @if (!$loop->last)
                ,&nbsp;
                @endif
                @endforeach
              </p>
              <a href="{{ route('show', $movie->id) }}" class="mt-auto text-purple-500 hover:underline">View details</a>
            </li>
            @endforeach
            
            @endif
          </ul>
        </div>
      </div>
    </main>
  </div>



</body>

</html>