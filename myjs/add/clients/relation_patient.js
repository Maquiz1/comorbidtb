const relation_patient1 = document.getElementById("relation_patient1");
const relation_patient2 = document.getElementById("relation_patient2");
const relation_patient3 = document.getElementById("relation_patient3");
const relation_patient4 = document.getElementById("relation_patient4");
const relation_patient5 = document.getElementById("relation_patient5");
const relation_patient96 = document.getElementById("relation_patient96");
const relation_patient_other = document.getElementById(
  "relation_patient_other"
);

const relation_patient_other_label = document.getElementById(
  "relation_patient_other_label"
);

function toggleElementVisibility() {
  if (relation_patient96.checked) {
    relation_patient_other.style.display = "block";
    relation_patient_other_label.style.display = "block";
  } else {
    relation_patient_other.style.display = "none";
    relation_patient_other_label.style.display = "none";
  }
}

relation_patient1.addEventListener("change", toggleElementVisibility);
relation_patient2.addEventListener("change", toggleElementVisibility);
relation_patient3.addEventListener("change", toggleElementVisibility);
relation_patient4.addEventListener("change", toggleElementVisibility);
relation_patient5.addEventListener("change", toggleElementVisibility);
relation_patient96.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
