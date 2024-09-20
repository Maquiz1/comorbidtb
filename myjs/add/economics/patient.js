const income_patient1 = document.getElementById("income_patient1");
const income_patient2 = document.getElementById("income_patient2");
const income_patient3 = document.getElementById("income_patient3");
const income_patient4 = document.getElementById("income_patient4");
const income_patient5 = document.getElementById("income_patient5");
const income_patient6 = document.getElementById("income_patient6");
const income_patient96 = document.getElementById("income_patient96");

const income_patient_other = document.getElementById("income_patient_other");


function toggleElementVisibility() {
  if (income_patient96.checked) {
    income_patient_other.style.display = "block";
  } else {
    income_patient_other.style.display = "none";
  }
}

income_patient1.addEventListener("change", toggleElementVisibility);
income_patient2.addEventListener("change", toggleElementVisibility);
income_patient3.addEventListener("change", toggleElementVisibility);
income_patient4.addEventListener("change", toggleElementVisibility);
income_patient5.addEventListener("change", toggleElementVisibility);
income_patient6.addEventListener("change", toggleElementVisibility);
income_patient96.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
