const income_household1 = document.getElementById("income_household1");
const income_household2 = document.getElementById("income_household2");
const income_household3 = document.getElementById("income_household3");
const income_household4 = document.getElementById("income_household4");
const income_household5 = document.getElementById("income_household5");
const income_household6 = document.getElementById("income_household6");
const income_household96 = document.getElementById("income_household96");

const income_household_other = document.getElementById(
  "income_household_other"
);

function toggleElementVisibility() {
  if (income_household96.checked) {
    income_household_other.style.display = "block";
  } else {
    income_household_other.style.display = "none";
  }
}

income_household1.addEventListener("change", toggleElementVisibility);
income_household2.addEventListener("change", toggleElementVisibility);
income_household3.addEventListener("change", toggleElementVisibility);
income_household4.addEventListener("change", toggleElementVisibility);
income_household5.addEventListener("change", toggleElementVisibility);
income_household6.addEventListener("change", toggleElementVisibility);
income_household96.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();

