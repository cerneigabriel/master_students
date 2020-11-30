(function () {
  var username_changed = false;
  var checkusername_url = "/api/auth/checkusername";
  var checkusername_method = "get";

  $("#first_name, #last_name").on("keyup", function () {
    var first_name = $("#first_name").val().toLowerCase();
    var last_name = $("#last_name").val().toLowerCase();

    generateUsername(`${first_name}_${last_name}`);
  });

  $("#username").on("keyup", function () {
    username_changed = true;
  });

  $("#username").on("change", function () {
    $.ajax({
      url: checkusername_url,
      type: checkusername_method,
      data: {
        username: $(this).val(),
      },
    })
      .done(function (response) {
        console.log(response);
      })
      .catch(function (error) {
        console.log(error);
      });
  });

  function generateUsername(username) {
    if (!username_changed) $("#username").val(username);
  }
})();
