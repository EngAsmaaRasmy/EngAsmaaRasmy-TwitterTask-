@extends('layouts.dashboard')
@section('content')
<div class="container">
    <h1 class="mt-5">Upload Image</h1>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form id="uploadForm" enctype="multipart/form-data">
                <div class="form-group">
                    <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Upload</button>
            </form>
            <div id="image-list" class="mt-4"></div>
        </div>
    </div>
</div>
<script>
    document.getElementById('uploadForm').addEventListener('submit', function(e) {
        e.preventDefault();
        var formData = new FormData();
        formData.append('image', document.getElementById('image').files[0]);

        console.log(document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
        fetch('/store-image', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            fetchImages();
        })
        .catch(error => console.error('Error:', error));
    });

    function fetchImages() {
        fetch('/images')
            .then(response => response.json())
            .then(data => {
                const imageList = document.getElementById('image-list');
                imageList.innerHTML = '';
                data.images.forEach(image => {
                    const imgDiv = document.createElement('div');
                    imgDiv.classList.add('mb-3');

                    const approveDisabled = image.status == 'approved' ? 'disabled' : '';
                    const rejectDisabled = image.status == 'rejected' ? 'disabled' : '';

                    imgDiv.innerHTML = `<img src="/storage/${image.path}" width="100" class="img-thumbnail">
                                        <button class="btn btn-success btn-sm" onclick="approveImage('${image._id}')" ${approveDisabled}>Approve</button>
                                        <button class="btn btn-danger btn-sm" onclick="rejectImage('${image._id}')" ${rejectDisabled}>Reject</button>`;
                    imageList.appendChild(imgDiv);
                });
            })
            .catch(error => console.error('Error:', error));
    }

    function approveImage(imageId) {
        fetch(`/approve-image/${imageId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            fetchImages();
        })
        .catch(error => console.error('Error:', error));
    }

    function rejectImage(imageId) {
        fetch(`/reject-image/${imageId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            fetchImages();
        })
        .catch(error => console.error('Error:', error));
    }

    document.addEventListener('DOMContentLoaded', function() {
        fetchImages();
    });
</script>
@endsection
