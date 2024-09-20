const qn081 = document.getElementById("qn081");
const qn082 = document.getElementById("qn082");

const qn09 = document.getElementById("qn09");
const qn091 = document.getElementById("qn091");

const qn10 = document.getElementById("qn10");
const qn101 = document.getElementById("qn101");

const qn11 = document.getElementById("qn11");
const qn111 = document.getElementById("qn111");

function toggleElementVisibility() {
  if (qn081.checked) {
    qn09.style.display = "block";
    qn091.setAttribute("required", "required");
    qn10.style.display = "block";
    qn101.setAttribute("required", "required");
    qn11.style.display = "block";
    qn091.setAttribute("required", "required");
  } else {
    qn09.style.display = "none";
    qn091.removeAttribute("required");
    qn10.style.display = "none";
    qn101.removeAttribute("required");
    qn11.style.display = "none";
    qn111.removeAttribute("required");
  }
}

qn081.addEventListener("change", toggleElementVisibility);
qn082.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
