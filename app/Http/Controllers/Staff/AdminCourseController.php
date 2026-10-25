<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use App\Models\CourseModule;
use App\Models\Lesson;
use App\Models\User;
use App\Support\Images\ImageUpload;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class AdminCourseController extends Controller
{
    public function index(Request $request): Response
    {
        return Inertia::render('Staff/Manage/Courses', [
            'courses' => Course::query()->with('category')->withCount(['modules', 'enrollments'])->orderBy('title')->paginate(20)->withQueryString(),
            'categories' => Category::query()->orderBy('sort_order')->get(['id', 'name']),
            'mentors' => User::query()->whereHas('roles', fn ($query) => $query->whereIn('name', ['teacher', 'admin']))->orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function storeCategory(Request $request): RedirectResponse
    {
        $data = $request->validate(['name' => ['required', 'string', 'max:120'], 'description' => ['nullable', 'string', 'max:1000']]);
        $data['slug'] = Str::slug($data['name']);
        $data['sort_order'] = (int) Category::query()->max('sort_order') + 1;
        Category::query()->create($data);

        return back()->with('success', 'Course category created.');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->courseData($request);
        $mentorIds = $data['mentor_ids'];
        unset($data['mentor_ids']);
        $data['slug'] = $data['slug'] ?: Str::slug($data['title']);
        $data['cover_image'] = ImageUpload::store($request, 'cover_upload', 'courses', 1200, 800) ?? $data['cover_image'] ?? null;
unset($data['cover_upload']);
        $data['created_by'] = $request->user()->id;
        $data['published_at'] = $data['status'] === 'published' ? now() : null;
        $course = Course::query()->create($data);
        $course->mentors()->sync($mentorIds);

        return to_route('staff.manage.courses')->with('success', 'Course created. Add its curriculum before publishing it.');
    }

    public function update(Request $request, Course $course): RedirectResponse
    {
        $data = $this->courseData($request, $course);
        $mentorIds = $data['mentor_ids'];
        unset($data['mentor_ids']);
        $data['slug'] = $data['slug'] ?: Str::slug($data['title']);
        if ($path = ImageUpload::store($request, 'cover_upload', 'courses', 1200, 800)) {
            ImageUpload::deleteManaged($course->getRawOriginal('cover_image'), 'courses');
            $data['cover_image'] = $path;
        } else {
            $data['cover_image'] = $course->getRawOriginal('cover_image');
        }
        unset($data['cover_upload']);
        $data['published_at'] = $data['status'] === 'published' ? ($course->published_at ?? now()) : null;
        $course->update($data);
        $course->mentors()->sync($mentorIds);

        return to_route('staff.manage.courses.edit', $course)->with('success', 'Course details updated.');
    }

    public function edit(Course $course): Response
    {
        $course->load(['modules.lessons', 'category', 'mentors:id,name']);

        return Inertia::render('Staff/Manage/Course', [
            'course' => $course,
            'categories' => Category::query()->orderBy('sort_order')->get(['id', 'name']),
            'mentors' => User::query()->whereHas('roles', fn ($query) => $query->whereIn('name', ['teacher', 'admin']))->orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function storeModule(Request $request, Course $course): RedirectResponse
    {
        $data = $request->validate(['title' => ['required', 'string', 'max:180'], 'description' => ['nullable', 'string', 'max:2000']]);
        $data['position'] = (int) $course->modules()->max('position') + 1;
        $course->modules()->create($data);

        return back()->with('success', 'Curriculum module added.');
    }

    public function storeLesson(Request $request, Course $course, CourseModule $module): RedirectResponse
    {
        abort_unless($module->course_id === $course->id, 404);
        $data = $request->validate([
            'title' => ['required', 'string', 'max:180'], 'summary' => ['nullable', 'string', 'max:1000'],
            'type' => ['required', Rule::in(['live', 'video', 'reading', 'assignment'])],
            'duration_seconds' => ['nullable', 'integer', 'min:0', 'max:86400'], 'video_url' => ['nullable', 'url', 'max:2048'],
            'body' => ['nullable', 'string', 'max:50000'], 'is_preview' => ['boolean'],
        ]);
        $data['position'] = (int) $module->lessons()->max('position') + 1;
        $data['duration_seconds'] = $data['duration_seconds'] ?? 0;
        $data['is_preview'] = $data['is_preview'] ?? false;
        $module->lessons()->create($data);

        return back()->with('success', 'Curriculum item added.');
    }

    public function destroyModule(Course $course, CourseModule $module): RedirectResponse
    {
        abort_unless($module->course_id === $course->id, 404);
        $module->delete();

        return back()->with('success', 'Module and its lessons removed.');
    }

    public function destroyLesson(Course $course, CourseModule $module, Lesson $lesson): RedirectResponse
    {
        abort_unless($module->course_id === $course->id && $lesson->course_module_id === $module->id, 404);
        $lesson->delete();

        return back()->with('success', 'Curriculum item removed.');
    }

    private function courseData(Request $request, ?Course $course = null): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'slug' => ['nullable', 'alpha_dash', 'max:190', Rule::unique('courses', 'slug')->ignore($course?->id)],
            'category_id' => ['nullable', 'exists:categories,id'], 'subtitle' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:20000'], 'level' => ['required', Rule::in(['beginner', 'intermediate', 'advanced', 'all_levels'])],
            'duration_weeks' => ['required', 'integer', 'min:1', 'max:104'], 'price_minor' => ['required', 'integer', 'min:0'],
            'currency' => ['required', 'string', 'size:3'], 'price' => ['required', 'numeric', 'min:0', 'max:999999'], 'cover_image' => ['nullable', 'string', 'max:2048'],
            'cover_upload' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'mentor_ids' => ['array'], 'mentor_ids.*' => ['exists:users,id'],
            'status' => ['required', Rule::in(['draft', 'published', 'archived'])],
        ]);
        $data['slug'] = trim($data['slug'] ?? '');
        $data['currency'] = strtoupper($data['currency']);
        $data['mentor_ids'] = array_values(array_unique(array_map('intval', $data['mentor_ids'] ?? [])));
        $allowedMentorIds = User::query()->whereIn('id', $data['mentor_ids'])->whereHas('roles', fn ($query) => $query->whereIn('name', ['teacher', 'admin']))->pluck('id')->all();
        abort_unless(count($allowedMentorIds) === count($data['mentor_ids']), 422, 'Only teachers and administrators can be assigned as mentors.');
        $data['price_minor'] = (int) round((float) $data['price'] * 100);
        unset($data['price']);

        return $data;
    }
}




