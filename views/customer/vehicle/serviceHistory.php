<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap");

        :root {
            --text: #f5f5f5;
            --background: #181a20;
            --primary: #C0C0C0FF;
            --secondary: #25272d;
            --accent: #2463eb;
            --hover-bg: rgba(36, 99, 235, 0.1);
            --border: #33363f;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: var(--background);
            font-family: "Inter", sans-serif;
            color: var(--text);
            line-height: 1.6;
            padding: 20px;
        }

        .navMenu {
            background-color: var(--secondary);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
            border-radius: 12px;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 70%;
            padding: 1rem;
            margin: 0 auto 2rem;
            position: sticky;
            top: 20px;
            z-index: 100;
        }

        .navMenu a {
            color: var(--primary);
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 500;
            padding: 0.75rem 1.25rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .navMenu a.active {
            color: var(--accent);
            background: var(--hover-bg);
        }

        .navMenu a:hover {
            color: var(--accent);
            background: var(--hover-bg);
        }

        .navMenu .dot {
            width: 4px;
            height: 4px;
            background: var(--accent);
            border-radius: 50%;
            position: absolute;
            bottom: 4px;
            left: 50%;
            transform: translateX(-50%);
            opacity: 0;
            transition: all 0.3s ease;
        }

        .navMenu a:hover .dot,
        .navMenu a.active .dot {
            opacity: 1;
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
            color: var(--primary);
            font-size: 1.5rem;
            font-weight: 600;
        }

        .accordion {
            background-color: var(--secondary);
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
            margin-bottom: 1rem;
            padding: 1rem;
        }

        .accordion-item {
            border-bottom: 1px solid var(--border);
        }

        .accordion-header {
            padding: 1rem;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: var(--secondary);
            font-weight: 800;
            color: var(--primary);
        }

        .accordion-header:hover {
            background-color: var(--hover-bg);
        }

        .accordion-title {
            color: var(--primary);
        }

        .accordion-content {
            padding: 1rem;
            display: none;
            overflow: hidden;
            text-align: justify;
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 20px;
        }

        .accordion-content p {
            margin-bottom: 0.5rem;
        }

        .description {
            grid-column: span 2;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            body {
                padding: 10px;
            }

            .navMenu {
                flex-direction: column;
                gap: 0.5rem;
            }

            .navMenu a {
                width: 100%;
                text-align: center;
            }

            .container {
                padding: 0 1rem;
            }

            .title {
                font-size: 1.2rem;
            }
        }
    </style>
</head>

<body>
    <nav class="navMenu">
        <a href="/customer/appointment/appoint" target="_self">New Vehicle<span class="dot"></span></a>
        <a href="/customer/vehicle/all" target="_self">My Vehicle<span class="dot"></span></a>
        <a href="#" class="active">Service History<span class="dot"></span></a>
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