const third_line23 = document.getElementById("third_line23");
const third_line24 = document.getElementById("third_line24");
const third_line25 = document.getElementById("third_line25");
const third_line26 = document.getElementById("third_line26");
const third_line29 = document.getElementById("third_line29");

const other_third_line_label11 = document.getElementById(
  "other_third_line_label"
);

const other_third_line = document.getElementById("other_third_line");

function toggleElementVisibility() {
  if (third_line29.checked) {
    other_third_line_label11.style.display = "block";
    other_third_line.style.display = "block";
    other_third_line.setAttribute("required", "required");
  } else {
    other_third_line_label11.style.display = "none";
    other_third_line.removeAttribute("required");
    other_third_line.style.display = "none";
  }
}

third_line23.addEventListener("change", toggleElementVisibility);
third_line24.addEventListener("change", toggleElementVisibility);
third_line25.addEventListener("change", toggleElementVisibility);
third_line26.addEventListener("change", toggleElementVisibility);
third_line29.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
