document.addEventListener("DOMContentLoaded", () => {
  const form = document.querySelector(".income-form");
  const incomeType = document.getElementById("incomeType");
  const incomeSource = document.getElementById("incomeSource");
  const incomeAmount = document.getElementById("incomeAmount");
  const incomeDate = document.getElementById("incomeDate");

  const sourceError = document.getElementById("sourceError");
  const amountError = document.getElementById("amountError");
  const dateError = document.getElementById("dateError");
  const emptyError = document.getElementById("emptyError");

  form.addEventListener("submit", (e) => {
    let hasError = false;

    sourceError.textContent = "";
    amountError.textContent = "";
    dateError.textContent = "";
    emptyError.textContent = "";

    const validTypes = ["main", "side", "irregular"];
    if (incomeType.value !== "" && !validTypes.includes(incomeType.value)) {
      emptyError.textContent = "Please select a valid Income Type.";
      hasError = true;
    }

    if (incomeSource.value !== "") {
      for (let i = 0; i < incomeSource.value.length; i++) {
        const c = incomeSource.value[i];
        if (
          !(
            (c >= "a" && c <= "z") ||
            (c >= "A" && c <= "Z") ||
            (c >= "0" && c <= "9") ||
            c === " " ||
            c === "." ||
            c === "," ||
            c === "-"
          )
        ) {
          sourceError.textContent = "Source contains invalid characters.";
          hasError = true;
          break;
        }
      }
    }

    if (incomeAmount.value.trim() === "") {
      amountError.textContent = "Amount is required.";
      hasError = true;
    } else if (isNaN(incomeAmount.value) || Number(incomeAmount.value) <= 0) {
      amountError.textContent = "Amount must be a positive number.";
      hasError = true;
    }

    if (incomeDate.value.trim() === "") {
      dateError.textContent = "Date is required.";
      hasError = true;
    }

    if (hasError) {
      e.preventDefault();
      if (emptyError.textContent === "") {
        emptyError.textContent = "Please fix the errors above and resubmit.";
      }
    }
  });
});
