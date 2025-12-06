function validateForm() {
  const name = document.querySelector('[name="name"]').value.trim();
  const email = document.querySelector('[name="email"]').value.trim();
  const message = document.querySelector('[name="message"]').value.trim();
  if (!name || !email || !message) {
    alert("Please fill in all fields!");
    return false;
  }
  alert("Message sent successfully!");
  return true;
}
