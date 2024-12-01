<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GearGuard - Vehicle Transfer Upload</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap");

        :root {
            --text: #f5f5f5;
            --background: #181a20;
            --primary: #c7adad;
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
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .upload-container {
            background: var(--secondary);
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 1200px;
            padding: 2.5rem;
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .title {
            color: var(--primary);
            font-size: 1.8rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .title i {
            color: var(--accent);
        }

        .file-upload-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
        }

        .section-wrapper {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .section-title {
            grid-column: 1 / -1;
            color: var(--accent);
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 1rem;
            border-bottom: 2px solid var(--border);
            padding-bottom: 0.5rem;
        }

        .file-input-wrapper {
            position: relative;
            display: flex;
            flex-direction: column;
            gap: 2.5rem;
            width: 100%;
        }

        .file-input {
            display: none;
        }

        .file-label {
            background: var(--background);
            border: 2px dashed var(--border);
            color: var(--text);
            padding: 2rem;
            text-align: center;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
        }

        .file-label i {
            font-size: 2rem;
            color: var(--accent);
            margin-bottom: 0.5rem;
        }

        .file-label:hover {
            border-color: var(--accent);
            background: var(--hover-bg);
        }

        .file-name {
            margin-top: 0.5rem;
            font-size: 0.9rem;
            color: var(--primary);
            text-overflow: ellipsis;
            white-space: nowrap;
            overflow: hidden;
        }

        .button-group {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            margin-top: 2rem;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-submit {
            background: var(--accent);
            color: var(--text);
            border: none;
        }

        .btn-submit:hover {
            background: #1b4ebd;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .btn-reset {
            background: transparent;
            border: 2px solid var(--border);
            color: var(--text);
        }

        .btn-reset:hover {
            background: var(--hover-bg);
        }

        @media (max-width: 768px) {
            .upload-container {
                padding: 1.5rem;
            }

            .section-wrapper {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div class="upload-container">
        <div class="header">
            <h1 class="title">
                <i class="fas fa-car-alt"></i>
                Vehicle Transfer Upload
            </h1>
        </div>

        <form enctype="multipart/form-data">
            <div class="file-upload-section">
                <div>
                    <div class="section-wrapper">
                        <h3 class="section-title">Vehicle Documentation</h3>
                        <div class="file-input-wrapper">
                            <input type="file" id="digicard" class="file-input" accept=".pdf,.jpg,.jpeg,.png" required>
                            <label for="digicard" class="file-label">
                                <i class="fas fa-file-invoice"></i>
                                Registration Certificate
                                <span class="file-name" id="digicard-name">No file chosen</span>
                            </label>
                        </div>
                        <div class="file-input-wrapper">
                            <input type="file" id="revenue_license" class="file-input" accept=".pdf,.jpg,.jpeg,.png" required>
                            <label for="revenue_license" class="file-label">
                                <i class="fas fa-file-alt"></i>
                                Revenue License
                                <span class="file-name" id="revenue_license-name">No file chosen</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="section-wrapper">
                        <h3 class="section-title">Vehicle Insurance</h3>
                        <div class="file-input-wrapper">
                            <input type="file" id="insurance_certificate" class="file-input" accept=".pdf,.jpg,.jpeg,.png" required>
                            <label for="insurance_certificate" class="file-label">
                                <i class="fas fa-shield-alt"></i>
                                Insurance Certificate
                                <span class="file-name" id="insurance_certificate-name">No file chosen</span>
                            </label>
                        </div>
                        <div class="file-input-wrapper">
                            <input type="file" id="insurance_transfer" class="file-input" accept=".pdf,.jpg,.jpeg,.png">
                            <label for="insurance_transfer" class="file-label">
                                <i class="fas fa-exchange-alt"></i>
                                Insurance Transfer Doc
                                <span class="file-name" id="insurance_transfer-name">No file chosen</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="section-wrapper">
                        <h3 class="section-title">Transfer Forms</h3>
                        <div class="file-input-wrapper">
                            <input type="file" id="mta6" class="file-input" accept=".pdf,.jpg,.jpeg,.png" required>
                            <label for="mta6" class="file-label">
                                <i class="fas fa-file-signature"></i>
                                MTA 6 Transfer Form
                                <span class="file-name" id="mta6-name">No file chosen</span>
                            </label>
                        </div>
                        <div class="file-input-wrapper">
                            <input type="file" id="mta8" class="file-input" accept=".pdf,.jpg,.jpeg,.png" required>
                            <label for="mta8" class="file-label">
                                <i class="fas fa-file-contract"></i>
                                MTA 8 Notification Form
                                <span class="file-name" id="mta8-name">No file chosen</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="section-wrapper">
                        <h3 class="section-title">Identification Documents</h3>
                        <div class="file-input-wrapper">
                            <input type="file" id="seller_nic" class="file-input" accept=".pdf,.jpg,.jpeg,.png" required>
                            <label for="seller_nic" class="file-label">
                                <i class="fas fa-id-card"></i>
                                Seller's NIC
                                <span class="file-name" id="seller_nic-name">No file chosen</span>
                            </label>
                        </div>
                        <div class="file-input-wrapper">
                            <input type="file" id="buyer_nic" class="file-input" accept=".pdf,.jpg,.jpeg,.png" required>
                            <label for="buyer_nic" class="file-label">
                                <i class="fas fa-id-badge"></i>
                                Buyer's NIC
                                <span class="file-name" id="buyer_nic-name">No file chosen</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="section-wrapper">
                        <h3 class="section-title">Transaction Proof</h3>
                        <div class="file-input-wrapper">
                            <input type="file" id="sale_agreement" class="file-input" accept=".pdf,.jpg,.jpeg,.png" required>
                            <label for="sale_agreement" class="file-label">
                                <i class="fas fa-file-contract"></i>
                                Bill of Sale
                                <span class="file-name" id="sale_agreement-name">No file chosen</span>
                            </label>
                        </div>
                        <div class="file-input-wrapper">
                            <input type="file" id="transaction_proof" class="file-input" accept=".pdf,.jpg,.jpeg,.png" required>
                            <label for="transaction_proof" class="file-label">
                                <i class="fas fa-receipt"></i>
                                Payment Proof
                                <span class="file-name" id="transaction_proof-name">No file chosen</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="section-wrapper">
                        <h3 class="section-title">Vehicle Condition</h3>
                        <div class="file-input-wrapper">
                            <input type="file" id="emission_test" class="file-input" accept=".pdf,.jpg,.jpeg,.png" required>
                            <label for="emission_test" class="file-label">
                                <i class="fas fa-wind"></i>
                                Emission Test Certificate
                                <span class="file-name" id="emission_test-name">No file chosen</span>
                            </label>
                        </div>
                        <div class="file-input-wrapper">
                            <input type="file" id="vehicle_condition" class="file-input" accept=".pdf,.jpg,.jpeg,.png">
                            <label for="vehicle_condition" class="file-label">
                                <i class="fas fa-car"></i>
                                Vehicle Condition Report
                                <span class="file-name" id="vehicle_condition-name">No file chosen</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="section-wrapper">
                        <h3 class="section-title">Financial Documents</h3>
                        <div class="file-input-wrapper">
                            <input type="file" id="loan_clearance" class="file-input" accept=".pdf,.jpg,.jpeg,.png">
                            <label for="loan_clearance" class="file-label">
                                <i class="fas fa-money-check-alt"></i>
                                Loan Clearance Letter
                                <span class="file-name" id="loan_clearance-name">No file chosen</span>
                            </label>
                        </div>
                        <div class="file-input-wrapper">
                            <input type="file" id="additional_financial" class="file-input" accept=".pdf,.jpg,.jpeg,.png">
                            <label for="additional_financial" class="file-label">
                                <i class="fas fa-file-invoice-dollar"></i>
                                Additional Financial Docs
                                <span class="file-name" id="additional_financial-name">No file chosen</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="section-wrapper">
                        <h3 class="section-title">Additional Documents</h3>
                        <div class="file-input-wrapper">
                            <input type="file" id="vehicle_manual" class="file-input" accept=".pdf,.jpg,.jpeg,.png">
                            <label for="vehicle_manual" class="file-label">
                                <i class="fas fa-book"></i>
                                Vehicle Manual
                                <span class="file-name" id="vehicle_manual-name">No file chosen</span>
                            </label>
                        </div>
                        <div class="file-input-wrapper">
                            <input type="file" id="service_records" class="file-input" accept=".pdf,.jpg,.jpeg,.png">
                            <label for="service_records" class="file-label">
                                <i class="fas fa-history"></i>
                                Service Records
                                <span class="file-name" id="service_records-name">No file chosen</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="button-group">
                <button type="reset" class="btn btn-reset">
                    <i class="fas fa-undo"></i>
                    Reset
                </button>
                <button type="submit" class="btn btn-submit">
                    <i class="fas fa-upload"></i>
                    Upload Documents
                </button>
            </div>
        </form>
    </div>

    <script>
        document.querySelectorAll('.file-input').forEach