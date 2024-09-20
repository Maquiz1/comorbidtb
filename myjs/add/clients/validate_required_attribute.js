const form = document.getElementById("myForm");

form.addEventListener("submit", function (event) {
  const radios = document.getElementsByName("gender");
  let checked = false;
  for (let i = 0; i < radios.length; i++) {
    if (radios[i].checked) {
      checked = true;
      break;
    }
  }
  if (!checked) {
    alert("Please select a gender.");
    event.preventDefault();
  }
});
