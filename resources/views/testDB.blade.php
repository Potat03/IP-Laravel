<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="" method="POST">
        @csrf 
        <input type="text" value="1" name="customer_id" id="customer_id">
        <input type="text" value="1" name="product_id" id="product_id">
        <input type="text" value="1" name="promotion_id" id="promotion_id">
        <input type="text" value="1" name="quantity" id="quantity">
        <input type="text" value="100.00" name="subtotal" id="subtotal">
        <input type="text" value="20.00" name="discount" id="discount">
        <input type="text" value="80.00" name="total" id="total">
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
                console.error('Error:', error);
                alert('An error occurred while uploading the image.');
            });
    });
    </script>
</body>

</html>