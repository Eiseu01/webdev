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

  // Event listener for the dashboard link
  $("#dashboard-link").on("click", function (e) {
    e.preventDefault(); // Prevent default behavior
    viewProposedEvents(); // Call the function to load analytics
  });

  $("#users-link").on("click", function (e) {
    e.preventDefault(); // Prevent default behavior
    viewUsers(); // Call the function to load analytics
  });

  $("#notifications-link").on("click", function (e) {
    e.preventDefault(); // Prevent default behavior
    viewNotifications(); // Call the function to load analytics
  });

  // Determine which page to load based on the current URL
  let url = window.location.href;
  console.log(url);
  if (url.endsWith("dashboard.php")) {
    $("#dashboard-link").trigger("click"); // Trigger the dashboard/home click event
  } else if (url.endsWith("users.php")) {
    $("#users-link").trigger("click"); // Trigger the notifications click event
  } else if (url.endsWith("notifications.php")) {
    $("#notifications-link").trigger("click"); // Trigger the reservations click event
  } else if (url.endsWith("profile.php")) {
    $("#profile-link").trigger("click"); // Trigger the reservations click event
  }

  function viewUsers() {
    $.ajax({
      type: "GET", // Use GET request
      url: "../staff/users-view.php", // URL for the analytics view
      dataType: "html", // Expect HTML response
      success: function (response) {
        $(".content-page").html(response); // Load the response into the content area
        
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
      },
    });
  }


  // Function to load analytics view
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

        $(".edit").on("click", function (e) {
          e.preventDefault();
          editEvent(this.dataset.id);
        });

        $(".delete").on("click", function (e) {
          e.preventDefault();
          deleteEvent(this.dataset.id);
        });

        $("#addEvent").on("click", function (e) {
          e.preventDefault();
          addEvent();
        });
      },
    });
  }

  function deleteEvent(eventId) {
    $.ajax({
      url: `../staff/deleteEvent.php`,
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
      url: `../staff/addEvent.html`,
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
      url: `../staff/addEvent.php`,
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
      url: `../staff/editEvent.html`,
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
      url: `../staff/editEvent.php?event_id=${eventId}`,
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
      url: `../staff/fetch-event.php?event_id=${eventId}`, // URL for fetching categories
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
        $("#capacity").val(event.capacity);
      },
    });
  }

  function fetchCourse() {
    $.ajax({
      url: "../staff/fetch-course.php", // URL for fetching categories
      type: "GET", // Use GET request
      dataType: "json", // Expect JSON response
      success: function (data) {
        // Clear existing options and add a default "Select" option
        $("#course_id").empty().append('<option value="">--Select--</option>');

        // Append each category to the select dropdown
        $.each(data, function (index, course) {
          $("#course_id").append(
            $("<option>", {
              value: course.course_id, // Value attribute
              text: course.course_code, // Displayed text
            })
          );
        });
      },
    });
  }

  function fetchUser(userId) {
    $.ajax({
      url: `../staff/fetch-user.php?user_id=${userId}`, // URL for fetching categories
      type: "POST", // Use GET request
      dataType: "json", // Expect JSON response
      success: function (user) {
        console.log(user);
        $("#username").val(user.username);
        $("#last_name").val(user.last_name);
        $("#first_name").val(user.first_name);
        $("#middle_name").val(user.middle_name);
        $("#course_id").val(user.course_id);
        $("#level").val(user.level);
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
});
