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

  $("#reservations-link").on("click", function (e) {
    e.preventDefault(); // Prevent default behavior
    viewReservations(); // Call the function to load analytics
  });

  $("#notifications-link").on("click", function (e) {
    e.preventDefault();
    viewNotifications();
  });

  // Determine which page to load based on the current URL
  let url = window.location.href;
  if (url.endsWith("dashboard.php")) {
    $("#dashboard-link").trigger("click"); // Trigger the dashboard/home click event
  } else if (url.endsWith("reservations.php")) {
    $("#reservations-link").trigger("click"); // Trigger the reservations click event
  } else if (url.endsWith("profile.php")) {
    $("#profile-link").trigger("click"); // Trigger the reservations click event
  } else if (url.endsWith("notifications.php")) {
    $("#notifications-link").trigger("click"); // Trigger the reservations click event
  }

  function viewEvents() {
    $.ajax({
      type: "GET", 
      url: "../user/dashboard-view.php", 
      dataType: "html",
      success: function (response) {
        $(".content-page").html(response);

        var table = $("#table-products").DataTable({
          dom: "rtp", 
          pageLength: 10, 
          ordering: false, 
        });

        $("#custom-search").on("keyup", function () {
          table.search(this.value).draw(); 
        });

        $("#category-filter").on("change", function () {
          if (this.value !== "choose") {
            table.column(7).search(this.value).draw(); // Filter products by selected category
          }
        });

        $(".register-btn").on("click", function (e) {
          e.preventDefault();
          registerModal(this.dataset.id);
        });

        $(".cancel-btn").on("click", function (e) {
          e.preventDefault();
          cancelModal(this.dataset.id);
        });
      },
    });
  }

  function registerModal(eventId) {
    $.ajax({
      url: `../modals/register.php`,
      type: "GET",
      datatype: "html",
      success: function (view) {
        $(".modal-container").empty().html(view);
        $("#staticBackdropedit").modal("show");
        $("#event_id").val(eventId);
      },
    });
  }

  function cancelModal(eventId) {
    $.ajax({
      url: `../modals/cancel.php`,
      type: "GET",
      datatype: "html",
      success: function (view) {
        $(".modal-container").empty().html(view);
        $("#staticBackdropedit").modal("show");
        $("#event_id").val(eventId);
      },
    });
  }

  function viewNotifications() {
    $.ajax({
      type: "GET",
      url: "../user/notifications-view.php",
      dataType: "html",
      success: function (response) {
        $(".content-page").html(response);

        var table = $("#table-products").DataTable({
          dom: "rtp", // Set DataTable options
          pageLength: 10, // Default page length
          ordering: false, // Disable ordering
        });

        // Bind custom input to DataTable search
        $("#custom-search").on("keyup", function () {
          table.search(this.value).draw(); // Search products based on input
        });

        $(".trash").on("click", function (e) {
          e.preventDefault();
          deleteNotification(this.dataset.id);
        });
      },
    });
  }

  function deleteNotification(notifId) {
    $.ajax({
      url: `../modals/deleteNotification.php`,
      type: "GET",
      datatype: "html",
      success: function (view) {
        $(".modal-container").empty().html(view); // Load the modal view
        $("#staticBackdropedit").modal("show"); // Show the modal
        $("#notification_id").val(notifId);
      },
    });
  }

  function viewReservations() {
    $.ajax({
      type: "GET",
      url: "../user/reservations-view.php",
      dataType: "html",
      success: function (response) {
        $(".content-page").html(response);

        var table = $("#table-products").DataTable({
          dom: "rtp",
          pageLength: 10,
          ordering: false,
        });

        $("#custom-search").on("keyup", function () {
          table.search(this.value).draw();
        });

        $(".view-ticket").on("click", function (e) {
          e.preventDefault();
          viewTicket(this.dataset.id);
        });
      },
    });
  }

  function viewTicket(reservationId) {
    $.ajax({
      url: `../modals/view-ticket.php`,
      type: "GET",
      datatype: "html",
      success: function (view) {
        fetchTicketInfo(reservationId);

        $(".modal-container").empty().html(view);
        $("#staticBackdropedit").modal("show");
      },
    });
  }

  function fetchTicketInfo(reservationId) {
    $.ajax({
      url: `../tools/fetch-ticket.php?reservation_id=${reservationId}`,
      type: "POST",
      dataType: "json",
      success: function (user) {
        console.log(user);
        $("#name").val(`Name: ${user.last_name}, ${user.first_name} ${user.middle_name}`);
        $("#event").val("Event Name: " + user.event_name);
        $("#venue").val("Venue: " + user.location);
        $("#date").val("Date: " + user.date);
        $("#time").val(`Time: ${user.start_time} - ${user.end_time}`);
      },
    });
  }
  
  function viewProfile() {
    $.ajax({
      type: "GET",
      url: "../user/profile-view.php",
      dataType: "html",
      success: function (response) {
        $(".content-page").html(response);
      },
    });
  }

});
