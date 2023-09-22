<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .container {
            max-width: 500px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #f9f9f9;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 15px;
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-group input, .form-group select, .form-group textarea {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .form-group .optional {
            font-style: italic;
            font-size: 12px;
            color: #888;
        }

        .form-group button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .form-group button:hover {
            background-color: #45a049;
        }

        .form-row {
            display: flex;
            gap: 10px;
        }

        .form-row .half {
            flex: 1;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

</head>
<body>

<div class="container">
    <h2 style="text-align: center;">Add Product</h2>
    <form id="addProductForm">
        <div class="form-row">
            <div class="form-group half">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group half">
                <label for="sku">SKU:</label>
                <input type="text" id="sku" name="sku" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group half">
                <label for="product_brand">Product brand:</label>
                <input type="text" id="product_brand" name="product_brand" required>
            </div>
            <div class="form-group half">
                <label for="product_category">Product product_category:</label>
                <select id="product_category" name="product_category" required>
                    <option value="">Select product_category</option>
                    <option value="electronics">Electronics</option>
                    <option value="clothing">Clothing</option>
                    <option value="appliances">Appliances</option>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group half">
                <label for="description">Description:</label>
                <textarea type="text" id="description" name="description"></textarea>
                <span class="optional">Optional</span>

            </div>
            <div class="form-group half">
                <label for="usp">USP:</label>
                <textarea type="text" id="usp" name="usp"></textarea>
                <span class="optional">Optional</span>

            </div>
        </div>

        <div class="form-group">
            <button type="submit">Add Product</button>
        </div>
    </form>
</div>
<script> 
        //Get the Form data.
        document.getElementById('addProductForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const name = document.getElementById('name').value;
            const sku = document.getElementById('sku').value;
            const product_brand = document.getElementById('product_brand').value;
            const product_category = document.getElementById('product_category').value;
            const description = document.getElementById('description').value;
            const usp = document.getElementById('usp').value;

            // Make a request to login and get the token
            addProduct(name,sku, product_brand, product_category, description, usp);
        });
        //Sent the process data to API
        async function addProduct(name, sku, product_brand, product_category, description, usp) {
            try {
                const response = await axios.post('{{ route('products') }}', {
                    name :name,
                    sku : sku,
                    product_brand: product_brand,
                    product_category: product_category,
                    description: description,
                    usp : usp
                });
                alert("Product Added Successful.");
            } catch (error) {
                alert('An Error Occur, Please follow the structure');
            }
        }
    </script>
</body>
</html>
