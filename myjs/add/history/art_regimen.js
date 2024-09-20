const art_regimen1 = document.getElementById("art_regimen1");
const art_regimen2 = document.getElementById("art_regimen2");
const art_regimen3 = document.getElementById("art_regimen3");
const art_regimen4 = document.getElementById("art_regimen4");
const art_regimen96 = document.getElementById("art_regimen96");

const art_regimen_other_label = document.getElementById(
  "art_regimen_other_label"
);
const art_regimen_other = document.getElementById("art_regimen_other");

const first_line1 = document.getElementById("first_line1");
const first_line = document.getElementById("first_line");
const second_line1 = document.getElementById("second_line1");
const second_line = document.getElementById("second_line");
const third_line1 = document.getElementById("third_line1");
const third_line = document.getElementById("third_line");

function toggleElementVisibility() {
  if (art_regimen1.checked) {
    first_line.style.display = "block";
    first_line1.setAttribute("required", "required");
    second_line.style.display = "none";
    second_line1.removeAttribute("required");
    third_line.style.display = "none";
    third_line1.removeAttribute("required");
    art_regimen_other_label.style.display = "none";
    art_regimen_other.style.display = "none";
    art_regimen_other.removeAttribute("required");
  } else if (art_regimen2.checked) {
    first_line.style.display = "none";
    first_line1.removeAttribute("required");
    second_line.style.display = "block";
    second_line1.setAttribute("required", "required");
    third_line.style.display = "none";
    third_line1.removeAttribute("required");
    art_regimen_other_label.style.display = "none";
    art_regimen_other.style.display = "none";
    art_regimen_other.removeAttribute("required");
  } else if (art_regimen3.checked) {
    first_line.style.display = "none";
    first_line1.removeAttribute("required");
    second_line.style.display = "none";
    second_line1.removeAttribute("required");
    third_line.style.display = "block";
    third_line1.setAttribute("required", "required");
    art_regimen_other_label.style.display = "none";
    art_regimen_other.style.display = "none";
    art_regimen_other.removeAttribute("required");
  } else if (art_regimen96.checked) {
    first_line.style.display = "none";
    first_line1.removeAttribute("required");
    second_line.style.display = "none";
    second_line1.removeAttribute("required");
    third_line.style.display = "none";
    third_line1.removeAttribute("required");
    art_regimen_other_label.style.display = "block";
    art_regimen_other.style.display = "block";
    art_regimen_other.setAttribute("required", "required");
  } else {
    first_line.style.display = "none";
    first_line1.removeAttribute("required");
    second_line.style.display = "none";
    second_line1.removeAttribute("required");
    third_line.style.display = "none";
    third_line1.removeAttribute("required");
    art_regimen_other_label.style.display = "none";
    art_regimen_other.style.display = "none";
    art_regimen_other.removeAttribute("required");
  }
}

art_regimen1.addEventListener("change", toggleElementVisibility);
art_regimen2.addEventListener("change", toggleElementVisibility);
art_regimen3.addEventListener("change", toggleElementVisibility);
art_regimen4.addEventListener("change", toggleElementVisibility);
art_regimen96.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
