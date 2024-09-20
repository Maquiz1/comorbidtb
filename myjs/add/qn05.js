const qn051 = document.getElementById("qn051");
const qn052 = document.getElementById("qn052");
const qn053 = document.getElementById("qn053");
const qn054 = document.getElementById("qn054");
const qn055 = document.getElementById("qn055");
const qn056 = document.getElementById("qn056");
const qn057 = document.getElementById("qn057");
const qn058 = document.getElementById("qn058");
const qn059 = document.getElementById("qn059");
const qn0596 = document.getElementById("qn0596");


const qn05_other1 = document.getElementById("qn05_other1");
const qn05_other = document.getElementById("qn05_other");


function toggleElementVisibility() {
  if (qn0596.checked) {
    qn05_other1.style.display = "block";
    qn05_other.setAttribute("required", "required");
  } else {
    qn05_other1.style.display = "none";
    qn05_other.removeAttribute("required");
  }
}

qn051.addEventListener("change", toggleElementVisibility);
qn052.addEventListener("change", toggleElementVisibility);
qn053.addEventListener("change", toggleElementVisibility);
qn054.addEventListener("change", toggleElementVisibility);
qn055.addEventListener("change", toggleElementVisibility);
qn056.addEventListener("change", toggleElementVisibility);
qn057.addEventListener("change", toggleElementVisibility);
qn058.addEventListener("change", toggleElementVisibility);
qn059.addEventListener("change", toggleElementVisibility);
qn0596.addEventListener("change", toggleElementVisibility);


// Initial check
toggleElementVisibility();
