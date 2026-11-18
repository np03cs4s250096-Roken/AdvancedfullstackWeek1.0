<!DOCTYPE html>
<html>
<head><title>Edit Student</title></head>
<body>
    <h1>Edit Student</h1>

    <form action="/students/{{ $student->id }}" method="POST">
        @csrf
        @method('PUT')  {{-- browser sends POST, Laravel treats it as PUT --}}
        @include('student._form')
        <button type="submit">Update Student</button>
    </form>

    <br>
    <a href="/students">Back to Students</a>
</body>
</html>