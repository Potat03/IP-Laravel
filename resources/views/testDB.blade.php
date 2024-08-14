<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="" method="POST" enctype="multipart/form-data">
        @csrf 
        <input type="text" value="C001" name="customer_id">
        <input type="text" value="P001" name="product_id">
        <input type="text" value="P" name="promotion_id">
        <input type="text" value="1" name="quantity">
        <input type="text" value="100.00" name="subtotal">
        <input type="text" value="20.00" name="discount">
        <input type="text" value="80.00" name="total">
        <button type="submit">Upload</button>
    </form>

    <script>
    //handle form submit
    form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        let formData = new FormData(form);

        fetch('/api/cartItem/upload', {
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
                console.log('Error:', error);
                alert('An error occurred while uploading the image.');
            });
    });
    </script>
</body>

</html>