<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Module</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #f9f9f9;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .card {
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 10px;
            background-color: white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            border: 1px solid #ccc;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 15px;
            text-align: left;
        }

        th:last-child, td:last-child {
            border: none;
        }

        th {
            background-color: #f2f2f2;
            width: 15%;
        }

        td input {
            width: 100%;
            box-sizing: border-box;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .add-button {
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            background-color: #4CAF50;
            color: white;
            border-radius: 5px;
            width: 100%;
        }

        .remove-button {
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            background-color: #FF3333;
            color: white;
            border-radius: 5px;
            width: 100%;
        }

        .total-row {
            font-weight: bold;
            width: 40%;
        }

        .total-value {
            width: 60%;
        }

        textarea {
            width: calc(100% - 22px);
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            margin-bottom: 10px;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            margin-top: 20px;
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
        .product-input {
    flex: 1.5;
    margin-right: 10px;
}
.product-input select {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
}
    </style>
</head>
<body>

<div class="container">
    <h2 style="text-align: center;">Sales Module</h2>


    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Unit</th>
                    <th>Sales Price</th>
                    <th>Payable</th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="sales-table-body">
                <tr>
                    <td class="product-input">
                        <select id="product" name="product" placeholder="Product" required>
                            @foreach($products as $product)
                                <option value="{{ $product->name }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td><input type="number" placeholder="Qty" oninput="calculatePayable(this)" required></td>
                    <td><input type="text" placeholder="Unit" required></td>
                    <td><input type="number" placeholder="Price" oninput="calculatePayable(this)" required></td>
                    <td><input type="number" placeholder="Payable" readonly></td>
                    <td><button class="add-button" onclick="addRow()">Add</button></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="card">
        <table>
            <tbody>
                <tr>
                    <td class="total-row" colspan="4">Grand Total</td>
                    <td class="total-value" id="grandTotal">0.00</td>
                </tr>
                <tr>
                    <td class="total-row" colspan="4">Pay</td>
                    <td class="total-value"><input type="number" placeholder="Pay" id="pay" oninput="updateDue()"></td>
                </tr>
                <tr>
                    <td class="total-row" colspan="4">Due</td>
                    <td class="total-value"><span id="due">0.00</span></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="form-actions">
        <button class="reset">Reset</button>
        <button class="submit" onclick="submitForm()">Submit</button>
    </div>

</div>
</div>

<script>
    let totalPayable = 0;
    //Calculate the payable
    function calculatePayable(input) {
        const row = input.parentElement.parentElement;
        const qty = parseFloat(row.querySelector('td:nth-child(2) input').value) || 0;
        const price = parseFloat(row.querySelector('td:nth-child(4) input').value) || 0;
        const payable = qty * price;
        row.querySelector('td:nth-child(5) input').value = payable.toFixed(2);
        updateTotalPayable();
    }
    //Update the payable
    function updateTotalPayable() {
    totalPayable = Array.from(document.querySelectorAll('tbody tr')).reduce((sum, row) => {
        const payableInput = row.querySelector('td:nth-child(5) input');
        if (payableInput) {
            const payable = parseFloat(payableInput.value) || 0;
            return sum + payable;
        }
        return sum;
    }, 0);
    document.getElementById('grandTotal').textContent = totalPayable.toFixed(2);
    updateDue();
}
//Update the Due
function updateDue() {
    const pay = parseFloat(document.getElementById('pay').value) || 0;
    const due = totalPayable - pay;
    document.getElementById('due').textContent = due.toFixed(2);
}

//add new Row
function addRow() {
        const salesTableBody = document.getElementById('sales-table-body');
        const newRow = salesTableBody.insertRow(-1);
        const productCell = newRow.insertCell(0);
        const qtyCell = newRow.insertCell(1);
        const unitCell = newRow.insertCell(2);
        const priceCell = newRow.insertCell(3);
        const payableCell = newRow.insertCell(4);
        const actionCell = newRow.insertCell(5);

        productCell.innerHTML = `<td class="product-input">
                                    <select  id="product" name="product" placeholder="Product" required>
                                        @foreach($products as $product)
                                            <option value="{{ $product->name }}">{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                </td>`;
        qtyCell.innerHTML = '<input type="number" placeholder="Qty" oninput="calculatePayable(this)" required>';
        unitCell.innerHTML = '<input type="text" placeholder="Unit" required>';
        priceCell.innerHTML = '<input type="number" placeholder="Price" oninput="calculatePayable(this)" required>';
        payableCell.innerHTML = '<input type="number" placeholder="Payable" readonly>';

        const removeButton = document.createElement('button');
        removeButton.className = 'remove-button';
        removeButton.textContent = '−';
        removeButton.onclick = function() {
            salesTableBody.removeChild(newRow);
            updateTotalPayable();
        };

        actionCell.appendChild(removeButton);
    }
    //Process the data 
    function submitForm() {
        const sales = [];
        const rows = document.querySelectorAll('#sales-table-body tr');

        rows.forEach(row => {
            const product = row.querySelector('td:nth-child(1) select').value;
            const quantity = parseFloat(row.querySelector('td:nth-child(2) input').value) || 0;
            const unit = row.querySelector('td:nth-child(3) input').value;
            const salesPrice = parseFloat(row.querySelector('td:nth-child(4) input').value) || 0;
            const payable = parseFloat(row.querySelector('td:nth-child(5) input').value) || 0;

            sales.push({
                product,
                quantity,
                unit,
                sales_price: salesPrice,
                payable
            });
        });

        const totalAmount = parseFloat(document.getElementById('grandTotal').textContent) || 0;
        const payAmount = parseFloat(document.getElementById('pay').value) || 0;

        const formData = {
            total_amount: totalAmount,
            pay_amount: payAmount,
            sales
        };

        // Send the data to the API using fetch
        fetch('{{ route('sales') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(formData)
        })
        .then(response => response.json())
        .then(data => {
            alert("Sale Added Successfully")
        })
        .catch(error => {
            alert('An Error Occur, Please follow the structure');
        });
    }
</script>

</body>
</html>
