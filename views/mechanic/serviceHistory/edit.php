<!DOCTYPE html>
<html lang="en">
<!-- [Previous head and style sections remain the same] -->
<head>
    <meta charset="UTF-8">
    <title>Edit Vehicle Service</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --text: #f5f5f5;
            --background: #181a20;
            --primary: #C0C0C0FF;
            --secondary: #25272d;
            --accent: #2463eb;
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

        .btn {
            padding: 0.5rem 1rem;
            margin: 0 0.25rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            font-size: 0.875rem;
            min-width: 100px;
            text-align: center;
        }

        .btn-primary {
            background: var(--accent);
            color: var(--text);
        }

        .btn-secondary {
            background: var(--primary);
            color: var(--secondary);
        }

        .btn-danger {
            background: #dc3545;
            color: var(--text);
        }

        .btn:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>
<nav class="navMenu">
    <a href="/mechanic/serviceHistory/edit" class="active">All Services</a>
    <a href="/mechanic/serviceHistory/edit" target="_self">Edit Services</a>
    <a href="/mechanic/serviceHistory/delete" target="_self">Delete Services</a>
</nav>

<script>
function editServiceDetails(record) {
    const modal = document.createElement('div');
    modal.style.position = 'fixed';
    modal.style.top = '0';
    modal.style.left = '0';
    modal.style.width = '100%';
    modal.style.height = '100%';
    modal.style.backgroundColor = 'rgba(0, 0, 0, 0.8)';
    modal.style.display = 'flex';
    modal.style.justifyContent = 'center';
    modal.style.alignItems = 'center';
    modal.style.zIndex = '1000';

    const content = document.createElement('div');
    content.style.backgroundColor = 'var(--secondary)';
    content.style.padding = '2rem';
    content.style.borderRadius = '12px';
    content.style.minWidth = '500px';
    content.style.color = 'var(--text)';
    content.style.position = 'relative';

    content.innerHTML = `
        <h2 style="color: var(--primary); margin-bottom: 1.5rem; text-align: center;">Edit Service Record</h2>
        <form id="editForm" method="POST">
            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem;">Vehicle</label>
                <input type="text" value="\${record.license_plate_no}" disabled 
                       style="width: 100%; padding: 0.5rem; background: var(--background); color: var(--text); border: 1px solid var(--border); border-radius: 4px;">
            </div>
            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem;">Service Type</label>
                <input type="text" value="\${record.service_type}" disabled 
                       style="width: 100%; padding: 0.5rem; background: var(--background); color: var(--text); border: 1px solid var(--border); border-radius: 4px;">
            </div>
            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem;">Begin Time</label>
                <input type="datetime-local" name="begin_timestamp" value="\${record.begin_timestamp.replace(' ', 'T')}" required 
                       style="width: 100%; padding: 0.5rem; background: var(--background); color: var(--text); border: 1px solid var(--border); border-radius: 4px;">
            </div>
            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem;">End Time</label>
                <input type="datetime-local" name="end_timestamp" value="\${record.end_timestamp.replace(' ', 'T')}" required 
                       style="width: 100%; padding: 0.5rem; background: var(--background); color: var(--text); border: 1px solid var(--border); border-radius: 4px;">
            </div>
            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem;">Notes</label>
                <textarea name="notes" rows="4" style="width: 100%; padding: 0.5rem; background: var(--background); color: var(--text); border: 1px solid var(--border); border-radius: 4px;">\${record.notes}</textarea>
            </div>
            <div style="display: flex; gap: 1rem;">
                <button type="submit" style="flex: 1; background: var(--accent); color: var(--text); border: none; padding: 0.75rem; border-radius: 4px; cursor: pointer;">Update</button>
                <button type="button" onclick="this.closest('.modal-container').remove()" 
                        style="flex: 1; background: var(--border); color: var(--text); border: none; padding: 0.75rem; border-radius: 4px; cursor: pointer;">Cancel</button>
            </div>
        </form>
    `;

    modal.classList.add('modal-container');
    modal.appendChild(content);
    document.body.appendChild(modal);

    // Add form submit handler
    const form = content.querySelector('#editForm');
    form.onsubmit = async (e) => {
        e.preventDefault();
        const formData = new FormData(form);
        const formDataObj = {};
        formData.forEach((value, key) => formDataObj[key] = value);

        try {
            const response = await fetch(\`/mechanic/serviceHistory/update/\${record.id}\`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(formDataObj)
            });

            const data = await response.json();
            
            if (data.success) {
                window.location.reload();
            } else {
                alert(data.message || 'Failed to update record');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred while updating');
        }
    };

    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.remove();
        }
    });
}
</script>
</body>
</html>
