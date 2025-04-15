<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spare Parts and Product Availability</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            background: #181a20;
            font-family: "Inter", sans-serif;
            color: #f5f5f5;
            line-height: 1.6;
            padding: 10px;
            overflow-x: hidden;

        }
   

        h2 {
            text-align: center;
            color:#f5f5f5;
        }
        .search-container {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 30px;
        }
        .search-container input,
        .search-container select {
            padding: 8px;
            font-size: 1rem;
            width: 200px;
        }
        .search-container button {
            padding: 8px 12px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }
        .search-container button:hover {
            background-color: #0056b3;
        }
        .product-table {
    margin: 0 auto;
    display: table;
    background-color: #25272d;
    width:80%;

}     

.product-table th, .product-table td {
    padding: 8px;
    text-align: left;
}

.product-table th {
    background-color: #333;
    color:#f5f5f5;
}

.product-table td.in-stock {
    color: green;
}

.product-table td.out-of-stock {
    color: red;
}      input[type="text"]:focus, input[type="email"]:focus, input[type="date"]:focus, input[type="password"]:focus, input[type="number"]:focus, input[type="tel"]:focus {
    border-color: #007bff;
    background-color: #181a20;
    color: #007bff;
    outline: none;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
}   
        button {
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    

    <h2>Spare Parts</h2>

    <!-- Search Filters -->
    <div class="search-container">
        <input type="text" id="searchSerial" placeholder="Search by Serial No...">
        <select id="filterType">
            <option value="">Filter by Type</option>
            <option value="Engine">Engine</option>
            <option value="Transmission">Transmission</option>
            <option value="Brake">Brake</option>
            <option value="Suspension">Suspension</option>
        </select>
        <button onclick="searchProducts()">Search</button>
    </div>

    <!-- Product Table -->
    <table class="product-table" id="productTable">
        <thead>
            <tr>
                <th>Serial No</th>
                <th>Type</th>
                <th>Manufacturer</th>
                <th>Price</th>
                <th>Manufactured Date</th>
                <th>Warranty Period</th>
                <th>Availability</th>
            </tr>
        </thead>
        <tbody>
           <tr>
    <td>SP123</td>
    <td>Brake Pad</td>
    <td>Bosch</td>
    <td>Rs.1500</td>
    <td>2023-06-10</td>
    <td>1 Year</td>
    <td class="in-stock">In Stock</td>
</tr>
<tr>
    <td>SP456</td>
    <td>Engine Oil Filter</td>
    <td>Wix</td>
    <td>Rs.800</td>
    <td>2022-05-15</td>
    <td>2 Years</td>
    <td class="in-stock">In Stock</td>
</tr>
<tr>
    <td>SP789</td>
    <td>Air Filter</td>
    <td>K&N</td>
    <td>Rs.1000</td>
    <td>2022-08-20</td>
    <td>1 Year</td>
    <td class="out-of-stock">Out of Stock</td>
</tr>
<tr>
    <td>SP012</td>
    <td>Brake Pad</td>
    <td>Brembo</td>
    <td>Rs.2000</td>
    <td>2023-01-10</td>
    <td>3 Years</td>
    <td class="in-stock">In Stock</td>
</tr>
<tr>
    <td>SP345</td>
    <td>Suspension</td>
    <td>Monroe</td>
    <td>Rs.3500</td>
    <td>2021-11-15</td>
    <td>2 Years</td>
    <td class="in-stock">In Stock</td>
</tr>
<tr>
    <td>SP678</td>
    <td>Battery</td>
    <td>Exide</td>
    <td>Rs.18000</td>
    <td>2022-12-25</td>
    <td>1 Year</td>
    <td class="out-of-stock">Out of Stock</td>
</tr>
       </tbody>
    </table>

    <!-- Product Cards (for mobile or alternate view) -->
    <div id="productCards">
        <!-- Product cards will be inserted here dynamically -->
    </div>

    <script>
        // Example data for products
        // const products = [
        //     { serial_no: "SP123", type: "Brake Pad", manufacturer: "Bosch", price: "Rs.1500", manufactured_date: "2023-06-10", warranty_period: "1 Year", available: true },
        //     { serial_no: "SP678", type: "Air Filter", manufacturer: "K&N", price: "Rs.1200", manufactured_date: "2022-08-15", warranty_period: "2 Years", available: false },
        //     { serial_no: "SP543", type: "Engine Oil", manufacturer: "Castrol", price: "Rs.2500", manufactured_date: "2023-02-20", warranty_period: "3 Years", available: true },
        //     { serial_no: "SP987", type: "Suspension", manufacturer: "Monroe", price: "Rs.4500", manufactured_date: "2021-11-05", warranty_period: "2 Years", available: true },
        //     { serial_no: "SP135", type: "Battery", manufacturer: "Exide", price: "Rs.16000", manufactured_date: "2022-12-30", warranty_period: "1 Year", available: false },
        //     // More product examples can be added here
        // ];

        function searchProducts() {
            const serial = document.getElementById("searchSerial").value.toLowerCase();
            const type = document.getElementById("filterType").value;
            const manufacturer = document.getElementById("filterManufacturer").value;
            const warranty = document.getElementById("filterWarranty").value;

            const filteredProducts = products.filter(product => {
                return (
                    (serial ? product.serial_no.toLowerCase().includes(serial) : true) &&
                    (type ? product.type === type : true) &&
                    (manufacturer ? product.manufacturer === manufacturer : true) &&
                    (warranty ? product.warranty_period === warranty : true)
                );
            });

            displayProducts(filteredProducts);
        }

        function displayProducts(products) {
            const tableBody = document.querySelector("#productTable tbody");
            const productCards = document.getElementById("productCards");

            // Clear existing rows
            tableBody.innerHTML = "";
            productCards.innerHTML = "";

            // Loop through filtered products and insert them into the table and cards
            products.forEach(product => {
                const row = document.createElement("tr");
                row.innerHTML = `
                    <td>${product.serial_no}</td>
                    <td>${product.type}</td>
                    <td>${product.manufacturer}</td>
                    <td>${product.price}</td>
                    <td>${product.manufactured_date}</td>
                    <td>${product.warranty_period}</td>
                    <td class="${product.available ? 'in-stock' : 'out-of-stock'}">${product.available ? 'In Stock' : 'Out of Stock'}</td>
                `;
                tableBody.appendChild(row);

            });
        }

        // Initial display of all products
        displayProducts(products);
    </script>

</body>
</html>
