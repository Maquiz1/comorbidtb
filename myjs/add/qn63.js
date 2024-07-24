const qn631 = document.getElementById("qn631");
const qn632 = document.getElementById("qn632");

const qn63_date1 = document.getElementById("qn63_date1");
const qn63_date = document.getElementById("qn63_date");

const qn63_kunywa1 = document.getElementById("qn63_kunywa1");
const qn63_kunywa = document.getElementById("qn63_kunywa");

function toggleElementVisibility() {
  if (qn631.checked) {
    qn63_date1.style.display = "block";
    qn63_date.setAttribute("required", "required");

    qn63_kunywa1.style.display = "block";
    qn63_kunywa.setAttribute("required", "required");
  } else {
    qn63_date1.style.display = "none";
    qn63_date.removeAttribute("required");

    qn63_kunywa1.style.display = "none";
    qn63_kunywa.removeAttribute("required");
  }
}

qn631.addEventListener("change", toggleElementVisibility);
qn632.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
