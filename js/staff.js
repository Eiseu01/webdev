$(document).ready(function () {
  // Event listener for navigation links
  $(".nav-link").on("click", function (e) {
    e.preventDefault(); // Prevent default anchor click behavior
    $(".nav-link").removeClass("link-active"); // Remove active class from all links
    $(this).addClass("link-active"); // Add active class to the clicked link

    let url = $(this).attr("href"); // Get the URL from the href attribute
    window.history.pushState({ path: url }, "", url); // Update the browser's URL without reloading
  });

  $(".profile-link").on("click", function (e) {
    e.preventDefault(); // Prevent default behavior
    viewProfile(); // Call the function to load analytics
  });

  $(".events-link").on("click", function (e) {
    e.preventDefault(); // Prevent default behavior
    viewEvents(); // Call the function to load analytics
  });

  $(".dashboard-link").on("click", function (e) {
    e.preventDefault(); // Prevent default behavior
    viewProposedEvents(); // Call the function to load analytics
  });

  $(".users-link").on("click", function (e) {
    e.preventDefault(); // Prevent default behavior
    viewUsers(); // Call the function to load analytics
  });

  $(".reservations-link").on("click", function (e) {
    e.preventDefault(); // Prevent default behavior
    viewReservations(); // Call the function to load analytics
  });

  $(".notifications-link").on("click", function (e) {
    e.preventDefault();
    viewNotifications();
  });

  // Determine which page to load based on the current URL
  let url = window.location.href;
  console.log(url);
  if (url.endsWith("dashboard.php")) {
    $(".dashboard-link").trigger("click"); // Trigger the dashboard/home click event
  } else if (url.endsWith("users.php")) {
    $(".users-link").trigger("click"); // Trigger the notifications click event
  } else if (url.endsWith("profile.php")) {
    $(".profile-link").trigger("click"); // Trigger the reservations click event
  } else if (url.endsWith("events.php")) {
    $(".events-link").trigger("click"); // Trigger the reservations click event
  } else if (url.endsWith("reservations.php")) {
    $(".reservations-link").trigger("click"); // Trigger the reservations click event
  } else if (url.endsWith("notifications.php")) {
    $(".notifications-link").trigger("click"); // Trigger the reservations click event
  }

  function viewEvents() {
    $.ajax({
      type: "GET",
      url: "../staff/events-view.php",
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

        // Register button click handler
        $(".register-btn").on("click", function (e) {
          e.preventDefault();
          registerModal(this.dataset.id); // Call registerModal with the data-id
        });

        // Cancel button click handler
        $(".cancel-btn").on("click", function (e) {
          e.preventDefault();
          cancelModal(this.dataset.id); // Call cancelModal with the data-id
        });

        // View finished events
        $("#finished").on("click", function (e) {
          e.preventDefault();
          viewEventsFinished();
        });

        // View in-progress events
        $("#inprogress").on("click", function (e) {
          e.preventDefault();
          viewEventsInProgress();
        });

        // View scheduled events
        $("#scheduled").on("click", function (e) {
          viewEvents();
        });
      },
    });
  }

   function viewEventsInProgress() {
     $.ajax({
       type: "GET",
       url: "../events-view/events-view-inprogress.php",
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

         // View finished events
         $("#finished").on("click", function (e) {
           e.preventDefault();
           viewEventsFinished();
         });

         // View in-progress events
         $("#inprogress").on("click", function (e) {
           e.preventDefault();
           viewEventsInProgress();
         });

         // View scheduled events
         $("#scheduled").on("click", function (e) {
           viewEvents();
         });
       },
     });
   }

   function viewEventsFinished() {
     $.ajax({
       type: "GET",
       url: "../events-view/events-view-finished.php",
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

         // View finished events
         $("#finished").on("click", function (e) {
           e.preventDefault();
           viewEventsFinished();
         });

         // View in-progress events
         $("#inprogress").on("click", function (e) {
           e.preventDefault();
           viewEventsInProgress();
         });

         // View scheduled events
         $("#scheduled").on("click", function (e) {
           viewEvents();
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

  function viewReservations() {
    $.ajax({
      type: "GET",
      url: "../staff/reservations-view.php",
      dataType: "html",
      success: function (response) {
        $(".content-page").html(response);

        var table = $("#table-products").DataTable({
          dom: "rtp",
          pageLength: 10,
          ordering: false,
        });

        $("#category-filter").on("change", function () {
          if (this.value !== "choose") {
            table.column(5).search(this.value).draw(); // Filter products by selected category
          }
        });

        // Search handler
        $("#custom-search").on("keyup", function () {
          table.search(this.value).draw(); // Perform search in DataTable
        });

        // View ticket handler
        $(".view-ticket").on("click", function (e) {
          e.preventDefault();
          viewTicket(this.dataset.id); // Call viewTicket with the data-id
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

  function viewUsers() {
    $.ajax({
      type: "GET", // Use GET request
      url: "../staff/users-view.php", // URL for the analytics view
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

        // Confirm reservation handler
        $(".confirm").on("click", function (e) {
          e.preventDefault();
          confirmReservation(
            this.dataset.id,
            this.dataset.user,
            this.dataset.event
          );
        });

        // Decline reservation handler
        $(".decline").on("click", function (e) {
          e.preventDefault();
          declineReservation(
            this.dataset.id,
            this.dataset.user,
            this.dataset.event
          );
        });

        // Delete reservation handler
        $(".delete").on("click", function (e) {
          e.preventDefault();
          deleteReservation(this.dataset.id);
        });

        // Attendance absent handler
        $(".absent").on("click", function (e) {
          e.preventDefault();
          attendanceAbsent(this.dataset.id);
        });

        // Attendance present handler
        $(".present").on("click", function (e) {
          e.preventDefault();
          attendancePresent(this.dataset.id);
        });
      },
    }); 
  }

  function attendanceAbsent(reservationId) {
    $.ajax({
      url: `../modals/absent.php`,
      type: "GET",
      datatype: "html",
      success: function (view) {
        $(".modal-container").empty().html(view); // Load the modal view
        $("#staticBackdropedit").modal("show"); // Show the modal
        $("#reservation_id").val(reservationId);
      },
    });
  }

  function attendancePresent(reservationId) {
    $.ajax({
      url: `../modals/present.php`,
      type: "GET",
      datatype: "html",
      success: function (view) {
        $(".modal-container").empty().html(view); // Load the modal view
        $("#staticBackdropedit").modal("show"); // Show the modal
        $("#reservation_id").val(reservationId);
      },
    });
  }

  function confirmReservation(reservationId, userId, eventName) {
    $.ajax({
      url: `../modals/confirm-reservation.php`,
      type: "GET",
      datatype: "html",
      success: function (view) {
        $(".modal-container").empty().html(view); // Load the modal view
        $("#staticBackdropedit").modal("show"); // Show the modal
        $("#reservation_id").val(reservationId);
        $("#user_id").val(userId);
        $("#event_name").val(eventName);
      },
    });
  }

  function declineReservation(reservationId, userId, eventName) {
    $.ajax({
      url: `../modals/decline-reservation.php`,
      type: "GET",
      datatype: "html",
      success: function (view) {
        $(".modal-container").empty().html(view); // Load the modal view
        $("#staticBackdropedit").modal("show"); // Show the modal
        $("#reservation_id").val(reservationId);
        $("#user_id").val(userId);
        $("#event_name").val(eventName);
      },
    });
  }

  function deleteReservation(reservationId) {
    $.ajax({
      url: `../modals/delete-reservation.php`,
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
      url: "../staff/dashboard-view.php", // URL for the analytics view
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

        // Edit event handler
        $(".edit").on("click", function (e) {
          e.preventDefault();
          editEvent(this.dataset.id);
        });

        // Delete event handler
        $(".delete").on("click", function (e) {
          e.preventDefault();
          deleteEvent(this.dataset.id);
        });

        // Reschedule event handler
        $(".resched").on("click", function (e) {
          e.preventDefault();
          reschedEvent(this.dataset.id);
        });

        // Add event handler
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
      url: `../modals/addEventForm.php`,
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
            $("#event_name").next(".invalid-feedback").text(response.event_nameErr) .show();
          } else {
            $("#event_name").removeClass("is-invalid");
          }
          if (response.event_venueErr) {
            $("#event_venue").addClass("is-invalid");
            $("#event_venue") .next(".invalid-feedback").text(response.event_venueErr).show();
          } else {
            $("#event_venue").removeClass("is-invalid");
          }
          if (response.event_descriptionErr) {
            $("#event_description").addClass("is-invalid");
            $("#event_description").next(".invalid-feedback").text(response.event_descriptionErr).show();
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
            $("#start_time").next(".invalid-feedback").text(response.start_timeErr).show();
          } else {
            $("#start_time").removeClass("is-invalid");
          }
          if (response.end_timeErr) {
            $("#end_time").addClass("is-invalid");
            $("#end_time").next(".invalid-feedback").text(response.end_timeErr).show();
          } else {
            $("#end_time").removeClass("is-invalid");
          }
          if (response.capacityErr) {
            $("#capacity").addClass("is-invalid");
            $("#capacity").next(".invalid-feedback").text(response.capacityErr).show();
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
        console.log(event)
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

  function viewNotifications() {
    $.ajax({
      type: "GET", // Use GET request
      url: "../staff/notifications-view.php", // URL for the analytics view
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

        $(".trash").on("click", function (e) {
          e.preventDefault();
          deleteNotification(this.dataset.id);
        });

        $("#truncateNotif").on("click", function (e) {
          e.preventDefault();
          truncateNotification();
        });
      },
    });
  }
  function truncateNotification() {
    $.ajax({
      url: `../modals/truncateNotification.php`,
      type: "GET",
      datatype: "html",
      success: function (view) {
        $(".modal-container").empty().html(view); // Load the modal view
        $("#staticBackdropedit").modal("show"); // Show the modal
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

  function viewProfile() {
    $.ajax({
      type: "GET", // Use GET request
      url: "../staff/profile-view.php", // URL for the analytics view
      dataType: "html", // Expect HTML response
      success: function (response) {
        $(".content-page").html(response); // Load the response into the content area
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
        $("#name").val(
          `Name: ${user.last_name}, ${user.first_name} ${user.middle_name}`
        );
        $("#event").val("Event Name: " + user.event_name);
        $("#venue").val("Venue: " + user.location);
        $("#date").val("Date: " + user.date);
        $("#time").val(`Time: ${user.start_time} - ${user.end_time}`);
      },
    });
  }

});
