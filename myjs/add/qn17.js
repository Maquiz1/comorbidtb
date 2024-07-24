const qn171 = document.getElementById("qn171");
const qn172 = document.getElementById("qn172");

const qn18 = document.getElementById("qn18");
const qn181 = document.getElementById("qn181");

const qn20 = document.getElementById("qn20");
const qn201 = document.getElementById("qn201");

const qn21 = document.getElementById("qn21");
const qn211 = document.getElementById("qn201");

const qn22 = document.getElementById("qn22");
const qn221 = document.getElementById("qn221");

const qn23 = document.getElementById("qn23");
const qn231 = document.getElementById("qn231");

const qn24 = document.getElementById("qn24");
const qn241 = document.getElementById("qn241");

function toggleElementVisibility() {
  if (qn171.checked) {
    qn18.style.display = "block";
    qn181.setAttribute("required", "required");
    qn20.style.display = "block";
    qn201.setAttribute("required", "required");
    qn21.style.display = "block";
    qn211.setAttribute("required", "required");
    qn22.style.display = "block";
    qn221.setAttribute("required", "required");
    qn23.style.display = "block";
    qn231.setAttribute("required", "required");
    qn24.style.display = "block";
    qn241.setAttribute("required", "required");
  }else {
    qn18.style.display = "none";
    qn181.removeAttribute("required");
    qn20.style.display = "none";
    qn201.removeAttribute("required");
    qn21.style.display = "none";
    qn211.removeAttribute("required");
    qn22.style.display = "none";
    qn221.removeAttribute("required");
    qn23.style.display = "none";
    qn231.removeAttribute("required");
    qn24.style.display = "none";
    qn241.removeAttribute("required");
  }
}

qn171.addEventListener("change", toggleElementVisibility);
qn172.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
