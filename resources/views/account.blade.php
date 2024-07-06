@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h1 class="mt-5">Accounts</h1>
    <div class="row">
        <div class="col-md-12">
            <ul id="account-list" class="list-group"></ul>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    fetch('/api/accounts')
        .then(response => response.json())
        .then(data => {
            const accountList = document.getElementById('account-list');
            accountList.innerHTML = renderAccounts(data);
        })
        .catch(error => console.error('Error:', error));
});

function renderAccounts(accounts) {
    let html = '';
    accounts.forEach(account => {
        html += `<li class="list-group-item">${account.name}
                    <ul class="list-group">${renderProjects(account.projects)}</ul>
                </li>`;
    });
    return html;
}

function renderProjects(projects) {
    let html = '';
    projects.forEach(project => {
        html += `<li class="list-group-item">${project.name} (Price: ${project.price})
                    <ul class="list-group">${renderJobs(project.jobs)}</ul>
                </li>`;
    });
    return html;
}

function renderJobs(jobs) {
    let html = '';
    jobs.forEach(job => {
        html += `<li class="list-group-item">${job.name} (Amount: ${job.amount})
                    <ul class="list-group">${renderTasks(job.tasks)}</ul>
                </li>`;
    });
    return html;
}

function renderTasks(tasks) {
    let html = '';
    tasks.forEach(task => {
        html += `<li class="list-group-item">${task.name}</li>`;
    });
    return html;
}
</script>
@endsection
