const matibabu_saratani1 = document.getElementById("matibabu_saratani1");
const matibabu_saratani2 = document.getElementById("matibabu_saratani2");

const matibabu1 = document.getElementById("matibabu1");

function toggleElementVisibility() {
  if (matibabu_saratani1.checked) {
    matibabu1.style.display = "block";
  } else {
    matibabu1.style.display = "none";
  }
}

matibabu_saratani1.addEventListener("change", toggleElementVisibility);
matibabu_saratani2.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
