$(document).ready(function () {
  // Event listener for navigation links
  var table = $("#table-products").DataTable({
    dom: "rtp", // Set DataTable options
    pageLength: 10, // Default page length
    ordering: false, // Disable ordering
  });

  // Bind custom input to DataTable search
  $("#custom-search").on("keyup", function () {
    table.search(this.value).draw(); // Search products based on input
  });

  $("#category-filter").on("change", function () {
    if (this.value !== "choose") {
      table.column(6).search(this.value).draw(); // Filter products by selected category
    }
  }); 

});
