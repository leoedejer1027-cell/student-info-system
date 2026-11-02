function confirmDelete(id) {
    if (confirm("Are you sure you want to delete this student record?")) {
        window.location.href = "delete_student.php?id=" + id;
    }
}