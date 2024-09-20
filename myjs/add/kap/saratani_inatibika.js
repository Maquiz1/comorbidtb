const saratani_inatibika1 = document.getElementById("saratani_inatibika1");
const saratani_inatibika2 = document.getElementById("saratani_inatibika2");

const matibabu_saratani = document.getElementById("matibabu_saratani");

function toggleElementVisibility() {
  if (saratani_inatibika1.checked) {
    matibabu_saratani.style.display = "block";
  } else {
    matibabu_saratani.style.display = "none";
  }
}

saratani_inatibika1.addEventListener("change", toggleElementVisibility);
saratani_inatibika2.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();