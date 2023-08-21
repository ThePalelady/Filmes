<div class="form-group mb-6">
  <label for="trailer_link" class="text-white text-sm font-semibold">Trailer Link ID:</label>
  <div class="relative">
    <input type="text" id="trailer_link" name="trailer_link" value="{{ $previousValue }}" required
      class="bg-gray-800 text-white border border-gray-600 rounded-md py-2 pl-4 pr-10 focus:outline-none focus:ring-purple-400 focus:border-purple-400 dark:bg-gray-600 dark:text-gray-300 dark:border-gray-400">
    <a href="https://www.youtube.com/" target="_blank" class="absolute top-1/2 right-4 transform -translate-y-1/2 text-purple-500 hover:underline">
      Go to YouTube
    </a>
  </div>
  <button type="button" id="previewButton" class="mt-2 bg-purple-500 hover:bg-purple-700 text-white font-semibold py-2 px-4 rounded-md focus:outline-none w-full focus:shadow-outline-purple active:bg-purple-800">
    See Preview
  </button>
  <div class="mt-2 text-gray-300">
    <p class="text-sm">Ex: Use The Bold ID to open Star Wars: The Last Jedi Trailer:</p>
    <p class="text-sm"><span class="font-semibold">https://www.youtube.com/watch?v=<b>Q0CbN8sfihY</b></span></p>
  </div>
</div>

<div id="trailerPreview"></div>

<script>
  const trailerLinkInput = document.getElementById('trailer_link');
  const previewButton = document.getElementById('previewButton');
  const trailerPreview = document.getElementById('trailerPreview');

  function showPreview() {
    const videoId = trailerLinkInput.value;
    if (!videoId) {
      trailerPreview.innerHTML = 'Provide the trailer link ID';
      return;
    }
    if (videoId) {
      trailerPreview.innerHTML = `<iframe width="560" height="315" src="https://www.youtube.com/embed/${videoId}" frameborder="0" allowfullscreen></iframe>`;
    }
  }

  previewButton.addEventListener('click', showPreview);
</script>