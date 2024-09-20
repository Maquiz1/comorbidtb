const second_line15 = document.getElementById("second_line15");
const second_line16 = document.getElementById("second_line16");
const second_line17 = document.getElementById("second_line17");
const second_line18 = document.getElementById("second_line18");
const second_line19 = document.getElementById("second_line19");
const second_line20 = document.getElementById("second_line20");
const second_line21 = document.getElementById("second_line21");
const second_line22 = document.getElementById("second_line22");
const second_line28 = document.getElementById("second_line28");

const other_second_line_label11 = document.getElementById(
  "other_second_line_label"
);

const other_second_line = document.getElementById("other_second_line");

function toggleElementVisibility() {
  if (second_line28.checked) {
    other_second_line_label11.style.display = "block";
    other_second_line.style.display = "block";
    other_second_line.setAttribute("required", "required");
  } else {
    other_second_line_label11.style.display = "none";
    other_second_line.removeAttribute("required");
    other_second_line.style.display = "none";
  }
}

second_line15.addEventListener("change", toggleElementVisibility);
second_line16.addEventListener("change", toggleElementVisibility);
second_line17.addEventListener("change", toggleElementVisibility);
second_line18.addEventListener("change", toggleElementVisibility);
second_line19.addEventListener("change", toggleElementVisibility);
second_line20.addEventListener("change", toggleElementVisibility);
second_line21.addEventListener("change", toggleElementVisibility);
second_line22.addEventListener("change", toggleElementVisibility);
second_line28.addEventListener("change", toggleElementVisibility);


// Initial check
toggleElementVisibility();
