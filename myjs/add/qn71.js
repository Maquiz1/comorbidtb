const qn711 = document.getElementById("qn711");
const qn712 = document.getElementById("qn712");
const qn713 = document.getElementById("qn713");
const qn714 = document.getElementById("qn714");
const qn715 = document.getElementById("qn715");
const qn716 = document.getElementById("qn716");

const tb_outcome_date_1 = document.getElementById("tb_outcome_date_1");
const tb_outcome_date_cured = document.getElementById("tb_outcome_date_cured");
const tb_outcome_date_completed = document.getElementById(
  "tb_outcome_date_completed"
);
const tb_outcome_date_death = document.getElementById("tb_outcome_date_death");
const tb_outcome_date_last_seen = document.getElementById(
  "tb_outcome_date_last_seen"
);
const tb_outcome_date = document.getElementById("tb_outcome_date");

function toggleElementVisibility() {
  if (qn711.checked) {
    tb_outcome_date_1.style.display = "block";
    tb_outcome_date_cured.style.display = "block";
  } else if (qn712.checked) {
    tb_outcome_date_1.style.display = "block";
    tb_outcome_date_completed.style.display = "block";
  } else if (qn713.checked) {
    tb_outcome_date_1.style.display = "block";
    tb_outcome_date_death.style.display = "block";
  } else if (qn715.checked) {
    tb_outcome_date_1.style.display = "block";
    tb_outcome_date_last_seen.style.display = "block";
  } else {
    tb_outcome_date_1.style.display = "none";
    tb_outcome_date_cured.style.display = "none";
    tb_outcome_date_completed.style.display = "none";
    tb_outcome_date_death.style.display = "none";
    tb_outcome_date_last_seen.style.display = "none";
  }
}

qn711.addEventListener("change", toggleElementVisibility);
qn712.addEventListener("change", toggleElementVisibility);
qn713.addEventListener("change", toggleElementVisibility);
qn714.addEventListener("change", toggleElementVisibility);
qn715.addEventListener("change", toggleElementVisibility);
qn716.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
