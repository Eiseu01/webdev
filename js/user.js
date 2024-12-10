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

  // Determine which page to load based on the current URL
  let url = window.location.href;
  if (url.endsWith("dashboard.php")) {
    $("#dashboard-link").trigger("click"); // Trigger the dashboard/home click event
  } else if (url.endsWith("reservations.php")) {
    $("#reservations-link").trigger("click"); // Trigger the reservations click event
  } else if (url.endsWith("profile.php")) {
    $("#profile-link").trigger("click"); // Trigger the reservations click event
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
      url: `../user/register.php`,
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
      url: `../user/cancel.php`,
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
      url: `../user/view-ticket.php`,
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
      url: `../user/fetch-ticket.php?reservation_id=${reservationId}`,
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
