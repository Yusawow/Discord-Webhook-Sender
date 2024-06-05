document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("submitButton").addEventListener("click", function() {
        var username = document.getElementById("username").value;
        var avatarUrl = document.getElementById("avatar_url").value;
        var content = document.getElementById("content").value;
        var webhookUrl = document.getElementById("webhook_url").value;

        if (username.trim() === "" || avatarUrl.trim() === "" || content.trim() === "" || webhookUrl.trim() === "") {
            document.getElementById("message").innerText = "Please fill in all fields.";
            return;
        }

        var form = document.getElementById("webhookForm");
        var formData = new FormData(form);

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "send_webhook.php", true);

        xhr.onloadstart = function() {
            document.getElementById("loader").style.display = "block";
        };

        xhr.onloadend = function() {
            document.getElementById("loader").style.display = "none";
        };

        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    var response = xhr.responseText;
                    document.getElementById("message").innerText = response;
                } else {
                    document.getElementById("message").innerText = "Error sending the message.";
                }
            }
        };

        xhr.send(formData);
    });
});
