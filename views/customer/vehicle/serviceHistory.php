<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap");

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #f8fafc;
            font-family: "Inter", sans-serif;
            color: #334155;
            line-height: 1.6;
            padding: 10px;
        }

        .navMenu {
            background-color: rgba(255, 255, 255, 0.9);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 67.5%;
            padding: 1rem;
            margin: 0 auto 2rem;
            position: sticky;
            top: 20px;
            z-index: 100;
        }

        .navMenu a {
            color: #64748b;
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 500;
            padding: 0.75rem 2.25rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .navMenu a.active {
            color: #2563eb;
            background: #eff6ff;
        }

        .navMenu a:hover {
            color: #2563eb;
            background: #f8fafc;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            margin-left: 450px;
        }

        .title {
            color: #1e293b;
            font-size: 1.5rem;
            font-weight: 600;
        }

        .accordion {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            margin-bottom: 1rem;
        }

        .accordion-item {
            border-bottom: 1px solid #e2e8f0;
        }

        .accordion-header {
            padding: 1rem;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #eff6ff;
            font-weight: 800;
        }

        .accordion-header:hover {
            background-color: #f8fafc;
        }

        .accordion-title {
            color: #1e293b;
        }

        .accordion-content {
            padding: 1rem;
            display: none;
            overflow: hidden;
            text-align: justify;
            /* Justify text alignment */
            display: grid;
            /* Use grid for two columns */
            grid-template-columns: repeat(2, minmax(0, 1fr));
            /* Two equal columns */
            gap: 20px;
            /* Space between columns */
        }

        .accordion-content p {
            margin-bottom: 0.5rem;
        }

        .description {
            grid-column: span 2;
        }
    </style>
</head>

<body>
    <nav class="navMenu">
        <a href="#">New Vehicle</a>
        <a href="#">My Vehicle</a>
        <a href="#" class="active">Service History</a>
    </nav>
    <div class="container">
        <div class="header">
            <h1 class="title">Service History</h1>
        </div>

        <div id="serviceAccordion" class="accordion">
            <!-- Service data will be populated here -->
        </div>
    </div>

    <script>
        // Sample service data - replace with your actual data
        const services = [{
                vehicleBrand: "Toyota",
                plateNumber: "ABC-1234",
                nickname: "Daily Commuter",
                vehicleType: "Car",
                garageName: "City Garage",
                serviceType: "Oil Change",
                cost: "$50",
                sparePartsReplaced: [{
                    part: "Oil Filter",
                    partNumber: "OF123",
                    supplierName: "AutoParts Co."
                }],
                sparePartsWarranty: {
                    expireDate: "2025-06-15",
                    timeLeft: "6 months"
                },
                description: "Regular oil change service.",
                serviceDate: "2024-06-15"
            },
            {
                vehicleBrand: "Honda",
                plateNumber: "XYZ-5678",
                nickname: "Weekend Rider",
                vehicleType: "Motorcycle",
                garageName: "Speedy Garage",
                serviceType: "Tire Replacement",
                cost: "$200",
                sparePartsReplaced: [{
                    part: "Front Tire",
                    partNumber: "FT456",
                    supplierName: "Tire Depot"
                }],
                sparePartsWarranty: {
                    expireDate: "2026-03-10",
                    timeLeft: "16 months"
                },
                description: "Changed front tire for better performance.",
                serviceDate: "2024-03-10"
            } // Add more services as needed
        ];

        function createAccordionItem(service) {
            return `
          <div class="accordion-item">
              <div class="accordion-header" onclick="toggleAccordion(this)">
                  <span class="accordion-title">${service.vehicleBrand} (${service.nickname})</span>
                  <span>${service.serviceType}</span>
                  <span>${service.serviceDate}</span>
              </div>
              <div class="accordion-content">
                  <p><strong>Plate Number:</strong> ${service.plateNumber}</p>
                  <p><strong>Vehicle Type:</strong> ${service.vehicleType}</p>
                  <p><strong>Garage Name:</strong> ${service.garageName}</p>
                  <p><strong>Cost:</strong> ${service.cost}</p>
                  <p><strong>Spare Parts Replaced:</strong></p>
                  ${service.sparePartsReplaced.map(part => `
                      <p>&nbsp;&nbsp;&nbsp;<strong>${part.part}</strong> (Part Number:${part.partNumber}, Supplier:${part.supplierName})</p>`).join('')}
                  <p><strong>Warranty Expiry:</strong> ${service.sparePartsWarranty.expireDate} (${service.sparePartsWarranty.timeLeft} left)</p>
                  <p class="description"><strong>Description:</strong> ${service.description}</p> <!-- Single row for description -->
              </div>
          </div>`;
        }

        function toggleAccordion(header) {
            const content = header.nextElementSibling;
            const isVisible = content.style.display === 'block';

            // Hide all other accordion contents
            const allContents = document.querySelectorAll('.accordion-content');
            allContents.forEach(item => item.style.display = 'none');

            // Toggle the clicked accordion content
            content.style.display = isVisible ? 'none' : 'block';
        }

        function loadServices() {
            const serviceAccordion = document.getElementById('serviceAccordion');

            if (services.length === 0) {
                serviceAccordion.innerHTML = "<p>No service records found.</p>";
                return;
            }

            serviceAccordion.innerHTML = services.map(createAccordionItem).join('');
        }

        // Initialize the page
        window.onload = function() {
            loadServices();
        };
    </script>

</body>

</html>