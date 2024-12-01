$(document).ready(function () {
  // Event listener for navigation links
  $(".nav-link").on("click", function (e) {
    e.preventDefault(); // Prevent default anchor click behavior
    $(".nav-link").removeClass("link-active"); // Remove active class from all links
    $(this).addClass("link-active"); // Add active class to the clicked link

    let url = $(this).attr("href"); // Get the URL from the href attribute
    window.history.pushState({ path: url }, "", url); // Update the browser's URL without reloading
  });

  $("#profile-link").on("click", function (e) {
    e.preventDefault(); // Prevent default behavior
    viewProfile(); // Call the function to load analytics
  });

  $("#dashboard-link").on("click", function (e) {
    e.preventDefault(); // Prevent default behavior
    viewEvents(); // Call the function to load analytics
  });

  $("#notifications-link").on("click", function (e) {
    e.preventDefault(); // Prevent default behavior
    viewNotifications(); // Call the function to load analytics
  });

  $("#reservations-link").on("click", function (e) {
    e.preventDefault(); // Prevent default behavior
    viewReservations(); // Call the function to load analytics
  });

  // Determine which page to load based on the current URL
  let url = window.location.href;
  if (url.endsWith("dashboard.php")) {
    $("#dashboard-link").trigger("click"); // Trigger the dashboard/home click event
  } else if (url.endsWith("notifications.php")) {
    $("#notifications-link").trigger("click"); // Trigger the notifications click event
  } else if (url.endsWith("reservations.php")) {
    $("#reservations-link").trigger("click"); // Trigger the reservations click event
  } else if (url.endsWith("profile.php")) {
    $("#profile-link").trigger("click"); // Trigger the reservations click event
  }

  // Function to load analytics view
  function viewEvents() {
    $.ajax({
      type: "GET", // Use GET request
      url: "../user/dashboard-view.php", // URL for the analytics view
      dataType: "html", // Expect HTML response
      success: function (response) {
        $(".content-page").html(response); // Load the response into the content area

        // Initialize DataTable for product table
        var table = $("#table-products").DataTable({
          dom: "rtp", // Set DataTable options
          pageLength: 10, // Default page length
          ordering: false, // Disable ordering
        });

        // Bind custom input to DataTable search
        $("#custom-search").on("keyup", function () {
          table.search(this.value).draw(); // Search products based on input
        });

        $(".register-btn").on("click", function (e) {
          e.preventDefault();
          registerModal(this.dataset.id);
        });
      },
    });
  }

  function registerModal(eventId) {
    $.ajax({
      url: `../user/register.php`,
      type: "GET",
      datatype: "html",
      success: function (view) {
        $(".modal-container").empty().html(view); // Load the modal view
        $("#staticBackdropedit").modal("show"); // Show the modal
        $("#event_id").val(eventId);
      },
    });
  }

  function viewNotifications() {
    $.ajax({
      type: "GET", // Use GET request
      url: "../user/notifications-view.php", // URL for the analytics view
      dataType: "html", // Expect HTML response
      success: function (response) {
        $(".content-page").html(response); // Load the response into the content area
      },
    });
  }

  function viewReservations() {
    $.ajax({
      type: "GET", // Use GET request
      url: "../user/reservations-view.php", // URL for the analytics view
      dataType: "html", // Expect HTML response
      success: function (response) {
        $(".content-page").html(response); // Load the response into the content area

        // Initialize DataTable for product table
        var table = $("#table-products").DataTable({
          dom: "rtp", // Set DataTable options
          pageLength: 10, // Default page length
          ordering: false, // Disable ordering
        });

        // Bind custom input to DataTable search
        $("#custom-search").on("keyup", function () {
          table.search(this.value).draw(); // Search products based on input
        });
      },
    });
  }
  
  function viewProfile() {
    $.ajax({
      type: "GET", // Use GET request
      url: "../user/profile-view.php", // URL for the analytics view
      dataType: "html", // Expect HTML response
      success: function (response) {
        $(".content-page").html(response); // Load the response into the content area
      },
    });
  }

});
