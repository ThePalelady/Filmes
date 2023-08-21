<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Movie;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

Route::get('/', function () {
  return redirect()->route('home');
})->name('root');

Route::get('/movies', function (Request $req) {
  $query = Movie::query();
  $year = $req->input('year', false);
  $name = $req->input('name', false);
  $category = $req->input('category', 0);
  if ($year) {
    $query->where('year', $year);
  }
  if ($name) {
    $query->where('name', 'like', '%' . $name . '%');
  }
  if ($category > 0) {
    $query->whereHas('categories', function ($q) use ($category) {
      $q->where('category_id', $category);
    });
  }
  $movies = $query->get();
  $categories = Category::all();
  return view('movies.index', compact('movies', 'categories'));
})->name('home');


Route::post('/movies', function (Request $req) {
  $data = $req->validate([
    'name' => 'required|string',
    'synopsis' => 'required|string',
    'year' => 'required|integer',
    'cover_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    'trailer_link' => 'required|string',
    'categories' => 'array', // Ensure categories is an array
  ]);
  $coverImage = $req->file('cover_image')->store('movie_covers', 'public');
  $movie = Movie::create([
    'name' => $data['name'],
    'synopsis' => $data['synopsis'],
    'year' => $data['year'],
    'cover_image' => $coverImage,
    'trailer_link' => $data['trailer_link'],
  ]);
  if (!$movie) {
    return back()->withErrors(['error' => 'Failed to create movie']);
  }
  if (isset($data['categories'])) {
    $movie->categories()->sync($data['categories']);
  }
  return redirect()->route('home');
})->name('create');

Route::post('/categories', function (Request $req) {
  $data = $req->validate([
    'category_name' => 'required|string|unique:categories,name',
  ]);
  $categoryExists = Category::where('name', strtoupper($data['category_name']))->first();
  if ($categoryExists) {
    return back()->withErrors(['error' => 'Category already exists']);
  }
  $category = Category::create([
    'name' => strtoupper($data['category_name']),
  ]);
  if (!$category) {
    return back()->withErrors(['error' => 'Failed to create category']);
  }
  return redirect()->route('home');
})->name('createCategory');

Route::get('/movies/{movie}', function (Movie $movie) {
  $categories = Category::all();
  return view('movies.show', compact('movie', 'categories'));
})->name('show');

Route::put('/movies/{movie}', function (Request $req, Movie $movie) {
  $data = $req->validate([
    'name' => 'required|string',
    'synopsis' => 'required|string',
    'year' => 'required|integer',
    'categories' => 'array',
    'trailer_link' => 'required|string',
  ]);
  if ($req->hasFile('cover_image')) {
    $req->validate([
      'cover_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);
    Storage::disk('public')->delete($movie->cover_image);
    $coverImage = $req->file('cover_image')->store('movie_covers', 'public');
    $data['cover_image'] = $coverImage;
  }
  $movie->update($data);
  if (isset($data['categories'])) {
    $movie->categories()->sync($data['categories']);
  }
  return redirect("/movies/" . $movie->id);
})->name('update');

Route::delete('/movies/{movie}', function (Movie $movie) {
  Storage::disk('public')->delete($movie->cover_image);
  $movie->delete();
  return redirect()->route('home');
})->name('delete');

Route::get('/login', function () {
  return view('login');
})->name('loginPage');

Route::post('/login', function (Request $req) {
  $credentials = $req->only('email', 'password');
  if (Auth::attempt($credentials)) {
    return redirect()->route('home');
  }
  return back()->withErrors(['email' => 'Invalid credentials'])->onlyInput('email');
})->name('login');

Route::get('/logout', function () {
  Auth::logout();
  return redirect()->route('home');
})->name('logout');

Route::get('/register', function () {
  return view('register');
})->name('registerPage');

Route::post('/register', function (Request $req) {
  $data = $req->validate([
    'email' => 'required|string|email|max:255|unique:users',
    'password' => 'required|string|min:6',
  ]);
  $userExists = User::where('email', $data['email'])->first();
  if ($userExists) {
    return back()->withErrors(['email' => 'Email already exists'])->onlyInput('email');
  }
  $data['password'] = Hash::make($data['password']);
  $user = User::create($data);
  Auth::login($user);
  return redirect('/');
})->name('register');