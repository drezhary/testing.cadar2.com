// main.js

// Load sidebar from external HTML file
document.getElementById('sidebar-container').innerHTML = fetch('../includes/sidebar.php')
    .then(response => {
        console.log("Fetch Status:", response.status);
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        return response.text();
    })
    .then(data => {
        console.log("Fetched Sidebar HTML:", data);
        document.getElementById('sidebar-container').innerHTML = data;
    })
    .catch(error => {
        console.error("Error fetching sidebar:", error);
    })
    .then(response => response.text())
    .then(data => {
        document.getElementById('sidebar-container').innerHTML = data;

        // Initialize the sidebar toggle functionality after sidebar is loaded
        const sidebar = document.getElementById('sidebar-container');
        const mainContent = document.getElementById('main-content');
        const toggleButton = document.getElementById('sidebarToggle');

        // Toggle sidebar when button is clicked
        toggleButton.addEventListener('click', function () {
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('collapsed');
        });

        // Automatically collapse sidebar on smaller screens
        function adjustSidebar() {
            if (window.innerWidth < 768) {
                sidebar.classList.add('collapsed');
                mainContent.classList.add('collapsed');
            } else {
                sidebar.classList.remove('collapsed');
                mainContent.classList.remove('collapsed');
            }
        }

        // Adjust sidebar when window is resized
        window.addEventListener('resize', adjustSidebar);

        // Call the function on initial load
        adjustSidebar();
    });
