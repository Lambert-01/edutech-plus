// Function to load dashboard content dynamically
function loadDashboardContent(page) {
fetch(page)
.then(response => response.text())
.then(data => {
document.getElementById("dashboard-content").innerHTML = data;
})
.catch(error => console.error('Error loading dashboard content:', error));
}

// Initial load of default dashboard content (home page, for example)
document.addEventListener("DOMContentLoaded", function() {
loadDashboardContent("dashboard_home.php");
});

// Event listeners for menu links
document.querySelectorAll(".menu a").forEach(function(link) {
link.addEventListener("click", function(event) {
event.preventDefault(); // Prevent default link behavior
var page = this.getAttribute("href");
loadDashboardContent(page);
});
});