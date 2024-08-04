<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <img src="{{ URL('storage/images/pinkglock.png') }}" alt="pinkglock" width="200" height="200">
    <form action="{{ route('product.image.upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="image" id="image">
        <button type="submit">Upload</button>
    </form>

    <script>
        //handle form submit
        form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            let formData = new FormData(form);

            fetch('/api/product/image/upload', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Upload Success');
                    } else {
                        alert('Upload Failed');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while uploading the image.');
                });
        });
    </script>
</body>

</html>