const form = document.getElementById("accDelete-form");
const reasonCheckboxes = document.querySelectorAll('input[name="reason[]"'); 
const otherReasonCheckbox = document.getElementById("other-reason");
const otherReasonText = document.getElementById("other-reason-text");
const otherReasonTextarea = document.querySelector('#other-reason-text textarea'); 
const errorMessage = document.getElementById("errorMSG");

otherReasonCheckbox.addEventListener("change", () => {
    otherReasonText.style.display = otherReasonCheckbox.checked ? "block" : "none";
});

form.addEventListener("submit", (event) => {
    const atLeastOneBaseReasonChecked = Array.from(reasonCheckboxes).some(
        checkbox => checkbox.value !== "Other" && checkbox.checked
    );

    const otherReasonFilled = !otherReasonCheckbox.checked || 
        (otherReasonCheckbox.checked && otherReasonTextarea.value.trim() !== "");

    if (!atLeastOneBaseReasonChecked && !otherReasonCheckbox.checked) {
        event.preventDefault();
        errorMessage.textContent = "Please select at least one reason for deleting your account.";
        errorMessage.style.color = "red";
        return;
    }

    if (otherReasonCheckbox.checked && otherReasonTextarea.value.trim() === "") {
        event.preventDefault();
        errorMessage.textContent = "Please specify the 'Other' reason for deleting your account.";
        errorMessage.style.color = "red";
        return;
    }

    const confirmation = confirm("Are you sure you want to delete your account?");
    if (!confirmation) {
        event.preventDefault();
        return;
    }
});
