var humane = require("humane-js");

angular.module("ui.notifications", []);

angular.module("ui.notifications").factory("notifications", function () {
    var notifications, wrap;
    notifications = humane.create({
        baseCls: "humane-flatty",
        timeout: 2000
    });
    wrap = function (message, config) {
        return notifications.spawn(config)(message);
    };
    notifications.error = function (message) {
        return wrap(message, {
            addnCls: "humane-flatty-error",
            timeout: 4000
        });
    };
    notifications.success = function (message) {
        return wrap(message, {
            addnCls: "humane-flatty-success",
            timeout: 2000
        });
    };
    return notifications;
});
