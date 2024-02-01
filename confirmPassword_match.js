function Validate() {
	var password = document.getElementById("password").value;
	var confirmPassword = document.getElementById("cpassword").value;
	if (password != confirmPassword) {
		alert("You first Passwords is not similar with 2nd password. Please enter same password in both");
		return false;
	}
	return true;
}