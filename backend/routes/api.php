<?php

use Illuminate\Http\Request;
use Illuminate\Support\FacadesRoute;

/*
|--------------------------------------------------------------------------
| API V1 Routes
|--------------------------------------------------------------------------
| Here you may register API routes for your application. These routes
| are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|*/

Route::prefix('v1')->group(function () {
    // Health check
    Route::get('/health', function () {
        return response()->json([
            'data' => ['status' => 'ok'],
            'message' => 'MISADA API is running.',
        ]);
    });

    // Admin authentication routes
    Route::post('/admin/login', function (Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (! auth()->attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Kredensial tidak valid'], 401);
        }

        $user = $request->user();
        $token = $user->createToken('admin-token')->plainTextToken;

        return response()->json([
            'data' => [
                'user' => $user,
                'token' => $token,
            ],
            'message' => 'Login berhasil',
        ]);
    })->withoutMiddleware(['auth:sanctum']);

    // Admin (authenticated)
    Route::get('/admin/me', function (Request $request) {
        return response()->json(['data' => $request->user()]);
    })->middleware('auth:sanctum');

    // Settings
    Route::get('/settings', function () {
        $settings = App\Models\WebsiteSetting::allowlist()->get();

        return response()->json(['data' => $settings->keyBy('key')->toArray()]);
    });

    // Home - returns all home content in one response
    Route::get('/home', function () {
        $settings = App\Models\WebsiteSetting::allowlist()->pluck('value', 'key')->toArray();

        $news = App\Models\News::published()
            ->latest()
            ->take(6)
            ->get()
            ->map(fn($n) => new App\Http\Resources\NewsResource($n));

        $announcements = App\Models\Announcement::published()
            ->whereNull('expires_at')
            ->orWhere('expires_at', '>', now())
            ->latest()
            ->take(3)
            ->get()
            ->map(fn($a) => new App\Http\Resources\AnnouncementResource($a));

        $events = App\Models\Event::published()
            ->latest()
            ->take(3)
            ->get()
            ->map(fn($e) => new App\Http\Resources\EventResource($e));

        $galleries = App\Models\Gallery::published()
            ->latest()
            ->take(3)
            ->get()
            ->map(fn($g) => new App\Http\Resources\GalleryResource($g));

        $facilities = App\Models\Facility::published()
            ->latest()
            ->take(3)
            ->get()
            ->map(fn($f) => new App\Http\Resources\FacilityResource($f));

        $teachers = App\Models\Teacher::published()
            ->latest()
            ->take(3)
            ->get()
            ->map(fn($t) => new App\Http\Resources\TeacherResource($t));

        return response()->json(['data' => [
            'settings' => $settings,
            'news' => $news,
            'announcements' => $announcements,
            'events' => $events,
            'galleries' => $galleries,
            'facilities' => $facilities,
            'teachers' => $teachers,
        ]]);
    });

    // Pages
    Route::get('/pages/{slug}', function (string $slug) {
        $page = App\Models\Page::where('slug', $slug)->where('status', 'published')->first();

        if (! $page) {
            return response()->json(['message' => 'Halaman tidak ditemukan'], 404);
        }

        return response()->json(['data' => new App\Http\Resources\PageResource($page)]);
    });

    // News categories
    Route::get('/news-categories', function () {
        $categories = App\Models\NewsCategory::all();

        return response()->json(['data' => $categories]);
    });

    // News listing with pagination and filtering
    Route::get('/news', function (Request $request) {
        $query = App\Models\News::published();

        $page = $request->query('page', 1);
        $perPage = $request->query('per_page', 12);
        $search = $request->query('q');
        $categorySlug = $request->query('category');

        if ($categorySlug) {
            $query->whereHas('category', function ($Q) use ($categorySlug) {
                $Q->where('slug', $categorySlug);
            });
        }

        if ($search) {
            $query->where(function ($Q) use ($search) {
                $Q->where('title', 'like', '%' . $search . '%')
                    ->orWhere('summary', 'like', '%' . $search . '%');
            });
        }

        $query->orderBy('published_at', 'desc');

        $news = $query->paginate(($perPage > 50 ? 50 : $perPage), ['*'], 'page', $page);

        return response()->json(['data' => App\Http\Resources\NewsResource::collection($news), 'meta' => [
            'current_page' => $news->currentPage(),
            'per_page' => $news->perPage(),
            'total' => $news->total(),
            'last_page' => $news->lastPage(),
        ]]);
    });

    // News detail by slug
    Route::get('/news/{slug}', function (string $slug) {
        $news = App\Models\News::where('slug', $slug)->whereHas('category', function ($q) {
            $q->where('status', 'published');
        })->published()->first();

        if (! $news) {
            return response()->json(['message' => 'Berita tidak ditemukan'], 404);
        }

        return response()->json(['data' => new App\Http\Resources\NewsResource($news)]);
    });

    // Announcements listing
    Route::get('/announcements', function (Request $request) {
        $query = App\Models\Announcement::published();

        $page = $request->query('page', 1);
        $perPage = $request->query('per_page', 12);

        $announcements = $query->paginate(($perPage > 50 ? 50 : $perPage), ['*'], 'page', $page);

        return response()->json(['data' => App\Http\Resources\AnnouncementResource::collection($announcements), 'meta' => [
            'current_page' => $announcements->currentPage(),
            'per_page' => $announcements->perPage(),
            'total' => $announcements->total(),
            'last_page' => $announcements->lastPage(),
        ]]);
    });

    // Announcement detail by slug
    Route::get('/announcements/{slug}', function (string $slug) {
        $announcement = App\Models\Announcement::where('slug', $slug)->published()->first();

        if (! $announcement) {
            return response()->json(['message' => 'Pengumuman tidak ditemukan'], 404);
        }

        return response()->json(['data' => new App\Http\Resources\AnnouncementResource($announcement)]);
    });

    // Events listing
    Route::get('/events', function (Request $request) {
        $query = App\Models\Event::published();

        $page = $request->query('page', 1);
        $perPage = $request->query('per_page', 12);

        $events = $query->paginate(($perPage > 50 ? 50 : $perPage), ['*'], 'page', $page);

        return response()->json(['data' => App\Http\Resources\EventResource::collection($events), 'meta' => [
            'current_page' => $events->currentPage(),
            'per_page' => $events->perPage(),
            'total' => $events->total(),
            'last_page' => $events->lastPage(),
        ]]);
    });

    // Event detail by slug
    Route::get('/events/{slug}', function (string $slug) {
        $event = App\Models\Event::where('slug', $slug)->published()->first();

        if (! $event) {
            return response()->json(['message' => 'Agenda tidak ditemukan'], 404);
        }

        return response()->json(['data' => new App\Http\Resources\EventResource($event)]);
    });

    // Gallery listing
    Route::get('/gallery', function (Request $request) {
        $query = App\Models\Gallery::published();

        $page = $request->query('page', 1);
        $perPage = $request->query('per_page', 12);

        $galleries = $query->paginate(($perPage > 50 ? 50 : $perPage), ['*'], 'page', $page);

        return response()->json(['data' => App\Http\Resources\GalleryResource::collection($galleries), 'meta' => [
            'current_page' => $galleries->currentPage(),
            'per_page' => $galleries->perPage(),
            'total' => $galleries->total(),
            'last_page' => $galleries->lastPage(),
        ]]);
    });

    // Gallery detail by slug
    Route::get('/gallery/{slug}', function (string $slug) {
        $gallery = App\Models\Gallery::where('slug', $slug)->where('status', 'published')->first();

        if (! $gallery) {
            return response()->json(['message' => 'Galeri tidak ditemukan'], 404);
        }

        return response()->json(['data' => new App\Http\Resources\GalleryResource($gallery)]);
    });

    // Facilities listing
    Route::get('/facilities', function (Request $request) {
        $query = App\Models\Facility::published();

        $page = $request->query('page', 1);
        $perPage = $request->query('per_page', 12);

        $facilities = $query->paginate(($perPage > 50 ? 50 : $perPage), ['*'], 'page', $page);

        return response()->json(['data' => App\Http\Resources\FacilityResource::collection($facilities), 'meta' => [
            'current_page' => $facilities->currentPage(),
            'per_page' => $facilities->perPage(),
            'total' => $facilities->total(),
            'last_page' => $facilities->lastPage(),
        ]]);
    });

    // Teachers listing
    Route::get('/teachers', function (Request $request) {
        $query = App\Models\Teacher::published();

        $page = $request->query('page', 1);
        $perPage = $request->query('per_page', 18);

        $teachers = $query->paginate(($perPage > 50 ? 50 : $perPage), ['*'], 'page', $page);

        return response()->json(['data' => App\Http\Resources\TeacherResource::collection($teachers), 'meta' => [
            'current_page' => $teachers->currentPage(),
            'per_page' => $teachers->perPage(),
            'total' => $teachers->total(),
            'last_page' => $teachers->lastPage(),
        ]]);
    });

    // ==================== ADMIN CRUD ROUTES ====================

    // Admin News CRUD
    Route::middleware('auth:sanctum')->group(function () {
        // News
        Route::get('/admin/news', function () {
            return App\Models\News::with('category')->latest()->get()->map(fn($n) => new App\Http\Resources\NewsResource($n));
        });
        Route::post('/admin/news', function (Request $request) {
            $request->validate([
                'title' => 'required|string',
                'slug' => 'required|string|unique:news,slug',
                'summary' => 'nullable|string',
                'body' => 'required|string',
                'category_id' => 'nullable|exists:news_categories,id',
                'status' => 'nullable|in:draft,published',
            ]);

            $news = App\Models\News::create([
                'title' => $request->title,
                'slug' => $request->slug,
                'summary' => $request->summary,
                'body' => $request->body,
                'category_id' => $request->category_id,
                'author_id' => auth()->id(),
                'status' => $request->status ?? 'draft',
            ]);

            return response()->json(['data' => new App\Http\Resources\NewsResource($news)], 201);
        });
        Route::put('/admin/news/{id}', function (Request $request, $id) {
            $request->validate([
                'title' => 'sometimes|required|string',
                'slug' => 'sometimes|required|string|unique:news,slug,' . $id,
                'summary' => 'nullable|string',
                'body' => 'sometimes|required|string',
                'category_id' => 'nullable|exists:news_categories,id',
                'status' => 'nullable|in:draft,published',
            ]);

            $news = App\Models\News::findOrFail($id);
            $news->update($request->only(['title', 'slug', 'summary', 'body', 'category_id', 'status']));

            return response()->json(['data' => new App\Http\Resources\NewsResource($news)]);
        });
        Route::delete('/admin/news/{id}', function ($id) {
            App\Models\News::findOrFail($id)->delete();

            return response()->json(['message' => 'Berita dihapus']);
        });

        // News Categories
        Route::get('/admin/news-categories', function () {
            return App\Models\NewsCategory::latest()->get();
        });
        Route::post('/admin/news-categories', function (Request $request) {
            $request->validate(['name' => 'required|string', 'slug' => 'required|string|unique:news_categories,slug']);

            return response()->json(['data' => App\Models\NewsCategory::create($request->only(['name', 'slug']))], 201);
        });

        // Announcements
        Route::get('/admin/announcements', function () {
            return App\Models\Announcement::latest()->get()->map(fn($a) => new App\Http\Resources\AnnouncementResource($a));
        });
        Route::post('/admin/announcements', function (Request $request) {
            $request->validate([
                'title' => 'required|string',
                'slug' => 'required|string|unique:announcements,slug',
                'summary' => 'nullable|string',
                'body' => 'required|string',
                'status' => 'nullable|in:draft,published',
                'expires_at' => 'nullable|date',
            ]);

            $announcement = App\Models\Announcement::create([
                'title' => $request->title,
                'slug' => $request->slug,
                'summary' => $request->summary,
                'body' => $request->body,
                'status' => $request->status ?? 'draft',
                'expires_at' => $request->expires_at,
            ]);

            return response()->json(['data' => new App\Http\Resources\AnnouncementResource($announcement)], 201);
        });
        Route::put('/admin/announcements/{id}', function (Request $request, $id) {
            $request->validate([
                'title' => 'sometimes|required|string',
                'slug' => 'sometimes|required|string|unique:announcements,slug,' . $id,
                'summary' => 'nullable|string',
                'body' => 'sometimes|required|string',
                'status' => 'nullable|in:draft,published',
                'expires_at' => 'nullable|date',
            ]);

            $announcement = App\Models\Announcement::findOrFail($id);
            $announcement->update($request->only(['title', 'slug', 'summary', 'body', 'status', 'expires_at']));

            return response()->json(['data' => new App\Http\Resources\AnnouncementResource($announcement)]);
        });
        Route::delete('/admin/announcements/{id}', function ($id) {
            App\Models\Announcement::findOrFail($id)->delete();

            return response()->json(['message' => 'Pengumuman dihapus']);
        });

        // Events
        Route::get('/admin/events', function () {
            return App\Models\Event::latest()->get()->map(fn($e) => new App\Http\Resources\EventResource($e));
        });
        Route::post('/admin/events', function (Request $request) {
            $request->validate([
                'title' => 'required|string',
                'slug' => 'required|string|unique:events,slug',
                'summary' => 'nullable|string',
                'body' => 'required|string',
                'starts_at' => 'required|date',
                'ends_at' => 'nullable|date',
                'location' => 'nullable|string',
                'registration_url' => 'nullable|url',
                'status' => 'nullable|in:draft,published',
            ]);

            $event = App\Models\Event::create([
                'title' => $request->title,
                'slug' => $request->slug,
                'summary' => $request->summary,
                'body' => $request->body,
                'starts_at' => $request->starts_at,
                'ends_at' => $request->ends_at,
                'location' => $request->location,
                'registration_url' => $request->registration_url,
                'status' => $request->status ?? 'draft',
            ]);

            return response()->json(['data' => new App\Http\Resources\EventResource($event)], 201);
        });
        Route::put('/admin/events/{id}', function (Request $request, $id) {
            $request->validate([
                'title' => 'sometimes|required|string',
                'slug' => 'sometimes|required|string|unique:events,slug,' . $id,
                'summary' => 'nullable|string',
                'body' => 'sometimes|required|string',
                'starts_at' => 'sometimes|required|date',
                'ends_at' => 'nullable|date',
                'location' => 'nullable|string',
                'registration_url' => 'nullable|url',
                'status' => 'nullable|in:draft,published',
            ]);

            $event = App\Models\Event::findOrFail($id);
            $event->update($request->only(['title', 'slug', 'summary', 'body', 'starts_at', 'ends_at', 'location', 'registration_url', 'status']));

            return response()->json(['data' => new App\Http\Resources\EventResource($event)]);
        });
        Route::delete('/admin/events/{id}', function ($id) {
            App\Models\Event::findOrFail($id)->delete();

            return response()->json(['message' => 'Agenda dihapus']);
        });

        // Galleries
        Route::get('/admin/galleries', function () {
            return App\Models\Gallery::with('items')->latest()->get()->map(fn($g) => new App\Http\Resources\GalleryResource($g));
        });
        Route::post('/admin/galleries', function (Request $request) {
            $request->validate([
                'title' => 'required|string',
                'slug' => 'required|string|unique:galleries,slug',
                'description' => 'nullable|string',
                'status' => 'nullable|in:draft,published',
            ]);

            $gallery = App\Models\Gallery::create([
                'title' => $request->title,
                'slug' => $request->slug,
                'description' => $request->description,
                'status' => $request->status ?? 'draft',
            ]);

            return response()->json(['data' => new App\Http\Resources\GalleryResource($gallery)], 201);
        });
        Route::put('/admin/galleries/{id}', function (Request $request, $id) {
            $request->validate([
                'title' => 'sometimes|required|string',
                'slug' => 'sometimes|required|string|unique:galleries,slug,' . $id,
                'description' => 'sometimes|nullable|string',
                'status' => 'sometimes|nullable|in:draft,published',
            ]);

            $gallery = App\Models\Gallery::findOrFail($id);
            $gallery->update($request->only(['title', 'slug', 'description', 'status']));

            return response()->json(['data' => new App\Http\Resources\GalleryResource($gallery)]);
        });
        Route::delete('/admin/galleries/{id}', function ($id) {
            App\Models\Gallery::findOrFail($id)->delete();

            return response()->json(['message' => 'Galeri dihapus']);
        });

        // Gallery Items
        Route::get('/admin/gallery-items', function () {
            return App\Models\GalleryItem::with('gallery')->latest()->get()->map(fn($i) => new App\Http\Resources\GalleryItemResource($i));
        });
        Route::post('/admin/gallery-items', function (Request $request) {
            $request->validate([
                'gallery_id' => 'required|exists:galleries,id',
                'display_order' => 'required|integer',
                'image_path' => 'nullable|image|max:10240', // 10MB max
                'video_url' => 'nullable|url',
                'alt_text' => 'nullable|string',
                'caption' => 'nullable|string',
            ]);

            $imagePath = null;
            if ($request->hasFile('image_path')) {
                $path = $request->file('image_path')->store('gallery-items', 'public');
                $imagePath = '/storage/' . $path;
            }

            $item = App\Models\GalleryItem::create([
                'gallery_id' => $request->gallery_id,
                'display_order' => $request->display_order,
                'image_path' => $imagePath,
                'video_url' => $request->video_url,
                'alt_text' => $request->alt_text,
                'caption' => $request->caption,
            ]);

            return response()->json(['data' => new App\Http\Resources\GalleryItemResource($item)], 201);
        });
        Route::delete('/admin/gallery-items/{id}', function ($id) {
            App\Models\GalleryItem::findOrFail($id)->delete();

            return response()->json(['message' => 'Item galeri dihapus']);
        });

        // Facilities
        Route::get('/admin/facilities', function () {
            return App\Models\Facility::latest()->get()->map(fn($f) => new App\Http\Resources\FacilityResource($f));
        });
        Route::post('/admin/facilities', function (Request $request) {
            $request->validate([
                'name' => 'required|string',
                'slug' => 'required|string|unique:facilities,slug',
                'description' => 'nullable|string',
                'image_path' => 'nullable|image|max:10240',
                'alt_text' => 'nullable|string',
                'display_order' => 'required|integer',
                'status' => 'nullable|in:draft,published',
            ]);

            $imagePath = null;
            if ($request->hasFile('image_path')) {
                $path = $request->file('image_path')->store('facilities', 'public');
                $imagePath = '/storage/' . $path;
            }

            $facility = App\Models\Facility::create([
                'name' => $request->name,
                'slug' => $request->slug,
                'description' => $request->description,
                'image_path' => $imagePath,
                'alt_text' => $request->alt_text,
                'display_order' => $request->display_order,
                'status' => $request->status ?? 'draft',
            ]);

            return response()->json(['data' => new App\Http\Resources\FacilityResource($facility)], 201);
        });
        Route::put('/admin/facilities/{id}', function (Request $request, $id) {
            $request->validate([
                'name' => 'sometimes|required|string',
                'slug' => 'sometimes|required|string|unique:facilities,slug,' . $id,
                'description' => 'sometimes|nullable|string',
                'image_path' => 'sometimes|nullable|image|max:10240',
                'alt_text' => 'nullable|string',
                'display_order' => 'sometimes|integer',
                'status' => 'sometimes|nullable|in:draft,published',
            ]);

            $facility = App\Models\Facility::findOrFail($id);
            $data = $request->only(['name', 'slug', 'description', 'display_order', 'status']);

            if ($request->hasFile('image_path')) {
                $path = $request->file('image_path')->store('facilities', 'public');
                $data['image_path'] = '/storage/' . $path;
            } elseif ($request->filled('image_path')) {
                $data['image_path'] = $request->image_path;
            }

            $facility = App\Models\Facility::findOrFail($id);
            $facility->update($data);

            return response()->json(['data' => new App\Http\Resources\FacilityResource($facility)]);
        });
        Route::delete('/admin/facilities/{id}', function ($id) {
            App\Models\Facility::findOrFail($id)->delete();

            return response()->json(['message' => 'Fasilitas dihapus']);
        });

        // Teachers
        Route::get('/admin/teachers', function () {
            return App\Models\Teacher::latest()->get()->map(fn($t) => new App\Http\Resources\TeacherResource($t));
        });
        Route::post('/admin/teachers', function (Request $request) {
            $request->validate([
                'name' => 'required|string',
                'role' => 'nullable|string',
                'biography' => 'nullable|string',
                'photo_path' => 'nullable|image|max:10240',
                'photo_alt' => 'nullable|string',
                'display_order' => 'required|integer',
                'status' => 'nullable|in:draft,published',
            ]);

            $imagePath = null;
            if ($request->hasFile('photo_path')) {
                $path = $request->file('photo_path')->store('teachers', 'public');
                $imagePath = '/storage/' . $path;
            }

            $teacher = App\Models\Teacher::create([
                'name' => $request->name,
                'role' => $request->role,
                'biography' => $request->biography,
                'photo_path' => $imagePath,
                'photo_alt' => $request->photo_alt,
                'display_order' => $request->display_order,
                'status' => $request->status ?? 'draft',
            ]);

            return response()->json(['data' => new App\Http\Resources\TeacherResource($teacher)], 201);
        });
        Route::put('/admin/teachers/{id}', function (Request $request, $id) {
            $request->validate([
                'name' => 'sometimes|required|string',
                'role' => 'sometimes|nullable|string',
                'biography' => 'sometimes|nullable|string',
                'photo_path' => 'sometimes|nullable|image|max:10240',
                'photo_alt' => 'nullable|string',
                'display_order' => 'sometimes|integer',
                'status' => 'sometimes|nullable|in:draft,published',
            ]);

            $teacher = App\Models\Teacher::findOrFail($id);
            $data = $request->only(['name', 'role', 'biography', 'display_order', 'status']);

            if ($request->hasFile('photo_path')) {
                $path = $request->file('photo_path')->store('teachers', 'public');
                $data['photo_path'] = '/storage/' . $path;
            } elseif ($request->filled('photo_path')) {
                $data['photo_path'] = $request->photo_path;
            }

            if ($request->filled('photo_alt')) {
                $data['photo_alt'] = $request->photo_alt;
            }

            $teacher->update($data);

            return response()->json(['data' => new App\Http\Resources\TeacherResource($teacher)]);
        });
        Route::delete('/admin/teachers/{id}', function ($id) {
            App\Models\Teacher::findOrFail($id)->delete();

            return response()->json(['message' => 'Guru dihapus']);
        });

        // Website Settings
        Route::get('/admin/settings', function () {
            return App\Models\WebsiteSetting::latest()->get()->map(fn($s) => new App\Http\Resources\WebsiteSettingResource($s));
        });
        Route::post('/admin/settings', function (Request $request) {
            $request->validate([
                'key' => 'required|string|unique:website_settings,key',
                'value' => 'required|json',
            ]);

            $setting = App\Models\WebsiteSetting::create([
                'key' => $request->key,
                'value' => json_encode($request->value),
            ]);

            return response()->json(['data' => new App\Http\Resources\WebsiteSettingResource($setting)], 201);
        });
        Route::put('/admin/settings/{id}', function (Request $request, $id) {
            $request->validate([
                'key' => 'sometimes|required|string|unique:website_settings,key,' . $id,
                'value' => 'sometimes|required|json',
            ]);

            $setting = App\Models\WebsiteSetting::findOrFail($id);
            $setting->update([
                'key' => $request->key,
                'value' => json_encode($request->value),
            ]);

            return response()->json(['data' => new App\Http\Resources\WebsiteSettingResource($setting)]);
        });
        Route::delete('/admin/settings/{id}', function ($id) {
            App\Models\WebsiteSetting::findOrFail($id)->delete();

            return response()->json(['message' => 'Pengaturan dihapus']);
        });
    });
});