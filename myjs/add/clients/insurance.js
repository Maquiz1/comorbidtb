const health_insurance1 = document.getElementById("health_insurance1");
const health_insurance2 = document.getElementById("health_insurance2");

const insurance_name = document.getElementById("insurance_name");
const pay_services = document.getElementById("pay_services");

function toggleElementVisibility() {
  if (health_insurance1.checked) {
    pay_services.style.display = "none";
    insurance_name.style.display = "block";
  } else if (health_insurance2.checked) {
    pay_services.style.display = "block";
    insurance_name.style.display = "none";
  } else {
    insurance_name.style.display = "none";
    pay_services.style.display = "none";
  }
}

health_insurance1.addEventListener("change", toggleElementVisibility);
health_insurance2.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
