<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle Documentation Checklist</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --bg-primary: #0f172a;
            --bg-secondary: #1e293b;
            --text-primary: #f8fafc;
            --text-secondary: #94a3b8;
            --accent-color: #3b82f6;
            --border-color: #334155;
            --hover-color: #1e40af;
            --background: #181a20;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            background-color: var(--background);
            color: var(--text-primary);
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            padding: 2rem;
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
            position: relative;
        }

        .navMenu a.active {
            color: var(--accent);
            background: var(--hover-bg);
        }

        .navMenu a:hover {
            color: var(--accent);
            background: var(--hover-bg);
        }


        .header {
            background: var(--background);
            color: white;
            padding: 1.5rem;
            text-align: center;
        }

        .header h1 {
            font-weight: 700;
            font-size: 1.75rem;
            letter-spacing: -0.025em;
        }

        .documentation-list {
            padding: 1.5rem;
        }

        .doc-item {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            padding: 1rem;
            border-bottom: 1px solid var(--border-color);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .doc-item:last-child {
            border-bottom: none;
        }

        .doc-item:hover {
            background-color: rgba(59, 130, 246, 0.1);
            transform: translateX(10px);
        }

        .doc-number {
            flex-shrink: 0;
            width: 2.5rem;
            height: 2.5rem;
            background-color: var(--accent-color);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }

        .doc-content {
            flex-grow: 1;
        }

        .doc-title {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.25rem;
            display: flex;
            align-items: center;
        }

        .doc-details {
            color: var(--text-secondary);
            font-size: 0.875rem;
        }

        .checkbox {
            margin-left: auto;
            display: flex;
            align-items: center;
        }

        .checkbox input {
            width: 1.25rem;
            height: 1.25rem;
            accent-color: var(--accent-color);
        }

        @media (max-width: 768px) {
            .doc-item {
                flex-direction: column;
            }

            .checkbox {
                margin-top: 0.5rem;
                align-self: flex-start;
            }
        }

        .search-container {
            padding: 1rem;
            background-color: var(--background);
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .search-input {
            flex-grow: 1;
            padding: 0.75rem;
            background-color: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            color: var(--text-primary);
            font-size: 1rem;
        }

        .search-input::placeholder {
            color: var(--text-secondary);
        }

        .search-input:focus {
            outline: none;
            border-color: var(--accent-color);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.25);
        }
    </style>
</head>

<body>
    <nav class="navMenu">
        <a href="/customer/vehicleTransfer/instruction" class="active">Instruction</a>
        <a href="/customer/appointment/my_appointment" target='_self'>Transfer Form</a>
    </nav>

    <div class="header">
        <h1>Vehicle Documentation Checklist</h1>
    </div>
    <div class="search-container">
        <input type="text" class="search-input" placeholder="Search documents..." id="searchInput">
    </div>
    <div class="documentation-list" id="docList"></div>


    <script>
        const documents = [{
                title: "Vehicle Registration Certificate",
                details: "Ensure you have the original vehicle registration certificate (DigiCard) issued by the Department of Motor Traffic.",
                icon: "fa-id-card"
            },
            {
                title: "Vehicle Revenue License",
                details: "Provide the current Revenue License (valid at the time of sale). Renew it if it's expired.",
                icon: "fa-file-invoice-dollar"
            },
            {
                title: "Vehicle Insurance Certificate",
                details: "Include the insurance certificate with the sale and inform the insurance provider.",
                icon: "fa-car-crash"
            },
            {
                title: "Transfer Application Forms",
                details: "Complete MTA 6 and MTA 8 Forms for ownership transfer.",
                icon: "fa-file-signature"
            },
            {
                title: "Seller's National Identity Card",
                details: "Provide a copy of your NIC for the buyer's records.",
                icon: "fa-address-card"
            },
            {
                title: "Buyer's NIC Copy",
                details: "Collect a copy of the buyer's NIC for your records.",
                icon: "fa-id-badge"
            },
            {
                title: "Proof of Payment",
                details: "Prepare a bill of sale signed by both parties as transaction proof.",
                icon: "fa-receipt"
            },
            {
                title: "Emission Test Certificate",
                details: "Provide a valid emission test certificate confirming environmental standards.",
                icon: "fa-wind"
            },
            {
                title: "Vehicle Loan Clearance",
                details: "Obtain a loan clearance letter from the financing institution if applicable.",
                icon: "fa-file-contract"
            },
            {
                title: "Duplicate Key",
                details: "Provide duplicate keys and the key code card if available.",
                icon: "fa-key"
            },
            {
                title: "Service Records",
                details: "Include vehicle manuals and service records for the buyer.",
                icon: "fa-book-medical"
            }
        ];

        const docList = document.getElementById('docList');
        const searchInput = document.getElementById('searchInput');

        function renderDocuments(docs) {
            docList.innerHTML = '';
            docs.forEach((doc, index) => {
                const docItem = document.createElement('div');
                docItem.className = 'doc-item';
                docItem.innerHTML = `
                    <div class="doc-number">${index + 1}</div>
                    <div class="doc-content">
                        <div class="doc-title">
                            <i class="fas ${doc.icon}" style="margin-right: 0.5rem;"></i>
                            ${doc.title}
                        </div>
                        <div class="doc-details">${doc.details}</div>
                    </div>
                    <div class="checkbox">
                        <input type="checkbox">
                    </div>
                `;
                docList.appendChild(docItem);
            });
        }

        searchInput.addEventListener('input', (e) => {
            const searchTerm = e.target.value.toLowerCase();
            const filteredDocs = documents.filter(doc =>
                doc.title.toLowerCase().includes(searchTerm) ||
                doc.details.toLowerCase().includes(searchTerm)
            );
            renderDocuments(filteredDocs);
        });

        renderDocuments(documents);
    </script>
</body>

</html>