const userName = document.getElementById("name");
const userUsername = document.getElementById("username");
const userEmail = document.getElementById("email");
const userBirthday = document.getElementById("birthday");

const userInfo = JSON.parse(localStorage.getItem('userInfo'));

userName.textContent = userInfo.name;
userUsername.textContent = userInfo.username;
userEmail.textContent = userInfo.email;
userBirthday.textContent = userInfo.birthday;
