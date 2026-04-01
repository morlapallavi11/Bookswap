// AUTO HIDE ALERTS
setTimeout(() => {
    let alerts = document.querySelectorAll(".alert");
    alerts.forEach(a => a.style.display = "none");
}, 3000);


// CONFIRM DELETE
function confirmDelete() {
    return confirm("Are you sure you want to delete?");
}


// SIMPLE LOADER (OPTIONAL)
function showLoader() {
    document.body.style.opacity = "0.5";
}
function toggleReviews(id) {
    let box = document.getElementById("review-" + id);
    box.style.display = (box.style.display === "none") ? "block" : "none";
}