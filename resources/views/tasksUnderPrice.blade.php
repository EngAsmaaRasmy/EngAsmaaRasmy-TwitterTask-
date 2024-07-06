@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h1 class="mt-5">Tasks Under Price 100</h1>
    <div class="row">
        <div class="col-md-12">
            <ul id="task-list" class="list-group"></ul>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    fetch('/api/tasks-under-price')
        .then(response => response.json())
        .then(data => {
            const taskList = document.getElementById('task-list');
            taskList.innerHTML = renderTasks(data);
        })
        .catch(error => console.error('Error:', error));
});

function renderTasks(tasks) {
    let html = '';
    tasks.forEach(task => {
        html += `<li class="list-group-item">${task.name}</li>`;
    });
    return html;
}
</script>
@endsection
