<?php

use App\Models\Student;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;

// Home page sends you to the student list
Route::get('/', function () {
    return redirect('/students');
});

/* ================= STUDENTS ================= */

// READ ALL: show the list
Route::get('/students', function () {
    $students = Student::all();                               // SELECT * FROM students
    return view('student.list', ['students' => $students]);   // send data to the view
})->name('students.index');

// CREATE (step 1): show the empty form
// Must stay ABOVE /students/{id}, or Laravel thinks "create" is an id
Route::get('/students/create', function () {
    return view('student.create');
})->name('students.create');

// CREATE (step 2): receive the form and save
Route::post('/students', function (Request $request) {
    $validated = $request->validate([                         // stops here if input is bad
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:students,email',
        'phone' => 'required|string|max:20',
        'address' => 'nullable|string|max:500',
        'date_of_birth' => 'nullable|date',
    ]);

    $student = Student::create($validated);                   // INSERT INTO students

    return redirect()->route('students.index')                // go back to the list
        ->with('success', "Student {$student->name} created successfully!");
})->name('students.store');

// READ ONE: show details
Route::get('/students/{id}', function ($id) {
    $student = Student::findOrFail($id);                      // 404 page if not found
    return view('student.detail', ['student' => $student]);
})->name('students.show');

// UPDATE (step 1): show the filled form
Route::get('/students/{id}/edit', function ($id) {
    $student = Student::findOrFail($id);
    return view('student.edit', ['student' => $student]);
})->name('students.edit');

// UPDATE (step 2): save changes
Route::put('/students/{id}', function (Request $request, $id) {
    $student = Student::findOrFail($id);

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => ['required', 'email', 'max:255',
            Rule::unique('students')->ignore($student->id)],  // allow this student's own email
        'phone' => 'required|string|max:20',
        'address' => 'nullable|string|max:500',
        'date_of_birth' => 'nullable|date',
    ]);

    $student->update($validated);                             // UPDATE students SET ...

    return redirect('/students/' . $student->id)
        ->with('success', 'Student updated successfully!');
})->name('students.update');

// DELETE
Route::delete('/students/{id}', function ($id) {
    Student::findOrFail($id)->delete();                       // DELETE FROM students
    return redirect('/students')->with('success', 'Student deleted successfully!');
})->name('students.destroy');

/* ================= COURSES ================= */

// One shared set of rules, used by both create and update
function courseRules(): array
{
    return [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string|max:1000',
        'duration' => 'required|integer|min:1',
        'fee' => 'required|numeric|min:0',
        'difficulty' => 'required|in:Easy,Medium,Hard',
        'is_active' => 'boolean',
    ];
}

Route::get('/courses', function () {
    return view('course.list', ['courses' => Course::all()]);
})->name('courses.index');

Route::get('/courses/create', function () {
    return view('course.create');
})->name('courses.create');

Route::post('/courses', function (Request $request) {
    $validated = $request->validate(courseRules());
    $validated['is_active'] = $request->boolean('is_active'); // checkbox to true/false

    $course = Course::create($validated);

    return redirect()->route('courses.index')
        ->with('success', "Course {$course->name} created successfully!");
})->name('courses.store');

Route::get('/courses/{id}', function ($id) {
    return view('course.detail', ['course' => Course::findOrFail($id)]);
})->name('courses.show');

Route::get('/courses/{id}/edit', function ($id) {
    return view('course.edit', ['course' => Course::findOrFail($id)]);
})->name('courses.edit');

Route::put('/courses/{id}', function (Request $request, $id) {
    $course = Course::findOrFail($id);
    $validated = $request->validate(courseRules());
    $validated['is_active'] = $request->boolean('is_active');

    $course->update($validated);

    return redirect('/courses/' . $course->id)
        ->with('success', 'Course updated successfully!');
})->name('courses.update');

Route::delete('/courses/{id}', function ($id) {
    Course::findOrFail($id)->delete();
    return redirect('/courses')->with('success', 'Course deleted successfully!');
})->name('courses.destroy');