@if ($errors->any())
  <div id="errorMessage" class="bg-red-700 text-white p-4 rounded-md shadow-md">
    <div class="flex items-center">
      <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M6 18L18 6M6 6l12 12"></path>
      </svg>
      <span class="font-semibold">Error:</span>
    </div>
    <ul class="mt-2 list-disc list-inside">
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
  @endif
<script>
  const errorMessage = document.getElementById('errorMessage');
  errorMessage.addEventListener('click', () => {
    errorMessage.remove();
  });
</script>