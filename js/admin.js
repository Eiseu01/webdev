$(document).ready(function () {
  // Event listener for navigation links
  $(".nav-link").on("click", function (e) {
    e.preventDefault(); // Prevent default anchor click behavior
    $(".nav-link").removeClass("link-active"); // Remove active class from all links
    $(this).addClass("link-active"); // Add active class to the clicked link

    let url = $(this).attr("href"); // Get the URL from the href attribute
    window.history.pushState({ path: url }, "", url); // Update the browser's URL without reloading
  });

  function PasswordChanged(txt) {
    $(txt).prev().val($(txt).val());
  }

  $("#dashboard-link").on("click", function (e) {
    e.preventDefault(); // Prevent default behavior
    viewDashboard(); // Call the function to load analytics
  });

  $("#users-link").on("click", function (e) {
    e.preventDefault(); // Prevent default behavior
    viewUsers(); // Call the function to load analytics
  });

  $("#manage-link").on("click", function (e) {
    e.preventDefault(); // Prevent default behavior
    viewEvents(); // Call the function to load analytics
  });

  $("#notifications-link").on("click", function (e) {
    e.preventDefault(); // Prevent default behavior
    viewNotifications(); // Call the function to load analytics
  });

  $("#profile-link").on("click", function (e) {
    e.preventDefault(); // Prevent default behavior
    viewProfile(); // Call the function to load analytics
  });


  // Determine which page to load based on the current URL
  let url = window.location.href;
  if (url.endsWith("dashboard.php")) {
    $("#dashboard-link").trigger("click"); // Trigger the dashboard click event
  } else if (url.endsWith("users.php")) {
    $("#users-link").trigger("click"); // Trigger the products click event
  } else if (url.endsWith("events.php")) {
    $("#manage-link").trigger("click"); // Default to dashboard if no specific page
  } else if (url.endsWith("profile.php")) {
    $("#profile-link").trigger("click"); // Default to dashboard if no specific page
  } else if (url.endsWith("notifications.php")) {
    $("#notifications-link").trigger("click"); // Default to dashboard if no specific page
  }

  function viewDashboard() {
    $.ajax({
      type: "GET", // Use GET request
      url: "../admin/dashboard-view.php", // URL for the analytics view
      dataType: "html", // Expect HTML response
      success: function (response) {
        $(".content-page").html(response); // Load the response into the content area
      },
    });
  }
  
  function viewProfile() {
    $.ajax({
      type: "GET", // Use GET request
      url: "../admin/profile-view.php", // URL for the analytics view
      dataType: "html", // Expect HTML response
      success: function (response) {
        $(".content-page").html(response); // Load the response into the content area
      },
    });
  }
  
  function viewEvents() {
    $.ajax({
      type: "GET", // Use GET request
      url: "../admin/events-view.php", // URL for the analytics view
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

  function reject(eventId) {
    $.ajax({
      url: `../admin/reject.php`,
      type: "GET",
      datatype: "html",
      success: function (view) {
        $(".modal-container").empty().html(view); // Load the modal view
        $("#staticBackdropedit").modal("show"); // Show the modal
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
        $(".modal-container").empty().html(view); // Load the modal view
        $("#staticBackdropedit").modal("show"); // Show the modal
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
        $(".modal-container").empty().html(view); // Load the modal view
        $("#staticBackdropedit").modal("show"); // Show the modal
        $("#event_id").val(eventId);
      },
    });
  }

  function viewUsers() {
    $.ajax({
      type: "GET", // Use GET request
      url: "../admin/users-view.php", // URL for the analytics view
      dataType: "html", // Expect HTML response
      success: function (response) {
        $(".content-page").html(response); // Load the response into the content area

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

        $(".modal-container").empty().html(view); // Load the modal view
        $("#staticBackdropedit").modal("show"); // Show the modal
        $("#staticBackdropedit").attr("data-id", userId);

        $("#form-edit-user").on("submit", function (e) {
          e.preventDefault(); // Prevent default form submission
          updateUser(userId); // Call function to save product
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
        console.log("Status:", status); // Logs the status (e.g., "timeout", "error", etc.)
        console.log("Error:", error); // Logs the error message
        console.log("Response text:", xhr.responseText); // Logs the raw response from the server
      },
    });
  }

  function fetchCourse() {
    $.ajax({
      url: "../admin/fetch-course.php", // URL for fetching categories
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
      url: `../admin/fetch-user.php?user_id=${userId}`, // URL for fetching categories
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
        $("#role").val(user.role);
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
});
