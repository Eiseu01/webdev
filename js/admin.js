$(document).ready(function () {
  // Event listener for navigation links
  $(".nav-link").on("click", function (e) {
    e.preventDefault(); // Prevent default anchor click behavior
    $(".nav-link").removeClass("link-active"); // Remove active class from all links
    $(this).addClass("link-active"); // Add active class to the clicked link

    let url = $(this).attr("href"); // Get the URL from the href attribute
    window.history.pushState({ path: url }, "", url); // Update the browser's URL without reloading
  });

  $("#dashboard-link").on("click", function (e) {
    e.preventDefault();
    viewDashboard();
  });

  $("#proposedevents-link").on("click", function (e) {
    e.preventDefault();
    viewProposedEvents();
  });

  $("#users-link").on("click", function (e) {
    e.preventDefault();
    viewUsers();
  });

  $("#manage-link").on("click", function (e) {
    e.preventDefault();
    viewEvents();
  });

  $("#finished").on("click", function (e) {
    e.preventDefault();
    viewEventsFinished();
  });

  $("#inprogresss").on("click", function (e) {
    e.preventDefault();
    viewEventsInProgress();
  });

  $("#profile-link").on("click", function (e) {
    e.preventDefault();
    viewProfile();
  });

  $("#participants-link").on("click", function (e) {
    e.preventDefault();
    viewParticipants();
  });


  // Determine which page to load based on the current URL
  let url = window.location.href;
  if (url.endsWith("dashboard.php")) {
    $("#dashboard-link").trigger("click"); // Trigger the dashboard click event
  } else if (url.endsWith("users.php")) {
    $("#users-link").trigger("click"); // Trigger the products click event
  } else if (url.endsWith("profile.php")) {
    $("#profile-link").trigger("click"); // Trigger the notifications click event
  } else if (url.endsWith("proposedeventss.php")) {
    $("#proposedevents-link").trigger("click"); // Trigger the notifications click event
  } else if (url.endsWith("participants.php")) {
    $("#participants-link").trigger("click"); // Trigger the notifications click event
  } else if (url.endsWith("events.php")) {
    $("#manage-link").trigger("click"); // Trigger the manage click event
  } else if (url.endsWith("finished.php")) {
    $("#finished").trigger("click"); // Trigger the manage click event
  } else if (url.endsWith("inprogress.php")) {
    $("#inprogress").trigger("click"); // Trigger the manage click event
  }

  function viewParticipants() {
    $.ajax({
      type: "GET", // Use GET request
      url: "../admin/participants-view.php", // URL for the analytics view
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

        $("#category-filter").on("change", function () {
          if (this.value !== "choose") {
            table.column(5).search(this.value).draw(); // Filter products by selected category
          }
        });

        $(".confirm").on("click", function (e) {
          e.preventDefault();
          confirmReservation(this.dataset.id);
        });

        $(".decline").on("click", function (e) {
          e.preventDefault();
          declineReservation(this.dataset.id);
        });
      },
    });
  }

  function confirmReservation(reservationId) {
    $.ajax({
      url: `../modals/confirm-reservation.php`,
      type: "GET",
      datatype: "html",
      success: function (view) {
        $(".modal-container").empty().html(view); // Load the modal view
        $("#staticBackdropedit").modal("show"); // Show the modal
        $("#reservation_id").val(reservationId);
      },
    });
  }

  function declineReservation(reservationId) {
    $.ajax({
      url: `../modals/decline-reservation.php`,
      type: "GET",
      datatype: "html",
      success: function (view) {
        $(".modal-container").empty().html(view); // Load the modal view
        $("#staticBackdropedit").modal("show"); // Show the modal
        $("#reservation_id").val(reservationId);
      },
    });
  }

  function viewProposedEvents() {
    $.ajax({
      type: "GET", // Use GET request
      url: "../admin/proposedeventss-view.php", // URL for the analytics view
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

        $("#category-filter").on("change", function () {
          if (this.value !== "choose") {
            table.column(5).search(this.value).draw(); // Filter products by selected category
          }
        });

        $(".edit").on("click", function (e) {
          e.preventDefault();
          editEvent(this.dataset.id);
        });

        $(".delete").on("click", function (e) {
          e.preventDefault();
          deleteEvent(this.dataset.id);
        });

        $(".resched").on("click", function (e) {
          e.preventDefault();
          reschedEvent(this.dataset.id);
        });

        $(".addEvent").on("click", function (e) {
          e.preventDefault();
          addEvent();
        });
      },
    });
  }

  function deleteEvent(eventId) {
    $.ajax({
      url: `../modals/deleteEvent.php`,
      type: "GET",
      datatype: "html",
      success: function (view) {
        $(".modal-container").empty().html(view); // Load the modal view
        $("#staticBackdropedit").modal("show"); // Show the modal
        $("#event_id").val(eventId);
      },
    });
  }

  function addEvent() {
    $.ajax({
      url: `../modals/addEvent.html`,
      type: "GET",
      datatype: "html",
      success: function (view) {
        $(".modal-container").empty().html(view); // Load the modal view
        $("#staticBackdropedit").modal("show"); // Show the modal

        $("#form-add-event").on("submit", function (e) {
          e.preventDefault(); // Prevent default form submission
          addNewEvent(); // Call function to save product
        });
      },
    });
  }

  function addNewEvent() {
    console.log("AJAX request is about to be sent");
    $.ajax({
      type: "POST",
      url: `../modals/addEvent.php`,
      data: $("form").serialize(),
      dataType: "json",
      success: function (response) {
        console.log(response);
        if (response.status === "error") {
          // Handle validation errors
          if (response.event_nameErr) {
            $("#event_name").addClass("is-invalid");
            $("#event_name")
              .next(".invalid-feedback")
              .text(response.event_nameErr)
              .show();
          } else {
            $("#event_name").removeClass("is-invalid");
          }
          if (response.event_venueErr) {
            $("#event_venue").addClass("is-invalid");
            $("#event_venue")
              .next(".invalid-feedback")
              .text(response.event_venueErr)
              .show();
          } else {
            $("#event_venue").removeClass("is-invalid");
          }
          if (response.event_descriptionErr) {
            $("#event_description").addClass("is-invalid");
            $("#event_description")
              .next(".invalid-feedback")
              .text(response.event_descriptionErr)
              .show();
          } else {
            $("#event_description").removeClass("is-invalid");
          }
          if (response.dateErr) {
            $("#date").addClass("is-invalid");
            $("#date").next(".invalid-feedback").text(response.dateErr).show();
          } else {
            $("#date").removeClass("is-invalid");
          }
          if (response.start_timeErr) {
            $("#start_time").addClass("is-invalid");
            $("#start_time")
              .next(".invalid-feedback")
              .text(response.start_timeErr)
              .show();
          } else {
            $("#start_time").removeClass("is-invalid");
          }
          if (response.end_timeErr) {
            $("#end_time").addClass("is-invalid");
            $("#end_time")
              .next(".invalid-feedback")
              .text(response.end_timeErr)
              .show();
          } else {
            $("#end_time").removeClass("is-invalid");
          }
          if (response.capacityErr) {
            $("#capacity").addClass("is-invalid");
            $("#capacity")
              .next(".invalid-feedback")
              .text(response.capacityErr)
              .show();
          } else {
            $("#capacity").removeClass("is-invalid");
          }
          if (response.message) {
            $("#timeErr").addClass("is-invalid");
            $("#timeErr")
              .text(response.message)
              .show();
          } else {
            $("#timeErr").removeClass("is-invalid");
          }
        } else if (response.status === "success") {
          // On success, hide modal and reset form
          $("#staticBackdropedit").modal("hide");
          $("form")[0].reset(); // Reset the form
          // Optionally, reload products to show new entry
          viewProposedEvents();
        }
      },
      error: function (xhr, status, error) {
        console.log("AJAX request failed:");
        console.log("Status:", status); // Logs the status (e.g., "timeout", "error", etc.)
        console.log("Error:", error); // Logs the error message
        console.log("Response text:", xhr.responseText); // Logs the raw response from the server
      },
    });
  }

  function editEvent(eventId) {
    $.ajax({
      url: `../modals/editEvent.html`,
      type: "GET",
      datatype: "html",
      success: function (view) {
        fetchEvent(eventId);

        $(".modal-container").empty().html(view); // Load the modal view
        $("#staticBackdropedit").modal("show"); // Show the modal
        $("#staticBackdropedit").attr("data-id", eventId);

        $("#form-edit-event").on("submit", function (e) {
          e.preventDefault(); // Prevent default form submission
          updateEvent(eventId); // Call function to save product
        });
      },
    });
  }

  function updateEvent(eventId) {
    console.log("AJAX request is about to be sent");
    $.ajax({
      type: "POST",
      url: `../modals/editEvent.php?event_id=${eventId}`,
      data: $("form").serialize(),
      dataType: "json",
      success: function (response) {
        console.log(response);
        if (response.status === "error") {
          // Handle validation errors
          if (response.event_nameErr) {
            $("#event_name").addClass("is-invalid");
            $("#event_name")
              .next(".invalid-feedback")
              .text(response.event_nameErr)
              .show();
          } else {
            $("#event_name").removeClass("is-invalid");
          }
          if (response.event_venueErr) {
            $("#event_venue").addClass("is-invalid");
            $("#event_venue")
              .next(".invalid-feedback")
              .text(response.event_venueErr)
              .show();
          } else {
            $("#event_venue").removeClass("is-invalid");
          }
          if (response.event_descriptionErr) {
            $("#event_description").addClass("is-invalid");
            $("#event_description")
              .next(".invalid-feedback")
              .text(response.event_descriptionErr)
              .show();
          } else {
            $("#event_description").removeClass("is-invalid");
          }
          if (response.dateErr) {
            $("#date").addClass("is-invalid");
            $("#date").next(".invalid-feedback").text(response.dateErr).show();
          } else {
            $("#date").removeClass("is-invalid");
          }
          if (response.start_timeErr) {
            $("#start_time").addClass("is-invalid");
            $("#start_time")
              .next(".invalid-feedback")
              .text(response.start_timeErr)
              .show();
          } else {
            $("#start_time").removeClass("is-invalid");
          }
          if (response.end_timeErr) {
            $("#end_time").addClass("is-invalid");
            $("#end_time")
              .next(".invalid-feedback")
              .text(response.end_timeErr)
              .show();
          } else {
            $("#end_time").removeClass("is-invalid");
          }
          if (response.capacityErr) {
            $("#capacity").addClass("is-invalid");
            $("#capacity")
              .next(".invalid-feedback")
              .text(response.capacityErr)
              .show();
          } else {
            $("#capacity").removeClass("is-invalid");
          }
          if (response.message) {
            $("#timeErr").addClass("is-invalid");
            $("#timeErr").text(response.message).show();
          } else {
            $("#timeErr").removeClass("is-invalid");
          }
        } else if (response.status === "success") {
          // On success, hide modal and reset form
          $("#staticBackdropedit").modal("hide");
          $("form")[0].reset(); // Reset the form
          // Optionally, reload products to show new entry
          viewProposedEvents();
        }
      },
      error: function (xhr, status, error) {
        console.log("AJAX request failed:");
        console.log("Status:", status); // Logs the status (e.g., "timeout", "error", etc.)
        console.log("Error:", error); // Logs the error message
        console.log("Response text:", xhr.responseText); // Logs the raw response from the server
      },
    });
  }

  function fetchEvent(eventId) {
    $.ajax({
      url: `../modals/fetch-event.php?event_id=${eventId}`, // URL for fetching categories
      type: "POST", // Use GET request
      dataType: "json", // Expect JSON response
      success: function (event) {
        console.log(event);
        $("#event_name").val(event.event_name);
        $("#event_venue").val(event.location);
        $("#event_description").val(event.event_description);
        $("#date").val(event.date);
        $("#start_time").val(event.start_time);
        $("#end_time").val(event.end_time);
        $("#capacity").val(event.total_capacity);
        $("#progress").val(event.progress_status);
      },
    });
  }

  function reschedEvent(eventId) {
    $.ajax({
      url: `../modals/reschedEvent.html`,
      type: "GET",
      datatype: "html",
      success: function (view) {
        fetchEvent(eventId);

        $(".modal-container").empty().html(view); // Load the modal view
        $("#staticBackdropedit").modal("show"); // Show the modal
        $("#staticBackdropedit").attr("data-id", eventId);

        $("#form-edit-event").on("submit", function (e) {
          e.preventDefault(); // Prevent default form submission
          updateReschedEvent(eventId); // Call function to save product
        });
      },
    });
  }

  function updateReschedEvent(eventId) {
    console.log("AJAX request is about to be sent");
    $.ajax({
      type: "POST",
      url: `../modals/reschedEvent.php?event_id=${eventId}`,
      data: $("form").serialize(),
      dataType: "json",
      success: function (response) {
        console.log(response);
        if (response.status === "error") {
          // Handle validation errors
          if (response.dateErr) {
            $("#date").addClass("is-invalid");
            $("#date")
              .next(".invalid-feedback")
              .text(response.dateErr)
              .show();
          } else {
            $("#date").removeClass("is-invalid");
          }
          if (response.start_timeErr) {
            $("#start_time").addClass("is-invalid");
            $("#start_time")
              .next(".invalid-feedback")
              .text(response.start_timeErr)
              .show();
          } else {
            $("#start_time").removeClass("is-invalid");
          } 
          if (response.end_timeErr) {
            $("#end_time").addClass("is-invalid");
            $("#end_time")
              .next(".invalid-feedback")
              .text(response.end_timeErr)
              .show();
          } else {
            $("#end_time").removeClass("is-invalid");
          } 
          if (response.message) {
            $("#timeErr").addClass("is-invalid");
            $("#timeErr").text(response.message).show();
          } else {
            $("#timeErr").removeClass("is-invalid");
          }
        } else if (response.status === "success") {
          // On success, hide modal and reset form
          $("#staticBackdropedit").modal("hide");
          $("form")[0].reset(); // Reset the form
          // Optionally, reload products to show new entry
          viewProposedEvents();
        }
      },
      error: function (xhr, status, error) {
        console.log("AJAX request failed:");
        console.log("Status:", status); // Logs the status (e.g., "timeout", "error", etc.)
        console.log("Error:", error); // Logs the error message
        console.log("Response text:", xhr.responseText); // Logs the raw response from the server
      },
    });
  }

  function viewDashboard() {
    $.ajax({
      type: "GET", 
      url: "../admin/dashboard-view.php",
      dataType: "html", 
      success: function (response) {
        $(".content-page").html(response);
      },
    });
  }
  
  function viewProfile() {
    $.ajax({
      type: "GET",
      url: "../admin/profile-view.php",
      dataType: "html",
      success: function (response) {
        $(".content-page").html(response);
      },
    });
  }
  
  function viewEvents() {
    $.ajax({
      type: "GET",
      url: "../admin/events-view.php",
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
            table.column(6).search(this.value).draw(); // Filter products by selected category
          }
        });

        $("#finished").on("click", function (e) {
          e.preventDefault();
          viewEventsFinished();
        });

        $("#inprogress").on("click", function (e) {
          e.preventDefault();
          viewEventsInProgress();
        });

        $("#scheduled").on("click", function (e) {
          e.preventDefault();
          viewEvents();
        });

        $(".reject").on("click", function (e) {
          e.preventDefault();
          reject(this.dataset.id);
        });

        $(".cancel").on("click", function (e) {
          e.preventDefault();
          cancel(this.dataset.id);
        });

        $(".approve").on("click", function (e) {
          e.preventDefault();
          approve(this.dataset.id);
        });
      },
    });
  }

  function viewEventsInProgress() {
    $.ajax({
      type: "GET",
      url: "../admin/events-view-inprogress.php",
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
            table.column(6).search(this.value).draw(); // Filter products by selected category
          }
        });

        $("#finished").on("click", function (e) {
          e.preventDefault();
          viewEventsFinished();
        });

        $("#inprogress").on("click", function (e) {
          e.preventDefault();
          viewEventsInProgress();
        });

        $("#scheduled").on("click", function (e) {
          e.preventDefault();
          viewEvents();
        });
      },
    });
  }

  function viewEventsFinished() {
    $.ajax({
      type: "GET",
      url: "../admin/events-view-finished.php",
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
            table.column(6).search(this.value).draw(); // Filter products by selected category
          }
        });

        $("#finished").on("click", function (e) {
          e.preventDefault();
          viewEventsFinished();
        });

        $("#inprogress").on("click", function (e) {
          e.preventDefault();
          viewEventsInProgress();
        });

        $("#scheduled").on("click", function (e) {
          e.preventDefault();
          viewEvents();
        });
      },
    });
  }


  function reject(eventId) {
    $.ajax({
      url: `../admin/reject.php`,
      type: "GET",
      datatype: "html",
      success: function (view) {
        $(".modal-container").empty().html(view);
        $("#staticBackdropedit").modal("show");
        $("#event_id").val(eventId);
      },
    });
  }

  function cancel(eventId) {
    $.ajax({
      url: `../admin/cancel.php`,
      type: "GET",
      datatype: "html",
      success: function (view) {
        $(".modal-container").empty().html(view);
        $("#staticBackdropedit").modal("show");
        $("#event_id").val(eventId);
      },
    });
  }

  function approve(eventId) {
    $.ajax({
      url: `../admin/approve.php`,
      type: "GET",
      datatype: "html",
      success: function (view) {
        $(".modal-container").empty().html(view);
        $("#staticBackdropedit").modal("show");
        $("#event_id").val(eventId);
      },
    });
  }

  function viewUsers() {
    $.ajax({
      type: "GET",
      url: "../admin/users-view.php",
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

        $("#category-filter").on("change", function () {
          if (this.value !== "choose") {
            table.column(5).search(this.value).draw(); // Filter products by selected category
          }
        });

        $(".manage-user").on("click", function (e) {
          e.preventDefault();
          editUser(this.dataset.id);
        });
        
      },
    });
  }

  function editUser(userId) {
    $.ajax({
      url: `../admin/editUser.html`,
      type: "GET",
      datatype: "html",
      success: function (view) {
        fetchCourse();
        fetchUser(userId);

        $(".modal-container").empty().html(view);
        $("#staticBackdropedit").modal("show");
        $("#staticBackdropedit").attr("data-id", userId);

        $("#form-edit-user").on("submit", function (e) {
          e.preventDefault();
          updateUser(userId);
        });
      },
    });
  }


  function updateUser(userId) {
    console.log("AJAX request is about to be sent");
    $.ajax({
      type: "POST",
      url: `../admin/editUser.php?user_id=${userId}`,
      data: $("form").serialize(),
      dataType: "json",
      success: function (response) {
        console.log(response);
        if (response.status === "error") {
          // Handle validation errors
          if (response.usernameErr) {
            $("#username").addClass("is-invalid");
            $("#username")
              .next(".invalid-feedback")
              .text(response.usernameErr)
              .show();
          } else {
            $("#username").removeClass("is-invalid");
          }
          if (response.first_nameErr) {
            $("#first_name").addClass("is-invalid");
            $("#first_name")
              .next(".invalid-feedback")
              .text(response.first_nameErr)
              .show();
          } else {
            $("#first_name").removeClass("is-invalid");
          }
          if (response.last_nameErr) {
            $("#last_name").addClass("is-invalid");
            $("#last_name")
              .next(".invalid-feedback")
              .text(response.last_nameErr)
              .show();
          } else {
            $("#last_name").removeClass("is-invalid");
          }
          if (response.middle_nameErr) {
            $("#middle_name").addClass("is-invalid");
            $("#middle_name")
              .next(".invalid-feedback")
              .text(response.middle_nameErr)
              .show();
          } else {
            $("#middle_name").removeClass("is-invalid");
          }
          if (response.course_idErr) {
            $("#course_id").addClass("is-invalid");
            $("#course_id")
              .next(".invalid-feedback")
              .text(response.course_idErr)
              .show();
          } else {
            $("#course_id").removeClass("is-invalid");
          }
          if (response.levelErr) {
            $("#level").addClass("is-invalid");
            $("#level")
              .next(".invalid-feedback")
              .text(response.levelErr)
              .show();
          } else {
            $("#level").removeClass("is-invalid");
          }
          if (response.roleErr) {
            $("#role").addClass("is-invalid");
            $("#role").next(".invalid-feedback").text(response.roleErr).show();
          } else {
            $("#role").removeClass("is-invalid");
          }
          if (response.passwordErr) {
            $("#password").addClass("is-invalid");
            $("#password")
              .next(".invalid-feedback")
              .text(response.passwordErr)
              .show();
          } else {
            $("#password").removeClass("is-invalid");
          }
        } else if (response.status === "success") {
          // On success, hide modal and reset form
          $("#staticBackdropedit").modal("hide");
          $("form")[0].reset(); // Reset the form
          // Optionally, reload products to show new entry
          viewUsers();
        }
      },
      error: function (xhr, status, error) {
        console.log("AJAX request failed:");
        console.log("Status:", status);
        console.log("Error:", error);
        console.log("Response text:", xhr.responseText);
      },
    });
  }

  function fetchCourse() {
    $.ajax({
      url: "../admin/fetch-course.php",
      type: "GET",
      dataType: "json",
      success: function (data) {
        $("#course_id").empty().append('<option value="">--Select--</option>');

        $.each(data, function (index, course) {
          $("#course_id").append(
            $("<option>", {
              value: course.course_id,
              text: course.course_code,
            })
          );
        });
      },
    });
  }

  function fetchUser(userId) {
    $.ajax({
      url: `../admin/fetch-user.php?user_id=${userId}`,
      type: "POST",
      dataType: "json",
      success: function (user) {
        console.log(user);
        $("#username").val(user.username);
        $("#last_name").val(user.last_name);
        $("#first_name").val(user.first_name);
        $("#middle_name").val(user.middle_name);
        $("#course_id").val(user.course_id);
        $("#level").val(user.level);
        $("#role").val(user.role);
      },
    });
  }

  function viewNotifications() {
    $.ajax({
      type: "GET",
      url: "../staff/notifications-view.php", 
      dataType: "html",
      success: function (response) {
        $(".content-page").html(response);
      },
    });
  }
});
