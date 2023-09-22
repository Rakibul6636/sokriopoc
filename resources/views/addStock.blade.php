<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Stock</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #f9f9f9;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .form-group .horizontal-line {
            border-top: 1px solid #ccc;
            text-align: center;
            margin-top: 15px;
            margin-bottom: 15px;
            line-height: 0;
        }

        .form-group .horizontal-line span {
            background-color: #f9f9f9;
            padding: 0 20px;
            color: #555;
            font-size: 16px;
        }

        .product-row {
            display: flex;
            align-items: center;
        }

        .product-row input {
            flex: 2;
            margin-right: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .toggle-button {
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            background-color: #4CAF50;
            color: white;
        }

        .toggle-button-red {
            background-color: #FF3333;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
        }

        .form-actions button {
            padding: 10px 20px;
            margin-left: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .form-actions button.reset {
            background-color: #FF3333;
            color: white;
        }

        .form-actions button.submit {
            background-color: #4CAF50;
            color: white;
        }
        .department-input {
    flex: 1.5;
    margin-right: 10px;
}

.chalan-input {
    flex: 1;
}

.department-input select,
.chalan-input input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
}

    </style>
</head>
<body>
<form id="addStockForm">
    <div class="container">
        <h2 style="text-align: center;">Add Stock</h2>
        <div class="form-group product-row">
            <div class="department-input">
                <label for="department">Department:</label>
                <select id="department" type="text" name="department" required>
                    @foreach($departments as $department)
                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="chalan-input">
                <label for="chalan_no">Chalan No.:</label>
                <input type="text" id="chalan_no" name="chalan_no" required>
            </div>
        </div>


        <div id="product-container">
            <div class="form-group product-row select-rw">
                <!-- Inside the product-row div -->
                <div class="department-input">
                
                <select class="product-name" id="product" name="product" required>
                    @foreach($products as $product)
                        <option value="{{ $product->name }}">{{ $product->name }}</option>
                    @endforeach
                </select>
                </div>
                <input type="text" placeholder="SKU" class="sku-input" id="sku" name="sku" required>
                <input type="number" placeholder="Added Quantity" class="quantity-input" id="quantity" name="quantity" required>
                <button class="toggle-button" onclick="addRow(this)">+</button>
            </div>
        </div>

        <div class="form-actions">
            <button class="reset">Reset</button>
            <button class="submit">Submit</button>
        </div>
    </div>
</form>

<script>
    //Add the new row.
    function addRow(button) {
        const productContainer = document.getElementById('product-container');
        const newRow = document.createElement('div');
        newRow.classList.add('form-group', 'product-row', 'select-rw');
        newRow.innerHTML = `
        <div class="department-input">
            <select class="product-name" id="product" name="product" required>
                @foreach($products as $product)
                    <option value="{{ $product->name }}">{{ $product->name }}</option>
                @endforeach
            </select>
            </div>
            <input type="text" placeholder="SKU" class="sku-input" id="sku" name="sku" required>
            <input type="number" placeholder="Added Quantity" class="quantity-input" id="quantity" name="quantity" required>
            <div class="button-container">
                <button class="delete toggle-button toggle-button-red" onclick="deleteRow(this)">-</button>
            </div>
            </div>

        `;
        productContainer.appendChild(newRow);
        button.classList.remove('add');
        button.classList.add('delete');
    }
    //Delete Row
    function deleteRow(button) {
        const productContainer = document.getElementById('product-container');
        productContainer.removeChild(button.parentElement.parentElement);
    }

    document.getElementById('addStockForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const department = document.getElementById('department').value;
    const chalanNo = document.getElementById('chalan_no').value;

    // Collect product details from each product row
    const productRows = document.querySelectorAll('.select-rw');
    const products = [];
    productRows.forEach(row => {
        const productName = row.querySelector('.product-name').value;
        const sku = row.querySelector('.sku-input').value; 
        const quantity = row.querySelector('.quantity-input').value;
        products.push({ productName, sku, quantity });
    });

    const formData = {
        department_id: department,
        challan_no: chalanNo,
        products
    };
    // Send the data to the API using fetch
    fetch('{{ route('stocks') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
       alert("Stock Added Successfully.");
    })
    .catch(error => {
        alert('An Error Occur, Please follow the structure');
    });
});    
</script>

</body>
</html>
