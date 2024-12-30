"use strict";

require("./bootstrap");

if (role == "user") {
  window.Echo["private"]("users.".concat(userId)).notification(function (event) {
    var link = showPostRoute.replace(':slug', event.post_slug) + '?notify=' + event.id;
    $('#push-notification').prepend("<div class=\"dropdown-item d-flex justify-content-between align-items-center\">\n                                        <span> Post Comment : ".concat(event.post_title.substring(0, 9), "..</span>\n                                        <a href=\"").concat(link, "\"><i class=\"fa fa-eye\"></i></a>\n                                    </div>"));
    count = Number($('#countNotifications').text());
    count++;
    $('#countNotifications').text(count);
  });
} //Admin


if (role == "admin") {
  window.Echo["private"]("admins.".concat(adminId)).notification(function (event) {
    console.log("Notification received:", event);
    $('#notify_push').prepend(" <a class=\"dropdown-item d-flex align-items-center\" href=\"".concat(event.link, "?notify_admin=").concat(event.id, "\">\n                    <div class=\"mr-3\">\n                        <div class=\"icon-circle bg-primary\">\n                            <i class=\"fas fa-file-alt text-white\"></i>\n                        </div>\n                    </div>\n                    <div>\n                        <div class=\"small text-gray-500\">").concat(event.date, "</div>\n                        <span class=\"font-weight-bold\">").concat(event.title, "</span>\n                    </div>\n                </a>"));
    count = Number($('#count_notify').text());
    count++;
    $('#count_notify').text(count);
  });
}