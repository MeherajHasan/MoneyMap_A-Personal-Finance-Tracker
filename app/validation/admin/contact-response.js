function handleReply(messageID, email, subject) {
    if (!confirm("Mark this message as replied?")) return;

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "../../controllers/replyMessageAjax.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            const res = JSON.parse(xhr.responseText);
            if (res.success) {
                const mailSubject = encodeURIComponent("Reply to " + subject);
                const mailtoLink = `mailto:${email}?subject=${mailSubject}`;
                window.open(mailtoLink, "_blank");

                location.reload(); 
            } else {
                alert("Failed to mark as replied: " + (res.error || "Unknown error"));
            }
        }
    };

    xhr.send("messageID=" + encodeURIComponent(messageID));
}
