@extends('layouts.dashboard')
@section('content')
<div class="container">
    <h1 class="mt-5">Categories</h1>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <ul id="category-list" class="list-group"></ul>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        fetch('/api/categories')
            .then(response => response.json())
            .then(data => {
                const categoryList = document.getElementById('category-list');
                categoryList.innerHTML = renderCategories(data);
            })
            .catch(error => console.error('Error:', error));
    });

    function renderCategories(categories) {
        let html = '';
        categories.forEach(category => {
            html += `<li class="list-group-item">${category.name}`;
            if (category.children_recursive && category.children_recursive.length > 0) {
                html += `<ul class="list-group">${renderCategories(category.children_recursive)}</ul>`;
            }
            html += `</li>`;
        });
        return html;
    }
</script>
@endsection
