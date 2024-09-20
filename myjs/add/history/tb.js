const tb1 = document.getElementById(`recent_tb_results1`);
const tb2 = document.getElementById(`recent_tb_results2`);
const tb3 = document.getElementById(`recent_tb_results3`);
const tb98 = document.getElementById(`recent_tb_results98`);
const tb99 = document.getElementById(`recent_tb_results99`);

const recent_tb_date_label = document.getElementById(`recent_tb_date_label`);
const recent_tb_date = document.getElementById(`recent_tb_date`);
const recent_tb_date_error = document.getElementById(`recent_tb_date_error`);

function toggleElementVisibility() {
  if (tb1.checked || tb2.checked || tb3.checked) {
    recent_tb_date_label.style.display = "block";
    recent_tb_date.style.display = "block";
    recent_tb_date.setAttribute("required", "required");
  } else {
    // if (recent_tb_date || recent_tb_date.value) {
      // recent_tb_date_label.style.display = "block";
      // recent_tb_date.style.display = "block";
      // recent_tb_date.setAttribute("required", "required");
      // recent_tb_date_error.val("Please");
    // } else {
      recent_tb_date_label.style.display = "none";
      recent_tb_date.style.display = "none";
      recent_tb_date.removeAttribute("required");
    // }
  }
}
// Initial check
toggleElementVisibility();

tb1.addEventListener("change", toggleElementVisibility);
tb2.addEventListener("change", toggleElementVisibility);
tb3.addEventListener("change", toggleElementVisibility);
tb98.addEventListener("change", toggleElementVisibility);
tb99.addEventListener("change", toggleElementVisibility);
