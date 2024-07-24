const tb_treatment1 = document.getElementById("tb_treatment1");
const tb_treatment96 = document.getElementById("tb_treatment96");

const tb_treatment_other1 = document.getElementById("tb_treatment_other1");
const tb_treatment_other = document.getElementById("tb_treatment_other");

function toggleElementVisibility() {
  if (tb_treatment96.checked) {
    tb_treatment_other1.style.display = "block";
    tb_treatment_other.setAttribute("required", "required");
  } else {
    tb_treatment_other1.style.display = "none";
    tb_treatment_other.removeAttribute("required");
  }
}

tb_treatment1.addEventListener("change", toggleElementVisibility);
tb_treatment96.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
