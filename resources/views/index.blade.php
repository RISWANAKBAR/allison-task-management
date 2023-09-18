<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task List</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
     
        .navbar {
            background-color: #f8f9fa; 
        }
        .navbar-brand {
            margin-left: auto; 
            margin-right: auto;
            font-weight: bold;
            color: #343a40;
        }
        .navbar-brand:hover {
            color: #007bff; 
        }
        .nav-link {
            color: #343a40;
        }
        .nav-link:hover {
            color: #007bff; 
        }
        .scrollable-table {
            max-height: 400px;
            overflow-y: auto;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <a class="navbar-brand" href="#">Task List App</a>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/registration') }}">Register</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/') }}">Login</a>
            </li>
        </ul>
    </div>
</nav>

<div class="container mt-5">
    <h2 class="mb-4 text-center">Task List</h2>
    <!-- Task List Table -->
    <div class="scrollable-table">
        <table class="table table-bordered">
            <!-- Table headers -->
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Due Date</th>
                    <th>Priority</th>
                    <th>Actions</th> <!-- Added Actions column -->
                </tr>
            </thead>
            <!-- Table body -->
            <tbody>
                <!-- Loop through tasks and display them -->
                @foreach($tasks as $task)
                    <tr>
                        <td>{{ $task->title }}</td>
                        <td>{{ $task->description }}</td>
                        <td>{{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('Y-m-d') : 'Not set' }}</td>
                        <td>{{ $task->priority }}</td>
                        <td>
                            <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-primary btn-sm">Edit</a>
                            <a href="{{ route('tasks.destroy', $task->id) }}" class="btn btn-danger btn-sm" onclick="event.preventDefault(); document.getElementById('delete-task-form-{{ $task->id }}').submit();">Delete</a>

                            @if($task->completed)
                                <button class="btn btn-success btn-sm" disabled>Completed</button>
                            @else
                                <form id="mark-completed-form-{{ $task->id }}" action="{{ route('tasks.markCompleted', $task->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">Mark as Completed</button>
                                </form>
                            @endif

                            <form id="delete-task-form-{{ $task->id }}" action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <a href="{{ route('tasks.create') }}" class="btn btn-primary mt-3">Create New Task</a>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

