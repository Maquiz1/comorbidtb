const clients = document.getElementById("clients");

clients.addEventListener("submit", function (event) {
  const relation_patient_value = document.getElementsByName("relation_patient");
  let checked = false;
  for (let i = 0; i < relation_patient_value.length; i++) {
    if (relation_patient_value[i].checked) {
      checked = true;
      break;
    }
  }
  if (!checked) {
    alert("Please select a gender.");
    event.preventDefault();
  }
});
