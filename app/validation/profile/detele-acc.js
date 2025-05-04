// Query Selectors
const form = document.getElementById("accDelete-form");
const reasonCheckboxes = document.querySelectorAll('input[name="reason"]'); // Select all checkboxes with name="reason"
const otherReasonCheckbox = document.getElementById("other-reason");
const otherReasonText = document.getElementById("other-reason-text");
const otherReasonTextarea = document.querySelector('#other-reason-text textarea'); // Select the textarea
const errorMessage = document.getElementById("errorMSG");
const submitButton = document.querySelector(".delete-button");

// Event Listeners
otherReasonCheckbox.addEventListener("change", () => {
    otherReasonText.style.display = otherReasonCheckbox.checked ? "block" : "none";
});

form.addEventListener("submit", (event) => {
    event.preventDefault(); 

    const atLeastOneBaseReasonChecked = Array.from(reasonCheckboxes).some(checkbox => checkbox.value !== "Other" && checkbox.checked);

    const otherReasonFilled = !otherReasonCheckbox.checked || (otherReasonCheckbox.checked && otherReasonTextarea.value.trim() !== "");

    if (!atLeastOneBaseReasonChecked && !otherReasonCheckbox.checked) {
        errorMessage.textContent = "Please select at least one reason for deleting your account.";
        errorMessage.style.color = "red";
        return; 
    }

    if (otherReasonCheckbox.checked && otherReasonTextarea.value.trim() === "") {
        errorMessage.textContent = "Please specify the 'Other' reason for deleting your account.";
        errorMessage.style.color = "red";
        return; 
    }

    errorMessage.textContent = ""; 

    const confirmation = confirm("Are you sure you want to delete your account?");
    if (confirmation) {
        window.location.href = "../../../public/index.html" 
    }
});